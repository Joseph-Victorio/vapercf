<?php
session_start();
include '../../backend/db.php';

$results_per_page = 10;


$total_results_query = "SELECT COUNT(*) AS total FROM inventory";
$total_results_result = mysqli_query($conn, $total_results_query);
$total_results_row = mysqli_fetch_assoc($total_results_result);
$total_results = $total_results_row['total'];


$total_pages = ceil($total_results / $results_per_page);


if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = $_GET['page'];
} else {
    $current_page = 1;
}


$start_limit = ($current_page - 1) * $results_per_page;

$query = "SELECT * FROM inventory LIMIT $start_limit, $results_per_page";
$sql = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        background: '#111111',
                        foreground: '#161616',
                        primary: '#1D4987',
                        hover: '#091930'
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-background">
    <!-- NAVBARR -->
    <nav class="bg-foreground flex flex-wrap justify-between items-center px-5 md:px-10 py-2">

        <div class="w-full md:w-auto flex justify-between md:justify-start">
            <div class="flex gap-3 md:gap-5 py-2 text-white">
                <a href="/pages/admin/dashboard.php" class="hover:underline">Dashboard</a>
                <a href="/pages/admin/inventory.php" class="hover:underline">Inventory</a>
                <a href="/pages/admin/report.php" class="hover:underline">Report</a>
                <a href="/pages/admin/request_order.php" class="hover:underline">Request Order</a>
            </div>
        </div>
        <div class="flex items-center gap-3 md:gap-5 relative w-full md:w-auto mt-2 md:mt-0">
            <img src="/img/logo.svg" alt="Logo" class="w-[30px] md:w-[40px]">
            <div class="relative w-full md:w-auto text-left">

                <button
                    id="user-menu-toggle"
                    class="flex items-center justify-between w-full md:w-auto gap-2 text-white focus:outline-none">
                    <div>
                        <p class="text-sm md:text-lg"><?php echo $_SESSION['nama']; ?></p>
                        <p class="text-[10px] md:text-[12px]"><?php echo $_SESSION['role']; ?></p>
                    </div>
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>

                <!-- Dropdown Menu -->
                <div
                    id="dropdown-menu"
                    class="absolute right-0 mt-2 bg-foreground rounded shadow-lg text-white w-full md:w-32 hidden">
                    <form action="/backend/logout.php" method="post">
                        <button type="submit" name="logout" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-800">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>


    <form action="/backend/inventory.php" method="post" class="flex flex-col md:w-[700px] mx-auto bg-foreground p-5 mt-10">
        <div class="flex gap-2 md:flex-row flex-col">
            <div class="flex flex-col text-white">
                <label for="kode_barang" class="">Kode Barang</label>
                <input type="text" name="kode_barang" id="" class="text-black focus:outline-none px-2 w-[100px]">
            </div>
            <div class="flex flex-col text-white flex-1">
                <label for="nama_barang" class="">Nama Barang</label>
                <input type="text" name="nama_barang" id="" class="text-black focus:outline-none px-2">
            </div>
            <div class="flex flex-col text-white">
                <label for="kategori" class="">Kategori</label>
                <input type="text" name="kategori" id="" class="text-black focus:outline-none px-2">
            </div>
        </div>
        <div class="flex gap-2 md:flex-row flex-col justify-center">
            <div class="flex flex-col text-white">
                <label for="stok_tersedia" class="">Stok Tersedia</label>
                <input type="number" name="stok_tersedia" id="" class="text-black focus:outline-none px-2">
            </div>
            <div class="flex flex-col text-white">
                <label for="harga_beli" class="">Harga Beli</label>
                <input type="number" name="harga_beli" id="" class="text-black focus:outline-none px-2">
            </div>
            <div class="flex flex-col text-white">
                <label for="harga_jual" class="">Harga Jual</label>
                <input type="number" name="harga_jual" id="" class="text-black focus:outline-none px-2">
            </div>
        </div>
        <button type="submit" name="simpan" class="bg-primary text-white mt-5 font-bold border-transparent border-[1px]  hover:border-primary  hover:bg-hover duration-200 ease-in-out transition-all py-2">Simpan</button>
    </form>

    <!-- Inventory Table -->
    <div class="md:w-[1000px] w-[350px] overflow-x-scroll md:overflow-hidden flex mx-auto">
        <table class="text-white mt-10 w-[700px] mx-auto">
            <tr class="">
                <th class="border-2 border-white px-2">Kode Barang</th>
                <th class="border-2 border-white px-2">Nama Barang</th>
                <th class="border-2 border-white px-2">Kategori</th>
                <th class="border-2 border-white px-2">Stok Tersedia</th>
                <th class="border-2 border-white px-2">Harga Beli</th>
                <th class="border-2 border-white px-2">Harga Jual</th>
                <th class="border-2 border-white px-2">Aksi</th>
            </tr>
            <?php
            while ($result = mysqli_fetch_assoc($sql)) {
            ?>
                <tr>
                    <td class="border-2 border-white px-2"><?php echo $result['kode_barang'] ?></td>
                    <td class="border-2 border-white px-2"><?php echo $result['nama_barang'] ?></td>
                    <td class="border-2 border-white px-2"><?php echo $result['kategori'] ?></td>
                    <td class="border-2 border-white px-2"><?php echo $result['stok_tersedia'] ?></td>
                    <td class="border-2 border-white px-2">
                        <?php echo "Rp " . number_format($result['harga_beli'], 0, ',', '.'); ?>
                    </td>
                    <td class="border-2 border-white px-2">
                        <?php echo "Rp " . number_format($result['harga_jual'], 0, ',', '.'); ?>
                    </td>
                    <td class="border-2 border-white px-2">
                        <div class="flex gap-2 items-center p-1">
                            <a href="inventory_update.php?update=<?php echo $result['id'] ?>"><box-icon name="pencil" color="green"></box-icon></a>
                            <a href="/backend/inventory.php?delete=<?php echo $result['id'] ?>"><box-icon name="trash" color="red"></box-icon></a>
                        </div>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="flex justify-center mt-5">
        <nav>
            <ul class="flex gap-2">
                <?php
                // Show previous page link
                if ($current_page > 1) {
                    echo '<li><a href="/pages/admin/inventory.php?page=' . ($current_page - 1) . '" class="bg-primary text-white px-3 py-1 rounded">Previous</a></li>';
                }

                // Show page number links
                for ($page = 1; $page <= $total_pages; $page++) {
                    if ($page == $current_page) {
                        echo '<li><a href="#" class="bg-primary text-white px-3 py-1 rounded">' . $page . '</a></li>';
                    } else {
                        echo '<li><a href="/pages/admin/inventory.php?page=' . $page . '" class="bg-primary text-white px-3 py-1 rounded">' . $page . '</a></li>';
                    }
                }

                // Show next page link
                if ($current_page < $total_pages) {
                    echo '<li><a href="/pages/admin/inventory.php?page=' . ($current_page + 1) . '" class="bg-primary text-white px-3 py-1 rounded">Next</a></li>';
                }
                ?>
            </ul>
        </nav>
    </div>

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="/js/dropdown.js"></script>
</body>

</html>