<?php
session_start();

$dbFile = __DIR__ . '/users.db';
$sqlFile = __DIR__ . '/database.sql';

if (!file_exists($dbFile)) {
    $pdo = new PDO('sqlite:' . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $sql = file_get_contents($sqlFile);
    if ($sql === false) {
        $_SESSION['flash'] = 'File schema SQL tidak ditemukan.';
        header('Location: register.php');
        exit;
    }
    $pdo->exec($sql);
} else {
    $pdo = new PDO('sqlite:' . $dbFile);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

$action = $_POST['action'] ?? '';

if ($action === 'register') {
    $fullName = trim($_POST['full_name'] ?? '');
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';
    $confirm = $_POST['confirm_password'] ?? '';

    if ($fullName === '' || $email === '' || $password === '' || $confirm === '') {
        $_SESSION['flash'] = 'Semua field wajib diisi.';
        header('Location: register.php');
        exit;
    }

    if (strlen($password) < 8) {
        $_SESSION['flash'] = 'Kata sandi minimal 8 karakter.';
        header('Location: register.php');
        exit;
    }

    if ($password !== $confirm) {
        $_SESSION['flash'] = 'Konfirmasi kata sandi tidak cocok.';
        header('Location: register.php');
        exit;
    }

    $check = $pdo->prepare('SELECT id FROM users WHERE email = ?');
    $check->execute([$email]);
    if ($check->fetch()) {
        $_SESSION['flash'] = 'Email sudah terdaftar. Silakan login.';
        header('Location: login.php');
        exit;
    }

    $stmt = $pdo->prepare('INSERT INTO users (full_name, email, password_hash) VALUES (?, ?, ?)');
    $stmt->execute([$fullName, $email, password_hash($password, PASSWORD_DEFAULT)]);

    $_SESSION['flash'] = 'Pendaftaran berhasil. Silakan login.';
    header('Location: login.php');
    exit;
}

if ($action === 'login') {
    $email = strtolower(trim($_POST['email'] ?? ''));
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $_SESSION['flash'] = 'Email dan kata sandi wajib diisi.';
        header('Location: login.php');
        exit;
    }

    $stmt = $pdo->prepare('SELECT id, full_name, password_hash FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['user'] = [
            'id' => (int) $user['id'],
            'full_name' => $user['full_name'],
            'email' => $email
        ];
        $_SESSION['flash'] = 'Login berhasil. Selamat datang ' . htmlspecialchars($user['full_name']) . '!';
        header('Location: index.php');
        exit;
    }

    $_SESSION['flash'] = 'Email atau kata sandi salah.';
    header('Location: login.php');
    exit;
}

$_SESSION['flash'] = 'Permintaan tidak valid.';
header('Location: index.php');
exit;
