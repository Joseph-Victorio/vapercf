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
<nav class="bg-foreground flex justify-between">
    <div class="px-5">
        <img src="../../img/logo.jpg" alt="" class="w-[50px] ">
    </div>
    <div class="flex gap-5 py-2 px-5 text-white">
        <a href="/pages/admin/dashboard.php">Dashboard</a>
        <a href="/pages/admin/inventory.php">Inventory</a>
        <a href="">Report</a>
        <a href="">Request Order</a>
    </div>
    </nav>
    <div>
        
    </div>
    <h1 class="text-white text-center mt-5">Selamat datang di dashboard</h1>
    <div style="position: relative; height:40vh; width:80vw" >
        <canvas id="myChart" class="w-[300px]"></canvas>
    </div>
    <script src="../../js/chart.js"></script>
</body>

</html>