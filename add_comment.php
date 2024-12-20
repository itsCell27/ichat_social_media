<?php
require 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postId = $_POST['post_id'];
    $commentContent = $_POST['comment_content'];
    $userId = $_SESSION['user_id']; // Assuming user_id is stored in session

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO comments (post_id, user_id, content, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->bind_param("iis", $postId, $userId, $commentContent);

    if ($stmt->execute()) {
        // Fetch the added comment's data for real-time updates
        $commentId = $stmt->insert_id;

        // Get user's profile picture and username
        $userResult = $conn->query("SELECT profile_picture, username FROM users WHERE user_id = $userId");
        $user = $userResult->fetch_assoc();
        $userProfilePicture = htmlspecialchars($user['profile_picture']);
        $username = htmlspecialchars($user['username']);

        // Get the number of likes
        $likeCountResult = $conn->query("SELECT COUNT(*) as like_count FROM comment_likes WHERE comment_id = $commentId");
        $likeCount = $likeCountResult->fetch_assoc()['like_count'];

        // Check if the user has already liked this comment
        $userHasLikedResult = $conn->query("SELECT COUNT(*) as user_has_liked FROM comment_likes WHERE comment_id = $commentId AND user_id = $userId");
        $userHasLiked = $userHasLikedResult->fetch_assoc()['user_has_liked'] > 0 ? 'liked' : '';

        echo json_encode([
            'status' => 'success',
            'comment_id' => $commentId,
            'profile_picture' => $userProfilePicture,
            'username' => $username,
            'like_count' => $likeCount,
            'user_has_liked' => $userHasLiked,
            'timeAgo' => 'Just now' // Adjust this according to your method to calculate 'timeAgo'
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add comment.']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}

$conn->close();
?>