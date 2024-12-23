<?php
session_start();
include "../../backend/db.php";

$results_per_page = 10;

$total_results_query = "SELECT COUNT(*) AS total FROM request_order";
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

$query = "SELECT * FROM request_order LIMIT $start_limit, $results_per_page";
$sql = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Order</title>
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
    <!-- NAVBAR -->
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
                <div id="dropdown-menu" class="absolute right-0 mt-2 bg-foreground rounded shadow-lg text-white w-full md:w-32 hidden">
                    <form action="/backend/logout.php" method="post">
                        <button type="submit" name="logout" class="block w-full text-left px-4 py-2 text-sm hover:bg-gray-800">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <p class="text-2xl text-white px-10 mt-5">List Request Order</p> 
    <div class="md:w-[1000px] w-[350px] overflow-x-scroll md:overflow-hidden flex mx-auto">
        <table class="text-white mt-10 w-[700px] mx-auto">
            <tr>
                <th class="border-2 border-white px-2">Nama Pembeli</th>
                <th class="border-2 border-white px-2">Order ID</th>
                <th class="border-2 border-white px-2">Tanggal</th>
                <th class="border-2 border-white px-2">Status</th>
            </tr>
            <?php while ($result = mysqli_fetch_assoc($sql)) { ?>
                <tr class="<?php echo $result['status'] == 'approved' ? 'bg-green-600 border-green-500' : ($result['status'] == 'declined' ? 'bg-red-600 border-red-500' : ''); ?>">
                    <td class="border-2 border-white px-2"><?php echo $result['nama_pembeli']; ?></td>
                    <td class="border-2 border-white px-2"><?php echo $result['order_id']; ?></td>
                    <td class="border-2 border-white px-2"><?php echo $result['tanggal']; ?></td>
                    <td class="border-2 border-white px-2 py-2 text-center">
                        <?php if ($result['status'] == 'approved') { ?>
                            <p class="text-white font-bold">Approved</p>
                        <?php } elseif ($result['status'] == 'declined') { ?>
                            <p class="text-white font-bold">Declined</p>
                        <?php } else { ?>
                            <form action="/backend/request_order.php" method="post" class="flex gap-2 justify-center items-center">
                                <input type="hidden" name="order_id" value="<?php echo $result['order_id']; ?>">
                                <button type="submit" name="approve" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-700">Approve</button>
                                <button type="submit" name="decline" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-700">Decline</button>
                            </form>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
    </div>

    <div class="flex justify-center mt-5">
        <nav>
            <ul class="flex gap-2">
                <?php if ($current_page > 1) { ?>
                    <li><a href="?page=<?php echo $current_page - 1; ?>" class="bg-primary text-white px-3 py-1 rounded">Previous</a></li>
                <?php } ?>
                <?php for ($page = 1; $page <= $total_pages; $page++) { ?>
                    <li><a href="?page=<?php echo $page; ?>" class="bg-primary text-white px-3 py-1 rounded"><?php echo $page; ?></a></li>
                <?php } ?>
                <?php if ($current_page < $total_pages) { ?>
                    <li><a href="?page=<?php echo $current_page + 1; ?>" class="bg-primary text-white px-3 py-1 rounded">Next</a></li>
                <?php } ?>
            </ul>
        </nav>
    </div>

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="/js/dropdown.js"></script>
</body>

</html>
