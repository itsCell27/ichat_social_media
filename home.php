<?php

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $email = $_POST['email'];
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <p>Email:<?php echo " " . htmlspecialchars($email); ?></p>
</body>
</html>