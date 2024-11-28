<?php
session_start();
include 'db.php';

// Ensure the user is logged in
$loggedInUserId = $_SESSION['user_id'] ?? null;
if (!$loggedInUserId) {
    echo json_encode(['error' => 'You must be logged in to send a message.']);
    exit();
}

// Get the user2_id and message from the POST data
$user2Id = $_POST['user2_id'] ?? null;
$messageContent = $_POST['message'] ?? null;

if (!$user2Id || !$messageContent) {
    echo json_encode(['error' => 'Invalid message or user.']);
    exit();
}

// Ensure the user is not trying to send a message to themselves
if ($user2Id == $loggedInUserId) {
    echo json_encode(['error' => 'You cannot send a message to yourself.']);
    exit();
}

// Validate if the other user exists
$query = "SELECT user_id FROM users WHERE user_id = $user2Id";
$result = $conn->query($query);
if ($result->num_rows === 0) {
    echo json_encode(['error' => 'Invalid user.']);
    exit();
}

// Find the conversation ID between the logged-in user and the other user
$query = "SELECT conversation_id FROM conversations WHERE 
          (user1_id = $loggedInUserId AND user2_id = $user2Id) OR 
          (user1_id = $user2Id AND user2_id = $loggedInUserId)";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $conversation = $result->fetch_assoc();
    $conversationId = $conversation['conversation_id'];
} else {
    // If no conversation exists, create a new one
    $conn->query("INSERT INTO conversations (user1_id, user2_id) VALUES ($loggedInUserId, $user2Id)");
    $conversationId = $conn->insert_id;
}

// Insert the new message into the database
$query = "INSERT INTO messages (conversation_id, sender_id, message, created_at) 
          VALUES ($conversationId, $loggedInUserId, ?, NOW())";
$stmt = $conn->prepare($query);
$stmt->bind_param('s', $messageContent);
$stmt->execute();

// Get the latest message and user details to send back to the frontend
$lastMessageQuery = "SELECT m.message, m.created_at, u.username, u.profile_picture, m.sender_id
                     FROM messages m 
                     JOIN users u ON m.sender_id = u.user_id 
                     WHERE m.conversation_id = $conversationId 
                     ORDER BY m.created_at DESC LIMIT 1";
$lastMessageResult = $conn->query($lastMessageQuery);
$lastMessage = $lastMessageResult->fetch_assoc();

// Return the new message data as JSON
echo json_encode([
    'message' => $lastMessage['message'],
    'created_at' => $lastMessage['created_at'],
    'username' => $lastMessage['username'],
    'profile_picture' => $lastMessage['profile_picture'] ?? 'default-profile.png'
]);
exit();
?>
