<?php
header('Content-Type: application/json');

require_once '../../koneksi/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    
    $id_penjualan = $_GET['id'];
    
    mysqli_begin_transaction($koneksi);
    
    try {
        // Get penjualan details first
        $query_get = "SELECT id_penjualan FROM penjualan WHERE id_penjualan = ? AND status_dihapus = 0";
        $stmt_get = mysqli_prepare($koneksi, $query_get);
        mysqli_stmt_bind_param($stmt_get, "i", $id_penjualan);
        mysqli_stmt_execute($stmt_get);
        $result = mysqli_stmt_get_result($stmt_get);
        $penjualan = mysqli_fetch_assoc($result);

        if (!$penjualan) {
            throw new Exception('Transaksi tidak ditemukan');
        }
            
        // Get and update stock from detail_penjualan
        $query_detail = "SELECT id_produk, jumlah FROM detail_penjualan WHERE id_penjualan = ? AND status_dihapus = 0";
        $stmt_detail = mysqli_prepare($koneksi, $query_detail);
        mysqli_stmt_bind_param($stmt_detail, "i", $id_penjualan);
        mysqli_stmt_execute($stmt_detail);
        $result_detail = mysqli_stmt_get_result($stmt_detail);
        
        if (mysqli_num_rows($result_detail) === 0) {
            throw new Exception('Detail penjualan tidak ditemukan');
        }
        
        while ($detail = mysqli_fetch_assoc($result_detail)) {
            // Check current stock first
            $query_check_stock = "SELECT stok FROM produk WHERE id_produk = ? AND status_dihapus = 0";
            $stmt_check_stock = mysqli_prepare($koneksi, $query_check_stock);
            mysqli_stmt_bind_param($stmt_check_stock, "i", $detail['id_produk']);
            mysqli_stmt_execute($stmt_check_stock);
            $result_stock = mysqli_stmt_get_result($stmt_check_stock);
            $current_stock = mysqli_fetch_assoc($result_stock);
            
            if (!$current_stock) {
                throw new Exception('Produk tidak ditemukan');
            }
            
            // Add stock back
            $query_update_stok = "UPDATE produk SET stok = stok + ? WHERE id_produk = ? AND status_dihapus = 0";
            $stmt_update_stok = mysqli_prepare($koneksi, $query_update_stok);
            mysqli_stmt_bind_param($stmt_update_stok, "ii", $detail['jumlah'], $detail['id_produk']);
            
            if (!mysqli_stmt_execute($stmt_update_stok)) {
                throw new Exception('Gagal mengupdate stok produk');
            }

            // Soft delete stok_keluar
            $query_delete_stok = "UPDATE stok_keluar SET status_dihapus = 1 WHERE id_penjualan = ? AND id_produk = ?";
            $stmt_delete_stok = mysqli_prepare($koneksi, $query_delete_stok);
            mysqli_stmt_bind_param($stmt_delete_stok, "ii", $id_penjualan, $detail['id_produk']);
            
            if (!mysqli_stmt_execute($stmt_delete_stok)) {
                throw new Exception('Gagal membatalkan stok keluar');
            }
        }
        
        // Soft delete detail_penjualan
        $query_delete_detail = "UPDATE detail_penjualan SET status_dihapus = 1 WHERE id_penjualan = ?";
        $stmt_delete_detail = mysqli_prepare($koneksi, $query_delete_detail);
        mysqli_stmt_bind_param($stmt_delete_detail, "i", $id_penjualan);
        
        if (!mysqli_stmt_execute($stmt_delete_detail)) {
            throw new Exception('Gagal membatalkan detail penjualan');
        }
        
        // Soft delete penjualan
        $query_delete = "UPDATE penjualan SET status_dihapus = 1 WHERE id_penjualan = ?";
        $stmt_delete = mysqli_prepare($koneksi, $query_delete);
        mysqli_stmt_bind_param($stmt_delete, "i", $id_penjualan);
        
        if (!mysqli_stmt_execute($stmt_delete)) {
            throw new Exception('Gagal membatalkan penjualan');
        }
        
        mysqli_commit($koneksi);
        echo json_encode([
            'success' => true,
            'message' => 'Transaksi penjualan berhasil dibatalkan'
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
}
?>