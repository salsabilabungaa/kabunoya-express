<?php 
session_start();

// 1. Proteksi Halaman: Wajib Login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// 2. Koneksi ke Database
include '../adminkoya/koneksi.php'; 

// 3. Data 12 Produk Manual (Pastikan file gambar ada di folder img/)
$products_manual = [
    ['id' => 1, 'name' => 'Original Kabunoya', 'price' => 12000, 'image' => 'img/produk1.jpg'],
    ['id' => 2, 'name' => 'Mie Kabunoya', 'price' => 15000, 'image' => 'img/produk2.jpg'],
    ['id' => 3, 'name' => 'Ricebowl Cuminoya', 'price' => 30000, 'image' => 'img/produk3.jpg'],
    ['id' => 4, 'name' => 'Spaghettinoya', 'price' => 42000, 'image' => 'img/produk7.jpg'],
    ['id' => 5, 'name' => 'Cheetos', 'price' => 12000, 'image' => 'img/produk8.jpg'],
    ['id' => 6, 'name' => 'Ichigoya', 'price' => 25000, 'image' => 'img/produk4.jpg'],
    ['id' => 7, 'name' => 'Noyaricano', 'price' => 15000, 'image' => 'img/produk5.jpg'],
    ['id' => 8, 'name' => 'Matchacih', 'price' => 31000, 'image' => 'img/produk6.jpg'],
    ['id' => 9, 'name' => 'Noygurt', 'price' => 15000, 'image' => 'img/produk9.jpg'],
    ['id' => 10, 'name' => 'Kabunoya Water', 'price' => 16000, 'image' => 'img/produk10.jpg'],
    ['id' => 11, 'name' => 'Lauvrawmen', 'price' => 45000, 'image' => 'img/produk11.png'],
    ['id' => 12, 'name' => 'NEW! Kabunoya secret', 'price' => 17000, 'image' => 'img/produk12.jpg'],
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kabunoya Express - Home</title> 
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root { --pink-koya: #ff69b4; }
        .nav-link i { font-size: 1.6rem; color: var(--pink-koya); }
        .dropdown-menu { border-radius: 12px; border: 1px solid var(--pink-koya); }
        .hero-header { background: #ffc0cb; min-height: 250px; }
        .btn-pink { background-color: var(--pink-koya); color: white; border: none; border-radius: 10px; }
        .btn-pink:hover { background-color: #ff1493; color: white; }
        .card-product { border-radius: 15px; border: none; transition: 0.3s; }
        .card-product:hover { transform: translateY(-5px); }
        .sticky-cart { top: 100px; border-radius: 15px; border: none; }
        .footer-dark { background: #222; color: white; padding: 40px 0; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="img/logo - Copy.jpg" alt="Logo" class="me-2" width="45" height="45">
                <span class="fw-bold" style="color: var(--pink-koya);">Kabunoya Express</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <li class="nav-item"><a class="nav-link" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#products">Menu</a></li>
                    <li class="nav-item"><a class="nav-link" href="#about">About Us</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact Us</a></li>
                    
                    <li class="nav-item dropdown ms-lg-3">
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="profileDrop" role="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                            <li class="dropdown-header text-center py-2" style="background: #fff5f7;">
                                <strong class="text-dark"><?= $_SESSION['nama'] ?></strong>
                            </li>
                            <li><a class="dropdown-item" href="profile.php"><i class="fas fa-user-edit me-2"></i> Update Profil</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="logout.php"><i class="fas fa-sign-out-alt me-2"></i> Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <header class="hero-header text-center d-flex align-items-center justify-content-center">
        <div class="container">
            <h1 class="display-4 fw-bold">Selamat Datang di Kabunoya!</h1>
            <p class="lead">Cita rasa Nusantara bertemu dengan gaya unik Meksiko.</p>
        </div>
    </header>

    <main class="container my-5">
        <div class="row">
            <div class="col-md-8">
                <h2 class="mb-4 fw-bold" id="products" style="color: var(--pink-koya);">Daftar Menu</h2>
                <div class="row row-cols-1 row-cols-md-3 g-4">
                    <?php foreach ($products_manual as $p): ?>
                        <div class="col">
                            <div class="card h-100 shadow-sm card-product">
                                <img src="<?= $p['image'] ?>" class="card-img-top" style="height:180px; object-fit:cover; border-radius: 15px 15px 0 0;">
                                <div class="card-body text-center">
                                    <h6 class="fw-bold"><?= $p['name'] ?></h6>
                                    <h5 class="text-danger fw-bold mb-3">Rp <?= number_format($p['price'], 0, ',', '.') ?></h5>
                                    <button class="btn btn-pink btn-add-cart w-100 py-2 fw-bold" 
                                            data-id="<?= $p['id'] ?>" data-name="<?= $p['name'] ?>" data-price="<?= $p['price'] ?>">
                                        Tambah
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            
            <div class="col-md-4 mt-5 mt-md-0">
                <div class="card shadow-sm sticky-top sticky-cart">
                    <div class="card-header text-white fw-bold text-center py-3" style="background: var(--pink-koya); border-radius: 15px 15px 0 0;">
                        🛒 Keranjang Belanja
                    </div>
                    <div class="card-body" id="cart-items" style="min-height: 150px;">
                        <p class="text-muted text-center py-4" id="empty-cart-message">Keranjang masih kosong.</p>
                    </div>
                    <div class="card-footer bg-white py-3">
                        <div class="d-flex justify-content-between fw-bold mb-3 fs-5">
                            <span>Total:</span>
                            <span id="cart-total" style="color: var(--pink-koya);">Rp 0</span>
                        </div>
                        <button class="btn btn-success w-100 py-2 fw-bold" id="checkout-button">CHECKOUT SEKARANG</button>
                    </div>
                </div>
            </div>
        </div>

        <section class="py-5 my-5 border-top text-center">
            <h2 class="fw-bold mb-4" style="color: var(--pink-koya);">Open Franchise</h2>
            <img src="img/franchise.jpg" class="img-fluid rounded-4 shadow-lg" width="600">
        </section>

        <section id="about" class="py-5 border-top"> 
            <div class="container">
                <h2 class="fw-bold text-center mb-5">About Us</h2>
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <img src="img/kabunoya.jpg" alt="About" class="img-fluid rounded-4 shadow-sm">
                    </div>
                    <div class="col-md-7 px-md-5 mt-4 mt-md-0">
                        <p class="lead">Kabunoya dikembangkan oleh 5 Mahasiswa PSTI. Perpaduan unik antara burrito Meksiko, nasi goreng kampung, dan dabu-dabu Manado menciptakan sensasi rasa yang tak terlupakan.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="contact" class="py-5 bg-light rounded-4 my-5 shadow-sm">
             <div class="container">
                <h2 class="fw-bold text-center mb-5">Contact Us</h2>
                <div class="row g-4">
                   <div class="col-md-6">
                      <div class="card p-4 border-0 shadow-sm" style="border-radius: 15px;">
                          <div class="mb-3">
                             <label class="form-label fw-bold">Name</label>
                             <input type="text" class="form-control" placeholder="Nama Anda...">
                          </div>
                          <div class="mb-3">
                             <label class="form-label fw-bold">Email</label>
                             <input type="email" class="form-control" placeholder="email@anda.com">
                          </div>
                          <div class="mb-3">
                             <label class="form-label fw-bold">Message</label>
                             <textarea class="form-control" rows="3" placeholder="Pesan Anda..."></textarea>
                          </div>
                          <button class="btn btn-pink fw-bold w-100 py-2">Kirim Sekarang</button>
                      </div>
                   </div>
                   <div class="col-md-6">
                      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.307450341795!2d107.636!3d-6.974!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTgnMjYuNCJTIDEwN8KwMzgnMDkuNiJF!5e0!3m2!1sid!2sid!4v1625000000000" 
                              width="100%" height="380" style="border:0; border-radius:15px;" allowfullscreen="" loading="lazy"></iframe>
                   </div>
                </div>
             </div>
        </section>
    </main>

    <footer class="footer-dark text-center">
        <p class="mb-0 small fw-bold">© 2025 Kabunoya Express - All Rights Reserved.</p>
    </footer>

    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>