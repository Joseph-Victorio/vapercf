<?php
include "backend/db.php";

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
                    <div id="cart-count" class="absolute top-[-10px] left-3 right-1 w-4 h-4 flex justify-center  bg-primary rounded-full text-[10px]">
                     
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
                <a href="" class="rounded-full border-2 border-primary text-primary flex justify-center hover:bg-primary hover:text-white duration-300 transition-all font-bold">Beli Sekarang</a>
            </div>
            <img src="/img/oatdrips.png" alt="oatdrips" class="w-[200px] object-fit object-cover">
        </div>
        <!-- ini pot -->
        <div class="flex p-5 bg-foreground rounded flex-col flex-grow-0 flex-shrink-0">
            <div class="flex flex-col gap-2 flex-grow-0 flex-shrink-0  ">
                <p class="text-white font-bold">Pot</p>
                <p class="text-white">Mulai Dari <span class="text-primary"> Rp 200.000</span></p>
                <a href="" class="rounded-full border-2 border-primary text-primary flex justify-center hover:bg-primary hover:text-white duration-300 transition-all font-bold flex-grow-0">Beli Sekarang</a>
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
                <a href="" class="rounded-full border-2 border-primary text-primary flex justify-center hover:bg-primary hover:text-white duration-300 transition-all font-bold">Beli Sekarang</a>
            </div>
            <div>
                <img src="/img/catridge.png" alt="catridge" class="w-[200px]">
            </div>
        </div>
        <div class="flex p-5 bg-foreground rounded flex-col flex-grow-0 flex-shrink-0">
            <div class="flex flex-col gap-2 flex-grow-0 flex-shrink-0 ">
                <p class="text-white font-bold">Salt Nic</p>
                <p class="text-white">Mulai Dari <span class="text-primary"> Rp 100.000</span></p>
                <a href="" class="rounded-full border-2 border-primary text-primary flex justify-center hover:bg-primary hover:text-white duration-300 transition-all font-bold">Beli Sekarang</a>
            </div>
            <div>
                <img src="/img/saltnic.png" alt="oatdrips" class="w-[200px]">
            </div>
        </div>

    </div>
    <div class="flex justify-between md:px-20 px-5 py-5 items-baseline">
        <p class="md:text-4xl font-bold text-primary">Produk Kami</p>
        <a href="" class="text-gray-500 hover:text-white ease-in-out transition-color duration-300">Lihat Selengkapnya ></a>
    </div>
    <div class="md:px-20 px-5 grid grid-cols-2 md:grid-cols-5 gap-5">
        <?php while ($result = mysqli_fetch_assoc($sql)) { ?>
            <div class="border-2 border-transparent hover:border-primary rounded duration-300 transition-all ease-in-out cursor-pointer p-2">
                <img src="<?php echo $result['foto'] ?>" alt="" class="w-[200px] h-[200px] rounded object-cover md:object-fill">
                <div class="text-white mt-2">
                    <p><?php echo $result['nama_barang'] ?></p>
                    <p class="text-primary"><?php
                                            echo "Rp" . number_format($result['harga_jual'], 0, ',', '.');
                                            ?></p>
                </div>
                <div class="flex justify-center">
                    <button
                        class="text-white bg-primary hover:bg-green-500 px-4 py-2 rounded duration-300 ease-in-out transition-all text-sm mt-2"
                        onclick="addToCart('<?php echo $result['nama_barang'] ?>', <?php echo $result['harga_jual'] ?>, '<?php echo $result['foto'] ?>')">
                        Tambah ke keranjang
                    </button>
                </div>
            </div>
        <?php } ?>
    </div>
    <div id="toast-container" style="position: fixed; top: 20px; right: 20px; z-index: 1000;"></div>

    <script>
        function addToCart(namaBarang, hargaJual, foto) {
          
            const item = {
                namaBarang: namaBarang,
                hargaJual: hargaJual,
                foto: foto
            };


            let cart = JSON.parse(localStorage.getItem('cart')) || [];


            cart.push(item);


            localStorage.setItem('cart', JSON.stringify(cart));

            showToast('Item berhasil ditambahkan ke keranjang!');
        }

        function updateCartCount() {
      
            let cart = JSON.parse(localStorage.getItem('cart')) || [];

   
            const cartCountElement = document.getElementById('cart-count');
            cartCountElement.textContent = cart.length; 
        }

        function showToast(message) {
            
            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.style.cssText = `
            background: rgba(0, 255, 13, 0.8);
            color: white;
            padding: 10px 20px;
            margin-bottom: 10px;
            border-radius: 5px;
            font-size: 14px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            animation: fadeOut 4s forwards;
            position: relative;
            opacity: 0;
            animation: fadeInOut 3s ease-in-out;
        `;
            toast.textContent = message;

            const toastContainer = document.getElementById('toast-container');
            toastContainer.appendChild(toast);

         
            setTimeout(() => {
                toast.remove();
            }, 3000);
        }

    
        const style = document.createElement('style');
        style.innerHTML = `
        @keyframes fadeInOut {
            0% { opacity: 0; transform: translateY(10px); }
            10% { opacity: 1; transform: translateY(0); }
            90% { opacity: 1; transform: translateY(0); }
            100% { opacity: 0; transform: translateY(10px); }
        }
    `;
        document.head.appendChild(style);


        document.addEventListener('DOMContentLoaded', updateCartCount);
    </script>

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
</body>

</html>