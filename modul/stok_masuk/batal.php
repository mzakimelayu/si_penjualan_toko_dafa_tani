<?php

session_start();

header('Content-Type: application/json');

require_once '../../koneksi/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_stok_masuk = $_POST['id_stok_masuk'];
    
    try {
        // Start transaction
        mysqli_begin_transaction($koneksi);
        
        // Get detail_stok_masuk data before deletion
        $query_detail = mysqli_prepare($koneksi, "SELECT id_produk, jumlah FROM detail_stok_masuk WHERE id_stok_masuk = ?");
        mysqli_stmt_bind_param($query_detail, "i", $id_stok_masuk);
        mysqli_stmt_execute($query_detail);
        $result = mysqli_stmt_get_result($query_detail);
        
        // Check if stock is sufficient for cancellation
        $insufficient_stock = false;
        $products_to_update = array();
        
        while($row = mysqli_fetch_assoc($result)) {
            $query_check = mysqli_prepare($koneksi, "SELECT stok FROM produk WHERE id_produk = ?");
            mysqli_stmt_bind_param($query_check, "i", $row['id_produk']);
            mysqli_stmt_execute($query_check);
            $stock_result = mysqli_stmt_get_result($query_check);
            $stock_data = mysqli_fetch_assoc($stock_result);
            
            if($stock_data['stok'] < $row['jumlah']) {
                $insufficient_stock = true;
                break;
            }
            $products_to_update[] = $row;
        }
        
        if($insufficient_stock) {
            throw new Exception('Stok produk tidak mencukupi untuk pembatalan, , Cek Bagian Transaksi Stok Keluar');
        }
        
        // Update product stock
        $query_update_stok = mysqli_prepare($koneksi, "UPDATE produk SET stok = stok - ? WHERE id_produk = ?");
        
        foreach($products_to_update as $product) {
            mysqli_stmt_bind_param($query_update_stok, "ii", $product['jumlah'], $product['id_produk']);
            mysqli_stmt_execute($query_update_stok);
        }
        
        // Update detail_stok_masuk
        $query_update_detail = mysqli_prepare($koneksi, "UPDATE detail_stok_masuk SET status_dihapus = 1 WHERE id_stok_masuk = ?");
        mysqli_stmt_bind_param($query_update_detail, "i", $id_stok_masuk);
        mysqli_stmt_execute($query_update_detail);
        
        // Update stok_masuk
        $query_update = mysqli_prepare($koneksi, "UPDATE stok_masuk SET status_dihapus = 1 WHERE id_stok_masuk = ?");
        mysqli_stmt_bind_param($query_update, "i", $id_stok_masuk);
        mysqli_stmt_execute($query_update);        
        mysqli_commit($koneksi);
        
        echo json_encode([
            'success' => true,
            'message' => 'Transaksi stok masuk berhasil dibatalkan'
        ]);
        
    } catch(Exception $e) {
        mysqli_rollback($koneksi);
        echo json_encode([
            'success' => false,
            'message' => 'Gagal membatalkan transaksi: ' . $e->getMessage()
        ]);
    }
    
    mysqli_close($koneksi);
    
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan'
    ]);
}?>
