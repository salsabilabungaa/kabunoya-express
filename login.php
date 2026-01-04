<?php
session_start();
include '../adminkoya/koneksi.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Kita cari usernya dulu
    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    
    if (mysqli_num_rows($query) === 1) {
        $data = mysqli_fetch_assoc($query);
        
        // Sesuaikan dengan nama kolom di database kamu (id atau id_user)
        // Jika di screenshot phpMyAdmin namanya 'id', pakai $data['id']
        if (password_verify($password, $data['password'])) {
            $_SESSION['user_id'] = (isset($data['id_user'])) ? $data['id_user'] : $data['id'];
            $_SESSION['nama'] = $data['nama_lengkap'];
            
            header("Location: index.php");
            exit();
        } else {
            echo "<script>alert('Password Salah!'); window.location='login.php';</script>";
        }
    } else {
        echo "<script>alert('Username Tidak Ditemukan!'); window.location='login.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Kabunoya Express</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#fdf5f8; height:100vh; display:flex; align-items:center; justify-content:center;">
    <div class="card p-4 border-0 shadow" style="width:380px; border-radius:15px;">
        <h4 class="text-center fw-bold mb-4" style="color:#ff69b4;">USER LOGIN</h4>
        <form method="POST">
            <div class="mb-3">
                <input type="text" name="username" class="form-control" placeholder="Username" required autofocus>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Password" required>
            </div>
            <button type="submit" name="login" class="btn w-100 text-white fw-bold" style="background:#ff69b4;">LOGIN</button>
            <p class="text-center mt-3 small">Belum punya akun? <a href="register.php" style="color:#ff69b4;">Daftar</a></p>
        </form>
    </div>
</body>
</html>