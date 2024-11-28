<?php
// Include the DB connection file
require_once 'db.php';

// Assuming the session contains the ID of the logged-in user
// For example, user 8 would be stored in $_SESSION['user_id']
$loggedInUserId = $_SESSION['user_id'] ?? null;

if ($loggedInUserId === null) {
    die('You must be logged in to perform this action.');
}

// Step 1: Get all users followed by the logged-in user
$query = "SELECT followed_id FROM following WHERE following_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $loggedInUserId);
$stmt->execute();
$result = $stmt->get_result();

$followedUsers = [];
while ($row = $result->fetch_assoc()) {
    $followedUsers[] = $row['followed_id'];
}

// Step 2: Get all users followed by the users that the logged-in user follows
$followedUsersIds = implode(',', array_map('intval', $followedUsers)); // Create a comma-separated list of followed user IDs

if (!empty($followedUsersIds)) {
    // Retrieve the followers of the followed users, and join with the 'users' table to get the usernames and profile pictures
    $query = "
        SELECT u.username AS followed_username, u.profile_picture, f.following_id AS follower_id
        FROM following f
        JOIN users u ON u.user_id = f.followed_id
        WHERE f.following_id IN ($followedUsersIds)
    ";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();

    // Collect the usernames, profile pictures, and follower names
    $followedByFollowedUsers = [];

    while ($row = $result->fetch_assoc()) {
        // Get the follower name (e.g., Adrian following Alvin, Aaron)
        $followerQuery = "SELECT username FROM users WHERE user_id = ?";
        $followerStmt = $conn->prepare($followerQuery);
        $followerStmt->bind_param("i", $row['follower_id']);
        $followerStmt->execute();
        $followerResult = $followerStmt->get_result();
        $followerRow = $followerResult->fetch_assoc();
        
        // Store the followed user and the follower's name, along with their profile picture
        $followedByFollowedUsers[] = [
            'followed_username' => $row['followed_username'],
            'profile_picture' => $row['profile_picture'],
            'follower_name' => $followerRow['username']
        ];
    }

    // Output the result in divs using your provided structure
}
?>
