<?php
session_start();
include 'db.php';
include 'friends_of_friends.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

$user_id = $_SESSION['user_id'];


$sql = "SELECT * FROM users WHERE user_id = ?";
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
} else {
    echo "<p>Database error: " . $conn->error . "</p>";
    exit();
}

date_default_timezone_set("Asia/Manila");
function timeAgo($datetime)
{
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=library_add,notifications" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=search" />
    <link rel="stylesheet" href="view_stories.css">
    <script src="https://kit.fontawesome.com/fa0399c701.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="home_main.css">
    <link rel="stylesheet" href="css/home.css">
    <!-- <link rel="stylesheet" href="css/home.css"> -->
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
        <div class="search_suggestion" id="result">
            <!-- the output is in search_handler.php -->
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

                <div class="middle_icon_wrap" onclick="location.reload();">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="4vw" height="4vh">
                        <path d="M23.121,9.069,15.536,1.483a5.008,5.008,0,0,0-7.072,0L.879,9.069A2.978,2.978,0,0,0,0,11.19v9.817a3,3,0,0,0,3,3H21a3,3,0,0,0,3-3V11.19A2.978,2.978,0,0,0,23.121,9.069ZM15,22.007H9V18.073a3,3,0,0,1,6,0Zm7-1a1,1,0,0,1-1,1H17V18.073a5,5,0,0,0-10,0v3.934H3a1,1,0,0,1-1-1V11.19a1.008,1.008,0,0,1,.293-.707L9.878,2.9a3.008,3.008,0,0,1,4.244,0l7.585,7.586A1.008,1.008,0,0,1,22,11.19Z" />
                    </svg>

                    <!-- hidden, only visible when hovering -->
                    <p class="middle_icon_name">Home</p>
                </div>

                <div class="middle_icon_wrap" onclick="window.location.href='message.php'">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="4vw" height="4vh">
                        <path d="M24,11.247A12.012,12.012,0,1,0,12.017,24H19a5.005,5.005,0,0,0,5-5V11.247ZM22,19a3,3,0,0,1-3,3H12.017a10.041,10.041,0,0,1-7.476-3.343,9.917,9.917,0,0,1-2.476-7.814,10.043,10.043,0,0,1,8.656-8.761A10.564,10.564,0,0,1,12.021,2,9.921,9.921,0,0,1,18.4,4.3,10.041,10.041,0,0,1,22,11.342Z" />
                        <path d="M8,9h4a1,1,0,0,0,0-2H8A1,1,0,0,0,8,9Z" />
                        <path d="M16,11H8a1,1,0,0,0,0,2h8a1,1,0,0,0,0-2Z" />
                        <path d="M16,15H8a1,1,0,0,0,0,2h8a1,1,0,0,0,0-2Z" />
                    </svg>

                    <!-- hidden, only visible when hovering -->
                    <p class="middle_icon_name">Chats</p>
                </div>

                <div class="middle_icon_wrap" onclick="window.location.href='view_saved_posts.php'">
                    <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="4vw" height="4vh">
                        <path d="M20.137,24a2.8,2.8,0,0,1-1.987-.835L12,17.051,5.85,23.169a2.8,2.8,0,0,1-3.095.609A2.8,2.8,0,0,1,1,21.154V5A5,5,0,0,1,6,0H18a5,5,0,0,1,5,5V21.154a2.8,2.8,0,0,1-1.751,2.624A2.867,2.867,0,0,1,20.137,24ZM6,2A3,3,0,0,0,3,5V21.154a.843.843,0,0,0,1.437.6h0L11.3,14.933a1,1,0,0,1,1.41,0l6.855,6.819a.843.843,0,0,0,1.437-.6V5a3,3,0,0,0-3-3Z" />
                    </svg>

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
            <div class="menu_options_wrap" onclick="location.reload();">
                <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="30px" height="30px">
                    <path d="M23.121,9.069,15.536,1.483a5.008,5.008,0,0,0-7.072,0L.879,9.069A2.978,2.978,0,0,0,0,11.19v9.817a3,3,0,0,0,3,3H21a3,3,0,0,0,3-3V11.19A2.978,2.978,0,0,0,23.121,9.069ZM15,22.007H9V18.073a3,3,0,0,1,6,0Zm7-1a1,1,0,0,1-1,1H17V18.073a5,5,0,0,0-10,0v3.934H3a1,1,0,0,1-1-1V11.19a1.008,1.008,0,0,1,.293-.707L9.878,2.9a3.008,3.008,0,0,1,4.244,0l7.585,7.586A1.008,1.008,0,0,1,22,11.19Z" />
                </svg>

                <p>Home</p>
            </div>
            <div class="menu_options_wrap" onclick="window.location.href='message.php'">
                <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="30px" height="30px">
                    <path d="M24,11.247A12.012,12.012,0,1,0,12.017,24H19a5.005,5.005,0,0,0,5-5V11.247ZM22,19a3,3,0,0,1-3,3H12.017a10.041,10.041,0,0,1-7.476-3.343,9.917,9.917,0,0,1-2.476-7.814,10.043,10.043,0,0,1,8.656-8.761A10.564,10.564,0,0,1,12.021,2,9.921,9.921,0,0,1,18.4,4.3,10.041,10.041,0,0,1,22,11.342Z" />
                    <path d="M8,9h4a1,1,0,0,0,0-2H8A1,1,0,0,0,8,9Z" />
                    <path d="M16,11H8a1,1,0,0,0,0,2h8a1,1,0,0,0,0-2Z" />
                    <path d="M16,15H8a1,1,0,0,0,0,2h8a1,1,0,0,0,0-2Z" />
                </svg>

                <p>Chats</p>
            </div>
            <div class="menu_options_wrap" onclick="window.location.href='view_saved_post.php'">
                <svg xmlns="http://www.w3.org/2000/svg" id="Outline" viewBox="0 0 24 24" width="30px" height="30px">
                    <path d="M20.137,24a2.8,2.8,0,0,1-1.987-.835L12,17.051,5.85,23.169a2.8,2.8,0,0,1-3.095.609A2.8,2.8,0,0,1,1,21.154V5A5,5,0,0,1,6,0H18a5,5,0,0,1,5,5V21.154a2.8,2.8,0,0,1-1.751,2.624A2.867,2.867,0,0,1,20.137,24ZM6,2A3,3,0,0,0,3,5V21.154a.843.843,0,0,0,1.437.6h0L11.3,14.933a1,1,0,0,1,1.41,0l6.855,6.819a.843.843,0,0,0,1.437-.6V5a3,3,0,0,0-3-3Z" />
                </svg>

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
            <div class="profile_menu_btn" onclick="window.location.href='logout.php'">
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

    <!-- menu -->
    <div class="menu">
        <div class="icons_menu">

            <div class="icon_wrapper" onclick="location.reload()">
                <svg class="icons_svg_menu" xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#000000">
                    <path d="M234-194h165v-210q0-11.98 7.76-19.74 7.76-7.76 19.74-7.76h108q10.82 0 18.66 7.76T561-404v210h165v-353.67q0-8-3.5-14.5t-9.5-11.5L499-735q-8-6-19-6t-19 6L247-573.67q-6 5-9.5 11.5t-3.5 14.5V-194Zm-22 0v-353q0-13.69 5.03-24.5T234-590l214-163q13.76-11 31.88-11Q498-764 512-753l214 163q11.94 7.69 16.97 18.5Q748-560.69 748-547v353q0 8.52-6.74 15.26Q734.53-172 726-172H566.5q-11.97 0-19.74-7.76-7.76-7.76-7.76-19.74v-210H421v210q0 11.98-7.81 19.74-7.8 7.76-18.58 7.76H233.56q-8.02 0-14.79-6.74T212-194Zm268-275Z" />
                </svg>
                <p class="icon_name">Home</p>
            </div>

            <div class="icon_wrapper" onclick="window.location.href='message.php'">
                <svg class="icons_svg_menu" xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#000000">
                    <path d="M243.58-292 178-226q-13 13-29.5 6.42T132-245.5v-528.67q0-22.07 15.88-37.95Q163.76-828 185.78-828h588.44q22.02 0 37.9 15.88Q828-796.24 828-774.2v428.4q0 22.04-15.88 37.92Q796.24-292 774.21-292H243.58Zm-9.08-22H774q12 0 22-10t10-22v-428q0-12-10-22t-22-10H186q-12 0-22 10t-10 22v542l80.5-82Zm-80.5 0v-492 492Zm123.5-112h244q4.07 0 7.29-3.19 3.21-3.2 3.21-8 0-4.81-3.21-7.81-3.22-3-7.29-3h-244q-5.23 0-8.36 3.27-3.14 3.27-3.14 7.42 0 5.31 3.14 8.31 3.13 3 8.36 3Zm0-123h406q4.07 0 7.29-3.19 3.21-3.2 3.21-8 0-4.81-3.21-7.81-3.22-3-7.29-3h-406q-5.23 0-8.36 3.27-3.14 3.27-3.14 7.42 0 5.31 3.14 8.31 3.13 3 8.36 3Zm0-123h406q4.07 0 7.29-3.19 3.21-3.2 3.21-8 0-4.81-3.21-7.81-3.22-3-7.29-3h-406q-5.23 0-8.36 3.27-3.14 3.27-3.14 7.42 0 5.31 3.14 8.31 3.13 3 8.36 3Z" />
                </svg>
                <p class="icon_name">Messages</p>
            </div>

            <div class="icon_wrapper" onclick="openModal()">
                <svg class="icons_svg_menu" xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#000000">
                    <path d="M470-468v150.5q0 5.18 3.23 8.34t8 3.16q4.77 0 7.77-3.16t3-8.34V-468h151.5q4.02 0 7.26-3.23t3.24-8q0-4.77-3.24-7.77t-7.26-3H492v-153.5q0-4.02-3.3-7.26-3.31-3.24-7.43-3.24-5.27 0-8.27 3.24t-3 7.26V-490H317.5q-5.18 0-8.34 3.3-3.16 3.31-3.16 7.43 0 5.27 3.16 8.27t8.34 3H470Zm10.57 336q-72.94 0-136.15-27.52-63.2-27.53-110.38-74.85-47.19-47.33-74.61-110.1Q132-407.25 132-479.7q0-72.53 27.52-136.09 27.53-63.56 74.85-110.71 47.33-47.15 110.1-74.32Q407.25-828 479.7-828q72.53 0 136.09 27.39 63.57 27.39 110.72 74.35 47.14 46.96 74.31 110.39Q828-552.43 828-480.57q0 72.94-27.27 136.15-27.28 63.2-74.35 110.2-47.08 47-110.51 74.61Q552.43-132 480.57-132Zm-.64-22q135.57 0 230.82-95.18Q806-344.37 806-479.93q0-135.57-94.93-230.82t-231-95.25q-135.57 0-230.82 94.93t-95.25 231q0 135.57 95.18 230.82Q344.37-154 479.93-154Zm.07-326Z" />
                </svg>
                <p class="icon_name">Create</p>
            </div>

            <div id="modal" class="modal">
                <div class="modal-content">
                    <button onclick="uploadStory()">Upload Story</button>
                    <button onclick="uploadPost()">Upload Post</button>
                </div>
            </div>

            <div id="post-modal" class="modal">
                <div class="modal-content">
                    <h1>Create a New Post</h1>
                    <form id="create-post-form" enctype="multipart/form-data">

                        <textarea name="content" placeholder="Write your post..." required></textarea><br>
                        <label>Upload Image:</label>
                        <input type="file" name="image" accept="image/*"><br>


                        <select name="privacy">
                            <option value="public">Public</option>
                            <option value="friends">Friends</option>
                            <option value="private">Private</option>
                        </select><br>

                        <!-- Tagging Functionality -->
                        <button type="button" onclick="toggleTagSection()">Tag</button><br>
                        <div id="tagSection" class="tag-section">
                            <input type="text" id="searchField" placeholder="Search to tag..." autocomplete="off">
                            <ul id="searchResults" class="tag-list"></ul>
                        </div>
                        <input type="hidden" name="tagged_names" id="taggedNames">

                        <button type="submit">Create Post</button>

                    </form>

                    <div id="response-message"></div>

                    <!-- Display Tagged Users with remove functionality -->
                    <div>
                        <h3>Tagged Users:</h3>
                        <ul id="taggedUsersList" class="tag-list">
                            <!-- Tagged users will appear here -->
                        </ul>
                    </div>

                    <!-- Hidden Field for Logged-in User ID -->
                    <input type="hidden" id="loggedInUserId" value="<?php echo $loggedInUserId; ?>">
                </div>

            </div>

            <div id="story-modal" class="modal">
                <div class="modal-content">
                    <form action="upload_story.php" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="user_id" value="1"><br> <!-- Replace 1 with the logged-in user's ID -->
                        <input type="file" name="story" required><br>
                        <input type="text" name="text_caption" placeholder="Add a caption"><br>
                        <select name="visibility"><br>
                            <option value="public">Public</option>
                            <option value="friends" selected>Friends</option>
                            <option value="private">Private</option>
                        </select>
                        <button type="submit">Upload Story</button>
                    </form>
                </div>
            </div>


            <div class="icon_wrapper" onclick="window.location.href='view_saved_posts.php'">
                <svg class="icons_svg_menu" xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#000000">
                    <path d="m480.5-296-152 65.5q-28.5 11-52.5-4.45t-24-45.55v-455.73q0-21.24 15.88-37.5Q283.76-790 305.78-790h348.44q22.02 0 37.9 16.27Q708-757.47 708-736.23v455.73q0 30.1-24 45.55-24 15.45-51.5 4.45l-152-65.5Zm-.5-25.33L641-252q16 7 30.5-2.5T686-282v-454q0-12-10-22t-22-10H306q-12 0-22 10t-10 22v454q0 18 14.5 27.5T319-252l161-69.33ZM480-768H274h412-206Z" />
                </svg>
                <p class="icon_name">Saved</p>
            </div>

            <div class="icon_wrapper" onclick="window.location.href='settings.php'">
                <svg class="icons_svg_menu" xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#000000">
                    <path d="M436-132q-6 0-11-4t-5.5-10l-13-97.5Q383-250 355-265.75t-47-33.75l-87.5 40q-6.5 2.5-12.26.9-5.76-1.61-8.74-7.4L153-345.5q-3-5-2-10.5t7.5-10.5l79-58.5q-2.5-13.48-3.75-26.99-1.25-13.51-1.25-27.01 0-12 1.25-26t3.25-30l-78.5-59q-6.5-3.92-7.25-10.21-.75-6.29 3.25-11.79l45-76q3.09-4.79 8.8-6.9 5.7-2.1 11.7-.6l87.5 38q21.5-17 47.5-32.5t50.5-22.5l14-97.5q.5-6 5.5-10t11.5-4H524q6 0 11 4t6.5 10l12.82 97.9q26.18 9.6 49.43 23.1Q627-679.5 649-661.5l92.5-38q5.5-1.5 11.26.6 5.76 2.11 9.74 6.9l45 77q3 6 1.75 11.98T802.5-594l-83 61q3 15 4.5 28t1.5 25q0 10.5-1.75 23.67Q722-443.15 719-426.5l80 60q6.5 4.04 7.75 10.02Q808-350.5 805-345.5L761.5-267q-5.09 5.79-11.3 7.4-6.2 1.6-11.2-.9l-90-40q-23 20.5-46.5 35.25t-48 21.25l-13 98q-1.5 6-6.5 10t-11 4h-88Zm3.29-22H520l15.5-111.5q30-8 54.25-21.75T641-326l102.5 44 39.5-69-90-67q3.5-19 6-33.59 2.5-14.59 2.5-28.41 0-16.5-2.25-30.25T693-540l92-69-39.5-69-105 44q-19-20-49.75-39t-56.25-22.5L521.57-806H439l-11.5 110q-33 6.5-58.25 20.75T318-635l-102.5-43-40.5 69 90.5 65.5q-5 14-7 30t-2 33.97q0 17.03 1.75 31.78T264-418l-89 67 40.58 69 101.92-43q23.5 25.5 49.5 39.25T426.5-264l12.79 110Zm38.44-241q35.77 0 60.27-24.55t24.5-60.5q0-35.95-24.54-60.45Q513.43-565 477.5-565q-36 0-60.5 24.55t-24.5 60.5q0 35.95 24.5 60.45t60.73 24.5Zm2.77-85.5Z" />
                </svg>
                <p class="icon_name">Settings</p>
            </div>

            <div class="icon_wrapper menu_profile" onclick="window.location.href='user_profile.php'">
                <img class="profile" width="40px" height="40px"
                    src="<?php echo htmlspecialchars($user['profile_picture'] ?? 'default_profile_pic.jpg'); ?>"
                    alt="Profile Picture">
                <p class="profile_name">
                    <?php echo htmlspecialchars($user['username']) ?>
                </p>
            </div>


        </div>
    </div>

    <main class="main">
        <!-- post feed -->
        <section class="post_feed">
            <?php
            $sql = "SELECT users.user_id, users.username, users.profile_picture, stories.story_id, stories.content_url, stories.text_caption,
            (SELECT COUNT(1) 
            FROM story_views 
            WHERE story_views.user_id = $user_id 
            AND story_views.story_id = stories.story_id) AS viewed
            FROM stories
            JOIN users ON stories.user_id = users.user_id
            WHERE stories.status = 'active' AND stories.expires_at > NOW()
            ORDER BY stories.created_at DESC";

            $result = $conn->query($sql);

            // Array to store users and their stories
            $users_stories = [];

            while ($row = $result->fetch_assoc()) {
                // Check if this user already exists in the array
                if (!isset($users_stories[$row['user_id']])) {
                    // Add the user and their profile details to the array
                    $users_stories[$row['user_id']] = [
                        'username' => $row['username'],
                        'profile_picture' => $row['profile_picture'],
                        'viewed' => $row['viewed'],  // Add the "viewed" status here
                        'stories' => [] // Initialize an empty array for the user's stories
                    ];
                }

                // Add the current story to the user's stories array
                $users_stories[$row['user_id']]['stories'][] = [
                    'story_id' => $row['story_id'],
                    'content_url' => $row['content_url'],
                    'text_caption' => $row['text_caption']
                ];
            }

            ?>
            <!-- post feed story -->
            <div class="post_story">
                <?php
                foreach ($users_stories as $user_id => $user_data) {
                    $borderClass = ($user_data['viewed'] == 0) ? "not-viewed" : "viewed";
                    echo "
                                        <div class='post_story_user'>
                                            <div class='story_img_user_containner $borderClass'>
                                                <img class='post_story_user_img profile-picture $borderClass' src='" . $user_data['profile_picture'] . "' 
                                                    alt='" . $user_data['username'] . "' 
                                                    data-user-id='" . $user_id . "'
                                                >   
                                            </div> 
                                            <p class='post_story_user_text'>" . $user_data['username'] . "</p>
                                        </div>
                                ";
                }
                ?>
            </div>
            <div class="story-overlay" id="storyOverlay">
                <span class="close-btn" onclick="closeStory()">&#10006;</span>
                <img id="storyContent" class="story-content" src="" alt="Story Content">
                <p id="storyCaption"></p>
            </div>

            <!-- user's post -->
            <?php

            // Assuming $user_id is already set from session
            $result = $conn->query("SELECT p.*, u.username, u.profile_picture, GROUP_CONCAT(pt.tag_name) AS tags
                                        FROM posts p
                                        JOIN users u ON p.user_id = u.user_id
                                        LEFT JOIN post_tags pt ON p.post_id = pt.post_id
                                        GROUP BY p.post_id
                                        ORDER BY p.created_at DESC");

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {

                    echo "<div class='post' id='post-" . htmlspecialchars($row['post_id']) . "'>";
                    echo "    <div class='upper_post_tag'>";
                    echo "      <div class='user_profile_group'>";
                    echo "        <img class='user_profile' width='50px' height='50px' src='" . $row['profile_picture'] . "'>";
                    echo "        <div class='post_text'>";

                    // User profile link
                    if ($user_id === $row['user_id']) {
                        echo "            <h3><a href='user_profile.php'>" . htmlspecialchars($row['username']) . "</a></h3>";
                    } else {
                        echo "            <h3><a href='user_profile.php?id=" . htmlspecialchars($row['user_id']) . "'>" . htmlspecialchars($row['username']) . "</a></h3>";
                    }

                    // Display tags (if any)
                    if (!empty($row['tags'])) {
                        echo "            <span class='post-tags'>Tags: " . htmlspecialchars($row['tags']) . "</span>";
                    }

                    echo "            <p class='post_time'>" . htmlspecialchars(timeAgo($row['created_at'])) . "</p>";
                    echo "        </div>";
                    echo "     </div>";
                    echo "        <ion-icon class='toggle_btn' name='ellipsis-horizontal-outline' onclick='togglePostOptions(" . htmlspecialchars($row['post_id']) . ")'></ion-icon>";
                    echo "    </div>";

                    // Post options
                    echo "    <div class='post-options' id='post-options-" . htmlspecialchars($row['post_id']) . "' style='display:none;'>";
                    echo "        <button class='save-post-btn' data-post-id='" . htmlspecialchars($row['post_id']) . "' onclick='savePost(" . htmlspecialchars($row['post_id']) . ")'>Save Post</button>";
                    echo "    </div>";

                    // Post description
                    echo "    <div class='post_description'>";
                    echo "        <p class='text_description'>" . htmlspecialchars($row['content']) . "&nbsp;</p>";
                    echo "        <p class='text_hashtag'></p>";
                    echo "    </div>";

                    // Post image
                    if (!empty($row['image_url'])) {
                        echo "    <div class='post_img_wrapper'>";
                        echo "        <img class='post_img' src='" . htmlspecialchars($row['image_url']) . "'>";
                        echo "    </div>";
                    }

                    // Post video
                    if (!empty($row['video_url'])) {
                        echo "<div class='post_img_wrapper'>";
                        echo "<video width='100%' controls>";
                        echo "<source src='" . htmlspecialchars($row['video_url']) . "' type='video/mp4'>";
                        echo "Your browser does not support the video tag.";
                        echo "</video>";
                        echo "</div>";
                    }

                    // Like section
                    echo "    <div class='post_icons'>";
                    echo "        <div class='post_icon_wrapper'>";
                    $post_id = $row['post_id'];
                    $likes_result = $conn->query("SELECT COUNT(*) as like_count FROM likes WHERE post_id = $post_id");
                    $likes_data = $likes_result->fetch_assoc();
                    $user_like_result = $conn->query("SELECT * FROM likes WHERE post_id = $post_id AND user_id = $user_id");
                    $user_has_liked = $user_like_result->num_rows > 0;
                    $icon_name = $user_has_liked ? 'heart' : 'heart-outline';
                    echo "            <button class='post_icon_btn_heart like-button' data-post-id='$post_id' >";
                    echo "                <ion-icon id='$icon_name' name='$icon_name'></ion-icon>";
                    echo "            </button>";
                    echo "            <p class='post_icon_text' id='like-count-$post_id'>" . htmlspecialchars($likes_data['like_count']) . "</p>";
                    echo "        </div>";

                    // Comments section
                    $comment_count_result = $conn->query("SELECT COUNT(*) as comment_count FROM comments WHERE post_id = " . $row['post_id']);
                    $comment_count_data = $comment_count_result->fetch_assoc();
                    echo "<div class='post_icon_wrapper'>";
                    echo "<button class='comment-icon post_icon_btn' data-post-id='" . $row['post_id'] . "'>";
                    echo "<ion-icon name='chatbubble-outline'></ion-icon>";
                    echo "</button>";
                    echo "<p class='post_icon_text'>" . htmlspecialchars($comment_count_data['comment_count']) . "</p>";
                    echo "</div>";

                    // Share section
                    $share_count_result = $conn->query("SELECT COUNT(*) as shares_count FROM shares WHERE post_id = " . $row['post_id']);
                    $share_count_data = $share_count_result->fetch_assoc();
                    echo "<div class='post_icon_wrapper'>";
                    echo "<button class='share-button post_icon_btn' data-post-id='" . $row['post_id'] . "' onclick='openShareModal(" . $row['post_id'] . ")'>";
                    echo "<ion-icon name='arrow-redo-outline'></ion-icon>";
                    echo "</button>";
                    echo "<p class='post_icon_text'>" . htmlspecialchars($share_count_data['shares_count']) . "</p>";
                    echo "</div>";

                    // Fetch friends for sharing (Updated Query)
                    $friends_result = $conn->query("SELECT u.user_id, u.username 
                                                        FROM friends f 
                                                        JOIN users u ON f.user_id = u.user_id 
                                                        WHERE f.friend_id = $user_id");

                    // Share modal
                    echo "<div class='share-modal' id='share-modal-" . $row['post_id'] . "' style='display: none;'>";
                    echo "    <h4>Select Friends to Share</h4>";
                    echo "    <div id='friend-list-" . $row['post_id'] . "'>";

                    // Check if the user has friends
                    if ($friends_result->num_rows > 0) {
                        while ($friend = $friends_result->fetch_assoc()) {
                            echo "        <label><input type='checkbox' value='" . $friend['user_id'] . "'> " . htmlspecialchars($friend['username']) . "</label><br>";
                        }
                    } else {
                        echo "<p>No friends found.</p>";
                    }

                    echo "    </div>";
                    echo "    <button class='confirm-share' data-post-id='" . $row['post_id'] . "' onclick='sharePostWithFriends(" . $row['post_id'] . ")'>Share</button>";
                    echo "    <button class='close-modal' onclick='closeShareModal(" . $row['post_id'] . ")'>Close</button>";
                    echo "</div>";

                    echo "</div>"; // Close post_icons

                    // Comments container
                    echo "<div class='comments-container' id='comments-container-" . $row['post_id'] . "' style='display:none;'>";
            ?>

                    <div class="comment_post_title">
                        <p class="comment_text">Comments</p>
                        <?php
                        echo "<button class='comment_close comment-icon' data-post-id='" . $row['post_id'] . "'>";
                        ?>
                        <ion-icon id="close_icon" name="close"></ion-icon>
                        </button>
                    </div>

                    <div class="comment_main_content">

                        <?php
                        echo "<div class='scrollable-comments' id='comments-" . $row['post_id'] . "'overflow-y: auto;'>";

                        // Fetch comments for this post
                        $comments_result = $conn->query("SELECT c.*, u.username, u.profile_picture, 
                                            (SELECT COUNT(*) FROM comment_likes cl WHERE cl.comment_id = c.comment_id) AS like_count,
                                            (SELECT COUNT(*) FROM comment_likes cl WHERE cl.comment_id = c.comment_id AND cl.user_id = $user_id) AS user_has_liked
                                            FROM comments c 
                                            JOIN users u ON c.user_id = u.user_id 
                                            WHERE c.post_id = " . $row['post_id'] . " 
                                            ORDER BY c.created_at DESC");

                        if ($comments_result->num_rows > 0) {
                            while ($comment = $comments_result->fetch_assoc()) {
                                $liked_class = $comment['user_has_liked'] > 0 ? 'liked' : '';
                                echo "<div class='comment'>";

                                echo "<img class='comment_user_img' width='40px' height='40px' src='" . htmlspecialchars($comment['profile_picture']) . "'>";
                                echo "<div class='comment-wrapper'>";
                                echo "<p><strong>" . htmlspecialchars($comment['username']) . ":</strong></p> ";
                                echo "<p>" . htmlspecialchars($comment['content']) . " " . "</p>";
                                echo "<div class='comment-info'>";
                                echo "<p>" . timeAgo($comment['created_at']) . "</p>";
                                echo "<span class='like-count' id='comment-like-count-" . $comment['comment_id'] . "'>" . htmlspecialchars($comment['like_count']) . "</span>" . "<p>&nbsp;Likes</p>";
                                echo "</div>";
                                echo "</div>";

                                echo "<div class='comment-like-section'>";
                                echo "<button class='post_icon_btn_heart like-comment-button $liked_class' data-comment-id='" . $comment['comment_id'] . "'>";
                                echo "<ion-icon id='" . ($comment['user_has_liked'] > 0 ? 'heart' : 'heart-outline') . "' name='" . ($comment['user_has_liked'] > 0 ? 'heart' : 'heart-outline') . "'></ion-icon>";
                                echo "</button>";
                                echo "</div>";

                                echo "</div>";
                            }
                        } else {
                            echo "<p>No comments yet.</p>";
                        } // Close scrollable-comments
                        echo "</div>";

                        // Comment input field
                        echo "<div class='comment-input' id='comment-input-" . $row['post_id'] . "' style='display:none;'>";
                        echo "<textarea class='comment-textarea' name='comment_content' placeholder='Add a comment...' required></textarea>";
                        echo "<button class='submit-comment' data-post-id='" . $row['post_id'] . "'><ion-icon id='send_icon' name='send'></ion-icon></button>";
                        echo "</div>"; // Close comment-input

                        ?>

                    </div> <!-- comment_main_content -->

            <?php

                    echo "</div>"; // Close comments-container

                    echo "<hr>";
                    echo "</div>"; // Close post
                }
            } else {
                echo "No posts found.";
            }

            $conn->close();
            ?>


        </section>
    </main>

    <div class="black_overlay" id="blackOverlay">
    </div>

    <!-- follow -->
    <div class="follow">
        <p class="suggest">Suggested for you</p>
        <div class="follow_wrapper">

            <?php
            while ($row = $result->fetch_assoc()) {
                // Get the follower name (e.g., Adrian following Alvin, Aaron)
                $followerQuery = "SELECT username FROM users WHERE user_id = ?";
                $followerStmt = $conn->prepare($followerQuery);
                $followerStmt->bind_param("i", $row['follower_id']);
                $followerStmt->execute();
                $followerResult = $followerStmt->get_result();
                $followerRow = $followerResult->fetch_assoc();

                // Store the followed user and the follower's name
                $followedByFollowedUsers[] = [
                    'followed_username' => $row['followed_username'],
                    'follower_name' => $followerRow['username']
                ];
            }

            // Output the result in divs using your provided structure
            if (empty($followedByFollowedUsers)) {
                echo "<p>No users are followed by the users you follow.</p>";
            } else {
                foreach ($followedByFollowedUsers as $entry) {
                    echo "
                        <div class='follow_container'>
                            <img class='profile follow_profile' width='40px' height='40px' src='{$entry['profile_picture']}' alt='Profile Picture'>
                            <div class='follow_text'>
                                <p class='follow_name'>{$entry['followed_username']}</p>
                                <p class='follow_description'>Followed by {$entry['follower_name']} + 5 more</p>
                            </div>
                            <button class='btn_follow' id='followButton1' onclick='followBtn(this)'>
                                <svg id='followIcon1' class='follow_icon' xmlns='http://www.w3.org/2000/svg' height='30px' viewBox='0 -960 960 960' width='30px' fill='#000000'>
                                    <path d='M517.5-419.5h22v-124h124v-22h-124v-124h-22v124h-124v22h124v124ZM308-280q-22.24 0-38.12-15.88Q254-311.76 254-334v-440q0-22.24 15.88-38.12Q285.76-828 308-828h440q22.24 0 38.12 15.88Q802-796.24 802-774v440q0 22.24-15.88 38.12Q770.24-280 748-280H308Zm0-22h440q12 0 22-10t10-22v-440q0-12-10-22t-22-10H308q-12 0-22 10t-10 22v440q0 12 10 22t22 10Zm-96 118q-22.24 0-38.12-15.88Q158-215.76 158-238v-462h22v462q0 12 10 22t22 10h462v22H212Zm64-622v504-504Z'/>
                                </svg>
                            </button>
                        </div>
                    ";
                }
            }
            ?>

        </div>
    </div>

    <!-- framework -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.like-button').click(function() {
                var button = $(this);
                var postId = button.data('post-id');
                var heartIcon = button.find('.heart-icon'); // Get the heart icon element

                $.ajax({
                    url: 'like_post.php',
                    method: 'POST',
                    data: {
                        post_id: postId
                    },
                    success: function(response) {
                        try {
                            var data = JSON.parse(response);
                            if (data.status === 'success') {
                                var likeCountElem = $('#like-count-' + postId);
                                likeCountElem.text(data.like_count);

                                // Toggle button color and icon based on like status
                                if (data.liked) {
                                    $icon_name = 'heart'; // Switch to filled heart
                                    button.addClass("clicked"); // Liked
                                    // Set background color to red
                                } else {
                                    $icon_name = "heart-outline"; // Switch back to outline heart
                                    button.removeClass("clicked"); // Not liked // Reset background color
                                }
                            } else {
                                alert(data.message);
                            }
                        } catch (error) {
                            console.error('Error parsing response:', error);
                        }
                    },
                    error: function() {
                        alert('Error processing your request.');
                    }
                });
            });
        });



        $('.comment-icon').click(function() {
            var postId = $(this).data('post-id');
            var overlay = document.getElementById("blackOverlay");
            $('#comments-container-' + postId).toggle(); // Toggle comments container
            $('#comment-input-' + postId).toggle(); // Toggle input field

            if (overlay.classList.contains("show")) {
                overlay.classList.remove("show");
            } else {
                overlay.classList.add("show");
            }
        });

        // Comment submit event
        $('.submit-comment').click(function() {
            var postId = $(this).data('post-id');
            var commentContent = $('#comment-input-' + postId).find('textarea[name="comment_content"]').val();

            $.ajax({
                url: 'add_comment.php',
                method: 'POST',
                data: {
                    post_id: postId,
                    comment_content: commentContent
                },
                success: function(response) {
                    try {
                        var data = JSON.parse(response); // Parse the response
                        if (data.status === 'success') {
                            // Add the new comment with a like button
                            const newComment = `
                <div class="comment" id="comment-${data.comment_id}">
                            <img class="comment_user_img" width="40px" height="40px" src="${data.profile_picture}" >
                            <div class="comment-wrapper">
                                <p><strong>${data.username}:</strong></p>
                                <p>${commentContent}</p>
                                <div class="comment-info">
                                    <p>${data.timeAgo}</p>
                                    <span class="like-count" id="comment-like-count-${data.comment_id}">${data.like_count}</span>
                                    <p>&nbsp;Likes</p>
                                </div>
                            </div>
                            <div class="comment-like-section">
                                <button class="post_icon_btn_heart like-comment-button ${data.user_has_liked > 0 ? 'liked' : ''}" data-comment-id="${data.comment_id}">
                                    <ion-icon name="${data.user_has_liked > 0 ? 'heart' : 'heart-outline'}"></ion-icon>
                                </button>
                            </div>
                        </div>

                
            `;
                            $('#comments-' + postId).append(newComment);
                            $('#comment-input-' + postId).find('textarea[name="comment_content"]').val(''); // Clear the textarea
                        } else {
                            alert(data.message); // Show the error message
                        }
                    } catch (error) {
                        console.error('Error parsing JSON response:', error);
                        alert('Failed to process response.');
                    }
                },
                error: function() {
                    alert('Error adding comment.');
                }
            });
        });

        document.addEventListener('click', function(e) {
            // Check if the clicked element is a like button
            if (e.target.closest('.like-comment-button')) {
                // Get the button element
                const button = e.target.closest('.like-comment-button');
                const commentId = button.getAttribute('data-comment-id');


                // Proceed with the like functionality
                fetch('like_comment.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({
                            comment_id: commentId
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            const likeCountElem = document.getElementById(`comment-like-count-${commentId}`);
                            likeCountElem.textContent = data.like_count;

                            // Toggle like button state
                            button.classList.toggle('liked');
                            button.querySelector('ion-icon').setAttribute('name', data.liked ? 'heart' : 'heart-outline');
                        } else {
                            alert(data.message || 'An error occurred.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while liking the comment.');
                    });
            }
        });


        function openShareModal(post_id) {
            document.getElementById('share-modal-' + post_id).style.display = 'block';
        }

        // Close Share Modal
        function closeShareModal(post_id) {
            document.getElementById('share-modal-' + post_id).style.display = 'none';
        }

        // Share the post with selected friends
        // Share the post with selected friends using AJAX
        function sharePostWithFriends(post_id) {
            const selectedFriends = [];
            const checkboxes = document.querySelectorAll('#friend-list-' + post_id + ' input[type="checkbox"]:checked');

            // Check if there are any selected friends
            if (checkboxes.length === 0) {
                alert('Error: No friends selected. Please select at least one friend to share with.');
                return;
            }

            checkboxes.forEach(function(checkbox) {
                selectedFriends.push(checkbox.value);
            });

            // Send AJAX request to share the post
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'share_post.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Prepare the data to be sent
            const data = `post_id=${post_id}&friend_ids=${encodeURIComponent(JSON.stringify(selectedFriends))}`;

            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Handle the response from the server
                    const response = xhr.responseText;
                    document.getElementById('share-modal-' + post_id).style.display = 'none'; // Close modal
                    alert('Post shared successfully!');
                } else {
                    alert('Error sharing the post.');
                }
            };

            xhr.send(data);
        }

        function togglePostOptions(postId) {
            const optionsDiv = document.getElementById('post-options-' + postId);
            optionsDiv.style.display = optionsDiv.style.display === 'none' ? 'block' : 'none';
        }

        function savePost(postId) {
            alert("Save button clicked for Post ID: " + postId);

            var userId = <?php echo $user_id; ?>; // Assuming user_id is a PHP variable available in the HTML

            // Disable the button to prevent multiple clicks and change its text
            var button = document.querySelector('.save-post-btn[data-post-id="' + postId + '"]');
            button.innerText = "Saving..."; // Change button text
            button.disabled = true; // Disable button

            // Send AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "save_post.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            // Handle the response from PHP
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        button.innerText = "Post Saved"; // Update button text
                    } else {
                        button.innerText = "Save Post"; // Revert button text if failed
                        button.disabled = false; // Re-enable the button
                        alert(response.message || "An error occurred while saving the post.");
                    }
                }
            };

            // Send the post_id and user_id to the server
            xhr.send("post_id=" + postId + "&user_id=" + userId);
        }
        // Function to open the Create modal
        function toggleTagSection() {
            const tagSection = document.getElementById('tagSection');
            tagSection.style.display = tagSection.style.display === 'none' ? 'block' : 'none';
        }

        // Search for users to tag
        $('#searchField').on('input', function() {
            const searchQuery = $(this).val();
            const loggedInUserId = $('#loggedInUserId').val(); // Get the logged-in user ID

            if (searchQuery.length > 0) {
                $.ajax({
                    url: 'tag_search.php', // Assuming you have a PHP file to search users
                    method: 'GET',
                    data: {
                        query: searchQuery
                    },
                    dataType: 'json',
                    success: function(data) {
                        const results = $('#searchResults');
                        results.empty();

                        // Filter out the logged-in user from the search results
                        const filteredData = data.filter(user => user.user_id !== parseInt(loggedInUserId));

                        if (filteredData.length > 0) {
                            filteredData.forEach(user => {
                                const listItem = $('<li></li>')
                                    .text(`${user.first_name} ${user.last_name} (${user.username})`)
                                    .on('click', () => tagUser(user.user_id, user.username));
                                results.append(listItem);
                            });
                        } else {
                            results.append('<li>No users found</li>');
                        }
                    }
                });
            } else {
                $('#searchResults').empty();
            }
        });

        // Tag a user and add their name to the hidden field
        function tagUser(userId, username) {
            const taggedNamesInput = $('#taggedNames');
            let taggedNames = taggedNamesInput.val().split(',').filter(Boolean);

            // Avoid adding the same tag more than once
            if (!taggedNames.includes(username)) {
                taggedNames.push(username);
                taggedNamesInput.val(taggedNames.join(','));

                // Add the tagged user to the list with a remove option
                const tagItem = $('<li></li>')
                    .text(`${username}`)
                    .append($('<button>X</button>').on('click', function() {
                        removeTag(userId, username);
                    }));

                $('#taggedUsersList').append(tagItem);
            }
        }

        // Remove a tagged user from the list and update the hidden input
        function removeTag(userId, username) {
            const taggedNamesInput = $('#taggedNames');
            let taggedNames = taggedNamesInput.val().split(',').filter(Boolean);

            // Remove the user from the tagged users array
            taggedNames = taggedNames.filter(name => name !== username);
            taggedNamesInput.val(taggedNames.join(','));

            // Remove the user from the displayed list
            $('#taggedUsersList').find(`li:contains(${username})`).remove();
        }

        $(document).ready(function() {
            // Form submission
            $('#create-post-form').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: 'create_post_handler.php', // PHP handler for creating posts
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        $('#response-message').html('<p>' + response.message + '</p>');
                        if (response.status === 'success') {
                            $('#create-post-form')[0].reset();
                            $('#taggedUsersList').empty(); // Clear tagged users list on success
                        }
                    },
                    error: function(jqXHR) {
                        // Show error message
                        $('#response-message').html('<p>An error occurred while creating the post: ' + jqXHR.responseText + '</p>');
                    }
                });
            });
        });
    </script>
    <script src="home.js"></script>
</body>

</html>