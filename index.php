<?php
session_start();
include "backend/db.php";

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_to_cart') {
    $item = [
        'namaBarang' => $_POST['namaBarang'],
        'hargaJual' => $_POST['hargaJual'],
        'foto' => $_POST['foto'],
        'quantity' => 1
    ];

    // Add item to session cart
    $itemExists = false;
    foreach ($_SESSION['cart'] as &$cartItem) {
        if ($cartItem['namaBarang'] === $item['namaBarang']) {
            $cartItem['quantity'] += 1; // Increase quantity if item exists
            $itemExists = true;
            break;
        }
    }
    if (!$itemExists) {
        $_SESSION['cart'][] = $item; // Add new item if it doesn't exist
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}

// Count the number of items in the cart
$cartItemCount = 0;
foreach ($_SESSION['cart'] as $item) {
    $cartItemCount += $item['quantity'];
}

$query = "SELECT * FROM inventory LIMIT 5";
$sql = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Beranda</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

<body class="bg-background">
    <nav class="bg-foreground flex flex-wrap justify-between items-center px-5 md:px-10 py-2">
        <div class="flex items-center gap-3 md:gap-5 relative w-full md:w-auto mt-2 md:mt-0">
            <img src="/img/logo.svg" alt="Logo" class="w-[30px] md:w-[40px]">
        </div>
        <div class="w-full md:w-auto flex justify-between md:justify-start">
            <div class="flex gap-3 md:gap-5 py-2 text-white">
                <div class="relative">
                    <div id="cart-count" class="absolute top-[-10px] left-3 right-1 w-4 h-4 flex justify-center items-center bg-primary rounded-full text-[10px]">
                        <?= $cartItemCount ?>
                    </div>
                    <a href="/pages/cart.php"><box-icon name='cart-alt' type='solid' color='#ffff'></box-icon></a>
                </div>
                <a href="/" class="hover:underline">Beranda</a>
                <a href="/pages/produkKami.php" class="hover:underline">Produk Kami</a>
                <a href="/pages/tentangKami.php" class="hover:underline">Tentang Kami</a>
            </div>
        </div>
    </nav>

    <div class="gap-5 flex justify-center py-5 md:px-20 px-5 items-center md:flex-row flex-col md:gap-10">
        <div class="md:w-1/2">
            <h1 class="text-white font-bold text-5xl">Vape RCF</h1>
            <p class="text-gray-500 font-medium mt-5">RCF Vape Store menjual berbagai jenis vape dan perlengkapannya dengan kualitas terbaik.</p>
            <p class="text-white mt-5 text-justify">
                RCF adalah toko vape yang menjual berbagai jenis perangkat vape, liquid, dan aksesori. Toko ini menyediakan produk berkualitas untuk pengguna vape pemula maupun berpengalaman, dengan pelayanan ramah dan harga kompetitif.
            </p>
            <button class="px-5 py-2 text-white bg-primary rounded font-bold mt-5 hover:bg-green-500    duration-300 transition-color">Lihat Produk lainnya</button>
        </div>
        <div class="md:w-1/2">
            <img src="/img/banner_img.png" alt="" class="w-[500px]">
        </div>
    </div>
    <div class="relative m-10 text-center">
        <h2 class="text-[72px] font-bold text-green-600 opacity-[.7] z-10">Products</h2>
        <p class="absolute z-20 top-[75px] md:left-[420px] text-white font-semibold">Kami Menjual Produk Produk Yang Berkualitas</p>
    </div>
    <div class="flex p-5 gap-5 justify-center md:flex-row flex-col ">
        <!-- INI LIQUID -->
        <div class="flex p-5 bg-foreground rounded gap-2 flex-col ">
            <div class="flex flex-col gap-2">
                <p class="text-white font-bold">Liquid</p>
                <p class="text-white">Mulai Dari <span class="text-primary"> Rp 130.000</span></p>
                <a href="/pages/produkKami.php?search=&filter=Liquid" class="rounded-full border-2 border-primary text-primary flex justify-center hover:bg-primary hover:text-white duration-300 transition-all font-bold">Beli Sekarang</a>
            </div>
            <img src="/img/oatdrips.png" alt="oatdrips" class="w-[200px] object-fit object-cover">
        </div>
        <!-- ini pot -->
        <div class="flex p-5 bg-foreground rounded flex-col flex-grow-0 flex-shrink-0">
            <div class="flex flex-col gap-2 flex-grow-0 flex-shrink-0  ">
                <p class="text-white font-bold">Pot</p>
                <p class="text-white">Mulai Dari <span class="text-primary"> Rp 200.000</span></p>
                <a href="/pages/produkKami.php?search=&filter=Pot" class="rounded-full border-2 border-primary text-primary flex justify-center hover:bg-primary hover:text-white duration-300 transition-all font-bold flex-grow-0">Beli Sekarang</a>
            </div>
            <div>
                <img src="/img/pot.png" alt="pot" class="w-[200px]">
            </div>
        </div>

        <!-- ini catridge -->
        <div class="flex p-5 bg-foreground rounded flex-col flex-grow-0 flex-shrink-0">
            <div class="flex flex-col gap-2 flex-grow-0 flex-shrink-0 ">
                <p class="text-white font-bold">Catridge</p>
                <p class="text-white">Mulai Dari <span class="text-primary"> Rp 35.000</span></p>
                <a href="/pages/produkKami.php?search=&filter=Catridge" class="rounded-full border-2 border-primary text-primary flex justify-center hover:bg-primary hover:text-white duration-300 transition-all font-bold">Beli Sekarang</a>
            </div>
            <div>
                <img src="/img/catridge.png" alt="catridge" class="w-[200px]">
            </div>
        </div>
        <div class="flex p-5 bg-foreground rounded flex-col flex-grow-0 flex-shrink-0">
            <div class="flex flex-col gap-2 flex-grow-0 flex-shrink-0 ">
                <p class="text-white font-bold">Salt Nic</p>
                <p class="text-white">Mulai Dari <span class="text-primary"> Rp 100.000</span></p>
                <a href="/pages/produkKami.php?search=&filter=Salt+nic" class="rounded-full border-2 border-primary text-primary flex justify-center hover:bg-primary hover:text-white duration-300 transition-all font-bold">Beli Sekarang</a>
            </div>
            <div>
                <img src="/img/saltnic.png" alt="oatdrips" class="w-[200px]">
            </div>
        </div>

    </div>
    <div class="flex justify-between md:px-20 px-5 py-5 items-baseline">
        <p class="md:text-4xl font-bold text-primary">Produk Kami</p>
        <a href="/pages/produkKami.php" class="text-gray-500 hover:text-white ease-in-out transition-color duration-300">Lihat Selengkapnya ></a>
    </div>
    <div class="md:px-20 px-5 grid grid-cols-2 md:grid-cols-5 gap-5">
        <?php while ($result = mysqli_fetch_assoc($sql)) { ?>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="border-2 border-transparent hover:border-primary rounded duration-300 transition-all ease-in-out cursor-pointer p-2">
                <input type="hidden" name="action" value="add_to_cart">
                <input type="hidden" name="namaBarang" value="<?php echo $result['nama_barang']; ?>">
                <input type="hidden" name="hargaJual" value="<?php echo $result['harga_jual']; ?>">
                <input type="hidden" name="foto" value="<?php echo $result['foto']; ?>">

                <img src="<?php echo $result['foto']; ?>" alt="" class="w-[200px] h-[200px] rounded object-cover md:object-fill">
                <div class="text-white mt-2">
                    <p><?php echo $result['nama_barang']; ?></p>
                    <p class="text-primary">
                        <?php echo "Rp" . number_format($result['harga_jual'], 0, ',', '.'); ?>
                    </p>
                </div>
                <div class="flex justify-center">
                    <button type="submit" class="text-white bg-primary hover:bg-green-500 px-4 py-2 rounded duration-300 ease-in-out transition-all text-sm mt-2">
                        Tambah ke keranjang
                    </button>
                </div>
            </form>
        <?php } ?>
    </div>
    <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 1000;"></div>

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>

</html>