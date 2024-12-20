<?php
session_start();
require 'db.php'; // Include your database connection

header('Content-Type: application/json');

// Validate request
$data = json_decode(file_get_contents('php://input'), true);
if (!isset($_SESSION['user_id']) || !isset($data['comment_id'])) {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    exit;
}

$user_id = $_SESSION['user_id'];
$comment_id = intval($data['comment_id']);

// Check if the user already liked the comment
$check_like = $conn->query("SELECT * FROM comment_likes WHERE comment_id = $comment_id AND user_id = $user_id");

if ($check_like->num_rows > 0) {
    // Unlike the comment
    $conn->query("DELETE FROM comment_likes WHERE comment_id = $comment_id AND user_id = $user_id");
    $liked = false;
} else {
    // Like the comment
    $conn->query("INSERT INTO comment_likes (comment_id, user_id) VALUES ($comment_id, $user_id)");
    $liked = true;
}

// Get the updated like count
$result = $conn->query("SELECT COUNT(*) AS like_count FROM comment_likes WHERE comment_id = $comment_id");
$like_data = $result->fetch_assoc();

echo json_encode([
    'success' => true,
    'liked' => $liked,
    'like_count' => $like_data['like_count']
]);
?>
