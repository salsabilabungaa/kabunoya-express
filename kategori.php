<tbody>
    <?php
    $res = mysqli_query($conn, "SELECT k.*, COUNT(p.id_produk) as total FROM kategori k LEFT JOIN produk p ON k.id_kategori = p.id_kategori GROUP BY k.id_kategori");
    
    // VARIABEL $row HARUS DI DALAM WHILE
    while($row = mysqli_fetch_assoc($res)): ?>
    <tr>
        <td><?= $row['id_kategori'] ?></td>
        <td class="fw-bold"><?= $row['nama_kategori'] ?></td>
        <td>
            <a href="index.php?kat=<?= $row['id_kategori'] ?>" class="btn btn-sm btn-outline-primary">
                <?= $row['total'] ?> Items (See Details)
            </a>
        </td>
    </tr>
    <?php endwhile; ?>
</tbody>