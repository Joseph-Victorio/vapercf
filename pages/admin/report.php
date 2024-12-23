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


$queryStok = "SELECT * FROM inventory LIMIT $start_limit, $results_per_page";
$sqlStok = mysqli_query($conn, $queryStok);

$total_sales_query = "SELECT COUNT(*) AS total FROM penjualan";
$total_sales_result = mysqli_query($conn, $total_sales_query);
$total_sales_row = mysqli_fetch_assoc($total_sales_result);
$total_sales = $total_sales_row['total'];
$total_sales_pages = ceil($total_sales / $results_per_page);


if (isset($_GET['page_sales']) && is_numeric($_GET['page_sales'])) {
    $current_page_sales = $_GET['page_sales'];
} else {
    $current_page_sales = 1;
}
$start_limit_sales = ($current_page_sales - 1) * $results_per_page;

$querySales = "SELECT * FROM penjualan LIMIT $start_limit_sales, $results_per_page";
$sqlSales = mysqli_query($conn, $querySales);

$total_purchases_query = "SELECT COUNT(*) AS total FROM pembelian";
$total_purchases_result = mysqli_query($conn, $total_purchases_query);
$total_purchases_row = mysqli_fetch_assoc($total_purchases_result);
$total_purchases = $total_purchases_row['total'];
$total_purchases_pages = ceil($total_purchases / $results_per_page);


if (isset($_GET['page_purchases']) && is_numeric($_GET['page_purchases'])) {
    $current_page_purchases = $_GET['page_purchases'];
} else {
    $current_page_purchases = 1;
}
$start_limit_purchases = ($current_page_purchases - 1) * $results_per_page;


