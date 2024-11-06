<?php

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $email = $_POST['email'];
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
    <script src="https://kit.fontawesome.com/fa0399c701.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <header class="navbar">

        <div class="left_icon">
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

    <!-- menu -->
    <div class="menu">
            <div class="icons_menu">

                <div class="icon_wrapper">
                    <svg class="icons" xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#000000"><path d="M234-194h165v-210q0-11.98 7.76-19.74 7.76-7.76 19.74-7.76h108q10.82 0 18.66 7.76T561-404v210h165v-353.67q0-8-3.5-14.5t-9.5-11.5L499-735q-8-6-19-6t-19 6L247-573.67q-6 5-9.5 11.5t-3.5 14.5V-194Zm-22 0v-353q0-13.69 5.03-24.5T234-590l214-163q13.76-11 31.88-11Q498-764 512-753l214 163q11.94 7.69 16.97 18.5Q748-560.69 748-547v353q0 8.52-6.74 15.26Q734.53-172 726-172H566.5q-11.97 0-19.74-7.76-7.76-7.76-7.76-19.74v-210H421v210q0 11.98-7.81 19.74-7.8 7.76-18.58 7.76H233.56q-8.02 0-14.79-6.74T212-194Zm268-275Z"/></svg>
                    <p class="icon_name">Home</p>
                </div>

                <div class="icon_wrapper">
                    <svg class="icons" xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#000000"><path d="M243.58-292 178-226q-13 13-29.5 6.42T132-245.5v-528.67q0-22.07 15.88-37.95Q163.76-828 185.78-828h588.44q22.02 0 37.9 15.88Q828-796.24 828-774.2v428.4q0 22.04-15.88 37.92Q796.24-292 774.21-292H243.58Zm-9.08-22H774q12 0 22-10t10-22v-428q0-12-10-22t-22-10H186q-12 0-22 10t-10 22v542l80.5-82Zm-80.5 0v-492 492Zm123.5-112h244q4.07 0 7.29-3.19 3.21-3.2 3.21-8 0-4.81-3.21-7.81-3.22-3-7.29-3h-244q-5.23 0-8.36 3.27-3.14 3.27-3.14 7.42 0 5.31 3.14 8.31 3.13 3 8.36 3Zm0-123h406q4.07 0 7.29-3.19 3.21-3.2 3.21-8 0-4.81-3.21-7.81-3.22-3-7.29-3h-406q-5.23 0-8.36 3.27-3.14 3.27-3.14 7.42 0 5.31 3.14 8.31 3.13 3 8.36 3Zm0-123h406q4.07 0 7.29-3.19 3.21-3.2 3.21-8 0-4.81-3.21-7.81-3.22-3-7.29-3h-406q-5.23 0-8.36 3.27-3.14 3.27-3.14 7.42 0 5.31 3.14 8.31 3.13 3 8.36 3Z"/></svg>
                    <p class="icon_name">Messages</p>
                </div>

                <div class="icon_wrapper">
                    <svg class="icons" xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#000000"><path d="M470-468v150.5q0 5.18 3.23 8.34t8 3.16q4.77 0 7.77-3.16t3-8.34V-468h151.5q4.02 0 7.26-3.23t3.24-8q0-4.77-3.24-7.77t-7.26-3H492v-153.5q0-4.02-3.3-7.26-3.31-3.24-7.43-3.24-5.27 0-8.27 3.24t-3 7.26V-490H317.5q-5.18 0-8.34 3.3-3.16 3.31-3.16 7.43 0 5.27 3.16 8.27t8.34 3H470Zm10.57 336q-72.94 0-136.15-27.52-63.2-27.53-110.38-74.85-47.19-47.33-74.61-110.1Q132-407.25 132-479.7q0-72.53 27.52-136.09 27.53-63.56 74.85-110.71 47.33-47.15 110.1-74.32Q407.25-828 479.7-828q72.53 0 136.09 27.39 63.57 27.39 110.72 74.35 47.14 46.96 74.31 110.39Q828-552.43 828-480.57q0 72.94-27.27 136.15-27.28 63.2-74.35 110.2-47.08 47-110.51 74.61Q552.43-132 480.57-132Zm-.64-22q135.57 0 230.82-95.18Q806-344.37 806-479.93q0-135.57-94.93-230.82t-231-95.25q-135.57 0-230.82 94.93t-95.25 231q0 135.57 95.18 230.82Q344.37-154 479.93-154Zm.07-326Z"/></svg>
                    <p class="icon_name">Create</p>
                </div>

                <div class="icon_wrapper">
                    <svg class="icons" xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#000000"><path d="m480.5-296-152 65.5q-28.5 11-52.5-4.45t-24-45.55v-455.73q0-21.24 15.88-37.5Q283.76-790 305.78-790h348.44q22.02 0 37.9 16.27Q708-757.47 708-736.23v455.73q0 30.1-24 45.55-24 15.45-51.5 4.45l-152-65.5Zm-.5-25.33L641-252q16 7 30.5-2.5T686-282v-454q0-12-10-22t-22-10H306q-12 0-22 10t-10 22v454q0 18 14.5 27.5T319-252l161-69.33ZM480-768H274h412-206Z"/></svg>
                    <p class="icon_name">Saved</p>
                </div>

                <div class="icon_wrapper">
                    <svg class="icons" xmlns="http://www.w3.org/2000/svg" height="50px" viewBox="0 -960 960 960" width="50px" fill="#000000"><path d="M436-132q-6 0-11-4t-5.5-10l-13-97.5Q383-250 355-265.75t-47-33.75l-87.5 40q-6.5 2.5-12.26.9-5.76-1.61-8.74-7.4L153-345.5q-3-5-2-10.5t7.5-10.5l79-58.5q-2.5-13.48-3.75-26.99-1.25-13.51-1.25-27.01 0-12 1.25-26t3.25-30l-78.5-59q-6.5-3.92-7.25-10.21-.75-6.29 3.25-11.79l45-76q3.09-4.79 8.8-6.9 5.7-2.1 11.7-.6l87.5 38q21.5-17 47.5-32.5t50.5-22.5l14-97.5q.5-6 5.5-10t11.5-4H524q6 0 11 4t6.5 10l12.82 97.9q26.18 9.6 49.43 23.1Q627-679.5 649-661.5l92.5-38q5.5-1.5 11.26.6 5.76 2.11 9.74 6.9l45 77q3 6 1.75 11.98T802.5-594l-83 61q3 15 4.5 28t1.5 25q0 10.5-1.75 23.67Q722-443.15 719-426.5l80 60q6.5 4.04 7.75 10.02Q808-350.5 805-345.5L761.5-267q-5.09 5.79-11.3 7.4-6.2 1.6-11.2-.9l-90-40q-23 20.5-46.5 35.25t-48 21.25l-13 98q-1.5 6-6.5 10t-11 4h-88Zm3.29-22H520l15.5-111.5q30-8 54.25-21.75T641-326l102.5 44 39.5-69-90-67q3.5-19 6-33.59 2.5-14.59 2.5-28.41 0-16.5-2.25-30.25T693-540l92-69-39.5-69-105 44q-19-20-49.75-39t-56.25-22.5L521.57-806H439l-11.5 110q-33 6.5-58.25 20.75T318-635l-102.5-43-40.5 69 90.5 65.5q-5 14-7 30t-2 33.97q0 17.03 1.75 31.78T264-418l-89 67 40.58 69 101.92-43q23.5 25.5 49.5 39.25T426.5-264l12.79 110Zm38.44-241q35.77 0 60.27-24.55t24.5-60.5q0-35.95-24.54-60.45Q513.43-565 477.5-565q-36 0-60.5 24.55t-24.5 60.5q0 35.95 24.5 60.45t60.73 24.5Zm2.77-85.5Z"/></svg>
                    <p class="icon_name">Settings</p>
                </div>

                <div class="icon_wrapper menu_profile">
                    <img class="profile" width="40px" height="40px" src="profile_pic1.jpg">
                    <p class="profile_name">Name</p>
                </div>


            </div>
    </div>

    <main class="main">

        <!-- post feed -->
        <section class="post_feed">
            <div class="post_story">

                <div class="post_story_user">
                    <img class="post_story_user_img" width="60px" height="60px" src="profile_pic1.jpg">
                    <p class="post_story_user_text">Your story</p>
                </div>

                <div class="post_story_user">
                    <img class="post_story_user_img" width="60px" height="60px" src="profile_pic2.jpg">
                    <p class="post_story_user_text">Wannabie</p>
                </div>

                <div class="post_story_user">
                    <img class="post_story_user_img" width="60px" height="60px" src="profile_pic3.jpg">
                    <p class="post_story_user_text">Norris</p>
                </div>

                <div class="post_story_user">
                    <img class="post_story_user_img" width="60px" height="60px" src="profile_pic4.jpg">
                    <p class="post_story_user_text">Kler</p>
                </div>

                <div class="post_story_user">
                    <img class="post_story_user_img" width="60px" height="60px" src="profile_pic5.jpg">
                    <p class="post_story_user_text">Cee</p>
                </div>

                <div class="post_story_user">
                    <img class="post_story_user_img" width="60px" height="60px" src="profile_pic6.jpg">
                    <p class="post_story_user_text">Isha</p>
                </div>

                <div class="post_story_user">
                    <img class="post_story_user_img" width="60px" height="60px" src="profile_pic4.jpg">
                    <p class="post_story_user_text">Isha</p>
                </div>

                <div class="post_story_user">
                    <img class="post_story_user_img" width="60px" height="60px" src="profile_pic7.jpg">
                    <p class="post_story_user_text">Isha</p>
                </div>

            </div>

            <!-- user's post -->
            <div class="post">
                <div class="upper_post_tag">
                    <img class="user_profile" width="50px" height="50px" src="profile_pic3.jpg">
                    <div class="post_text">
                        <h3 class="user_name">Charles James</h3>
                        <p class="post_time">25 min ago</p>
                    </div>
                        <ion-icon class="toggle_btn" name="ellipsis-horizontal-outline"></ion-icon>
                    </div>
                    <div class="post_description">
                        <p class="text_description">Overwhelming view!&nbsp;</p>
                        <p class="text_hashtag">#mountainlife #adventure</p>
                    </div>
                    <div class="post_img_wrapper">
                        <img class="post_img" src="post_sample.jpg">
                    </div>
                    <div class="post_icons">

                        <div class="post_icon_wrapper">
                            <button class="post_icon_btn_heart" onclick="heartBtn()">
                                <ion-icon name="heart-outline"></ion-icon>
                            </button>
                            <p class="post_icon_text">0</p>
                        </div>
                    
                        <div class="post_icon_wrapper">
                            <button class="post_icon_btn" id="comment">
                                <ion-icon name="chatbubble-outline"></ion-icon>
                            </button>
                            <p class="post_icon_text">0</p>
                        </div>

                        <div class="post_icon_wrapper">
                            <button class="post_icon_btn" id="share">
                                <ion-icon name="arrow-redo-outline"></ion-icon>
                            </button>
                            <p class="post_icon_text">share</p>
                        </div>

                    </div>
            </div>

            <!-- user's post -->
            <div class="post">
                <div class="upper_post_tag">
                    <img class="user_profile" width="50px" height="50px" src="profile_pic5.jpg">
                    <div class="post_text">
                        <h3 class="user_name">Cee Lee</h3>
                        <p class="post_time">1h</p>
                    </div>
                    <ion-icon class="toggle_btn" name="ellipsis-horizontal-outline"></ion-icon>
                </div>
                    <div class="post_description">
                        <p class="text_description">Overwhelming view!&nbsp;</p>
                        <p class="text_hashtag">#river #adventure</p>
                    </div>
                    <div class="post_img_wrapper">
                        <img class="post_img" src="post_sample2.jpg">
                    </div>
                    <div class="post_icons">

                        <div class="post_icon_wrapper">
                            <button class="post_icon_btn_heart" onclick="heartBtn()">
                                <ion-icon name="heart-outline"></ion-icon>
                            </button>
                            <p class="post_icon_text">0</p>
                        </div>
                    
                        <div class="post_icon_wrapper">
                            <button class="post_icon_btn" id="comment">
                                <ion-icon name="chatbubble-outline"></ion-icon>
                            </button>
                            <p class="post_icon_text">0</p>
                        </div>

                        <div class="post_icon_wrapper">
                            <button class="post_icon_btn" id="share">
                                <ion-icon name="arrow-redo-outline"></ion-icon>
                            </button>
                            <p class="post_icon_text">share</p>
                        </div>

                    </div>
            </div>

        </section>

        

    </main>

    <!-- follow -->
        <div class="follow">
            <p class="suggest">Suggested for you</p>
            <div class="follow_wrapper">

                <div class="follow_container">
                    <img class="profile follow_profile" width="40px" height="40px" src="profile_pic4.jpg">
                    <div class="follow_text">
                        <p class="follow_name">Staku Virtigo</p>
                        <p class="follow_description">Followed by marcus + 5 more</p>
                    </div>
                    <button class="btn_follow" id="followButton1" onclick="followBtn(this)">
                        <svg id="followIcon1" class="follow_icon" xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#000000">
                            <path d="M517.5-419.5h22v-124h124v-22h-124v-124h-22v124h-124v22h124v124ZM308-280q-22.24 0-38.12-15.88Q254-311.76 254-334v-440q0-22.24 15.88-38.12Q285.76-828 308-828h440q22.24 0 38.12 15.88Q802-796.24 802-774v440q0 22.24-15.88 38.12Q770.24-280 748-280H308Zm0-22h440q12 0 22-10t10-22v-440q0-12-10-22t-22-10H308q-12 0-22 10t-10 22v440q0 12 10 22t22 10Zm-96 118q-22.24 0-38.12-15.88Q158-215.76 158-238v-462h22v462q0 12 10 22t22 10h462v22H212Zm64-622v504-504Z"/>
                        </svg>
                    </button>
                </div>

                <div class="follow_container">
                    <img class="profile follow_profile" width="40px" height="40px" src="profile_pic7.jpg">
                    <div class="follow_text">
                        <p class="follow_name">Staku Virtigo</p>
                        <p class="follow_description">Followed by marcus + 5 more</p>
                    </div>
                    <button class="btn_follow" id="followButton2" onclick="followBtn(this)">
                        <svg id="followIcon2" class="follow_icon" xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#000000">
                            <path d="M517.5-419.5h22v-124h124v-22h-124v-124h-22v124h-124v22h124v124ZM308-280q-22.24 0-38.12-15.88Q254-311.76 254-334v-440q0-22.24 15.88-38.12Q285.76-828 308-828h440q22.24 0 38.12 15.88Q802-796.24 802-774v440q0 22.24-15.88 38.12Q770.24-280 748-280H308Zm0-22h440q12 0 22-10t10-22v-440q0-12-10-22t-22-10H308q-12 0-22 10t-10 22v440q0 12 10 22t22 10Zm-96 118q-22.24 0-38.12-15.88Q158-215.76 158-238v-462h22v462q0 12 10 22t22 10h462v22H212Zm64-622v504-504Z"/>
                        </svg>
                    </button>

                </div>

                <div class="follow_container">
                    <img class="profile follow_profile" width="40px" height="40px" src="profile_pic2.jpg">
                    <div class="follow_text">
                        <p class="follow_name">Staku Virtigo</p>
                        <p class="follow_description">Followed by marcus + 5 more</p>
                    </div>
                    <button class="btn_follow" id="followButton3" onclick="followBtn(this)">
                        <svg id="followIcon3" class="follow_icon" xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#000000">
                            <path d="M517.5-419.5h22v-124h124v-22h-124v-124h-22v124h-124v22h124v124ZM308-280q-22.24 0-38.12-15.88Q254-311.76 254-334v-440q0-22.24 15.88-38.12Q285.76-828 308-828h440q22.24 0 38.12 15.88Q802-796.24 802-774v440q0 22.24-15.88 38.12Q770.24-280 748-280H308Zm0-22h440q12 0 22-10t10-22v-440q0-12-10-22t-22-10H308q-12 0-22 10t-10 22v440q0 12 10 22t22 10Zm-96 118q-22.24 0-38.12-15.88Q158-215.76 158-238v-462h22v462q0 12 10 22t22 10h462v22H212Zm64-622v504-504Z"/>
                        </svg>
                    </button>
                </div>

                <div class="follow_container">
                    <img class="profile follow_profile" width="40px" height="40px" src="profile_pic5.jpg">
                    <div class="follow_text">
                        <p class="follow_name">Staku Virtigo</p>
                        <p class="follow_description">Followed by marcus + 5 more</p>
                    </div>
                    <button class="btn_follow" id="followButton4" onclick="followBtn(this)">
                        <svg id="followIcon4" class="follow_icon" xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#000000">
                            <path d="M517.5-419.5h22v-124h124v-22h-124v-124h-22v124h-124v22h124v124ZM308-280q-22.24 0-38.12-15.88Q254-311.76 254-334v-440q0-22.24 15.88-38.12Q285.76-828 308-828h440q22.24 0 38.12 15.88Q802-796.24 802-774v440q0 22.24-15.88 38.12Q770.24-280 748-280H308Zm0-22h440q12 0 22-10t10-22v-440q0-12-10-22t-22-10H308q-12 0-22 10t-10 22v440q0 12 10 22t22 10Zm-96 118q-22.24 0-38.12-15.88Q158-215.76 158-238v-462h22v462q0 12 10 22t22 10h462v22H212Zm64-622v504-504Z"/>
                        </svg>
                    </button>
                </div>

                <div class="follow_container">
                    <img class="profile follow_profile" width="40px" height="40px" src="profile_pic6.jpg">
                    <div class="follow_text">
                        <p class="follow_name">Staku Virtigo</p>
                        <p class="follow_description">Followed by marcus + 5 more</p>
                    </div>
                    <button class="btn_follow" id="followButton5" onclick="followBtn(this)">
                        <svg id="followIcon5" class="follow_icon" xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px" fill="#000000">
                            <path d="M517.5-419.5h22v-124h124v-22h-124v-124h-22v124h-124v22h124v124ZM308-280q-22.24 0-38.12-15.88Q254-311.76 254-334v-440q0-22.24 15.88-38.12Q285.76-828 308-828h440q22.24 0 38.12 15.88Q802-796.24 802-774v440q0 22.24-15.88 38.12Q770.24-280 748-280H308Zm0-22h440q12 0 22-10t10-22v-440q0-12-10-22t-22-10H308q-12 0-22 10t-10 22v440q0 12 10 22t22 10Zm-96 118q-22.24 0-38.12-15.88Q158-215.76 158-238v-462h22v462q0 12 10 22t22 10h462v22H212Zm64-622v504-504Z"/>
                        </svg>
                    </button>
                </div>

            </div>
        </div>

    <!-- framework -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    
    <!-- js -->
    <script src="home.js"></script>
    
</body>
</html>