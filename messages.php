<?php
session_start();
include 'db.php';

// Ensure the user is logged in
$loggedInUserId = $_SESSION['user_id'] ?? null;
if (!$loggedInUserId) {
    die('You must be logged in to access this feature.');
}

// Fetch recent conversations and the last message for each
$query = "SELECT u.username, 
                 u.profile_picture,
                 IF(m.sender_id = $loggedInUserId, 'You', u.username) AS sender,
                 m.message, 
                 DATE_FORMAT(m.created_at, '%l:%i %p') AS time,
                 u.user_id AS other_user_id
          FROM messages m
          JOIN conversations c ON m.conversation_id = c.conversation_id
          JOIN users u ON (u.user_id = c.user1_id OR u.user_id = c.user2_id)
          WHERE (c.user1_id = $loggedInUserId OR c.user2_id = $loggedInUserId)
          AND u.user_id != $loggedInUserId
          AND m.created_at = (
              SELECT MAX(created_at) 
              FROM messages 
              WHERE conversation_id = m.conversation_id
          )
          ORDER BY m.created_at DESC 
          LIMIT 10";

$result = $conn->query($query);

$recentConversations = [];
if ($result->num_rows > 0) {
    $recentConversations = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Users</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body{
            height: 100vh;
            width: 100vw;
        }
        ul { list-style-type: none; padding: 0; }
        li { margin: 5px 0; }
        a { text-decoration: none; color: inherit; display: flex; align-items: center; padding: 10px; border: 1px solid #ccc; border-radius: 5px; }
        a:hover { background-color: #f0f0f0; }
        .recent-messages { border-top: 1px solid #ccc; margin-top: 20px; padding-top: 10px; }
        .username { font-weight: bold; }
        .message-details { margin-left: 10px; color: #555; }
        
        .avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }
        #results {
    position: absolute;  /* Position relative to the search box * /* Place the results directly below the search box */
    left: 0;
    width: 100%;  /* Match the width of the search input */
    max-height: 30%;  /* Limit the height of the results */
    overflow-y: auto;  /* Add scroll bar if there are too many results */
    background-color: #fff;  /* White background for results */
    border: 1px solid #ccc;  /* Border around results */
    border-radius: 5px;  /* Rounded corners */
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);  /* Subtle shadow */
    z-index: 9999;  /* Ensure results appear above other content */
    margin-top: 5px;  /* Optional space between the input and results */
    padding: 0;  /* No extra padding inside the box */
}
    </style>
</head>
<body>
    <h2>Search Users</h2>
    <input type="text" id="searchInput" placeholder="Type to search..." autocomplete="off">

    <ul id="results"></ul>

    <div class="recent-messages">
    <h3>Recent Messages</h3>
    <?php 
    if (!empty($recentConversations)) {
        echo '<ul>';
        foreach ($recentConversations as $conversation) {
            echo '<li>
                    <a href="#" class="conversation-item" data-user-id="' . htmlspecialchars($conversation['other_user_id']) . '">
                        <img src="' . (htmlspecialchars($conversation['profile_picture']) ? htmlspecialchars($conversation['profile_picture']) : 'default-avatar.jpg') . '" alt="Profile Picture" class="avatar">
                        <span class="username">' . htmlspecialchars($conversation['username']) . '</span><br>
                        <span class="message-details">
                            ' . htmlspecialchars($conversation['sender']) . ': 
                            ' . htmlspecialchars($conversation['message']) . ' 
                            ' . htmlspecialchars($conversation['time']) . '
                        </span>
                    </a>
                  </li>';
        }
        echo '</ul>';
    } else {
        echo '<p>No recent messages found.</p>';
    }
    ?>
</div>

    <!-- Dynamic conversation container -->
    <div id="conversation-container">
        <p>Select a conversation to start chatting...</p>
    </div>

    <script>
        $(document).ready(function () {
            // Handle typing in the search input field
            $('#searchInput').on('input', function () {
                const searchTerm = $(this).val();
                if (searchTerm.length > 0) {
                    $.ajax({
                        url: 'messages_search_handler.php',
                        method: 'POST',
                        data: { search_term: searchTerm },
                        success: function (response) {
                            $('#results').html(response);
                        }
                    });
                } else {
                    $('#results').empty();
                }
            });

            // Event listener for the clickable search results
            $(document).on('click', '.conversation-item', function (e) {
                e.preventDefault();
                const userId = $(this).data('user-id');

                // Load the conversation for the clicked user
                loadConversation(userId);
            });

            function loadConversation(userId) {
                // Use AJAX to load the messages with the selected user
                $.ajax({
                    url: 'messages_load.php', // The page that will load the conversation
                    method: 'GET',
                    data: { user2_id: userId },
                    success: function (response) {
                        // Insert the loaded conversation into the conversation container
                        $('#conversation-container').html(response).show();
                    }
                });
            }
        });
    </script>
</body>
</html>
