<?php
session_start();
require_once 'User.php';

$op = $_GET['op'];
$user = new User();

if ($op == "in") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user->login($email, $password);
} else if ($op == "out") {
    session_unset();
    session_destroy();
    header("location: index.php");
}
?>
