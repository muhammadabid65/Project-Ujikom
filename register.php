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
    <title>Register - Toko Sepatu Online</title>
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
                    <a href="login.php">Masuk</a>
                </div>
            </nav>
            <p class="eyebrow">Daftar</p>
            <h1>Buat akun untuk pengalaman belanja yang lebih praktis</h1>
            <p>Daftar sekarang untuk menikmati promo, tracking pesanan, dan notifikasi terbaru dari toko kami.</p>
        </div>
    </header>

    <main>
        <?php if ($flash): ?>
            <div style="max-width:1200px;margin:0 auto 18px;padding:12px 18px;background:#fef3c7;border:1px solid #fde68a;border-radius:14px;color:#92400e;"><?php echo htmlspecialchars($flash); ?></div>
        <?php endif; ?>
        <section class="auth-shell">
            <article class="panel-card auth-card">
                <p class="eyebrow">Register</p>
                <h2>Buat akun baru</h2>
                <p class="auth-note">Isi data singkat berikut untuk mulai menikmati semua benefit member.</p>
                <form class="auth-form" action="auth.php" method="post">
                    <input type="hidden" name="action" value="register" />
                    <label>
                        Nama lengkap
                        <input type="text" name="full_name" placeholder="Contoh: Andi Pratama" required />
                    </label>
                    <label>
                        Email
                        <input type="email" name="email" placeholder="nama@email.com" required />
                    </label>
                    <label>
                        Kata sandi
                        <input type="password" name="password" placeholder="Minimal 8 karakter" required />
                    </label>
                    <label>
                        Konfirmasi kata sandi
                        <input type="password" name="confirm_password" placeholder="Ulangi kata sandi" required />
                    </label>
                    <button class="btn btn-primary" type="submit">Daftar</button>
                    <p class="auth-note">Sudah punya akun? <a class="auth-link" href="login.php">Masuk di sini</a>.</p>
                </form>
            </article>

            <article class="panel-card auth-card auth-side-card">
                <p class="eyebrow">Keunggulan member</p>
                <h3>Kenapa pelanggan memilih akun member?</h3>
                <ul class="feature-list">
                    <li>Update produk terbaru langsung ke email Anda.</li>
                    <li>Diskon khusus dan akses promo terbatas.</li>
                    <li>Proses checkout lebih cepat dengan data tersimpan.</li>
                </ul>
            </article>
        </section>
    </main>

    <footer class="footer"><p>&copy; <?php echo date('Y'); ?> Toko Sepatu Online.</p></footer>
</body>
</html>
