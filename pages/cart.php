<?php
session_start();
include '../backend/db.php';

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize cart in session
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add item to cart
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $namaBarang = $_POST['nama_barang'];
    $hargaJual = $_POST['harga_jual'];
    $foto = $_POST['foto'];

    // Check if item already exists in cart
    $itemExists = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['namaBarang'] === $namaBarang) {
            $item['quantity'] += 1;
            $itemExists = true;
            break;
        }
    }

    if (!$itemExists) {
        $_SESSION['cart'][] = [
            'namaBarang' => $namaBarang,
            'hargaJual' => $hargaJual,
            'foto' => $foto,
            'quantity' => 1
        ];
    }
}

// Update quantity
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantity'])) {
    $namaBarang = $_POST['nama_barang'];
    $action = $_POST['action'];

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['namaBarang'] === $namaBarang) {
            if ($action === 'increase') {
                $item['quantity'] += 1;
            } elseif ($action === 'decrease' && $item['quantity'] > 1) {
                $item['quantity'] -= 1;
            }
            break;
        }
    }
}

// Remove item
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_item'])) {
    $namaBarang = $_POST['nama_barang'];

    $_SESSION['cart'] = array_filter($_SESSION['cart'], function ($item) use ($namaBarang) {
        return $item['namaBarang'] !== $namaBarang;
    });
}

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_order'])) {
    $name = $_POST['name'];
    $address = $_POST['address'];
    $orderId = "RCF" . rand(100000, 999999);
    $cart = $_SESSION['cart'];
    $tanggal = date('d-m-Y');

    foreach ($cart as $item) {
        $namaBarang = $item['namaBarang'];
        $hargaJual = $item['hargaJual'];
        $quantity = $item['quantity'];
        $status = "Pending";

        $sql = "INSERT INTO request_order (nama_pembeli, order_id, nama_barang, harga_jual, quantity,alamat,tanggal, status) 
                VALUES ('$name','$orderId', '$namaBarang', '$hargaJual', '$quantity', '$address','$tanggal','$status')";

        if (!$conn->query($sql)) {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    // Clear cart after order submission
    $_SESSION['cart'] = [];
    header("Location: https://wa.me/6281994280045?text=Send20%a20%quote");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        background: '#111111',
                        foreground: '#161616',
                        primary: '#34e24d',
                        hover: '#091930'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-background text-white">
    <div class="container mx-auto px-5 py-10">
        <a href="/">Kembali</a>
        <h1 class="text-3xl font-bold mb-5">Keranjang Belanja</h1>

        <div id="cart-items" class="space-y-5">
            <?php if (!empty($_SESSION['cart'])): ?>
                <?php $totalPrice = 0; ?>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                    <?php $itemTotalPrice = $item['hargaJual'] * $item['quantity']; ?>
                    <?php $totalPrice += $itemTotalPrice; ?>
                    <div class="flex items-center justify-between bg-foreground p-4 rounded shadow">
                        <div class="flex items-center gap-4">
                            <img src="<?= $item['foto'] ?>" alt="<?= $item['namaBarang'] ?>" class="w-16 h-16 object-cover rounded">
                            <div>
                                <p class="font-bold"><?= $item['namaBarang'] ?></p>
                                <p class="text-primary">Rp <?= number_format($item['hargaJual'], 0, ',', '.') ?> x <?= $item['quantity'] ?></p>
                                <p>Total: Rp <?= number_format($itemTotalPrice, 0, ',', '.') ?></p>
                            </div>
                        </div>
                        <div class="flex gap-2">
                            <form method="POST" class="inline">
                                <input type="hidden" name="nama_barang" value="<?= $item['namaBarang'] ?>">
                                <input type="hidden" name="action" value="increase">
                                <button type="submit" name="update_quantity" class="px-3 py-1 bg-green-600 text-white rounded">+</button>
                            </form>
                            <form method="POST" class="inline">
                                <input type="hidden" name="nama_barang" value="<?= $item['namaBarang'] ?>">
                                <input type="hidden" name="action" value="decrease">
                                <button type="submit" name="update_quantity" class="px-3 py-1 bg-red-600 text-white rounded">-</button>
                            </form>
                            <form method="POST" class="inline">
                                <input type="hidden" name="nama_barang" value="<?= $item['namaBarang'] ?>">
                                <button type="submit" name="remove_item" class="px-3 py-1 bg-gray-600 text-white rounded">Hapus</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
                <div id="cart-total" class="mt-5 text-right text-lg font-bold">Total: Rp <?= number_format($totalPrice, 0, ',', '.') ?></div>
            <?php else: ?>
                <div id="empty-cart-message" class="text-center text-gray-400 mt-10">Keranjang belanja Anda kosong.</div>
            <?php endif; ?>
        </div>
        <form method="POST" class="mt-10">
            <div class="mb-4">
                <label for="name" class="block text-lg font-bold">Nama Lengkap</label>
                <input type="text" id="name" name="name" required class="mt-2 p-2 w-full bg-foreground border border-primary rounded">
            </div>
            <div class="mb-4">
                <label for="address" class="block text-lg font-bold">Alamat</label>
                <textarea id="address" name="address" required class="mt-2 p-2 w-full bg-foreground border border-primary rounded"></textarea>
            </div>
            <button type="submit" name="submit_order" class="px-5 py-2 bg-primary text-white rounded font-bold hover:bg-green-500 duration-300">Pesan Sekarang</button>
        </form>
    </div>
</body>

</html>
