<?php
include '../adminkoya/koneksi.php';

if (isset($_POST['register'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $user = mysqli_real_escape_string($conn, $_POST['username']);
    $pass = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password, nama_lengkap) VALUES ('$user', '$pass', '$nama')";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Berhasil Daftar!'); window.location='login.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <title>Register - Kabunoya Express</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background:#fdf5f8; height:100vh; display:flex; align-items:center; justify-content:center;">
    <div class="card p-4 border-0 shadow" style="width:380px; border-radius:15px;">
        <h4 class="text-center fw-bold mb-4" style="color:#ff69b4;">DAFTAR AKUN</h4>
        <form method="POST">
            <div class="mb-3"><input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required></div>
            <div class="mb-3"><input type="text" name="username" class="form-control" placeholder="Username" required></div>
            <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
            <button type="submit" name="register" class="btn w-100 text-white fw-bold" style="background:#ff69b4;">DAFTAR</button>
        </form>
    </div>
</body>
</html>