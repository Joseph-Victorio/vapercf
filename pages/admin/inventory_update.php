<?php
session_start();
include '../../backend/db.php';

$kode_barang = "";
$nama_barang = "";
$kategori = "";
$stok_tersedia = "";
$harga_jual = "";
$harga_beli = "";

if (isset($_GET['update'])) {
    $id = $_GET['update'];
    $query = "SELECT * FROM inventory WHERE id = '$id';";
    $sql = mysqli_query($conn, $query);

    $result = mysqli_fetch_assoc($sql);
    $kode_barang = $result['kode_barang'];
    $nama_barang = $result['nama_barang'];
    $kategori = $result['kategori'];
    $stok_tersedia = $result['stok_tersedia'];
    $harga_jual = $result['harga_jual'];
    $harga_beli = $result['harga_beli'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>update inventory</title>
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
    <a href="inventory.php" class="flex gap-2 items-center mt-5"><box-icon name='left-arrow-alt' color="white"></box-icon>
        <p class="text-white">Kembali</p>
    </a>
    <div class="flex gap-5 px-10 items-center md:flex-row flex-col">
        <form action="/backend/inventory.php" method="post" class="flex flex-col md:w-[700px] mx-auto bg-foreground p-5 mt-10">
            <p class="text-white text-2xl mb-5">Edit Barang</p>
            <input type="hidden" name="id" value="<?php echo $id;?>">
            <div class="flex gap-2 md:flex-row flex-col">
                <div class="flex flex-col text-white">
                    <label for="kode_barang" class="">Kode Barang</label>
                    <input type="text" name="kode_barang" value="<?php echo $kode_barang ?>" id="" class="text-black focus:outline-none px-2 w-[100px]">
                </div>
                <div class="flex flex-col text-white flex-1">
                    <label for="nama_barang" class="">Nama Barang</label>
                    <input type="text" name="nama_barang" value="<?php echo $nama_barang ?>" class="text-black focus:outline-none px-2">
                </div>
                <div class="flex flex-col text-white">
                    <label for="kategori" class="">Kategori</label>
                    <input type="text" name="kategori" value="<?php echo $kategori ?>" class="text-black focus:outline-none px-2">
                </div>
            </div>
            <div class="flex gap-2 md:flex-row flex-col justify-center">
                <div class="flex flex-col text-white">
                    <input type="number" name="stok_tersedia" value="<?php echo $stok_tersedia ?>" class="text-black focus:outline-none px-2" hidden >
                </div>
                <div class="flex flex-col text-white">
                    <label for="harga_beli" class="">Harga Beli</label>
                    <input type="number" name="harga_beli" value="<?php echo $harga_beli ?>" class="text-black focus:outline-none px-2">
                </div>
                <div class="flex flex-col text-white">
                    <label for="harga_jual" class="">Harga Jual</label>
                    <input type="number" name="harga_jual" value="<?php echo $harga_jual ?>" class="text-black focus:outline-none px-2">
                </div>
                
            </div>
            <p class="text-white mt-2">Stok Tersedia : <?php echo $stok_tersedia?></p>
            <button type="submit" name="update" class="bg-primary text-white mt-5 font-bold border-transparent border-[1px]  hover:border-primary  hover:bg-hover duration-200 ease-in-out transition-all py-2">Simpan</button>
        </form>

        <form action="/backend/inventory.php" method="post" class="bg-foreground p-5 md:w-[700px] mx-auto mt-5">
            <p class="text-white text-2xl mb-5">Edit Stok Barang</p>
            <select name="jualbeli" id="jualbeli" onchange="updateForm()">
                <option value="beli">Tambah Stok</option>
                <option value="jual">Pengurangan Stok</option>
            </select>
            <div class="flex flex-col text-white">
                <input type="text" name="kode_barang" value="<?php echo $kode_barang ?>" id="" class="text-black focus:outline-none px-2 w-[100px]" hidden>
            </div>
            <div class="flex flex-col text-white mt-3">
                <input
                    type="number"
                    id="jumlahInput"
                    name="jumlah_beli"
                    class="text-black focus:outline-none px-2">
            </div>

            <button
                type="submit"
                id="actionButton"
                name="tambah_stok"
                class="bg-primary text-white mt-5 font-bold border-transparent border-[1px] hover:border-primary hover:bg-hover duration-200 ease-in-out transition-all py-2 px-4">
                Tambah Stok
            </button>
        </form>
    </div>


    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="/js/dropdown.js"></script>
    <script>
        function updateForm() {
            const select = document.getElementById("jualbeli");
            const jumlahInput = document.getElementById("jumlahInput");
            const actionButton = document.getElementById("actionButton");

            if (select.value === "beli") {

                jumlahInput.name = "jumlah_beli";
                actionButton.name = "tambah_stok";
                actionButton.textContent = "Tambah Stok";
            } else if (select.value === "jual") {
                jumlahInput.name = "jumlah_jual";
                actionButton.name = "kurang_stok";
                actionButton.textContent = "Kurangi Stok";
            }
        }
    </script>
</body>

</html>