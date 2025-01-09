<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $orderId = $_POST['order_id'];
    $name = $_POST['name'];
    $address = $_POST['address'];
    $tanggal = date("j-m-Y");

    $itemNames = '';


    $query = "INSERT INTO request_order (nama_pembeli, order_id, alamat, tanggal, status ) VALUES ( '$name', '$orderId', '$address','$tanggal', 'pending' )";

    if (mysqli_query($conn, $query)) {

        $orderIdInserted = mysqli_insert_id($conn);


        $totalPrice = 0;


        if (isset($_POST['cart_items'])) {
            foreach ($_POST['cart_items'] as $itemJson) {
                $item = json_decode($itemJson, true);
                $itemName = $item['namaBarang'];
                $itemPrice = $item['hargaJual'];
                $itemQuantity = $item['quantity'];

                $itemNames .= $itemName . ', ';


                $itemQuery = "INSERT INTO request_order_items (order_id, item_name, item_price, quantity) 
                              VALUES ('$orderIdInserted', '$itemName', '$itemPrice', '$itemQuantity')";
                mysqli_query($conn, $itemQuery);


                $totalPrice += $itemPrice * $itemQuantity;
            }


            $itemNames = rtrim($itemNames, ', ');


            $updateQuery = "UPDATE request_order SET nama_barang = '$itemNames', total_price = $totalPrice WHERE order_id = '$orderIdInserted'";
            mysqli_query($conn, $updateQuery);


            echo "Order placed successfully with ID: " . $orderIdInserted;
        } else {

            echo "No items found in the cart.";
        }
    } else {

        echo "Error: " . mysqli_error($conn);
    }
}
