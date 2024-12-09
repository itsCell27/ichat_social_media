<?php
// Include database connection
require 'db.php';
session_start();

// Get the logged-in user's ID from the session
$current_user_id = $_SESSION['user_id'] ?? null;


$sql = "SELECT * FROM users WHERE user_id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $current_user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "<p>Database error: " . $conn->error . "</p>";
    exit();
}

// Check if a user ID is provided in the URL (for viewing other users' saved posts)
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : $current_user_id;

// Ensure we have a valid user ID to proceed
if (!$user_id) {
    echo "<p>User ID is required.</p>";
    exit;
}

// Prepare the SQL query to fetch saved posts along with the counts for likes, comments, shares, and user info
$sqli = "
    SELECT p.*, u.username, u.user_id AS post_user_id, 
           (SELECT COUNT(*) FROM likes WHERE post_id = p.post_id) AS likes_count, 
           (SELECT COUNT(*) FROM comments WHERE post_id = p.post_id) AS comments_count, 
           (SELECT COUNT(*) FROM shares WHERE post_id = p.post_id) AS shares_count 
    FROM saved s
    JOIN posts p ON s.post_id = p.post_id
    JOIN users u ON p.user_id = u.user_id
    WHERE s.user_id = ?
    ORDER BY s.saved_at DESC
";


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Saved</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=library_add,notifications" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=search" />
    <script src="https://kit.fontawesome.com/fa0399c701.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/view_saved_posts.css">
