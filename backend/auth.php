<?php
session_start();
include 'db.php';
if (isset($_POST['login'])) {

    $username = $_POST['username'];
    $pass = $_POST['password'];
    $query = "SELECT * FROM user WHERE username = '$username';";
    $sql = mysqli_query($conn, $query);
    $result = mysqli_fetch_assoc($sql);

    if (!empty($username) && !empty($pass)) {
        if ($result['username'] == $username && $result['pass'] == $pass) {
            $_SESSION['nama'] = $username;
            $_SESSION['role'] = 'Admin';
            header('location: ../pages/admin/dashboard.php');
        }
    } else {
      echo"  <script>alert('Username atau Password Salah')</script>";
        header("location: ../pages/admin/login.php");
    }
}
