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
    <nav class="bg-foreground flex justify-between">
    <div class="px-5">
        <img src="../../img/logo.jpg" alt="" class="w-[50px] ">
    </div>
    <div class="flex gap-5 py-2 px-5 text-white">
        <a href="/pages/admin/dashboard.php">Dashboard</a>
        <a href="">Inventory</a>
        <a href="">Report</a>
        <a href="">Request Order</a>
    </div>
    </nav>
    <form action="" method="post" class="flex flex-col w-[500px] mx-auto bg-foreground p-5 mt-10">
        <div class="flex flex-col text-white">
            <label for="kode_barang" class="">Kode Barang</label>
            <input type="text" name="kode_barang" id="" class="text-black focus:outline-none px-2">
        </div>
        <div class="flex flex-col text-white">
            <label for="nama_barang" class="">Nama Barang</label>
            <input type="text" name="nama_barang" id="" class="text-black focus:outline-none px-2">
        </div>
        <div class="flex flex-col text-white">
            <label for="keterangan" class="">Keterangan</label>
            <input type="text" name="keterangan" id="" class="text-black focus:outline-none px-2">
        </div>
        <button type="submit" class="bg-primary text-white mt-5 font-bold border-transparent border-[1px]  hover:border-primary  hover:bg-hover duration-200 ease-in-out transition-all py-2">Simpan</button>
    </form>

    <div>
        <table class="text-white mt-10 w-[500px] mx-auto">
            <tr class="">
                <th class="border-2 border-white px-2">Kode Barang</th>
                <th class="border-2 border-white px-2">Nama Barang</th>
                <th class="border-2 border-white px-2">Keterangan</th>
            </tr>
            <tr>
                <td class="border-2 border-white px-2">CE1</td>
                <td class="border-2 border-white px-2">Catridge</td>
                <td class="border-2 border-white px-2">Caliburn</td>
            </tr>
        </table>
    </div>
</body>
</html>