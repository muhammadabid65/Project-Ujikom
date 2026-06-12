<?php
session_start();

$products = [
    [
        'id' => 1,
        'name' => 'Nike Air Force 1',
        'price' => 1599000,
        'category' => 'Sneakers',
        'description' => 'Klasik, nyaman, dan cocok untuk gaya kasual sehari-hari.',
        'image' => 'airforce.png'
    ],
    [
        'id' => 2,
        'name' => 'Adidas Ultraboost',
        'price' => 2499000,
        'category' => 'Running',
        'description' => 'Ringan dan responsif, sempurna untuk lari dan latihan.',
        'image' => 'ultrabost.png'
    ],
    [
        'id' => 3,
        'name' => 'Converse Chuck Taylor',
        'price' => 699000,
        'category' => 'Casual',
        'description' => 'Sepatu ikonik untuk gaya santai dan modern.',
        'image' => 'convers.png'
    ],
    [
        'id' => 4,
        'name' => 'Vans Old Skool',
        'price' => 799000,
        'category' => 'Skate',
        'description' => 'Desain timeless dengan stripe yang sangat dikenal.',
        'image' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=800&q=80'
    ],
    [
        'id' => 5,
        'name' => 'New Balance 574',
        'price' => 899000,
        'category' => 'Lifestyle',
        'description' => 'Nyaman, dukungan ekstra, dan cocok untuk aktivitas sehari-hari.',
        'image' => '574.png'
    ],
    [
        'id' => 6,
        'name' => 'Addidas Samba',
        'price' => 239000,
        'category' => 'Casual',
        'description' => 'Nyaman, dukungan ekstra, dan cocok untuk aktivitas sehari-hari.',
        'image' => 'pinksamba.png'
    ],
    [
        'id' => 7,
        'name' => 'Aerostreet Jujutsu Kaisen',
        'price' => 329000,
        'category' => 'Lifestyle',
        'description' => 'Nyaman, dukungan ekstra, dan cocok untuk aktivitas sehari-hari.',
        'image' => 'aerostreet.png'
    ],
    [
        'id' => 8,
        'name' => 'Vans Old Skool',
        'price' => 309000,
        'category' => 'Skate',
        'description' => 'Nyaman, dukungan ekstra, dan cocok untuk aktivitas sehari-hari.',
        'image' => 'vans.png'
    ]
];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

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
    header('Location: products.php');
    exit;
}

$cartCount = array_sum($_SESSION['cart']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Produk - Toko Sepatu Online</title>
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
            <p class="eyebrow">Produk</p>
            <h1>Temukan koleksi sepatu pilihan terbaik</h1>
            <p>Gunakan pencarian dan filter untuk melihat model favorit Anda dengan cepat.</p>
            <div class="hero-actions">
                <a href="cart.php" class="cart btn">Keranjang: <span id="cart-count"><?php echo $cartCount; ?></span> item</a>
            </div>
        </div>
    </header>

    <main>
        <section class="search-panel">
            <div class="search-box">
                <label for="search-input">Cari sepatu:</label>
                <input type="text" id="search-input" placeholder="Cari berdasarkan nama atau kategori..." />
            </div>
            <div class="filters">
                <button class="filter-btn active" data-filter="all">Semua</button>
                <button class="filter-btn" data-filter="Sneakers">Sneakers</button>
                <button class="filter-btn" data-filter="Running">Running</button>
                <button class="filter-btn" data-filter="Casual">Casual</button>
                <button class="filter-btn" data-filter="Skate">Skate</button>
                <button class="filter-btn" data-filter="Lifestyle">Lifestyle</button>
            </div>
        </section>

        <section id="products" class="product-grid">
            <?php foreach ($products as $product): ?>
                <article class="product-card" data-category="<?php echo htmlspecialchars($product['category']); ?>">
                    <img src="<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
                    <div class="product-info">
                        <span class="product-category"><?php echo htmlspecialchars($product['category']); ?></span>
                        <h2><?php echo htmlspecialchars($product['name']); ?></h2>
                        <p><?php echo htmlspecialchars($product['description']); ?></p>
                        <div class="product-meta">
                            <span class="price">Rp <?php echo number_format($product['price'], 0, ',', '.'); ?></span>
                            <div style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
                                <a href="?add=<?php echo $product['id']; ?>" class="btn btn-secondary">Tambah ke Keranjang</a>
                                <a href="?buy=<?php echo $product['id']; ?>" class="btn" style="background:#ff6b6b;color:white;border-radius:999px;padding:10px 14px;text-decoration:none;">Beli Sekarang</a>
                            </div>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </section>
    </main>

    <footer class="footer"><p>&copy; <?php echo date('Y'); ?> Toko Sepatu Online.</p></footer>
    <script src="script.js"></script>
</body>
</html>