</head>
<body>  

    <!-- navbar start -->

    <!-- search_bar dropdown -->
    <div class="search_bar_dropdown" id="searchBarDropdown">
        <div class="search_bar">
            <button class="search_back" id="back_search">
                <ion-icon class="search_back_btn" name="arrow-back-outline" onclick="toggleSearch()"></ion-icon>
            </button>
            <div class="search_after">
                <input class="search_input_after" type="search" id="search" placeholder="Search" onkeyup="searchUser()">
            </div>
        </div>
        <div class="search_suggestion">
            <div class="search_bar_result">
                <img class="search_result_img" src="css/imgs/profile_pic4.jpg">
                <p class="search_result_name" id="result"></p>
            </div>
        </div>
    </div>
    <!-- sear_bar dropdown ending -->

    <!-- navbar -->
    <header class="navbar">

        <div class="left_icon">

            <img id="logo_hide" class="logo" width="40px" height="40px" src="css/imgs/ichat_logo4.jpg" onclick="window.location.href='home.php'">

            <div id="searchBefore" class="search_before" onclick="toggleSearch()">
                <button class="search_btn">
                    <span class="material-symbols-rounded">
                        search
                    </span>
                </button>
                
                <p class="search_input">Search</p>
            </div>

        </div>

        <div class="middle_icons">
            <div class="middle_icons_wrap">

                <div class="middle_icon_wrap" onclick="window.location.href='home.php'">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="4vw" height="4vh"><path d="M23.121,9.069,15.536,1.483a5.008,5.008,0,0,0-7.072,0L.879,9.069A2.978,2.978,0,0,0,0,11.19v9.817a3,3,0,0,0,3,3H21a3,3,0,0,0,3-3V11.19A2.978,2.978,0,0,0,23.121,9.069ZM15,22.007H9V18.073a3,3,0,0,1,6,0Zm7-1a1,1,0,0,1-1,1H17V18.073a5,5,0,0,0-10,0v3.934H3a1,1,0,0,1-1-1V11.19a1.008,1.008,0,0,1,.293-.707L9.878,2.9a3.008,3.008,0,0,1,4.244,0l7.585,7.586A1.008,1.008,0,0,1,22,11.19Z"/></svg>

                    <!-- hidden, only visible when hovering -->
                    <p class="middle_icon_name">Home</p>
                </div>

                <div class="middle_icon_wrap" onclick="window.location.href='message.php'">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="4vw" height="4vh"><path d="M24,11.247A12.012,12.012,0,1,0,12.017,24H19a5.005,5.005,0,0,0,5-5V11.247ZM22,19a3,3,0,0,1-3,3H12.017a10.041,10.041,0,0,1-7.476-3.343,9.917,9.917,0,0,1-2.476-7.814,10.043,10.043,0,0,1,8.656-8.761A10.564,10.564,0,0,1,12.021,2,9.921,9.921,0,0,1,18.4,4.3,10.041,10.041,0,0,1,22,11.342Z"/><path d="M8,9h4a1,1,0,0,0,0-2H8A1,1,0,0,0,8,9Z"/><path d="M16,11H8a1,1,0,0,0,0,2h8a1,1,0,0,0,0-2Z"/><path d="M16,15H8a1,1,0,0,0,0,2h8a1,1,0,0,0,0-2Z"/></svg>

                    <!-- hidden, only visible when hovering -->
                    <p class="middle_icon_name">Chats</p>
                </div>

                <div class="middle_icon_wrap" onclick="location.reload();">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="4vw" height="4vh"><path d="M20.137,24a2.8,2.8,0,0,1-1.987-.835L12,17.051,5.85,23.169a2.8,2.8,0,0,1-3.095.609A2.8,2.8,0,0,1,1,21.154V5A5,5,0,0,1,6,0H18a5,5,0,0,1,5,5V21.154a2.8,2.8,0,0,1-1.751,2.624A2.867,2.867,0,0,1,20.137,24ZM6,2A3,3,0,0,0,3,5V21.154a.843.843,0,0,0,1.437.6h0L11.3,14.933a1,1,0,0,1,1.41,0l6.855,6.819a.843.843,0,0,0,1.437-.6V5a3,3,0,0,0-3-3Z"/></svg>

                    <!-- hidden, only visible when hovering -->
                    <p class="middle_icon_name">Saved</p>
                </div>
            </div>
        </div>   

        <div class="right_icon">

            <!-- hidden -->
            <button class="menu_btn" onclick="toggleMenu()">
                <ion-icon id="menu_icon" name="grid-outline"></ion-icon>

                <!-- hidden, only visible when hovering -->
                <p class="menu_icon_name">Menu</p> 
            </button>

            <button class="notif_icon" onclick="toggleNotifications()">
                <span class="material-symbols-outlined">
                notifications
                </span>

                <!-- hidden, only visible when hovering -->
                <p class="notif_icon_name">Notifications</p>
            </button>
            <button class="profile_btn" onclick="toggleProfile()">
                <img class="profile" width="40px" height="40px" src="<?php echo htmlspecialchars($user['profile_picture'] ?? 'default_profile_pic.jpg'); ?>">

                <!-- hidden, only visible when hovering -->
                <p class="profile_icon_name">Profile</p>
            </button>
        </div>

    </header>

    <!-- menu dropdown -->
    <div id="menuDropdown" class="menu_dropdown">
        <div class="menu_text_group">
            <p class="menu_text">Menu</p>
        </div>
    
        <br>
        <div class="menu_options">
            <div class="menu_options_wrap" onclick="window.location.href='home.php'">
                <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="30px" height="30px"><path d="M23.121,9.069,15.536,1.483a5.008,5.008,0,0,0-7.072,0L.879,9.069A2.978,2.978,0,0,0,0,11.19v9.817a3,3,0,0,0,3,3H21a3,3,0,0,0,3-3V11.19A2.978,2.978,0,0,0,23.121,9.069ZM15,22.007H9V18.073a3,3,0,0,1,6,0Zm7-1a1,1,0,0,1-1,1H17V18.073a5,5,0,0,0-10,0v3.934H3a1,1,0,0,1-1-1V11.19a1.008,1.008,0,0,1,.293-.707L9.878,2.9a3.008,3.008,0,0,1,4.244,0l7.585,7.586A1.008,1.008,0,0,1,22,11.19Z"/></svg>

                <p>Home</p>
            </div>
            <div class="menu_options_wrap" onclick="window.location.href='message.php'">
                <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="30px" height="30px"><path d="M24,11.247A12.012,12.012,0,1,0,12.017,24H19a5.005,5.005,0,0,0,5-5V11.247ZM22,19a3,3,0,0,1-3,3H12.017a10.041,10.041,0,0,1-7.476-3.343,9.917,9.917,0,0,1-2.476-7.814,10.043,10.043,0,0,1,8.656-8.761A10.564,10.564,0,0,1,12.021,2,9.921,9.921,0,0,1,18.4,4.3,10.041,10.041,0,0,1,22,11.342Z"/><path d="M8,9h4a1,1,0,0,0,0-2H8A1,1,0,0,0,8,9Z"/><path d="M16,11H8a1,1,0,0,0,0,2h8a1,1,0,0,0,0-2Z"/><path d="M16,15H8a1,1,0,0,0,0,2h8a1,1,0,0,0,0-2Z"/></svg>

                <p>Chats</p>
            </div>
            <div class="menu_options_wrap" onclick="location.reload();">
                <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="30px" height="30px"><path d="M20.137,24a2.8,2.8,0,0,1-1.987-.835L12,17.051,5.85,23.169a2.8,2.8,0,0,1-3.095.609A2.8,2.8,0,0,1,1,21.154V5A5,5,0,0,1,6,0H18a5,5,0,0,1,5,5V21.154a2.8,2.8,0,0,1-1.751,2.624A2.867,2.867,0,0,1,20.137,24ZM6,2A3,3,0,0,0,3,5V21.154a.843.843,0,0,0,1.437.6h0L11.3,14.933a1,1,0,0,1,1.41,0l6.855,6.819a.843.843,0,0,0,1.437-.6V5a3,3,0,0,0-3-3Z"/></svg>

                <p>Saved</p>
            </div>
        </div>
    </div>

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
    <!-- notification dropdown ending -->

    <!-- profile dropdown -->
    <div class="profile_dropdown" id="profileDropdown">
        <div class="profile_title">
            <p class="profile_text">Profile</p>
        </div>
        <br>
        <hr class="notif_line">
        <br>
        <div class="user_profile_wrapper" onclick="window.location.href='user_profile.php'">
            <img class="user_profile_img" width="40px" height="40px" src="<?php echo htmlspecialchars($user['profile_picture'] ?? 'default_profile_pic.jpg'); ?>">
            <p class="user_text_name"><?php echo htmlspecialchars($user['username']) ?></p>
        </div>
        <br>
        <hr class="notif_line">
        <br>
        <div class="profile_menu">
            <div class="profile_menu_btn" onclick="window.location.href='settings.php'">
                <button class="profile_settings">
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
    <!-- profile dropdown ending -->
    <!-- navbar ending -->

    <!-- main saved post -->
    <div class="main_saved_post">
        <div class="saved_post_group">
            <h1 class="saved_post_text">Saved Posts</h1>
        </div>
        <div class="saved_post_content">
            <?php

                // Prepare and execute the SQL statement
                if ($stmt = $conn->prepare($sqli)) {
                    // Bind the user ID parameter to the query
                    $stmt->bind_param("i", $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Check if there are saved posts
                    if ($result->num_rows > 0) {
                        // Start the HTML output

                        while ($post = $result->fetch_assoc()) {
                            // Display each post with likes, comments, and shares
                            echo "<div class='post'>";
                            
                            // User Profile and Username
                            echo "<div class='upper_post_tag'>";
                            echo "<img class='user_profile' width='50px' height='50px' src='css/imgs/profile_pic5.jpg'>"; // Update with dynamic profile image if needed
                            echo "<div class='post_text'>";
                            echo "<h3><a href='user_profile.php?id=" . htmlspecialchars($post['post_user_id']) . "'>" . htmlspecialchars($post['username']) . "</a></h3>";
                            echo "<p class='post_time'>" . htmlspecialchars(timeAgo($post['created_at'])) . "</p>";
                            echo "</div>";
                            echo "</div>";
                            
                            // Post content
                            echo "<p>" . nl2br(htmlspecialchars($post['content'])) . "</p>";
                            
                            // Display image if available
                            if ($post['image_url']) {
                                echo "<div class";
                                echo "<img src='" . htmlspecialchars($post['image_url']) . "' alt='Post Image' />";
                            }

                            // Display video if available
                            if ($post['video_url']) {
                                echo "<video controls src='" . htmlspecialchars($post['video_url']) . "' ></video>";
                            }

                            // Likes, comments, shares
                            echo "<p><strong>Likes:</strong> " . $post['likes_count'] . " | 
                                    <strong>Comments:</strong> " . $post['comments_count'] . " | 
                                    <strong>Shares:</strong> " . $post['shares_count'] . "</p>";

                            // Created at date
                            echo "<p><small>Created on: " . date('F j, Y, g:i a', strtotime($post['created_at'])) . "</small></p>";

                            // Additional post details
                            echo "<p><strong>Privacy:</strong> " . htmlspecialchars($post['privacy']) . "</p>";
                            echo "<p><strong>Updated at:</strong> " . date('F j, Y, g:i a', strtotime($post['updated_at'])) . "</p>";
                            
                            echo "</div><hr>";
                        }
                    } else {
                        // No saved posts found
                        echo "<p>No saved posts found.</p>";
                    }

                    // Close the prepared statement
                    $stmt->close();
                } else {
                    // Error preparing the SQL query
                    echo "<p>Error preparing the query.</p>";
                }

                // Close the database connection
                $conn->close();

                // Function to format time (you can implement your own or use an existing time ago function)
                function timeAgo($datetime) {
                    $time_ago = strtotime($datetime);
                    $current_time = time();
                    $time_difference = $current_time - $time_ago;
                    $seconds = $time_difference;
                    
                    // Calculate time difference and return readable format (you can extend this to include more granular time)
                    $minutes = round($seconds / 60);           // value 60 is seconds
                    $hours = round($seconds / 3600);           // value 3600 is 60 minutes * 60 sec
                    $days = round($seconds / 86400);           // value 86400 is 24 hours * 60 minutes * 60 sec
                    $weeks = round($seconds / 604800);         // value 604800 is 7 days * 24 hours * 60 minutes * 60 sec
                    $months = round($seconds / 2629440);       // value 2629440 is ((365+365+365+365)/4/12) days * 24 hours * 60 minutes * 60 sec
                    $years = round($seconds / 31553280);       // value 31553280 is ((365+365+365+365)/4) days * 24 hours * 60 minutes * 60 sec
                    
                    if ($seconds <= 60) {
                        return "Just Now";
                    } else if ($minutes <= 60) {
                        return "$minutes minutes ago";
                    } else if ($hours <= 24) {
                        return "$hours hours ago";
                    } else if ($days <= 7) {
                        return "$days days ago";
                    } else if ($weeks <= 4.3) { // 4.3 == 30/7
                        return "$weeks weeks ago";
                    } else if ($months <= 12) {
                        return "$months months ago";
                    } else {
                        return "$years years ago";
                    }
                }
            ?>
        </div>
    </div>
    <!-- main saved post ending -->

        




    <!-- framework -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <!-- js -->
     <script src="view_saved_post.js"></script>


</body>
</html>
