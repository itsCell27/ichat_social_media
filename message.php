<?php
// Start the session to store messages
session_start();

// Initialize the message array if it doesn't exist yet
if (!isset($_SESSION['messages'])) {
    $_SESSION['messages'] = [];
}

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name']) && isset($_POST['message'])) {
    // Sanitize the input
    $name = htmlspecialchars($_POST['name']);
    $message = htmlspecialchars($_POST['message']);

    // Add the new message to the session array
    $_SESSION['messages'][] = [
        'name' => $name,
        'message' => $message,
        'time' => date("Y-m-d H:i:s")
    ];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Page</title>
</head>
<body>
    <h1>Leave a Message</h1>

    <!-- Form for submitting a message -->
    <form action="" method="POST">
        <label for="name">Your Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="message">Your Message:</label><br>
        <textarea id="message" name="message" rows="4" cols="50" required></textarea><br><br>

        <input type="submit" value="Submit">
    </form>
    <form method="POST">
        <input type="submit" name="clear" value="Clear Messages">
    </form>


    <!-- Display messages -->
    <h2>Messages:</h2>
    <?php if (!empty($_SESSION['messages'])): ?>
        <ul>
            <?php foreach ($_SESSION['messages'] as $msg): ?>
                <li>
                    <strong><?php echo $msg['name']; ?>:</strong>
                    <?php echo $msg['message']; ?>
                    <br><small><?php echo $msg['time']; ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>No messages yet.</p>
    <?php endif; ?>
</body>
<?php
    // To clear session
    if (isset($_POST['clear'])) {
        session_destroy(); // Destroys the session and all its data
        header("Location:"); // Refresh the page to start with a clean session
        exit();
    }
?>
</html>
