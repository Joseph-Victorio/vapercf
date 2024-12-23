<?php
session_start();
// Assuming you have a connection to the database
include '../../backend/db.php';
$queryJual = "
    SELECT SUM(p.jumlah_jual * i.harga_jual) AS total_penjualan
    FROM penjualan p
    JOIN inventory i ON p.kode_barang = i.kode_barang
";


$resultJual = mysqli_query($conn, $queryJual);

if ($resultJual) {
    $row = mysqli_fetch_assoc($resultJual);
    $total_penjualan = $row['total_penjualan'];
} else {
    echo "Error: " . mysqli_error($conn);
}
$queryBeli = "
    SELECT SUM(p.jumlah_beli * i.harga_beli) AS total_pengeluaran
    FROM pembelian p
    JOIN inventory i ON p.kode_barang = i.kode_barang
";

$resultBeli = mysqli_query($conn, $queryBeli);

if ($resultBeli) {
    $row = mysqli_fetch_assoc($resultBeli);
    $total_pengeluaran = $row['total_pengeluaran'];
} else {
    echo "Error: " . mysqli_error($conn);
}

$total_Keuntungan = $total_penjualan - $total_pengeluaran;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
                        <button name="logout" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-800">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <div>

    </div>

    <div class="flex gap-5 px-10 justify-center items-baseline m-5">
        <div class="flex bg-foreground p-5 text-white rounded flex-col">
            <p class="font-bold text-lg">Total Penjualan</p>
            <p class="font-bold text-xl">
                <?php
                echo "Rp" . number_format($total_penjualan, 0, ',', '.');
                ?>
            </p>
        </div>
        <div class="flex bg-foreground p-5 text-white rounded flex-col">
            <p class="font-bold text-center text-xl">Total Keuntungan</p>
            <p class="font-bold text-5xl"><?php
                                            echo "Rp" . number_format($total_Keuntungan, 0, ',', '.');
                                            ?>
            </p>
        </div>
        <div class="flex bg-foreground p-5 text-white rounded flex-col">
            <p class="font-bold text-lg text-center">Total Pengeluaran</p>
            <p class="font-bold text-xl"><?php
                                            echo "Rp" . number_format($total_pengeluaran, 0, ',', '.');
                                            ?>
            </p>
        </div>
    </div>
    <div class="flex flex-col gap-5">
        <div style="position: relative;" class="mx-auto">
            <canvas id="myChart" class="md:w-[1000px] mx-auto bg-foreground p-1"></canvas>
        </div>
        <div style="position: relative; " class="mx-auto m-5">
            <canvas id="penjualan_chart" class="md:w-[1000px] mx-auto bg-foreground p-1"></canvas>
        </div>
    </div>
    <script src="../../js/chart.js"></script>
    <script src="../../js/penjualan_summary.js"></script>
    <script src="/js/dropdown.js"></script>
</body>

</html>