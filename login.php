<?php
session_start();

$username = $_POST['username'];
$password = $_POST['password'];

$users = json_decode(file_get_contents('users.json'), true);

foreach ($users as $user) {
    if ($user['username'] === $username && $user['password'] === $password) {
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $user['role'];
        header("Location: dashboard.php");
        exit();
    }
}

echo "Invalid credentials. <a href='index.php'>Try again</a>";
?>
