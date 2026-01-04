<?php
include '../adminkoya/koneksi.php';
$data = json_decode(file_get_contents('php://input'), true);

if (!empty($data['cart'])) {
    foreach ($data['cart'] as $item) {
        $id = $item['id'];
        $qty = $item['quantity'];
        // Update stok di tabel produk milik admin
        mysqli_query($conn, "UPDATE produk SET stok = stok - $qty WHERE id_produk = '$id'");
    }
    echo json_encode(['status' => 'success']);
}
?>