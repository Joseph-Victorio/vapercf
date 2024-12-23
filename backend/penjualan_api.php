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

        $id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : null;

        if ($id !== null) {
            // Fetch data by ID
            $query = "SELECT * FROM penjualan WHERE id = $id";
            $result = mysqli_query($conn, $query);
            if ($result && mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                echo json_encode($row);
            } else {
                http_response_code(404);
                echo json_encode(["result" => "Product not found"]);
            }
        } else {
            $query = "SELECT tanggal, SUM(jumlah_jual) AS total_jumlah_jual FROM penjualan GROUP BY tanggal ORDER BY tanggal";
            $allInventory = mysqli_query($conn, $query);
            if ($allInventory && mysqli_num_rows($allInventory) > 0) {
                $json_array = [];
                while ($row = mysqli_fetch_assoc($allInventory)) {
                    $json_array[] = array(
                        'tanggal' => $row['tanggal'],
                        'total_jumlah_jual' => $row['total_jumlah_jual']
                    );
                }
                echo json_encode($json_array);
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
