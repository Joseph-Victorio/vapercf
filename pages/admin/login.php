<?php
session_start();
include '../../backend/db.php';

if (isset($_POST['login'])) {

  $username = $_POST['username'];
  $pass = $_POST['password'];
  $query = "SELECT * FROM user WHERE username = '$username';";
  $sql = mysqli_query($conn, $query);
  $result = mysqli_fetch_assoc($sql);

  if ($result['username'] == $username && $result['pass'] == $pass) {
    $_SESSION['nama'] = $username;
    $_SESSION['role'] = 'Admin';
    $_SESSION['login'] = 'True';
    header('location: dashboard.php');
    exit; // Always call exit after header redirection
  } else {
    echo "<script>alert('Username atau Password Salah');</script>";
    // Now you can redirect after the alert
    echo "<script>window.location.href = 'login.php';</script>";
    exit; // Ensure that no further code is executed
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Halaman Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-500">
  <div class="w-[500px] bg-white p-5 mx-auto mt-[20vh] rounded shadow-lg shadow-black">
    <img src="/img/logo.svg" alt="" class="w-20 mx-auto" />
    <h1 class="font-bold text-center text-2xl">Selamat Datang</h1>
    <p class="text-center">Silahkan Login </p>
    <form action="" method="post">
      <div class="flex flex-col gap-5 mt-5">
        <input
          type="text"
          placeholder="Username"
          name="username"
          class="w-full bg-transparent placeholder:text-blue-400 text-blue-700 text-sm border border-blue-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-blue-500 hover:border-blue-300 shadow-lg shadow-gray-100 ring-4 ring-transparent focus:ring-blue-100"
          required />
        <input
          type="password"
          placeholder="Password"
          name="password"
          class="w-full bg-transparent placeholder:text-blue-400 text-blue-700 text-sm border border-blue-200 rounded-md px-3 py-2 transition duration-300 ease focus:outline-none focus:border-blue-500 hover:border-blue-300 shadow-lg shadow-gray-100 ring-4 ring-transparent focus:ring-blue-100"
          required />
        <button type="submit" class="bg-blue-500 text-white font-semibold px-5 py-2 rounded " name="login">Masuk</button>
      </div>
    </form>
  </div>
</body>

</html>
