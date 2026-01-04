<?php
include 'koneksi.php'; // Pastikan path koneksi benar

if (isset($_POST['checkout'])) {
    // 1. Ambil data dari session user dan form
    $id_user = $_SESSION['user_id']; 
    $total_bayar = $_POST['total_harga'];
    $tanggal = date('Y-m-d H:i:s');

    // 2. Simpan ke tabel transaksi (Agar muncul di Admin)
    $query_t = "INSERT INTO transaksi (id_user, total, tanggal) VALUES ('$id_user', '$total_bayar', '$tanggal')";
    
    if (mysqli_query($conn, $query_t)) {
        // 3. LOGIKA PENGURANGAN STOK (SYARAT TUGAS ANDA)
        // Kita asumsikan barang yang dibeli ada di session keranjang
        foreach ($_SESSION['keranjang'] as $id_produk => $jumlah) {
            // Update stok: Stok lama dikurangi jumlah beli
            mysqli_query($conn, "UPDATE produk SET stok = stok - $jumlah WHERE id_produk = '$id_produk'");
        }

        // Kosongkan keranjang
        unset($_SESSION['keranjang']);
        echo "<script>alert('Pesanan Berhasil! Silakan cek di Admin.'); window.location='index.php';</script>";
    } else {
        echo "Gagal kirim pesanan: " . mysqli_error($conn);
    }
}
?>