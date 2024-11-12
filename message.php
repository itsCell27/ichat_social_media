<?php
session_start();

// Check if the clear button was clicked to clear the session
if (isset($_POST['clear'])) {
    session_destroy(); // Destroy the session data
    header("Location: message.php"); // Redirect to the same page to reset session data
    exit();
}

// Initialize the message array if it doesn't exist yet
if (!isset($_SESSION['messages'])) {
    $_SESSION['messages'] = [];
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['message'])) {
    // Sanitize the input
    $message = htmlspecialchars($_POST['message']);

    // Add the new message to the session array
    $_SESSION['messages'][] = [
        'message' => $message,
        'time' => date("Y-m-d H:i:s")
    ];
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
            <img class="logo" width="40px" height="40px" src="ichat_logo.png">
            <h5>iChat</h5>
        </div>
        
        <div class="search">
            <button class="search_btn">
                <span class="material-symbols-rounded">
                    search
                </span>
            </button>
            
            <input class="search_input" type="search" placeholder="Search">
        </div>
        

        <div class="right_icon">
            <button class="notif_icon" onclick="toggleNotifications()">
                <span class="material-symbols-outlined">
                notifications
                </span>
            </button>
            <button class="profile_btn" onclick="toggleProfile()">
                <img class="profile" width="40px" height="40px" src="profile_pic1.jpg">
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
                <img width="40px" height="40px" src="follow_request_img.png">
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
                    <img class="notif_user_img" width="40px" height="40px" src="profile_pic3.jpg">
                    <div class="notif_group_text">
                        <p class="user_text">jws.pjs&nbsp;</p>
                        <p class="notif_info">liked your post. 1m</p>
                    </div>
                    <img class="notif_post_img" width="40px" height="40px" src="post_sample.jpg">
                </div>

                <div class="earlier_wrapper">
                    <img class="notif_user_img" width="40px" height="40px" src="profile_pic3.jpg">
                    <div class="notif_group_text">
                        <p class="user_text">jws.pjs&nbsp;</p>
                        <p class="notif_info">liked your post. 1m</p>
                    </div>
                    <img class="notif_post_img" width="40px" height="40px" src="post_sample2.jpg">
                </div>
            </div>

            <br>
            <hr class="notif_line">
            <br>
            <div class="earlier">
                <p class="earlier_text">New</p>
                <div class="earlier_wrapper">
                    <img class="notif_user_img" width="40px" height="40px" src="profile_pic6.jpg">
                    <div class="notif_group_text">
                        <p class="user_text">jws.pjs&nbsp;</p>
                        <p class="notif_info">liked your post. 1m</p>
                    </div>
                    <img class="notif_post_img" width="40px" height="40px" src="post_sample.jpg">
                </div>

                <div class="earlier_wrapper">
                    <img class="notif_user_img" width="40px" height="40px" src="profile_pic7.jpg">
                    <div class="notif_group_text">
                        <p class="user_text">jws.pjs&nbsp;</p>
                        <p class="notif_info">liked your post. 1m</p>
                    </div>
                    <img class="notif_post_img" width="40px" height="40px" src="post_sample2.jpg">
                </div>

                <div class="earlier_wrapper">
                    <img class="notif_user_img" width="40px" height="40px" src="profile_pic5.jpg">
                    <div class="notif_group_text">
                        <p class="user_text">jws.pjs&nbsp;</p>
                        <p class="notif_info">liked your post. 1m</p>
                    </div>
                    <img class="notif_post_img" width="40px" height="40px" src="post_sample2.jpg">
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
            <img class="user_profile_img" width="40px" height="40px" src="profile_pic1.jpg">
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

            </div>

            <div class="chatheads_users_group">

                <!-- single user containner -->
                <div class="chatheads_user_wrap">
                    <img class="chatheads_user_img" width="50px" height="50px" src="profile_pic5.jpg">
                    <div class="chatheads_user_text_group">
                        <p class="chatheads_user_name">Cee Lee</p>
                        <p class="chatheads_last_message"><?php 

                                        if (!empty($_SESSION['messages'])) {

                                            $last_message = end($_SESSION['messages']);
                                            echo htmlspecialchars($last_message['message']);
                                        } else {

                                            echo "no message yet.";
                                        }?>
                        </p>
                    </div>
                </div>

            </div>


        </div>


        <!-- chat box -->
        <div class="chat_box_containner">

            <!-- main chat box -->
            <div class="chat_box" id="chatBox">

                <div class="chat_box_navbar">
                    <div class="chat_box_img_status">
                        <img id="user_img_status" width="40px" height="40px" src="profile_pic5.jpg">
                        <ion-icon id="user_status_icon" name="ellipse"></ion-icon>
                    </div>
                    
                    <div class="chat_box_text_group">
                        <p class="chat_box_user_name">Cee Lee</p>
                        <p class="chat_box_status_text">Active now</p>
                    </div>
                    
                    <ion-icon class="chat_box_nav_option" name="ellipsis-horizontal-outline" onclick="toggleOption()"></ion-icon>
                </div>

                <div class="chat_box_conversation">

                    

                        <!-- your message -->
                        <?php if (!empty($_SESSION['messages'])): ?>
                            <?php for ($i = count($_SESSION['messages']) - 1; $i >= 0; $i--): ?>
                                <div class="your_message_wrap">      
                                    <p class="your_message"><?php echo htmlspecialchars($_SESSION['messages'][$i]['message']); ?></p>  
                                </div>
                            <?php endfor; ?>
                        <?php else: ?>
                            
                        <?php endif; ?>

                        <!-- partner message -->
                        <div class="partner_chat_group">
                            <img id="partner_chat_img" width="40px" height="40px" src="profile_pic5.jpg">
                            <p id="partner_message">Hello World!</p>
                        </div>

                    

                    <div class="conversation_partner_profile">
                        <img id="partner_img" width="100px" height="100px" src="profile_pic5.jpg">
                        <p id="partner_name">Cee Lee</p>
                        <button id="view_partner_profile">View Profile</button>
                    </div>

                </div>

                <form class="send_message_group" action="" method="POST">
                    
                    <!-- hidden input file -->
                    <input type="file" id="uploadImage" name="uploadedImage" accept="image/*"/>

                    <label id="send_img" for="uploadImage">
                        <ion-icon class="create_post_img_icon" name="images-outline"></ion-icon>
                    </label>

                    <input type="text" id="message" name="message" required placeholder="Aa">

                    <button id="send_text" type="submit" value="Submit">
                        <ion-icon name="paper-plane"></ion-icon>
                    </button>

                </form>

            </div>

            <!-- message option dropdown -->
            <div class="message_option_dropdown" id="optionDropdown">

                <div class="message_option_title">
                    <ion-icon id="option_close_button" name="close" onclick="toggleOption()"></ion-icon>
                    <p class="option_text_profile">Profile</p>
                </div>

                <div class="main_option_content">
                    
                    <div class="option_user_group">
                        <img class="option_user_img" width="100px" height="100px" src="profile_pic5.jpg">
                        <p class="option_user_name">Cee Lee</p>
                    </div>

                    <div class="option_files">
                        
                        <div class="files_title_group">
                            <p class="files_title_name">Photos</p>
                            <ion-icon class="files_expand_btn" name="chevron-forward"></ion-icon>
                        </div>

                        <div class="files_content_group">
                            <img class="files_sample" width="100px" height="100px" src="profile_pic1.jpg">
                            <img class="files_sample" width="100px" height="100px" src="profile_pic2.jpg">
                            <img class="files_sample" width="100px" height="100px" src="profile_pic3.jpg">
                            <img class="files_sample" width="100px" height="100px" src="profile_pic4.jpg">
                            <img class="files_sample" width="100px" height="100px" src="profile_pic5.jpg">
                            <img class="files_sample" width="100px" height="100px" src="profile_pic6.jpg">
                        </div>

                    </div>

                    <div class="lower_option_group">
                        <a class="red_option_btn" onclick="deleteToggle()">Delete conversation</a>
                        <a class="red_option_btn">Block</a>
                    </div>

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








    <!-- <h1>Leave a Message</h1> -->

    <!-- Form for submitting a message 
    <form action="" method="POST">
        <label for="name">Your Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="message">Your Message:</label><br>
        <textarea id="message" name="message" rows="4" cols="50" required></textarea><br><br>

        <input type="submit" value="Submit">
    </form>
    <form method="POST">
        <input type="submit" name="clear" value="Clear Messages">
    </form>
    -->


    <!-- Display messages -->
    <!--
    <h2>Messages:</h2>
    <?php //if (!empty($_SESSION['messages'])): ?>
        <ul>
            <?php //foreach ($_SESSION['messages'] as $msg): ?>
                <li>
                    <strong><?php //echo $msg['name']; ?>:</strong>
                    <?php //echo $msg['message']; ?>
                    <br><small><?php //echo $msg['time']; ?></small>
                </li>
            <?php //endforeach; ?>
        </ul>
    <?php //else: ?>
        <p>No messages yet.</p>
    <?php //endif; ?>
    -->



    <!-- framework -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
    <!-- js -->
    <script src="message.js"></script>


</body>

</html>
