<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$notices = json_decode(file_get_contents('notices.json'), true);
$id = $_POST['id'];
$role = $_SESSION['role'];
$username = $_SESSION['username'];

if (!isset($notices[$id])) {
    echo "Invalid ID.";
    exit();
}

if ($role === 'admin' || ($role === 'teacher' && $notices[$id]['author'] === $username)) {
    array_splice($notices, $id, 1);
    file_put_contents('notices.json', json_encode($notices, JSON_PRETTY_PRINT));
}

header("Location: dashboard.php");
?>
