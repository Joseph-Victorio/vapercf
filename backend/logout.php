<?php 
session_start();

if(isset($_POST['logout'])){
    header('location: /pages/admin/login.php');
}
