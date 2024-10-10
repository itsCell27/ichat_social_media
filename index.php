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
        </form>
    </main>

    <footer>
        
    </footer>
</body>
</html>