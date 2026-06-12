<?php
session_start();

$products = [
    [
        'id' => 1,
        'name' => 'Nike Air Force 1',
        'price' => 1599000,
        'category' => 'Sneakers',
        'description' => 'Klasik, nyaman, dan cocok untuk gaya kasual sehari-hari.',
        'image' => 'https://images.unsplash.com/photo-1519741498174-1009df39444a?auto=format&fit=crop&w=800&q=80'
    ],
    [
        'id' => 2,
        'name' => 'Adidas Ultraboost',
        'price' => 2499000,
        'category' => 'Running',
        'description' => 'Ringan dan responsif, sempurna untuk lari dan latihan.',
        'image' => 'https://images.unsplash.com/photo-1528701800489-20b9cbf6a0bb?auto=format&fit=crop&w=800&q=80'
    ],
    [
        'id' => 3,
        'name' => 'Converse Chuck Taylor',
        'price' => 699000,
        'category' => 'Casual',
        'description' => 'Sepatu ikonik untuk gaya santai dan modern.',
        'image' => 'https://images.unsplash.com/photo-1528701800483-3b70c8424fa6?auto=format&fit=crop&w=800&q=80'
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
        'image' => 'https://images.unsplash.com/photo-1519431458148-9a4b14dc8f18?auto=format&fit=crop&w=800&q=80'
    ]
];

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

function findProduct($products, $id) {
    foreach ($products as $p) {
        if ($p['id'] == $id) return $p;
    }
    return null;
}

// Hapus item
if (isset($_GET['remove'])) {
    $id = (int) $_GET['remove'];
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
    header('Location: cart.php');
    exit;
}

$paymentMethod = $_POST['payment_method'] ?? 'bank_transfer';
$cardNumber = trim($_POST['card_number'] ?? '');
$cardExpiry = trim($_POST['card_expiry'] ?? '');
$cardCvv = trim($_POST['card_cvv'] ?? '');

// Update kuantitas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
    if (isset($_POST['qty']) && is_array($_POST['qty'])) {
        foreach ($_POST['qty'] as $id => $q) {
            $id = (int) $id;
            $q = (int) $q;
            if ($q <= 0) {
                unset($_SESSION['cart'][$id]);
            } else {
                $_SESSION['cart'][$id] = $q;
            }
        }
    }
    header('Location: cart.php');
    exit;
}

