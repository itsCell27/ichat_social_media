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

?>



    <!-- main chat box -->
    <div class="chat_box" id="chatBox">

        <div class="chat_box_navbar" id="conversation-container">
            <ion-icon class="chat_box_nav_option" name="ellipsis-horizontal-outline" onclick="toggleOption()"></ion-icon>
        </div>

        <div class="chat_box_conversation">
            <!-- Dynamically loaded partner's messages -->
            <?php foreach ($messages as $message): ?>
                <div class="chat_message_group" style="display: flex; 
                    <?php echo ($message['sender_id'] == $loggedInUserId) ? 'justify-content: flex-end;' : 'justify-content: flex-start;'; ?> margin-bottom: 10px;">
                    
                    <?php if ($message['sender_id'] != $loggedInUserId): ?>
                        <!-- Partner's avatar and message -->
                        <div class="partner_chat_group" style="margin-right: 10px;">
                            <?php if ($message['profile_picture']): ?>
                                <img src="<?php echo htmlspecialchars($message['profile_picture']); ?>" alt="Profile Picture" style="width: 40px; height: 40px; border-radius: 50%;">
                            <?php else: ?>
                                <img src="default-profile.png" alt="Default Profile Picture" style="width: 40px; height: 40px; border-radius: 50%;">
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Message bubble -->
                    <div style="max-width: 70%; background-color: <?php echo ($message['sender_id'] == $loggedInUserId) ? '#d1e7ff' : '#f0f0f0'; ?>; border-radius: 10px; padding: 8px;">
                        <strong><?php echo htmlspecialchars($message['username']); ?>:</strong>
                        <p style="margin: 0;"><?php echo htmlspecialchars($message['message']); ?></p>
                        <em style="font-size: 0.8em; color: #888;"><?php echo $message['created_at']; ?></em>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Partner's profile info -->
            <div class="conversation_partner_profile">
                <img id="partner_img" width="100px" height="100px" src="css/imgs/profile_pic5.jpg">
                <p id="partner_name"><?php echo htmlspecialchars($username2); ?></p>
                <button id="view_partner_profile">View Profile</button>
            </div>
        </div>

        <!-- Message send form -->
        <form class="send_message_group" action="messages_system.php" method="POST">
            
            <!-- Hidden input for image upload -->
            <input type="file" id="uploadImage" name="uploadedImage" accept="image/*"/>
            <label id="send_img" for="uploadImage">
                <ion-icon class="create_post_img_icon" name="images-outline"></ion-icon>
            </label>

            <!-- Text message input -->
            <div class="message_input_containner">
                <input type="text" id="message" name="message" required placeholder="Type a message...">
            </div>

            <button id="send_text" type="submit">
                <ion-icon name="paper-plane"></ion-icon>
            </button>
        </form>
    </div>

            <!-- message option dropdown -->
            <div class="message_option_dropdown" id="optionDropdown">

                <div class="message_option_slide">
                    <div class="message_option_title">
                        <ion-icon id="option_close_button" name="close" onclick="toggleOption()"></ion-icon>
                        <p class="option_text_profile">Profile</p>
                    </div>

                    <div class="main_option_content">
                        
                        <div class="option_user_group">
                            <img class="option_user_img" width="100px" height="100px" src="css/imgs/profile_pic5.jpg">
                            <p class="option_user_name">Cee Lee</p>
                        </div>

                        <div class="option_files">
                            <div class="option_files_wrap">
                                <div class="files_title_group">
                                    <p class="files_title_name">Photos</p>
                                    <ion-icon class="files_expand_btn" name="chevron-forward" onclick="photosToggle()"></ion-icon>
                                </div>

                                <div class="files_content_group">
                                    <img class="files_sample" width="75vw" height="75vh" src="css/imgs/profile_pic1.jpg">
                                    <img class="files_sample" width="75vw" height="75vh" src="css/imgs/profile_pic2.jpg">
                                    <img class="files_sample" width="75vw" height="75vh" src="css/imgs/profile_pic3.jpg">
                                    <img class="files_sample" width="75vw" height="75vh" src="css/imgs/profile_pic6.jpg">
                                </div>
                            </div>   
                        </div>

                        <div class="lower_option_group">
                            <a class="red_option_btn" onclick="deleteToggle()">Delete conversation</a>
                            <a class="red_option_btn">Block</a>
                        </div>

                    </div>
                </div>

                <!-- photos tab -->
                <div class="photos_tab" id="photoTab">

                    <div class="photos_title_group">
                        <ion-icon id="photos_back_btn" name="arrow-back-outline" onclick="photosToggle()"></ion-icon>
                        <p class="photos_text">Photos</p>
                    </div>

                    <div id="files_img_group">
                        <img class="files_sample" width="75vw" height="75vh" src="css/imgs/profile_pic1.jpg">
                        <img class="files_sample" width="75vw" height="75vh" src="css/imgs/profile_pic2.jpg">
                        <img class="files_sample" width="75vw" height="75vh" src="css/imgs/profile_pic3.jpg">
                        <img class="files_sample" width="75vw" height="75vh" src="css/imgs/profile_pic6.jpg">
                    </div>

                </div>

            </div>    

        

    </main>

    <!-- delete conversation popup -->
    <div class="delete_overlay" id="deleteConversation">
        <form method="POST" class="delete_form">

        <!-- hidden -->
        <input type="submit" id="clear" name="clear" value="Clear Messages">

        <ion-icon name="alert-circle-outline" class="alert_icon"></ion-icon>
        <p class="delete_sure_text">Are you sure?</p>
        <p class="delete_warning_text">Warning: This will permanently delete all messages in this conversation. This action cannot be undone.</p>

        <div class="delete_btn_group">
            <label class="delete_no" onclick="deleteToggle()">No</label>
            <label class="delete_yes" for="clear" onclick="deleteToggle()">Yes</label>
        </div>

        </form>
    </div>

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
                            <div style="max-width: 70%; background-color: #d1e7ff; border-radius: 10px; padding: 8px;">
                                <strong>${response.username}:</strong>
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
