<?php
include 'db.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: *');
header('Access-Control-Allow-Methods: *');

$method = $_SERVER['REQUEST_METHOD'];
switch ($method) {
    case 'GET':

        $nama_barang = isset($_GET['nama_barang']) ? mysqli_real_escape_string($conn, $_GET['nama_barang']) : null;

        if ($nama_barang !== null) {
            $query = "
                SELECT 
                    p.nama_barang, 
                    SUM(p.jumlah_jual * i.harga_jual) AS total_revenue
                FROM penjualan p
                JOIN inventory i ON p.nama_barang = i.nama_barang
                WHERE p.nama_barang = '$nama_barang'
                GROUP BY p.nama_barang
            ";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo json_encode($row);
            } else {
                http_response_code(404);
                echo json_encode(["result" => "Product not found"]);
            }
        } else {
            $query = "
                SELECT 
                    p.nama_barang, 
                    SUM(p.jumlah_jual * i.harga_jual) AS total_revenue
                FROM penjualan p
                JOIN inventory i ON p.nama_barang = i.nama_barang
                GROUP BY p.nama_barang
            ";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $response = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $response[] = array(
                        'nama_barang' => $row['nama_barang'],
                        'total_revenue' => $row['total_revenue']
                    );
                }
                echo json_encode($response);
            } else {
                http_response_code(404);
                echo json_encode(["result" => "No sales data found"]);
            }
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(["result" => "Method not allowed"]);
        break;
}
?>
