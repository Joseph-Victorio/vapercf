<?php
include "db.php";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['approve'])) {
        $order_id = $_POST['order_id'];
        $update_query = "UPDATE request_order SET status='approved' WHERE order_id='$order_id'";
        mysqli_query($conn, $update_query);
    } elseif (isset($_POST['decline'])) {
        $order_id = $_POST['order_id'];
        $update_query = "UPDATE request_order SET status='declined' WHERE order_id='$order_id'";
        mysqli_query($conn, $update_query);
    }
    // Refresh the page to show updated status
    header("Location: /pages/admin/request_order.php");
    exit();
}
?>
