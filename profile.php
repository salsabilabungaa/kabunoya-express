<?php
session_start();
include '../adminkoya/koneksi.php';

// 1. Cek Login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil ID dari Session (Gunakan id_user sesuai auth.php Anda)
$id_session = $_SESSION['user_id'];

// 2. Ambil Data User Terbaru dari Database
// Saya menggunakan 'id_user' sesuai dengan file login/auth Anda
$query_user = mysqli_query($conn, "SELECT * FROM users WHERE id = '$id_session'");
$user = mysqli_fetch_assoc($query_user);

// 3. Proses Update Data
if (isset($_POST['update'])) {
    $nama   = mysqli_real_escape_string($conn, $_POST['nama']);
    $email  = mysqli_real_escape_string($conn, $_POST['email']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    
    // Update data ke database
    $sql_update = "UPDATE users SET 
                    nama_lengkap = '$nama', 
                    email = '$email', 
                    alamat = '$alamat' 
                   WHERE id_user = '$id_session'";
    
    if (mysqli_query($conn, $sql_update)) {
        // Update session nama agar di Navbar langsung berubah
        $_SESSION['nama'] = $nama;
        
        echo "<script>
                alert('Profil Berhasil Diperbarui!');
                window.location='profile.php';
              </script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil - Kabunoya Express</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body style="background-color: #fdf5f8; min-height: 100vh; display: flex; align-items: center;">

    <div class="container">
        <div class="card mx-auto shadow-sm border-0" style="max-width: 500px; border-radius: 15px;">
            <div class="card-header bg-white text-center py-4 border-0">
                <h4 class="fw-bold" style="color: #ff69b4;">Update Profil</h4>
                <p class="text-muted small">Kelola informasi data diri Anda</p>
            </div>
            <div class="card-body px-4 pb-4">
                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label fw-bold small">Nama Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-user text-muted"></i></span>
                            <input type="text" name="nama" class="form-control bg-light border-0" value="<?= htmlspecialchars($user['nama_lengkap']) ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold small">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-envelope text-muted"></i></span>
                            <input type="email" name="email" class="form-control bg-light border-0" value="<?= htmlspecialchars($user['email'] ?? '') ?>" placeholder="contoh@mail.com">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small">Alamat Lengkap</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-0"><i class="fas fa-map-marker-alt text-muted"></i></span>
                            <textarea name="alamat" class="form-control bg-light border-0" rows="3"><?= htmlspecialchars($user['alamat'] ?? '') ?></textarea>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" name="update" class="btn fw-bold py-2 shadow-sm" style="background-color: #ff69b4; color: white; border-radius: 10px;">
                            Simpan Perubahan
                        </button>
                        <a href="index.php" class="btn btn-light fw-bold py-2" style="border-radius: 10px;">
                            Kembali ke Beranda
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>