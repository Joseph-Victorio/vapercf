<?php
include 'db.php';


if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]));
}

$data = json_decode(file_get_contents("php://input"), true);

if ($data) {
    $nama_barang = $conn->real_escape_string($data['namaBarang']);
    $harga_jual = $conn->real_escape_string($data['hargaJual']);
    $foto = $conn->real_escape_string($data['foto']);
    $quantity = 1;
    $status = "Pending";

    $sql = "INSERT INTO request_order (nama_barang, harga_jual, foto, quantity, status) 
            VALUES ('$nama_barang', '$harga_jual', '$foto', '$quantity', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true, "message" => "Item added to cart"]);
    } else {
        echo json_encode(["success" => false, "message" => "Error: " . $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid data"]);
}

$conn->close();
