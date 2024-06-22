<?php
require_once 'database/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function login($email, $password) {
        $email = $this->db->escape_string($email);
        $password = $this->db->escape_string($password);

        $query = "SELECT * FROM multiuser WHERE emailuser = '$email' AND (status='user' OR status='admin') AND passworduser = '$password'";
        $result = $this->db->query($query);

        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if ($user['status'] == 'user') {
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['status'] = $user['status'];
                header("location: user/home_user.php");
            } elseif ($user['status'] == 'admin') {
                $_SESSION['nama_lengkap'] = "admin";
                $_SESSION['id_admin'] = $user['id_admin'];
                header("location: admin/home_admin.php");
            } else {
                echo "<script>alert('Akun Anda Belum Aktif, Silahkan Cek Email Anda untuk Aktivasi Akun !');history.back();</script>";
            }
        } else {
            echo "<script>alert('Username atau Password Anda Salah !');history.back();</script>";
        }
    }

    public function register($email, $nama_lengkap, $password, $ulangi_password) {
        $email = $this->db->escape_string($email);
        $nama_lengkap = $this->db->escape_string($nama_lengkap);
        $password = $this->db->escape_string($password);
        $ulangi_password = $this->db->escape_string($ulangi_password);

        if ($password != $ulangi_password) {
            echo "<script>alert('Ulangi, password tidak sama');history.back();</script>";
            return;
        }

        $sql = "SELECT emailuser FROM multiuser WHERE emailuser = '$email'";
        $result = $this->db->query($sql);

        if ($result->num_rows > 0) {
            echo "<script>alert('Email Sudah Terdfatar !');history.back();</script>";
        } else {
            $sql = "INSERT INTO multiuser (nama_lengkap, emailuser, passworduser, status) VALUES ('$nama_lengkap', '$email', '$password', 'user')";
            $this->db->query($sql);
            echo "<script>alert('Anda Sukses Registrasi, silahkan Login !');window.location.href = 'index.php';</script>";
        }
    }
}
?>
