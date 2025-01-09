<?php
session_start();
include '../backend/db.php';

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


    $itemExists = false;
    foreach ($_SESSION['cart'] as &$cartItem) {
        if ($cartItem['namaBarang'] === $item['namaBarang']) {
            $cartItem['quantity'] += 1;
            $itemExists = true;
            break;
        }
    }
    if (!$itemExists) {
        $_SESSION['cart'][] = $item;
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}


$cartItemCount = 0;
foreach ($_SESSION['cart'] as $item) {
    $cartItemCount += $item['quantity'];
}


$itemsPerPage = 15;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $itemsPerPage;


$filter = isset($_GET['filter']) ? $_GET['filter'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';

$whereClause = "WHERE 1=1";
if ($filter) {
    $whereClause .= " AND kategori = '$filter'";
}
if ($search) {
    $whereClause .= " AND nama_barang LIKE '%$search%'";
}


$totalQuery = "SELECT COUNT(*) as total FROM inventory $whereClause";
$totalResult = mysqli_query($conn, $totalQuery);
$totalRow = mysqli_fetch_assoc($totalResult);
$totalItems = $totalRow['total'];
$totalPages = ceil($totalItems / $itemsPerPage);


$query = "SELECT * FROM inventory $whereClause LIMIT $itemsPerPage OFFSET $offset";
$sql = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Kami</title>
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
    <div class="relative m-10 text-center">
        <h1 class="text-[72px] font-bold text-green-600 opacity-[.7] z-10">Products</h1>
        <p class="absolute z-20 top-[75px] md:left-[420px] text-white font-semibold">Kami Menjual Produk Produk Yang Berkualitas</p>
    </div>
    <form action="" method="get" class="flex justify-between md:px-20 pb-5">
        <input
            type="text"
            name="search"
            value="<?php echo htmlspecialchars($search); ?>"
            placeholder="Cari produk..."
            class="bg-foreground text-white px-4 py-2 rounded-lg">
        <div class="flex gap-2">
            <button
                type="submit"
                name="filter"
                value=""
                class="<?php echo $filter === '' ? 'bg-green-500' : 'bg-primary'; ?> md:px-4 md:py-2 rounded-lg text-white font-bold">
                All
            </button>
            <button
                type="submit"
                name="filter"
                value="Liquid"
                class="<?php echo $filter === 'Liquid' ? 'bg-green-500' : 'bg-primary'; ?> md:px-4 md:py-2 rounded-lg text-white font-bold">
                Liquid
            </button>
            <button
                type="submit"
                name="filter"
                value="Salt nic"
                class="<?php echo $filter === 'Salt nic' ? 'bg-green-500' : 'bg-primary'; ?> md:px-4 md:py-2 rounded-lg text-white font-bold">
                Salt-nic
            </button>
            <button
                type="submit"
                name="filter"
                value="Pot"
                class="<?php echo $filter === 'Pot' ? 'bg-green-500' : 'bg-primary'; ?> md:px-4 md:py-2 rounded-lg text-white font-bold">
                Pot
            </button>
            <button
                type="submit"
                name="filter"
                value="Catridge"
                class="<?php echo $filter === 'Catridge' ? 'bg-green-500' : 'bg-primary'; ?> md:px-4 md:py-2 rounded-lg text-white font-bold">
                Catridge
            </button>
        </div>
    </form>


    <div class="md:px-20 px-5 grid grid-cols-2 md:grid-cols-5 gap-5">
        <?php while ($result = mysqli_fetch_assoc($sql)) { ?>
            <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="border-2 border-transparent hover:border-primary rounded duration-300 transition-all ease-in-out cursor-pointer p-2">
                <input type="hidden" name="action" value="add_to_cart">
                <input type="hidden" name="namaBarang" value="<?php echo $result['nama_barang']; ?>">
                <input type="hidden" name="hargaJual" value="<?php echo $result['harga_jual']; ?>">
                <input type="hidden" name="foto" value="<?php echo $result['foto']; ?>">

                <img src="<?php echo $result['foto']; ?>" alt="" class="w-[200px] h-[200px] rounded object-cover md:object-fill">
                <div class="text-white mt-2">
                    <p class="text-sm"><?php echo $result['nama_barang']; ?></p>
                    <p class="text-primary">
                        <?php echo "Rp" . number_format($result['harga_jual'], 0, ',', '.'); ?>
                    </p>
                </div>
                <div class="flex justify-center">
                    <button type="submit" class="text-white bg-primary hover:bg-green-500 md:px-4 md:py-2 rounded duration-300 ease-in-out transition-all text-sm mt-2">
                        Tambah ke keranjang
                    </button>
                </div>
            </form>
        <?php } ?>
    </div>

    <!-- Pagination -->
    <div class="flex justify-center items-center mt-10">
        <?php if ($page > 1) { ?>
            <a href="?page=<?php echo $page - 1; ?>&search=<?php echo htmlspecialchars($search); ?>&filter=<?php echo htmlspecialchars($filter); ?>"
                class="px-4 py-2 bg-foreground text-white rounded-lg hover:bg-primary duration-300">Previous</a>
        <?php } ?>
        <span class="px-4 py-2 bg-primary text-white rounded-lg mx-2"><?php echo $page; ?></span>
        <?php if ($page < $totalPages) { ?>
            <a href="?page=<?php echo $page + 1; ?>&search=<?php echo htmlspecialchars($search); ?>&filter=<?php echo htmlspecialchars($filter); ?>"
                class="px-4 py-2 bg-foreground text-white rounded-lg hover:bg-primary duration-300">Next</a>
        <?php } ?>
    </div>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>

</html>