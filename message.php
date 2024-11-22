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

// Function to convert URLs to clickable links
function makeLinksClickable($text) {
    // Regular expression to identify URLs
    $pattern = '/(https?:\/\/[^\s]+)/';

    // Replace URLs with clickable links
    $text = preg_replace($pattern, '<a id="link_clickable" href="$1" target="_blank" rel="noopener noreferrer">$1</a>', $text);

    return $text;
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
    <link rel="stylesheet" href="css/message.css">
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
            
            <input class="search_input" type="search" placeholder="Search">
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

            </div>

            <div class="chatheads_users_group">

                <!-- single user containner -->
                <div class="chatheads_user_wrap">
                    <img class="chatheads_user_img" src="css/imgs/profile_pic5.jpg">
                    <div class="chatheads_user_text_group">
                        <p class="chatheads_user_name">Cee Lee</p>
                        <p class="chatheads_last_message">
                        <?php 
                            if (!empty($_SESSION['messages'])) {
                                $last_message = end($_SESSION['messages']);
                                echo makeLinksClickable(htmlspecialchars($last_message['message']));
                                //echo "has sent a message";
                            } else {
                                echo "no message yet.";
                            }
                        ?>
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
                        <img id="user_img_status" width="40px" height="40px" src="css/imgs/profile_pic5.jpg">
                        <ion-icon id="user_status_icon" name="ellipse"></ion-icon>
                    </div>
                    
                    <div class="chat_box_text_group">
                        <p class="chat_box_user_name">Cee Lee</p>
                        <p class="chat_box_status_text">Active now</p>
                    </div>
                    
                    <ion-icon class="chat_box_nav_option" name="ellipsis-horizontal-outline" onclick="toggleOption()"></ion-icon>
                </div>

                <div class="chat_box_conversation">

                    

                        <!-- Display your messages -->
                        <?php if (!empty($_SESSION['messages'])): ?>
                            <?php for ($i = count($_SESSION['messages']) - 1; $i >= 0; $i--): ?>
                                <div class="your_message_wrap">      
                                    <p class="your_message">
                                        <?php echo makeLinksClickable($_SESSION['messages'][$i]['message']); ?>
                                    </p>  
                                </div>
                            <?php endfor; ?>
                        <?php else: ?>
                            
                        <?php endif; ?>


                        <!-- partner message -->
                        <div class="partner_chat_group">
                            <img id="partner_chat_img" width="40px" height="40px" src="css/imgs/profile_pic5.jpg">
                            <p id="partner_message">Hello World!</p>
                        </div>

                    

                    <div class="conversation_partner_profile">
                        <img id="partner_img" width="100px" height="100px" src="css/imgs/profile_pic5.jpg">
                        <p id="partner_name">Cee Lee</p>
                        <button id="view_partner_profile">View Profile</button>
                    </div>

                </div>

                <form class="send_message_group" action="" method="POST" enctype="multipart/form-data">
                    
                    <!-- hidden input file -->
                    <input type="file" id="uploadImage" name="uploadedImages[]" accept="image/*" multiple/>

                    <label id="send_img" for="uploadImage">
                        <ion-icon class="create_post_img_icon" name="images-outline"></ion-icon>
                    </label>
                    
                    <div class="message_input_containner">

                        <!-- hidden -->
                        <div class="message_img_preview_group">
                            <label id="add_img" for="uploadImage">
                                <svg class="add_svg" version="1.0" xmlns="http://www.w3.org/2000/svg"
                                viewBox="0 0 512.000000 512.000000"
                                preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0.000000,512.000000) scale(0.100000,-0.100000)"
                                fill="#000000" stroke="none">
                                <path d="M1640 4621 c-80 -21 -164 -59 -225 -101 -96 -66 -214 -245 -245 -371
                                -6 -25 -21 -115 -34 -200 l-21 -154 -165 -6 c-141 -5 -176 -10 -238 -32 -160
                                -56 -296 -170 -369 -312 -79 -152 -74 -74 -74 -1309 0 -748 3 -1117 11 -1149
                                41 -186 174 -354 345 -438 152 -74 54 -70 1506 -67 l1304 3 80 23 c242 67 399
                                222 453 449 17 71 18 73 52 78 155 24 266 80 375 190 115 114 166 220 186 379
                                5 45 71 518 146 1051 135 964 136 971 124 1061 -27 227 -128 387 -313 497
                                -129 77 -57 65 -1933 327 -159 22 -383 54 -496 70 -238 35 -371 38 -469 11z
                                m690 -365 c217 -31 508 -72 645 -92 1259 -176 1305 -183 1358 -207 125 -59
                                173 -120 197 -255 10 -56 6 -94 -34 -380 -25 -174 -89 -625 -141 -1001 -59
                                -422 -103 -707 -116 -743 -35 -106 -81 -162 -159 -197 -88 -40 -79 -143 -82
                                937 l-3 957 -27 73 c-37 101 -82 173 -156 248 -73 74 -154 124 -261 162 l-76
                                27 -1017 3 c-829 2 -1018 5 -1018 15 0 41 33 239 46 280 20 60 86 159 122 183
                                15 10 52 26 82 36 81 26 183 19 640 -46z m1128 -813 c117 -40 179 -111 207
                                -237 14 -63 15 -194 13 -1106 l-3 -1035 -24 -60 c-31 -79 -97 -145 -176 -176
                                l-60 -24 -1240 -3 c-864 -2 -1259 0 -1304 8 -127 22 -211 84 -253 188 l-23 57
                                0 1075 c0 1216 -5 1133 80 1228 50 56 116 88 203 101 31 5 611 8 1287 7 l1230
                                -1 63 -22z"/>
                                <path d="M2086 2820 c-41 -13 -94 -68 -106 -110 -5 -19 -10 -122 -10 -227 l0
                                -193 -209 0 c-199 0 -209 -1 -241 -22 -48 -33 -72 -70 -77 -120 -7 -58 23
                                -118 74 -149 36 -23 48 -24 245 -27 l207 -3 3 -207 c3 -197 4 -209 27 -245 31
                                -51 91 -81 149 -74 50 5 87 29 120 77 21 32 22 42 22 241 l0 209 193 0 c105 0
                                208 4 226 10 47 13 99 66 112 112 17 64 -17 148 -74 181 -15 8 -92 14 -237 17
                                l-215 5 -5 217 c-6 246 -8 253 -90 296 -47 23 -67 26 -114 12z"/>
                                </g>
                                </svg>
                            </label>
                            <div id="imagePreviewContainer">

                            </div>
                            <!-- <div class="img_preview_wrap" >

                                absolute -->
                                <!-- <div class="img_close_wrap">
                                    <ion-icon class="close_img_preview" name="close"></ion-icon>
                                </div> -->
                                
                            <!-- </div> --> 
                        </div>

                        <input type="text" id="message" name="message" required placeholder="Aa">

                    </div>

                    <button id="send_text" type="submit" value="Submit">
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
