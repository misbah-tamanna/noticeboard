<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['new_username'];
    $password = $_POST['new_password'];
    $role = $_POST['new_role'];

    $users = json_decode(file_get_contents('users.json'), true);

    // Check if user already exists
    foreach ($users as $user) {
        if ($user['username'] === $username) {
            echo "Username already exists. <a href='dashboard.php'>Back</a>";
            exit();
        }
    }

    $users[] = [
        'username' => $username,
        'password' => $password,
        'role' => $role
    ];

    file_put_contents('users.json', json_encode($users, JSON_PRETTY_PRINT));
    header("Location: dashboard.php");
    exit();
}
?>
