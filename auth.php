<?php
include '../adminkoya/koneksi.php';
session_start();

// Proses Register
if (isset($_POST['register'])) {
    $user = $_POST['username'];
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nama = $_POST['nama_lengkap'];
    mysqli_query($conn, "INSERT INTO users (username, password, nama_lengkap) VALUES ('$user', '$pass', '$nama')");
    echo "<script>alert('Berhasil Daftar!');</script>";
}

// Proses Login
if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $res = mysqli_query($conn, "SELECT * FROM users WHERE username='$user'");
    $data = mysqli_fetch_assoc($res);
    if ($data && password_verify($pass, $data['password'])) {
        $_SESSION['user_id'] = $data['id_user'];
        $_SESSION['nama'] = $data['nama_lengkap'];
        header("Location: index.php");
    } else {
        echo "<script>alert('Login Gagal!');</script>";
    }
}
?>