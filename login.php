<?php
session_start();
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Toko Sepatu Online</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body class="auth-page">
    <header class="hero compact-hero">
        <div class="hero-content">
            <nav class="top-nav">
                <a href="index.php" class="brand-mark">ShoeHub</a>
                <div class="top-links">
                    <a href="index.php">Beranda</a>
                    <a href="products.php">Produk</a>
                    <a href="about.php">Tentang</a>
                    <a href="contact.php">Kontak</a>
                    <a href="register.php">Daftar</a>
                </div>
            </nav>
            <p class="eyebrow">Akun</p>
            <h1>Masuk untuk kelola pesanan dan promo</h1>
            <p>Gunakan akun Anda untuk melihat riwayat belanja, menyimpan favorit, dan menikmati promo eksklusif setiap minggu.</p>
        </div>
    </header>

    <main>
        <?php if ($flash): ?>
            <div style="max-width:1200px;margin:0 auto 18px;padding:12px 18px;background:#ecfdf5;border:1px solid #bbf7d0;border-radius:14px;color:#065f46;"><?php echo htmlspecialchars($flash); ?></div>
        <?php endif; ?>
        <section class="auth-shell">
            <article class="panel-card auth-card">
                <p class="eyebrow">Login</p>
                <h2>Selamat datang kembali</h2>
                <p class="auth-note">Masukkan email dan kata sandi Anda untuk melanjutkan belanja.</p>
                <form class="auth-form" action="auth.php" method="post">
                    <input type="hidden" name="action" value="login" />
                    <label>
                        Email
                        <input type="email" name="email" placeholder="nama@email.com" required />
                    </label>
                    <label>
                        Kata sandi
                        <input type="password" name="password" placeholder="Minimal 8 karakter" required />
                    </label>
                    <label style="display:flex; align-items:center; gap:8px; font-weight:500; color:var(--muted);">
                        <input type="checkbox" />
                        Ingat saya
                    </label>
                    <button class="btn btn-primary" type="submit">Masuk</button>
                    <p class="auth-note">Lupa kata sandi? <a class="auth-link" href="contact.php">Hubungi tim support</a>.</p>
                </form>
            </article>

            <article class="panel-card auth-card auth-side-card">
                <p class="eyebrow">Kenapa daftar?</p>
                <h3>Keuntungan akun member</h3>
                <ul class="feature-list">
                    <li>Riwayat pesanan dan status pengiriman cepat.</li>
                    <li>Promo member eksklusif dan diskon mingguan.</li>
                    <li>Wishlist pribadi untuk koleksi favorit Anda.</li>
                </ul>
                <p class="auth-note" style="margin-top:14px;">Belum punya akun? <a class="auth-link" href="register.php">Daftar sekarang</a>.</p>
            </article>
        </section>
    </main>

    <footer class="footer"><p>&copy; <?php echo date('Y'); ?> Toko Sepatu Online.</p></footer>
</body>
</html>
