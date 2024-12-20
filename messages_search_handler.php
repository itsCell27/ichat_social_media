<?php
session_start();
include 'db.php';

// Ensure the user is logged in
$loggedInUserId = $_SESSION['user_id'] ?? null;
if (!$loggedInUserId) {
    die('You must be logged in to access this feature.');
}

// Handle the search
if (isset($_POST['search_term'])) {
    // Sanitize the search term
    $searchTerm = $_POST['search_term'];

    // Prepare the query to search for users that match the search term (excluding the logged-in user)
    $query = "SELECT user_id, username, profile_picture FROM users 
              WHERE username LIKE ? AND user_id != ?";
    $stmt = $conn->prepare($query);

    // Bind the parameters
    $searchTermParam = "%" . $searchTerm . "%"; // Add percent symbols for LIKE search
    $stmt->bind_param("si", $searchTermParam, $loggedInUserId);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Prepare the response
    $response = '';

    if ($result->num_rows > 0) {
        // Iterate through the search results and generate a clickable list
        while ($user = $result->fetch_assoc()) {
            $profilePic = htmlspecialchars($user['profile_picture']) ? $user['profile_picture'] : 'default-avatar.jpg';
            $response .= "<div class='conversation-item' data-user-id='{$user['user_id']}'>
                            <a href='#' id='conversation-item'>
                                <img class='search-result-img' src='$profilePic' alt='{$user['username']}' onerror=\"this.src='default_pic.png';\"/>
                                <span class='username'>" . htmlspecialchars($user['username']) . "</span>
                            </a>
                          </div>";
        }
    } else {
        // If no results found, return a message
        $response = "<li>No users found.</li>";
    }

    // Return the response back to the AJAX request
    echo $response;

    // Close the statement
    $stmt->close();
}
?>
