<?php
session_start();
header('Content-Type: application/json');

if (isset($_SESSION['email']) && isset($_SESSION['password'])) {
    echo json_encode([
        'email' => $_SESSION['email'],
        'password' => $_SESSION['password']
    ]);
} else {
    echo json_encode([
        'email' => 'Not Logged In',
        'password' => 'Not Logged In'
    ]);
}
?>
