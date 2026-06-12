<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kontak - Toko Sepatu Online</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <header class="hero compact-hero">
        <div class="hero-content">
            <nav class="top-nav">
                <a href="index.php" class="brand-mark">ShoeHub</a>
                <div class="top-links">
                    <a href="index.php">Beranda</a>
                    <a href="products.php">Produk</a>
                    <a href="about.php">Tentang</a>
                    <a href="contact.php">Kontak</a>
                </div>
            </nav>
            <p class="eyebrow">Kontak</p>
            <h1>Hubungi tim kami kapan saja</h1>
            <p>Untuk bantuan pemesanan, pertanyaan produk, atau promo khusus, kami siap membantu.</p>
        </div>
    </header>

    <main>
        <section class="auth-grid">
            <article class="panel-card">
                <h2>Informasi Kontak</h2>
                <p>Email: support@shoehub.example</p>
                <p>Telepon: +62 812 3456 7890</p>
                <p>Alamat: Jl. Fashion No. 28, Jakarta</p>
            </article>
            <article class="panel-card">
                <h2>Form Pertanyaan</h2>
                <form class="auth-form">
                    <input type="text" placeholder="Nama" />
                    <input type="email" placeholder="Email" />
                    <textarea placeholder="Pesan Anda" rows="4" style="width:100%;padding:12px 14px;border-radius:12px;border:1px solid #e5e7eb;"></textarea>
                    <button class="btn btn-primary" type="button">Kirim</button>
                </form>
            </article>
        </section>
    </main>

    <footer class="footer"><p>&copy; <?php echo date('Y'); ?> Toko Sepatu Online.</p></footer>
</body>
</html>
