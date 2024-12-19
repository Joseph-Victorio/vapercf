<?php

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $pass = $_POST['password'];
    if (!empty($username) && !empty($pass)) {

        header('location: ../pages/admin/dashboard.php');
    } else {
        header("location: /");
    }
}
