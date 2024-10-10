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
       <form method="POST" action="index.php" class="login_page">
                
                <h1 class="login_title">Create your iChat account</h1>

                <input name="first_name" id="first_name" class="first_name input_login" type="text" required placeholder="First Name">
                
                <input name="last_name" id="last_name" class="last_name input_login" type="text" required placeholder="Last Name">

                <input name="email" id="email" class="email input_login" type="email" required  placeholder="Email" autocapitalize="off" >

                <input name="password" id="password" class="password input_login" type="password" required placeholder="Password">

                <input name="confirm_password" id="confirm_password" class="confirm_password input_login" type="password" required placeholder="Confirm password">
                
                <button type="submit" class="create_btn btn">Create Account</button>
                
                <div class="sign_in">
                    <p class="have_acc">Have an account?</p>
                    <a class="text_hover" href="index.php">sign in</a>
                </div>
                
        </form>
    </main>

    <footer>
        
    </footer>
</body>
</html>