// Checkout
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['checkout'])) {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $paymentMethod = $_POST['payment_method'] ?? 'bank_transfer';
    $cardNumber = trim($_POST['card_number'] ?? '');
    $cardExpiry = trim($_POST['card_expiry'] ?? '');
    $cardCvv = trim($_POST['card_cvv'] ?? '');

    $errors = [];
    if ($name === '') $errors[] = 'Nama wajib diisi.';
    if ($email === '') $errors[] = 'Email wajib diisi.';
    if ($address === '') $errors[] = 'Alamat wajib diisi.';
    if ($paymentMethod === 'card') {
        if ($cardNumber === '' || $cardExpiry === '' || $cardCvv === '') {
            $errors[] = 'Lengkapi data kartu kredit/debit untuk membayar.';
        }
    }

    $items = [];
    $total = 0;
    foreach ($_SESSION['cart'] as $id => $qty) {
        $p = findProduct($products, $id);
        if ($p) {
            $items[] = [
                'id' => $p['id'],
                'name' => $p['name'],
                'price' => $p['price'],
                'qty' => $qty,
                'subtotal' => $p['price'] * $qty,
            ];
            $total += $p['price'] * $qty;
        }
    }

    if (empty($items)) {
        $errors[] = 'Keranjang kosong.';
    }

    if (empty($errors)) {
        $order = [
            'id' => uniqid('order_'),
            'name' => $name,
            'email' => $email,
            'address' => $address,
            'phone' => $phone,
            'payment_method' => $paymentMethod,
            'payment_status' => $paymentMethod === 'card' ? 'Lunas' : 'Menunggu Konfirmasi',
            'payment_info' => $paymentMethod === 'card' ? ['card_last4' => substr($cardNumber, -4)] : null,
            'items' => $items,
            'total' => $total,
            'created_at' => date('c'),
        ];

        $ordersFile = __DIR__ . '/orders.json';
        $orders = [];
        if (file_exists($ordersFile)) {
            $content = file_get_contents($ordersFile);
            $orders = json_decode($content, true) ?: [];
        }
        $orders[] = $order;
        file_put_contents($ordersFile, json_encode($orders, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Bersihkan keranjang
        $_SESSION['cart'] = [];
        $_SESSION['flash'] = 'Terima kasih! Pesanan Anda telah diterima.';

        header('Location: order_success.php?id=' . urlencode($order['id']));
        exit;
    }
}

$cartItems = [];
$grandTotal = 0;
foreach ($_SESSION['cart'] as $id => $qty) {
    $p = findProduct($products, $id);
    if ($p) {
        $subtotal = $p['price'] * $qty;
        $cartItems[] = ['product' => $p, 'qty' => $qty, 'subtotal' => $subtotal];
        $grandTotal += $subtotal;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Keranjang - Toko Sepatu</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <header style="padding:24px;text-align:center;background:#fff;margin-bottom:20px;box-shadow:0 6px 18px rgba(0,0,0,0.04)">
        <a href="index.php" style="text-decoration:none;color:var(--text)"><h2>Toko Sepatu</h2></a>
    </header>

    <main style="max-width:1000px;margin:0 auto;padding:20px;">
        <h3>Keranjang Anda</h3>

        <?php if (!empty($errors)): ?>
            <div style="background:#fee2e2;padding:12px;border-radius:8px;color:#991b1b;margin-bottom:16px;">
                <?php foreach ($errors as $e): ?>
                    <div><?php echo htmlspecialchars($e); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (empty($cartItems)): ?>
            <p>Keranjang kosong. <a href="index.php">Kembali belanja</a></p>
        <?php else: ?>
            <form method="post">
                <input type="hidden" name="update" value="1" />
                <table style="width:100%;border-collapse:collapse;margin-bottom:18px;">
                    <thead>
                        <tr style="text-align:left;border-bottom:1px solid #e5e7eb;">
                            <th>Produk</th>
                            <th>Kuantitas</th>
                            <th>Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cartItems as $row): $p = $row['product']; ?>
                        <tr>
                            <td style="padding:12px 0;">
                                <strong><?php echo htmlspecialchars($p['name']); ?></strong>
                                <div style="color:#6b7280;">Rp <?php echo number_format($p['price'],0,',','.'); ?></div>
                            </td>
                            <td style="padding:12px 0;">
                                <input type="number" name="qty[<?php echo $p['id']; ?>]" value="<?php echo $row['qty']; ?>" min="0" style="width:84px;padding:8px;border-radius:8px;border:1px solid #e5e7eb;" />
                            </td>
                            <td style="padding:12px 0;">Rp <?php echo number_format($row['subtotal'],0,',','.'); ?></td>
                            <td style="padding:12px 0;"><a href="cart.php?remove=<?php echo $p['id']; ?>">Hapus</a></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div style="display:flex;gap:12px;align-items:center;margin-bottom:24px;">
                    <button type="submit" class="btn btn-secondary">Perbarui Keranjang</button>
                    <a href="index.php" class="btn">Lanjut Belanja</a>
                </div>
            </form>

            <div style="background:#fff;border-radius:12px;padding:18px;border:1px solid #e5e7eb;">
                <h4>Ringkasan Pesanan</h4>
                <div style="display:flex;justify-content:space-between;margin-bottom:8px;">Total</div>
                <div style="font-weight:700;margin-bottom:12px;">Rp <?php echo number_format($grandTotal,0,',','.'); ?></div>

                <h4>Form Checkout</h4>
                <form method="post">
                    <input type="hidden" name="checkout" value="1" />
                    <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px;">
                        <input type="text" name="name" placeholder="Nama penerima" required style="padding:10px;border-radius:8px;border:1px solid #e5e7eb;" />
                        <input type="email" name="email" placeholder="Email" required style="padding:10px;border-radius:8px;border:1px solid #e5e7eb;" />
                    </div>
                    <div style="margin-bottom:10px;">
                        <input type="text" name="phone" placeholder="Telepon" style="width:100%;padding:10px;border-radius:8px;border:1px solid #e5e7eb;" />
                    </div>
                    <div style="margin-bottom:10px;">
                        <textarea name="address" placeholder="Alamat pengiriman" rows="3" required style="width:100%;padding:10px;border-radius:8px;border:1px solid #e5e7eb;"><?php echo htmlspecialchars($address ?? ''); ?></textarea>
                    </div>
                    <div style="margin-bottom:12px;display:grid;gap:10px;">
                        <label style="font-weight:600;">Metode Pembayaran</label>
                        <select name="payment_method" id="payment-method" style="width:100%;padding:10px;border-radius:8px;border:1px solid #e5e7eb;">
                            <option value="bank_transfer" <?php echo ($paymentMethod ?? 'bank_transfer') === 'bank_transfer' ? 'selected' : ''; ?>>Transfer Bank</option>
                            <option value="card" <?php echo ($paymentMethod ?? '') === 'card' ? 'selected' : ''; ?>>Kartu Kredit/Debit</option>
                        </select>
                    </div>
                    <div id="card-details" style="display:<?php echo ($paymentMethod ?? 'bank_transfer') === 'card' ? 'grid' : 'none'; ?>;gap:10px;margin-bottom:12px;">
                        <input type="text" name="card_number" placeholder="Nomor kartu (XXXX XXXX XXXX XXXX)" value="<?php echo htmlspecialchars($cardNumber ?? ''); ?>" style="width:100%;padding:10px;border-radius:8px;border:1px solid #e5e7eb;" />
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:10px;">
                            <input type="text" name="card_expiry" placeholder="MM/YY" value="<?php echo htmlspecialchars($cardExpiry ?? ''); ?>" style="padding:10px;border-radius:8px;border:1px solid #e5e7eb;" />
                            <input type="text" name="card_cvv" placeholder="CVV" value="<?php echo htmlspecialchars($cardCvv ?? ''); ?>" style="padding:10px;border-radius:8px;border:1px solid #e5e7eb;" />
                        </div>
                    </div>
                    <div style="display:flex;gap:10px;align-items:center;">
                        <button type="submit" class="btn btn-primary">Bayar Sekarang</button>
                        <small style="color:#6b7280;">Pembayaran masih simulasi (tidak terhubung gateway)</small>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </main>

    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> Toko Sepatu Online</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>
