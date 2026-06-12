<?php
session_start();



if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Jika klik "Beli Sekarang" dari halaman produk, tambahkan ke keranjang lalu langsung ke halaman keranjang
if (isset($_GET['buy'])) {
    $productId = (int) $_GET['buy'];
    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 0;
    }
    $_SESSION['cart'][$productId]++;
    header('Location: cart.php');
    exit;
}

if (isset($_GET['add'])) {
    $productId = (int) $_GET['add'];
    if (!isset($_SESSION['cart'][$productId])) {
        $_SESSION['cart'][$productId] = 0;
    }
    $_SESSION['cart'][$productId]++;
    header('Location: index.php');
    exit;
}

$cartCount = array_sum($_SESSION['cart']);

// Flash message singkat
$flash = '';
if (isset($_SESSION['flash'])) {
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Toko Sepatu Online</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <header class="hero">
        <div class="hero-content">
            <nav class="top-nav">
                <a href="#" class="brand-mark">ShoeHub</a>
                <div class="top-links">
                    <a href="products.php">Produk</a>
                    <a href="about.php">Tentang</a>
                    <a href="contact.php">Kontak</a>
                    <a href="login.php">Masuk</a>
                    <a href="register.php">Daftar</a>
                </div>
            </nav>
            <p class="eyebrow">Toko Sepatu</p>
            <h1>Jual Sepatu Terbaik untuk Gaya Anda</h1>
            <p>Temukan pilihan sepatu sneakers, running, casual, dan skate dengan kualitas terbaik, harga jelas, dan pengiriman cepat.</p>
            <div class="hero-actions">
                <a href="products.php" class="btn btn-primary">Lihat Produk</a>
                <a href="cart.php" class="cart btn" style="background:rgba(255,255,255,0.12);border-radius:999px;padding:10px 16px;text-decoration:none;color:white;">
                    <strong>Keranjang:</strong> <span id="cart-count"><?php echo $cartCount; ?></span> item
                </a>
            </div>
            <ul class="feature-pills">
                <li>Gratis Ongkir</li>
                <li>Bayar Aman</li>
                <li>Promo Mingguan</li>
            </ul>
        </div>
        <div class="hero-visual">
            <div class="hero-image">
                <img src="toko.jpg" alt="Toko sepatu modern dengan koleksi sneakers premium" />
            </div>
            <div class="hero-badges">
                <span class="mini-note">⭐ 4.9 rating pelanggan</span>
                <span class="mini-note mini-note-soft">🛍️ Koleksi terbaru 2026</span>
            </div>
        </div>
    </header>

    <?php if ($flash): ?>
        <div style="max-width:1200px;margin:16px auto;padding:12px 20px;background:#ecfdf5;border:1px solid #bbf7d0;border-radius:12px;color:#065f46;">
            <?php echo htmlspecialchars($flash); ?>
        </div>
    <?php endif; ?>

    <main>
        <section class="stats-grid">
            <article class="stat-card"><strong>500+</strong><span>Model sepatu terbaru</span></article>
            <article class="stat-card"><strong>24 jam</strong><span>Proses pesanan cepat</span></article>
            <article class="stat-card"><strong>98%</strong><span>Pelanggan puas</span></article>
        </section>

        <section class="info-grid">
            <article class="panel-card">
                <p class="eyebrow">Kenapa Memilih Kami?</p>
                <h2>Kenapa pelanggan memilih kami?</h2>
                <p>Stok terbaru, harga transparan, dan pengiriman cepat membuat belanja sepatu Anda terasa aman dan nyaman.</p>
            </article>
            <article class="panel-card highlight-card">
                <p class="eyebrow">Media visual</p>
                <img src="https://images.unsplash.com/photo-1525966222134-fcfa99b8ae77?auto=format&fit=crop&w=900&q=80" alt="Visual koleksi sepatu" />
            </article>
        </section>

        <section class="panel-grid">
            <article class="panel-card testimonial-card" id="testimonials">
                <p class="eyebrow">Testimoni</p>
                <h2>“Beli sepatu di sini gampang, cepat, dan kualitasnya premium.”</h2>
                <p>— Rina, pelanggan setia</p>
            </article>
            <article class="panel-card cta-card" id="contact">
                <p class="eyebrow">Promo</p>
                <h2>Siap upgrade penampilan Anda?</h2>
                <p>Mulai belanja sekarang dan nikmati promo khusus member baru.</p>
                <button class="btn btn-primary" id="open-modal" type="button">Lihat Notifikasi Promo</button>
            </article>
        </section>

        
    </main>

    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> Toko Sepatu Online. Semua hak cipta dilindungi.</p>
    </footer>

    <div class="modal-backdrop" id="notification-modal" aria-hidden="true">
        <div class="modal-card" role="dialog" aria-modal="true" aria-labelledby="modal-title">
            <button class="modal-close" id="close-modal" type="button" aria-label="Tutup popup">&times;</button>
            <p class="eyebrow">Modal</p>
            <h3 id="modal-title">Promo khusus hari ini</h3>
            <p>Dapatkan diskon 10% untuk pembelian sepatu pertama Anda. Segera checkout sekarang!</p>
            <button class="btn btn-secondary" type="button" id="confirm-modal">Saya Mengerti</button>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>