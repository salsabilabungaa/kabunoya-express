<?php
include '../adminkoya/koneksi.php';
session_start();

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id_user'];
            $_SESSION['nama_user'] = $row['nama_lengkap'];
            header("Location: index.php");
        }
    }
    $error = true;
}
?>