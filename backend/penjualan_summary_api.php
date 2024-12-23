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

        $kode_barang = isset($_GET['kode_barang']) ? mysqli_real_escape_string($conn, $_GET['kode_barang']) : null;

        if ($kode_barang !== null) {
            $query = "
                SELECT 
                    p.kode_barang, 
                    SUM(p.jumlah_jual * i.harga_jual) AS total_revenue
                FROM penjualan p
                JOIN inventory i ON p.kode_barang = i.kode_barang
                WHERE p.kode_barang = '$kode_barang'
                GROUP BY p.kode_barang
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
                    p.kode_barang, 
                    SUM(p.jumlah_jual * i.harga_jual) AS total_revenue
                FROM penjualan p
                JOIN inventory i ON p.kode_barang = i.kode_barang
                GROUP BY p.kode_barang
            ";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $response = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $response[] = array(
                        'kode_barang' => $row['kode_barang'],
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
