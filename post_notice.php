<?php
session_start();
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'teacher') {
    header("Location: index.php");
    exit();
}

$message = $_POST['message'];
$author = $_SESSION['username'];
$date = date("Y-m-d H:i:s");

$notices = json_decode(file_get_contents('notices.json'), true);

$notices[] = [
    'author' => $author,
    'message' => $message,
    'date' => $date
];

file_put_contents('notices.json', json_encode($notices, JSON_PRETTY_PRINT));
header("Location: dashboard.php");
?>
