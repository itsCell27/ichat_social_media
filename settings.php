<?php
session_start();

// Include the database connection from db.php
require_once 'db.php'; // This will include the $conn variable for DB connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die('Please log in to change your password.');
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Validate passwords
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error_message = 'Please fill out all fields.';
    } elseif ($new_password !== $confirm_password) {
        $error_message = 'New passwords do not match.';
    } else {
        // Fetch the current hashed password from the database
        $sql = "SELECT password FROM users WHERE user_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if (!$user) {
            $error_message = 'User not found.';
        } else {
            $stored_hashed_password = $user['password'];

            // Verify the current password
            if (!password_verify($current_password, $stored_hashed_password)) {
                $error_message = 'Current password is incorrect.';
            } else {
                // Hash the new password
                $new_hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                // Update the password in the database
                $update_sql = "UPDATE users SET password = ? WHERE user_id = ?";
                $stmt = $conn->prepare($update_sql);
                $stmt->bind_param("si", $new_hashed_password, $user_id);

                if ($stmt->execute()) {
                    $success_message = 'Password updated successfully!';
                    // Optional: Redirect after success
                    // header('Location: profile.php'); exit; // Uncomment if you want to redirect
                } else {
                    $error_message = 'Error updating password.';
                }
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="settings.css">
</head>
<body>
    <div class="sidebar">
        <a href="home.php" class="back-button">
            <ion-icon name="arrow-back"></ion-icon>
        </a>

        <div class="menu">
            <a href="#" id="change_password">
                <ion-icon name="key"></ion-icon> Change password
            </a>
            <a href="#" id="delete_account">
                <ion-icon name="backspace"></ion-icon> Delete account
            </a>
        </div>
        <br><br><br><br><br><br><br><br><br><br><br><br><br><br>
        
        <div class="menu">
        <a href="#" id="terms">
            <ion-icon name="documents"></ion-icon> Terms of use
        </a>
        <a href="#" id="privacy">
            <ion-icon name="shield-checkmark"></ion-icon> Privacy Policy
        </a>
        <a href="#" id="about">
            <ion-icon name="people"></ion-icon> About us
        </a>
        </div>
    </div>

    <div class="content" id="content">
        
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const links = document.querySelectorAll(".menu a");
        const contentDiv = document.getElementById("content");

        links.forEach(link => {
            link.addEventListener("click", function(event) {
                event.preventDefault(); // Prevent default anchor click behavior
                
                const id = this.id; // Get the ID of the clicked link

                // Use Fetch API to load the content dynamically
                fetch(id + ".php") // Assumes you have corresponding PHP files like change-password.php
                    .then(response => {
                        if (!response.ok) {
                            throw new Error("Network response was not ok");
                        }
                        return response.text(); // Get response as text
                    })
                    .then(data => {
                        contentDiv.innerHTML = data; // Update the content div
                    })
                    .catch(error => {
                        contentDiv.innerHTML = `<div class="error">Error loading content: ${error.message}</div>`;
                    });
            });
        });
    });
    
        function showConfirmationDialog() {
            document.getElementById('confirmation-dialog').style.display = 'block';
        }

        function hideConfirmationDialog() {
            document.getElementById('confirmation-dialog').style.display = 'none';
        }
   
</script>

</body>
</html>
