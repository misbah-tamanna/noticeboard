<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
$notices = json_decode(file_get_contents('notices.json'), true);
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
        .btn {
        background-color: #4CAF50;
        color: white;
        padding: 8px 16px;
        margin: 5px;
        text-decoration: none;
        border: none;
        border-radius: 4px;
        display: inline-block;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .btn.logout {
            background-color: #f44336;
        }

        .btn.logout:hover {
            background-color: #d7372e;
        }
    </style>
</head>
<body>
    <h2>Welcome, <?php echo $username; ?> (<?php echo $role; ?>)</h2>
    <a href="index.php" class="btn">Home</a>
    <a href="logout.php" class="btn logout">Logout</a>


    <hr>

    <?php if ($role === 'teacher'): ?>
        <h3>Post a Notice</h3>
        <form action="post_notice.php" method="POST">
            <textarea name="message" rows="4" cols="50" required></textarea><br>
            <input type="submit" value="Post Notice">
        </form>
    <?php endif; ?>

    <?php if ($role === 'admin'): ?>
        <h3>Add New User</h3>
        <form action="add_user.php" method="POST">
            <label>Username: <input type="text" name="new_username" required></label><br>
            <label>Password: <input type="password" name="new_password" required></label><br>
            <label>Role:
                <select name="new_role">
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select>
            </label><br>
            <input type="submit" value="Add User">
        </form>

        <h3>Delete Old Notices</h3>
        <form action="delete_notice.php" method="POST">
            <input type="text" name="id" placeholder="Notice ID to delete" required>
            <input type="submit" value="Delete">
        </form>
    <?php endif; ?>

    <hr>

    <h3>All Notices (Newest First)</h3>
    <?php
    usort($notices, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    foreach ($notices as $index => $notice) {
        echo "<div>";
        echo "<p><strong>{$notice['author']}</strong> ({$notice['date']}): {$notice['message']}</p>";

        if ($role === 'teacher' && $notice['author'] === $username) {
            echo "<form action='delete_notice.php' method='POST'>";
            echo "<input type='hidden' name='id' value='$index'>";
            echo "<input type='submit' value='Delete'>";
            echo "</form>";
        }

        if ($role === 'admin') {
            echo "<small>Notice ID: $index</small>";
        }

        echo "<hr></div>";
    }
    ?>
<p style="font-size:12px; text-align:center;">Made by Misbah (Roll No. 17)</p>

</body>
</html>
