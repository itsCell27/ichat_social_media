<link rel="stylesheet" href="css/home.css">
<?php
// Include database connection
require 'db.php';
session_start();

// Get the current user's ID from the session
$current_user_id = $_SESSION['user_id'] ?? null;

// Check if the search query is set
if (isset($_GET['query'])) {
    $query = $_GET['query'];

    // Prepare the SQL statement to search for users
    $sql = "SELECT * FROM users WHERE (username LIKE ? OR first_name LIKE ? OR last_name LIKE ?) AND user_id != ?";

    if ($stmt = $conn->prepare($sql)) {
        // Bind parameters
        $search_param = '%' . $query . '%';
        $stmt->bind_param("sssi", $search_param, $search_param, $search_param, $current_user_id);

        // Execute the statement
        $stmt->execute();

        // Fetch the results
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Display the results
            echo "<div class='search_suggestion'>";
            while ($user = $result->fetch_assoc()) {
                $user_id = $user['user_id'];
                echo "<div class='search_bar_result'>";
                // Display clickable user names that lead to their user profile
                echo "<a class='result_username_text' href='user_profile.php?id=" . urlencode($user_id) . "'>";
                echo htmlspecialchars($user['first_name'] . " " . $user['last_name']) . " (@" . htmlspecialchars($user['username']) . ")";
                echo "</a>";
                echo "</div>";
            }
            echo "</div>";
        } else {
            echo "<p>No users found matching your search.</p>";
        }

        // Close the statement
        $stmt->close();
    }
} else {
    echo "<p>No search query provided.</p>";
}
?>