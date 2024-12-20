<?php
// Include database connection
require 'db.php';
include 'friends_db_handler.php';
session_start();

// Get the logged-in user's ID from the session
$current_user_id = $_SESSION['user_id'] ?? null;

// Check if a user ID is provided in the URL
if (isset($_GET['id'])) {
    $user_id = intval($_GET['id']); // Convert to integer to ensure it's a valid ID
} else {
    // If no ID is provided, use the current user's ID
    $user_id = $current_user_id;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instagram Profile</title>
    <link rel="stylesheet" href="user_profile.css">
</head>
<body>
    
<?php
        $sql = "SELECT * FROM users WHERE user_id = ?";

if ($stmt = $conn->prepare($sql)) {
    // Bind the user_id parameter
    $stmt->bind_param("i", $user_id);

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists
    if ($result->num_rows > 0) {
        // Fetch user data
        $user = $result->fetch_assoc();

        $followers_count_sql = "SELECT COUNT(*) as count FROM following WHERE followed_id = ?";
        $followers_stmt = $conn->prepare($followers_count_sql);
        $followers_stmt->bind_param("i", $user_id);
        $followers_stmt->execute();
        $followers_result = $followers_stmt->get_result();
        $followers_count = $followers_result->fetch_assoc()['count'];

        // Fetch following count
        $following_count_sql = "SELECT COUNT(*) as count FROM following WHERE following_id = ?";
        $following_stmt = $conn->prepare($following_count_sql);
        $following_stmt->bind_param("i", $user_id);
        $following_stmt->execute();
        $following_result = $following_stmt->get_result();
        $following_count = $following_result->fetch_assoc()['count'];
        echo '
        <div class="profile-info-container">
            <div class="profile-info">
                <div class="profile-picture">
                    <img src="'.htmlspecialchars($user['profile_picture']).'" alt="Profile Picture">
                </div>
                <div class="profile-details">
                    <div class="username-buttons">
                        <h2>'. htmlspecialchars($user['username']) .'</h2>';
                        if ($user_id == $current_user_id) {
                            echo '<a href="edit_profile.php"><button class="edit-profile-button">Edit Profile</button></a>
                                  <button class="archive-button">Archive</button>';
                        }
                        echo '
                    </div>
                    <div class="post-followers">
                        <div class="followers">
                            <p>'. htmlspecialchars($followers_count) .' followers</p>
                          
                        </div>
                        <div class="following">
                            <p>'. htmlspecialchars($following_count) .' following</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
echo '
        <div class="bottom-buttons-container">
    <div class="bottom-buttons-wrapper">
        <div class="bottom-buttons">
            <button id="show-posts-btn" class="bottom-button" >Posts</button>
            
            <button id="show-saved-posts-btn" class="bottom-button" >Saved</button>
            
            <button  id="show-tagged-posts-btn" class="bottom-button" >Tagged</button>
            
        </div>
    </div>
</div>
    </div>
    <div id="posts-container" style="display: none;"></div>
<div id="saved-posts-container" style="display: none;"></div>
<div id="tagged-posts-container" style="display: none;"></div>';
    $stmt->close();
      } else {
          echo "<p>Error preparing statement.</p>";
      }
    }
?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
     
function hideAllContainers() {
    $('#posts-container').hide();
    $('#saved-posts-container').hide();
    $('#tagged-posts-container').hide();
}

// Click event for posts button
$(document).on('click', '#show-posts-btn', function() {
    hideAllContainers(); // Hide all other containers
    const userId = <?php echo json_encode($user_id); ?>;
    $.get('fetch_user_posts.php', { user_id: userId }, function(response) {
        const result = JSON.parse(response);
        if (result.status === "success") {
            $('#posts-container').html(result.posts.map(post => 
                `<div class='post'>
                    <p>${post.content}</p>
                    ${post.image_url ? <img src='${post.image_url}' alt='Post Image' style='max-width: 100%;'/> : ''}
                    ${post.video_url ? <video controls src='${post.video_url}' style='max-width: 100%;'></video> : ''}
                    <p><strong>Likes:</strong> ${post.likes_count} | <strong>Comments:</strong> ${post.comments_count} | <strong>Shares:</strong> ${post.shares_count}</p>
                </div>`).join(''));
            $('#posts-container').show(); // Show the posts container
        } else {
            alert(result.message);
        }
    }).fail(function() {
        alert("An error occurred while fetching posts.");
    });
});

// Click event for saved posts button
$(document).on('click', '#show-saved-posts-btn', function() {
    hideAllContainers(); // Hide all other containers
    const userId = <?php echo json_encode($user_id); ?>;
    $.get('saved_fetch.php', { user_id: userId }, function(response) {
        const result = JSON.parse(response);
        if (result.status === "success") {
            const postsHtml = result.posts.map(post => 
                `<div class='post'>
                    <p>${post.content}</p>
                    ${post.image_url ? <img src='${post.image_url}' alt='Post Image' style='max-width: 100%;'/> : ''}
                    ${post.video_url ? <video controls src='${post.video_url}' style='max-width: 100%;'></video> : ''}
                    <p><strong>Likes:</strong> ${post.likes_count} | <strong>Comments:</strong> ${post.comments_count} | <strong>Shares:</strong> ${post.shares_count}</p>
                </div>`).join('');
            $('#saved-posts-container').html(postsHtml);
            $('#saved-posts-container').show(); // Show the saved posts container
        } else {
            alert(result.message || "An error occurred while fetching saved posts.");
        }
    }).fail(function() {
        alert("An error occurred while fetching saved posts.");
    });
});

// Click event for tagged posts button
$(document).on('click', '#show-tagged-posts-btn', function() {
    hideAllContainers(); // Hide all other containers
    const userId = <?php echo json_encode($user_id); ?>;
    $.get('fetch_tagged_posts.php', { user_id: userId }, function(response) {
        const result = JSON.parse(response);
        if (result.status === "success") {
            const postsHtml = result.posts.map(post => 
                `<div class='post'>
                    <p>${post.content}</p>
                    ${post.image_url ? <img src='${post.image_url}' alt='Post Image' style='max-width: 100%;'/> : ''}
                    ${post.video_url ? <video controls src='${post.video_url}' style='max-width: 100%;'></video> : ''}
                    <p><strong>Likes:</strong> ${post.likes_count} | <strong>Comments:</strong> ${post.comments_count} | <strong>Shares:</strong> ${post.shares_count}</p>
                </div>`).join('');
            $('#tagged-posts-container').html(postsHtml);
            $('#tagged-posts-container').show(); // Show the tagged posts container
        } else {
            alert(result.message || "An error occurred while fetching tagged posts.");
        }
    }).fail(function() {
        alert("An error occurred while fetching tagged posts.");
    });
});

    </script>
</body>
</html>