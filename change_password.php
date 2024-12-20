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

<h1>Change password</h1>

<!-- Display success or error message -->
<?php if (isset($success_message)): ?>
    <p style="color: green;"><?php echo $success_message; ?></p>
<?php elseif (isset($error_message)): ?>
    <p style="color: red;"><?php echo $error_message; ?></p>
<?php endif; ?>

<!-- Password Change Form -->
<form method="POST" action="change_password.php">
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" placeholder="Enter your current password">
            </div>

            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" id="new_password" name="new_password" placeholder="Enter your new password">
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm your new password">
            </div>

            <div class="form-group">
                <button type="submit">Change Password</button>
            </div>
        </form>

