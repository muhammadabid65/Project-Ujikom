<?php
session_start();

$orderId = $_GET['id'] ?? '';
$ordersFile = __DIR__ . '/orders.json';
$order = null;
if ($orderId && file_exists($ordersFile)) {
    $content = file_get_contents($ordersFile);
    $orders = json_decode($content, true) ?: [];
    foreach ($orders as $o) {
        if ($o['id'] === $orderId) {
            $order = $o;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>Pesanan Diterima - Toko Sepatu</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
    <header style="padding:24px;text-align:center;background:#fff;margin-bottom:20px;box-shadow:0 6px 18px rgba(0,0,0,0.04)">
        <a href="index.php" style="text-decoration:none;color:var(--text)"><h2>Toko Sepatu</h2></a>
    </header>

    <main style="max-width:900px;margin:0 auto;padding:20px;">
        <?php if ($order): ?>
            <h3>Terima kasih, pesanan Anda telah diterima!</h3>
            <p>Nomor pesanan: <strong><?php echo htmlspecialchars($order['id']); ?></strong></p>
            <h4>Ringkasan</h4>
            <ul>
                <?php foreach ($order['items'] as $it): ?>
                    <li><?php echo htmlspecialchars($it['name']); ?> x <?php echo $it['qty']; ?> — Rp <?php echo number_format($it['subtotal'],0,',','.'); ?></li>
                <?php endforeach; ?>
            </ul>
            <p><strong>Total: Rp <?php echo number_format($order['total'],0,',','.'); ?></strong></p>
            <p><strong>Metode pembayaran:</strong> <?php echo htmlspecialchars($order['payment_method'] === 'card' ? 'Kartu Kredit/Debit' : 'Transfer Bank'); ?></p>
            <?php if ($order['payment_method'] === 'card'): ?>
                <p>Status Pembayaran: <strong><?php echo htmlspecialchars($order['payment_status']); ?></strong></p>
            <?php else: ?>
                <p>Status Pembayaran: <strong><?php echo htmlspecialchars($order['payment_status']); ?></strong></p>
                <div style="background:#f8fafc;border:1px solid #dbeafe;padding:12px;border-radius:8px;margin:12px 0;">
                    <p>Silakan transfer ke rekening berikut:</p>
                    <p><strong>BCA 1234-5678-9012 a.n. Toko Sepatu</strong></p>
                </div>
            <?php endif; ?>
            <p>Data pengiriman:</p>
            <div style="background:#fff;border:1px solid #e5e7eb;padding:12px;border-radius:8px;">
                <div><?php echo htmlspecialchars($order['name']); ?></div>
                <div><?php echo htmlspecialchars($order['address']); ?></div>
                <div><?php echo htmlspecialchars($order['phone']); ?></div>
                <div><?php echo htmlspecialchars($order['email']); ?></div>
            </div>
            <p style="margin-top:16px;"><a href="index.php" class="btn">Kembali ke Beranda</a></p>
        <?php else: ?>
            <h3>Pesanan tidak ditemukan</h3>
            <p><a href="index.php">Kembali</a></p>
        <?php endif; ?>
    </main>

    <footer class="footer">
        <p>&copy; <?php echo date('Y'); ?> Toko Sepatu Online</p>
    </footer>
</body>
</html>