$queryPurchases = "SELECT * FROM pembelian LIMIT $start_limit_purchases, $results_per_page";
$sqlPurchases = mysqli_query($conn, $queryPurchases);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report</title>
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

    <div class="md:w-[1000px] w-[350px] overflow-x-scroll md:overflow-hidden mx-auto">
        <!-- Laporan Stok Barang Table -->
        <p class="text-white text-2xl mt-5">Laporan Stok Barang</p>
        <table class="text-white mt-10 w-[700px] mx-auto">
            <tr>
                <th class="border-2 border-white px-2">Kode Barang</th>
                <th class="border-2 border-white px-2">Nama Barang</th>
                <th class="border-2 border-white px-2">Kategori</th>
                <th class="border-2 border-white px-2">Stok Tersedia</th>
                <th class="border-2 border-white px-2">Status</th>
            </tr>
            <?php
            // Loop through inventory data and display
            while ($resulStok = mysqli_fetch_assoc($sqlStok)) {
                $status = '';
                $statusClass = '';
                if ($resulStok['stok_tersedia'] <= 0) {
                    $status = 'Habis';
                    $statusClass = 'bg-red-500';
                } elseif ($resulStok['stok_tersedia'] <= 10) {
                    $status = 'Sedikit';
                    $statusClass = 'bg-yellow-500';
                } else {
                    $status = 'Banyak';
                    $statusClass = 'bg-green-500';
                }
            ?>
                <tr>
                    <td class="border-2 border-white px-2"><?php echo $resulStok['kode_barang'] ?></td>
                    <td class="border-2 border-white px-2"><?php echo $resulStok['nama_barang'] ?></td>
                    <td class="border-2 border-white px-2"><?php echo $resulStok['kategori'] ?></td>
                    <td class="border-2 border-white px-2"><?php echo $resulStok['stok_tersedia'] ?></td>
                    <td class="border-2 border-white px-2 p-1">
                        <div class="rounded p-1 font-bold text-center cursor-default text-sm <?php echo $statusClass; ?> text-white"><?php echo $status; ?></div>
                    </td>
                </tr>
            <?php } ?>
        </table>

  
        <div class="flex justify-center mt-5">
            <nav>
                <ul class="flex gap-2">
                    <?php
                   
                    if ($current_page > 1) {
                        echo '<li><a href="/pages/admin/report.php?page=' . ($current_page - 1) . '" class="bg-primary text-white px-3 py-1 rounded">Previous</a></li>';
                    }
                    for ($page = 1; $page <= $total_pages; $page++) {
                        if ($page == $current_page) {
                            echo '<li><a href="#" class="bg-primary text-white px-3 py-1 rounded">' . $page . '</a></li>';
                        } else {
                            echo '<li><a href="/pages/admin/report.php?page=' . $page . '" class="bg-primary text-white px-3 py-1 rounded">' . $page . '</a></li>';
                        }
                    }
                    if ($current_page < $total_pages) {
                        echo '<li><a href="/pages/admin/report.php?page=' . ($current_page + 1) . '" class="bg-primary text-white px-3 py-1 rounded">Next</a></li>';
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>


    <div class="md:w-[1000px] w-[350px] overflow-x-scroll md:overflow-hidden mx-auto mt-10">
        <p class="text-white text-2xl mt-5">Laporan Penjualan</p>
        <table class="text-white mt-10 w-[700px] mx-auto">
            <tr>
                <th class="border-2 border-white px-2">Kode Barang</th>
                <th class="border-2 border-white px-2">Jumlah</th>
                <th class="border-2 border-white px-2">Tanggal</th>
            </tr>
            <?php
         
            while ($resulSales = mysqli_fetch_assoc($sqlSales)) {
            ?>
                <tr>
                    <td class="border-2 border-white px-2"><?php echo $resulSales['kode_barang'] ?></td>
                    <td class="border-2 border-white px-2"><?php echo $resulSales['jumlah_jual'] ?></td>
                    <td class="border-2 border-white px-2"><?php echo $resulSales['tanggal'] ?></td>
                </tr>
            <?php } ?>
        </table>


        <div class="flex justify-center mt-5">
            <nav>
                <ul class="flex gap-2">
                    <?php
                
                    if ($current_page_sales > 1) {
                        echo '<li><a href="/pages/admin/report.php?page_sales=' . ($current_page_sales - 1) . '" class="bg-primary text-white px-3 py-1 rounded">Previous</a></li>';
                    }
                    for ($page = 1; $page <= $total_sales_pages; $page++) {
                        if ($page == $current_page_sales) {
                            echo '<li><a href="#" class="bg-primary text-white px-3 py-1 rounded">' . $page . '</a></li>';
                        } else {
                            echo '<li><a href="/pages/admin/report.php?page_sales=' . $page . '" class="bg-primary text-white px-3 py-1 rounded">' . $page . '</a></li>';
                        }
                    }
                    if ($current_page_sales < $total_sales_pages) {
                        echo '<li><a href="/pages/admin/report.php?page_sales=' . ($current_page_sales + 1) . '" class="bg-primary text-white px-3 py-1 rounded">Next</a></li>';
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>


    <div class="md:w-[1000px] w-[350px] overflow-x-scroll md:overflow-hidden mx-auto mt-10">
        <p class="text-white text-2xl mt-5">Laporan Pembelian</p>
        <table class="text-white mt-10 w-[700px] mx-auto">
            <tr>
                <th class="border-2 border-white px-2">Kode Barang</th>
                <th class="border-2 border-white px-2">Jumlah</th>
                <th class="border-2 border-white px-2">Tanggal</th>
            </tr>
            <?php
            // Loop through pembelian data and display
            while ($resulPurchases = mysqli_fetch_assoc($sqlPurchases)) {
            ?>
                <tr>
                    <td class="border-2 border-white px-2"><?php echo $resulPurchases['kode_barang'] ?></td>
                    <td class="border-2 border-white px-2"><?php echo $resulPurchases['jumlah_beli'] ?></td>
                    <td class="border-2 border-white px-2"><?php echo $resulPurchases['tanggal'] ?></td>
                </tr>
            <?php } ?>
        </table>

        <!-- Pagination for Pembelian -->
        <div class="flex justify-center mt-5">
            <nav>
                <ul class="flex gap-2">
                    <?php
                    // Pagination links for Pembelian
                    if ($current_page_purchases > 1) {
                        echo '<li><a href="/pages/admin/report.php?page_purchases=' . ($current_page_purchases - 1) . '" class="bg-primary text-white px-3 py-1 rounded">Previous</a></li>';
                    }
                    for ($page = 1; $page <= $total_purchases_pages; $page++) {
                        if ($page == $current_page_purchases) {
                            echo '<li><a href="#" class="bg-primary text-white px-3 py-1 rounded">' . $page . '</a></li>';
                        } else {
                            echo '<li><a href="/pages/admin/report.php?page_purchases=' . $page . '" class="bg-primary text-white px-3 py-1 rounded">' . $page . '</a></li>';
                        }
                    }
                    if ($current_page_purchases < $total_purchases_pages) {
                        echo '<li><a href="/pages/admin/report.php?page_purchases=' . ($current_page_purchases + 1) . '" class="bg-primary text-white px-3 py-1 rounded">Next</a></li>';
                    }
                    ?>
                </ul>
            </nav>
        </div>
    </div>

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="/js/dropdown.js"></script>
</body>

</html>