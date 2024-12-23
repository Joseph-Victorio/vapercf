<?php
include 'db.php';

if (isset($_POST['simpan'])) {
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $stok_tersedia = $_POST['stok_tersedia'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];

    $query = "INSERT INTO inventory VALUES(null,'$kode_barang','$nama_barang','$kategori','$stok_tersedia', '$harga_beli','$harga_jual');";

    $sql = mysqli_query($conn, $query);
    if ($sql) {
        header("location: /pages/admin/inventory.php");
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    $query = "DELETE FROM inventory WHERE id = '$id'";
    $sql = mysqli_query($conn, $query);

    if ($sql) {
        header("location: /pages/admin/inventory.php");
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $kode_barang = $_POST['kode_barang'];
    $nama_barang = $_POST['nama_barang'];
    $kategori = $_POST['kategori'];
    $stok_tersedia = $_POST['stok_tersedia'];
    $harga_beli = $_POST['harga_beli'];
    $harga_jual = $_POST['harga_jual'];


    $query = "UPDATE inventory SET
                kode_barang = '$kode_barang',
                nama_barang = '$nama_barang',
                kategori = '$kategori',
                stok_tersedia = '$stok_tersedia',
                harga_beli = '$harga_beli',
                harga_jual = '$harga_jual'
              WHERE id = '$id'";


    $sql = mysqli_query($conn, $query);


    if ($sql) {
        header("Location: /pages/admin/inventory.php");
        exit();
    } else {

        echo "Error: " . mysqli_error($conn);
    }
}



if (isset($_POST['tambah_stok'])) {

    $kode_barang = $_POST['kode_barang'];
    $jumlah_beli = $_POST['jumlah_beli'];
    $tanggal = date("d-m-Y");

    $kode_barang = mysqli_real_escape_string($conn, $kode_barang);
    $jumlah_beli = mysqli_real_escape_string($conn, $jumlah_beli);
    $tanggal = mysqli_real_escape_string($conn, $tanggal);


    $query = "INSERT INTO pembelian (kode_barang, jumlah_beli, tanggal) VALUES ('$kode_barang', '$jumlah_beli', '$tanggal')";


    if (mysqli_query($conn, $query)) {

        $update_query = "UPDATE inventory SET stok_tersedia = stok_tersedia + '$jumlah_beli' WHERE kode_barang = '$kode_barang'";

        if (mysqli_query($conn, $update_query)) {
            header("location: /pages/admin/inventory.php");
        } else {
            echo "Error updating stock: " . mysqli_error($conn);
        }
    } else {
        echo "Error inserting record: " . mysqli_error($conn);
    }
}
if (isset($_POST['kurang_stok'])) {

    $kode_barang = $_POST['kode_barang'];
    $jumlah_jual = $_POST['jumlah_jual'];
    $tanggal = date("d-m-Y");


    $kode_barang = mysqli_real_escape_string($conn, $kode_barang);
    $jumlah_jual = mysqli_real_escape_string($conn, $jumlah_jual);
    $tanggal = mysqli_real_escape_string($conn, $tanggal);


    $query = "INSERT INTO penjualan (kode_barang, jumlah_jual, tanggal) VALUES ('$kode_barang', '$jumlah_jual', '$tanggal')";

    if (mysqli_query($conn, $query)) {

        $update_query = "UPDATE inventory SET stok_tersedia = stok_tersedia - '$jumlah_jual' WHERE kode_barang = '$kode_barang'";

        if (mysqli_query($conn, $update_query)) {

            header("Location: /pages/admin/inventory.php");
            exit();
        } else {
            echo "Error updating stock: " . mysqli_error($conn);
        }
    } else {
        echo "Error inserting record: " . mysqli_error($conn);
    }
}
