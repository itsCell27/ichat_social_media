<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/fa0399c701.js" crossorigin="anonymous"></script>
</head>
<body>
    
    <main>
       <div class="text_page">
            <div class="text_glass">
                    <h1 class="text_easy">
                        <i class="fa-solid fa-caret-right"></i>
                        Conversations 
                    </h1>
                    <h1 class="text_easy">Made Easy</h1>
                    <h1 class="text_stay">
                        Stay Connected.
                    </h1>
                    <p class="long_text">
                        Stay connected, chat and share moments with friends and family. Your conversations, your way.
                    </p>
            </div>
       </div>
       <form method="POST" action="home.php" class="login_page">
                <img width="100px" height="100px" src="ichat_logo.png">
                <h1 class="login_title">Login</h1>

                <input name="email" id="email" class="email input_login" type="email" required  placeholder="email" autocapitalize="off">

                <input name="password" id="password" class="password input_login" type="password" required placeholder="password">

                <div class="div_forgot">
                    <a href="forgot_password.php" class="text_hover">forgot password</a>
                </div>
                
                <button type="submit" class="login_btn btn">Login</button>
                
                <a class="text_hover" href="sign_up.php">create new account</a>

                <p class="or">Or Sign up with</p>

                <button class="google_btn">
                    <span class="google-icon">
                        <svg viewBox="0 0 48 48">
                            <title>Google Logo</title>
                            <clipPath id="g">
                                <path
                                d="M44.5 20H24v8.5h11.8C34.7 33.9 30.1 37 24 37c-7.2 0-13-5.8-13-13s5.8-13 13-13c3.1 0 5.9 1.1 8.1 2.9l6.4-6.4C34.6 4.1 29.6 2 24 2 11.8 2 2 11.8 2 24s9.8 22 22 22c11 0 21-8 21-22 0-1.3-.2-2.7-.5-4z"
                                ></path>
                            </clipPath>
                            <g clip-path="url(#g)" class="colors">
                                <path d="M0 37V11l17 13z" fill="#FBBC05"></path>
                                <path d="M0 11l17 13 7-6.1L48 14V0H0z" fill="#EA4335"></path>
                                <path d="M0 37l30-23 7.9 1L48 0v48H0z" fill="#34A853"></path>
                                <path d="M48 48L17 24l-4-3 35-10z" fill="#4285F4"></path>
                            </g>
                        </svg>
                    </span>
                </button>
        </form>
    </main>

    <footer>
        
    </footer>
</body>
</html>