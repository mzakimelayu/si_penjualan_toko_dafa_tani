<?php
include "../../koneksi/db.php";

header('Content-Type: application/json');

if(isset($_GET['term'])) {
    $searchTerm = $_GET['term'];
    
    $query = "SELECT id_produk, kode_produk, nama_produk, harga_beli, harga_jual, stok, id_kategori, id_satuan, stok_minimum, deskripsi 
              FROM produk 
              WHERE (LOWER(nama_produk) LIKE LOWER(?) OR LOWER(kode_produk) LIKE LOWER(?))
              AND status_dihapus = 0 AND stok > 0";
    
    $stmt = mysqli_prepare($koneksi, $query);
    $searchParam = "%$searchTerm%";
    mysqli_stmt_bind_param($stmt, "ss", $searchParam, $searchParam);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);    
    $data = array();
    while($row = mysqli_fetch_assoc($result)) {
        $data[] = array(
            'id_produk' => $row['id_produk'],
            'kode_produk' => $row['kode_produk'],
            'nama_produk' => $row['nama_produk'],
            'harga_beli' => $row['harga_beli'],
            'harga_jual' => $row['harga_jual'],
            'stok' => $row['stok'],
            'id_kategori' => $row['id_kategori'],
            'id_satuan' => $row['id_satuan'],
            'stok_minimum' => $row['stok_minimum'],
            'deskripsi' => $row['deskripsi']
        );
    }    
    echo json_encode($data);
    mysqli_stmt_close($stmt);
    exit;
}
mysqli_close($koneksi);?>
