<?php
session_start();
include 'db.php';

// Ensure the user is logged in
$loggedInUserId = $_SESSION['user_id'] ?? null;
if (!$loggedInUserId) {
    die('You must be logged in to access this feature.');
}

// Fetch recent conversations and the last message for each
$query = "SELECT u.username, 
                 u.profile_picture,
                 IF(m.sender_id = $loggedInUserId, 'You', u.username) AS sender,
                 m.message, 
                 DATE_FORMAT(m.created_at, '%l:%i %p') AS time,
                 u.user_id AS other_user_id
          FROM messages m
          JOIN conversations c ON m.conversation_id = c.conversation_id
          JOIN users u ON (u.user_id = c.user1_id OR u.user_id = c.user2_id)
          WHERE (c.user1_id = $loggedInUserId OR c.user2_id = $loggedInUserId)
          AND u.user_id != $loggedInUserId
          AND m.created_at = (
              SELECT MAX(created_at) 
              FROM messages 
              WHERE conversation_id = m.conversation_id
          )
          ORDER BY m.created_at DESC 
          LIMIT 10";

$result = $conn->query($query);

$recentConversations = [];
if ($result->num_rows > 0) {
    $recentConversations = $result->fetch_all(MYSQLI_ASSOC);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Page</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=library_add,notifications" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=search" />
    <script src="https://kit.fontawesome.com/fa0399c701.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="message.css">
</head>
<body>

    <!-- navbar -->
    <header class="navbar">

        <div class="left_icon" onclick="window.location.href='home.php'">
            <img class="logo" width="40px" height="40px" src="css/imgs/ichat_logo.png">
            <h5>iChat</h5>
        </div>
        
        <div class="search">
            <button class="search_btn">
                <span class="material-symbols-rounded">
                    search
                </span>
            </button>
            
            <input class="search_input"  id="searchInput" type="search" placeholder="Search">
            <ul id="results"></ul>

        </div>
        

        <div class="right_icon">
            <button class="notif_icon" onclick="toggleNotifications()">
                <span class="material-symbols-outlined">
                notifications
                </span>
            </button>
            <button class="profile_btn" onclick="toggleProfile()">
                <img class="profile" width="40px" height="40px" src="css/imgs/profile_pic1.jpg">
            </button>
        </div>
        
    </header>

    <!-- notification dropdown -->
    <div id="notifDropdown" class="notif_dropdown">
        <div class="notif_text">
            <p class="notif_title">Notifications</p>
        </div>
        <div class="notif_white_bg">
            <div class="follow_request">
                <img width="40px" height="40px" src="css/imgs/follow_request_img.png">
                <div class="request_text_group">
                    <p class="request_text_follow">Follow request</p>
                    <p class="request_text_plus">itshiro20 + 3 others</p>
                </div>
            </div>
            <br>
            <hr class="notif_line">
            <br>
            <div class="earlier">
                <p class="earlier_text">Earlier</p>
                <div class="earlier_wrapper">
                    <img class="notif_user_img" width="40px" height="40px" src="css/imgs/profile_pic3.jpg">
                    <div class="notif_group_text">
                        <p class="user_text">jws.pjs&nbsp;</p>
                        <p class="notif_info">liked your post. 1m</p>
                    </div>
                    <img class="notif_post_img" width="40px" height="40px" src="css/imgs/post_sample.jpg">
                </div>

                <div class="earlier_wrapper">
                    <img class="notif_user_img" width="40px" height="40px" src="css/imgs/profile_pic3.jpg">
                    <div class="notif_group_text">
                        <p class="user_text">jws.pjs&nbsp;</p>
                        <p class="notif_info">liked your post. 1m</p>
                    </div>
                    <img class="notif_post_img" width="40px" height="40px" src="css/imgs/post_sample2.jpg">
                </div>
            </div>

            <br>
            <hr class="notif_line">
            <br>
            <div class="earlier">
                <p class="earlier_text">New</p>
                <div class="earlier_wrapper">
                    <img class="notif_user_img" width="40px" height="40px" src="css/imgs/profile_pic6.jpg">
                    <div class="notif_group_text">
                        <p class="user_text">jws.pjs&nbsp;</p>
                        <p class="notif_info">liked your post. 1m</p>
                    </div>
                    <img class="notif_post_img" width="40px" height="40px" src="css/imgs/post_sample.jpg">
                </div>

                <div class="earlier_wrapper">
                    <img class="notif_user_img" width="40px" height="40px" src="css/imgs/profile_pic7.jpg">
                    <div class="notif_group_text">
                        <p class="user_text">jws.pjs&nbsp;</p>
                        <p class="notif_info">liked your post. 1m</p>
                    </div>
                    <img class="notif_post_img" width="40px" height="40px" src="css/imgs/post_sample2.jpg">
                </div>

                <div class="earlier_wrapper">
                    <img class="notif_user_img" width="40px" height="40px" src="css/imgs/profile_pic5.jpg">
                    <div class="notif_group_text">
                        <p class="user_text">jws.pjs&nbsp;</p>
                        <p class="notif_info">liked your post. 1m</p>
                    </div>
                    <img class="notif_post_img" width="40px" height="40px" src="css/imgs/post_sample2.jpg">
                </div>
            </div>
        </div>
    </div>

    <!-- profile dropdown -->
    <div class="profile_dropdown" id="profileDropdown">
        <div class="profile_title">
            <p class="profile_text">Profile</p>
        </div>
        <br>
        <hr class="notif_line">
        <br>
        <div class="user_profile_wrapper">
            <img class="user_profile_img" width="40px" height="40px" src="css/imgs/profile_pic1.jpg">
            <p class="user_text_name">Name</p>
        </div>
        <br>
        <hr class="notif_line">
        <br>
        <div class="profile_menu">
            <div class="profile_menu_btn">
                <button class="profile_settings" >
                    <ion-icon name="settings-outline"></ion-icon>
                </button>
                <p class="profile_menu_text">Settings & Privacy</p>
            </div>
            <div class="profile_menu_btn">
                <button class="profile_logout">
                    <ion-icon name="log-out-outline"></ion-icon>
                </button>
                <p class="profile_menu_text">Logout</p>
            </div>
        </div>
        <br>
        <hr class="notif_line">
        <br>
        <div class="terms_wrap">
            <div class="terms_link">
                <a class="terms_bold link" href="#">About us</a>
                <p class="terms_bold">&nbsp;·&nbsp;</p>
                <a class="terms_bold link" href="#">Terms of use</a>
                <p class="terms_bold">&nbsp;·&nbsp;</p>
                <a class="terms_bold link" href="#">Privacy policy</a>
                <p class="terms_bold">&nbsp;·&nbsp;</p>
                <a class="terms_bold link" href="#">FAQ</a>
            </div>
            <p class="terms_text">© 2024 iChat. All Rights Reserved.</p>
        </div>
    </div>

    <!-- main message -->
    <main class="main_message">

    <!-- chat heads -->
    <div class="chatheads">

        <div class="upper_chatheads">

            <p class="chatheads_message_text">Messages</p>

            <div class="message_search_box">
                <ion-icon id="chatheads_search_icon" name="search-outline"></ion-icon>
                <input type="text" id="search_chats" placeholder="Search chats">
            </div>
            <ul id="results">a</ul>
        </div>

        <div class="chatheads_users_group">
            <?php
            // Loop through recent conversations and display the user chat heads
            if (!empty($recentConversations)) {
                foreach ($recentConversations as $conversation) {
                    echo '<div class="chatheads_user_wrap">
                            <img class="chatheads_user_img" src="' . (htmlspecialchars($conversation['profile_picture']) ? htmlspecialchars($conversation['profile_picture']) : 'default-avatar.jpg') . '" alt="Profile Picture">
                            <div class="chatheads_user_text_group">
                                <p class="chatheads_user_name">' . htmlspecialchars($conversation['username']) . '</p>
                                <p class="chatheads_last_message">'. htmlspecialchars($conversation['message']).'</p>
                            </div>
                          </div>';
                }
            } else {
                echo '<p>No recent messages found.</p>';
            }
            ?>
        </div>

    </div>

    <!-- chat box -->
    <div class="chat_box_containner" id="conversation-container">

    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- framework -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
    <!-- js -->
    <script>
       $(document).ready(function () {
            // Handle typing in the search input field
            $('#search_chats').on('input', function () {
                const searchTerm = $(this).val();
                if (searchTerm.length > 0) {
                    $.ajax({
                        url: 'messages_search_handler.php',
                        method: 'POST',
                        data: { search_term: searchTerm },
                        success: function (response) {
                            $('#results').html(response); // Populate results
                        }
                    });
                } else {
                    $('#results').empty(); // Clear results if input is empty
                }
            });

            // Event listener for the clickable search results
            $(document).on('click', '.conversation-item', function (e) {
                e.preventDefault();
                
                // Prevent multiple clicks
                if ($(this).hasClass('clicked')) return;

                $(this).addClass('clicked'); // Mark as clicked

                const userId = $(this).data('user-id');

                // Load the conversation for the clicked user
                loadConversation(userId);
            });

            function loadConversation(userId) {
                // Use AJAX to load the messages with the selected user
                $.ajax({
                    url: 'message_load.php', // The page that will load the conversation
                    method: 'GET',
                    data: { user2_id: userId },
                    success: function (response) {
                        // Insert the loaded conversation into the conversation container
                        $('#conversation-container').html(response).show();
                    }
                });
            }
        });
    </script>
    <script src="message.js"></script>

</body>

</html>

