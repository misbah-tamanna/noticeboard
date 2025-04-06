<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Notice Board</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: sans-serif;
            margin: 10px;
        }
        textarea {
            width: 100%;
            max-width: 100%;
        }
        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            padding: 8px;
            margin: 5px 0;
            width: 100%;
            max-width: 300px;
            box-sizing: border-box;
        }
        form {
            margin-bottom: 20px;
        }
        hr {
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <h2>Welcome to the Class Notice Board</h2>
    <?php if (isset($_SESSION['username'])): ?>
        <p>Hello, <?php echo $_SESSION['username']; ?>!</p>
        <a href="dashboard.php">Go to Dashboard</a><br>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <form action="login.php" method="POST">
            <label>Username: <input type="text" name="username" required></label><br>
            <label>Password: <input type="password" name="password" required></label><br>
            <input type="submit" value="Login">
        </form>
    <?php endif; ?>
</body>
</html>
