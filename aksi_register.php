<?php
session_start();
require_once 'User.php';

if (isset($_POST['daftar'])) {
    $email = $_POST['email'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $password = $_POST['password'];
    $ulangi_password = $_POST['ulangi_password'];

    $user = new User();
    $user->register($email, $nama_lengkap, $password, $ulangi_password);
}
?>
