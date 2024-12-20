<?php
session_start();
include 'db.php';

// Ensure the user is logged in
$loggedInUserId = $_SESSION['user_id'] ?? null;
if (!$loggedInUserId) {
    die('You must be logged in to access this feature.');
}

// Get the user being messaged from the GET data
$user2Id = $_GET['user2_id'] ?? null;

if (!$user2Id || $user2Id == $loggedInUserId) {
    die('Invalid user or you cannot message yourself.');
}

// Validate if the user exists in the database
$query = "SELECT user_id, username, profile_picture FROM users WHERE user_id = $user2Id";
$result = $conn->query($query);

if ($result->num_rows === 0) {
    die('Invalid user.');
}

$user2 = $result->fetch_assoc();
$username2 = $user2['username']; // Retrieve the username of the other user
$profilePicture2 = $user2['profile_picture']; // Retrieve the profile picture of the other user

// Find or create the conversation
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

// Fetch all messages in the conversation
$messages = [];
$query = "SELECT m.message, m.created_at, u.username, u.profile_picture, m.sender_id
          FROM messages m 
          JOIN users u ON m.sender_id = u.user_id 
          WHERE m.conversation_id = $conversationId 
          ORDER BY m.created_at ASC";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $messages = $result->fetch_all(MYSQLI_ASSOC);
}

date_default_timezone_set("Asia/Manila");
function timeAgo($datetime) {
    $now = new DateTime();
    $createdAt = new DateTime($datetime);
    $interval = $now->diff($createdAt);

    if ($interval->y > 0) return $interval->y . ' yr' . ($interval->y > 1 ? 's' : '') . ' ago';
    if ($interval->m > 0) return $interval->m . ' mo' . ($interval->m > 1 ? 's' : '') . ' ago';
    if ($interval->d > 0) return $interval->d . ' day' . ($interval->d > 1 ? 's' : '') . ' ago';
    if ($interval->h > 0) return $interval->h . ' hr' . ($interval->h > 1 ? 's' : '') . ' ago';
    if ($interval->i > 0) return $interval->i . ' min' . ($interval->i > 1 ? 's' : '') . ' ago';
    return 'Just now';
}

?>

<div class="chat_box_navbar">
    <div class="chat_box_img_status">
        <img id="user_img_status" width="40px" height="40px" src="<?php echo $profilePicture2; ?>" alt="Profile Picture" onerror="this.src='default_pic.png';">
        <ion-icon id="user_status_icon" name="ellipse"></ion-icon>
    </div>
    
    <div class="chat_box_text_group">
        <p class="chat_box_user_name"><?php echo htmlspecialchars($username2); ?></p>
        <!-- <p class="chat_box_status_text">Active now</p> -->
    </div>
    
    <ion-icon class="chat_box_nav_option" name="ellipsis-horizontal-outline" onclick="toggleOption()"></ion-icon>
</div>


<div class="chat_box_conversation">

    <div id="messages-container">
        <?php foreach ($messages as $message): ?>
            <div style="display: flex; <?php echo ($message['sender_id'] == $loggedInUserId) ? 'justify-content: flex-end;' : 'justify-content: flex-start;'; ?> margin-bottom: 10px;">
                <?php if ($message['sender_id'] != $loggedInUserId): ?>
                    <div style="margin-right: 10px;">
                        <?php if ($message['profile_picture']): ?>
                            <img src="<?php echo htmlspecialchars($message['profile_picture']); ?>" alt="Profile Picture" onerror="this.src='default_pic.png';" style="width: 30px; height: 30px; border-radius: 50%;">
                        <?php else: ?>
                            <img src="css/imgs/default_pic.png" alt="Default Profile Picture" onerror="this.src='default_pic.png';" style="width: 30px; height: 30px; border-radius: 50%;">
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div style="max-width: 70%; background: <?php echo ($message['sender_id'] == $loggedInUserId) ? 'linear-gradient(90deg, #595bf1 0%, rgb(148, 134, 241) 100%)' : '#f0f0f0'; ?>; border-radius: 10px; padding: 10px; color: <?php echo ($message['sender_id'] == $loggedInUserId) ? '#fff' : '#000' ?>">
                    <!-- <strong><?php //echo htmlspecialchars($message['username']); ?>:</strong> -->
                    <p style="margin: 0;" class="your_message_a"><?php echo htmlspecialchars($message['message']); ?></p>
                    <em style="font-size: 0.8em; color: <?php echo ($message['sender_id'] == $loggedInUserId) ? '#ffffff82' : '#888'; ?>;"><?php echo timeAgo($message['created_at']); ?></em>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="conversation_partner_profile">
        <img id="partner_img" width="100px" height="100px" src="<?php echo $profilePicture2; ?>" alt="Profile Picture" onerror="this.src='default_pic.png';">
        <p id="partner_name"><?php echo htmlspecialchars($username2); ?></p>
    </div>

</div>

<form id="message-form" class="send_message_group">
        <input type="hidden" name="user2_id" value="<?php echo $user2Id; ?>">
        <textarea class="message_input_containner" name="message" placeholder="Aa" required></textarea>
        <button type="submit" id="send_text">
            <ion-icon name="paper-plane"></ion-icon>
        </button>
</form>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#message-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        var messageContent = $('textarea[name="message"]').val();
        var user2Id = $('input[name="user2_id"]').val();

        $.ajax({
            url: 'messages_send.php',
            method: 'POST',
            data: {
                message: messageContent,
                user2_id: user2Id
            },
            dataType: 'json',
            success: function(response) {
                if (response.error) {
                    alert(response.error);
                } else {
                    // Append the new message to the message container
                    var newMessage = `
                        <div style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
                            <div style="max-width: 70%; background-color: #d1e7ff; border-radius: 10px; padding: 10px;">
                                <!-- <strong>$//{response.username}:</strong> -->
                                <p style="margin: 0;">${response.message}</p>
                                <em style="font-size: 0.8em; color: #888;">${response.created_at}</em>
                            </div>
                        </div>
                    `;
                    $('#messages-container').append(newMessage);
                    $('textarea[name="message"]').val(''); // Clear the textarea
                }
            },
            error: function() {
                alert('An error occurred while sending the message.');
            }
        });
    });
});
</script>