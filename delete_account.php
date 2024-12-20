<?php
session_start();
require 'db.php'; // Ensure this file contains the database connection logic

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to delete your account.";
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] === 'yes') {
        // Start transaction
        $conn->begin_transaction(); 

        try {
            // Disable foreign key checks temporarily
            $conn->query("SET foreign_key_checks = 0");

            // Delete related data from other tables before deleting from the user table
            $queries = [
                "DELETE FROM shares WHERE post_id IN (SELECT post_id FROM posts WHERE user_id = ?)",
                "DELETE FROM saved WHERE user_id = ?",
                "DELETE FROM likes WHERE user_id = ?",
                "DELETE FROM comments WHERE user_id = ?",
                "DELETE FROM messages WHERE sender_id = ?",
                "DELETE FROM friends WHERE user_id = ? OR friend_id = ?",
                "DELETE FROM following WHERE following_id = ? OR followed_id = ?",
                "DELETE FROM followers WHERE sender_id = ? OR receiver_id = ?",
                "DELETE FROM conversations WHERE user1_id = ? OR user2_id = ?",
                "DELETE FROM posts WHERE user_id = ?",
                "DELETE FROM post_tags WHERE post_id IN (SELECT post_id FROM posts WHERE user_id = ?)"
            ];

            foreach ($queries as $query) {
                $stmt = $conn->prepare($query);
                if ($stmt === false) {
                    throw new Exception('Prepare statement failed: ' . $conn->error);
                }

                // Bind parameters according to the table
                if (strpos($query, 'friends') !== false || strpos($query, 'followers') !== false || strpos($query, 'following') !== false || strpos($query, 'conversations') !== false) {
                    $stmt->bind_param('ii', $user_id, $user_id); // Bind twice for these tables
                } else {
                    $stmt->bind_param('i', $user_id); // Single bind for other tables
                }

                // Execute query
                if (!$stmt->execute()) {
                    throw new Exception('Execute statement failed: ' . $stmt->error);
                }

                $stmt->close();
            }

            // Delete the user
            $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
            if ($stmt === false) {
                throw new Exception('Prepare statement failed: ' . $conn->error);
            }
            $stmt->bind_param('i', $user_id);
            if (!$stmt->execute()) {
                throw new Exception('Execute statement failed: ' . $stmt->error);
            }
            $stmt->close();

            // Commit the transaction if everything is successful
            $conn->commit();
            session_destroy();
            header("Location: login.php"); // Redirect to login.php after successful deletion
            exit;

            // Re-enable foreign key checks
            $conn->query("SET foreign_key_checks = 1");
        } catch (Exception $e) {
            // Rollback transaction if there is an error
            $conn->rollback();
            echo "An error occurred while deleting your account: " . $e->getMessage();
        } finally {
            $conn->close(); // Ensure the connection is closed even if an error occurs
        }
    } else {
        echo "Account deletion canceled.";
    }
    
    exit;
}
?>



    <h1>Delete Account</h1>
    <button class="delete-account-btn" onclick="showConfirmationDialog()">Delete Account</button>

    <!-- Confirmation Dialog -->
    <div id="confirmation-dialog" class="confirmation-dialog">
        <form method="POST" action="delete_account.php">
            <button type="submit" name="confirm_delete" value="yes">Confirm</button><br>
            <button type="button" onclick="hideConfirmationDialog()">Cancel</button>
        </form>
    </div>

    
