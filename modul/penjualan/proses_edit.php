<?php

session_start();

include '../../koneksi/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $no_faktur_penjualan = $_POST['no_faktur_penjualan'];
        $id_pelanggan = $_POST['id_pelanggan'];
        $tanggal = $_POST['tanggal'];
        $diskon = $_POST['diskon'];
        $total_harga = $_POST['total_harga'];
        $dibayar = $_POST['dibayar'];
        $kembalian = $_POST['kembalian'];
        $id_pengguna = $_SESSION['dataPengguna']['id_pengguna'];
        $id_penjualan = $_POST['id_penjualan'];

        // Validate required fields first
        if (isset($_POST['produk']) && is_array($_POST['produk'])) {
            foreach($_POST['produk'] as $produk) {
                if (empty($produk['id_produk']) || empty($produk['kode_produk'])) {
                    $_SESSION['penjualan_eror'] = 'Data produk tidak lengkap! Pastikan Data Produk Diisi dengan benar.';
                    header('Location: edit.php?id=' . $id_penjualan);
                    exit;
                }
            }
        }

        mysqli_begin_transaction($koneksi);

        try {
            // Update penjualan header
            $query = mysqli_prepare($koneksi, "UPDATE penjualan SET no_faktur_penjualan=?, id_pelanggan=?, id_pengguna=?, tanggal=?, total=?, diskon=?, bayar=?, kembalian=? WHERE id_penjualan=?");
            mysqli_stmt_bind_param($query, "siisddddi", $no_faktur_penjualan, $id_pelanggan, $id_pengguna, $tanggal, $total_harga, $diskon, $dibayar, $kembalian, $id_penjualan);
            mysqli_stmt_execute($query);

            // Delete existing detail_penjualan
            $query_delete = mysqli_prepare($koneksi, "DELETE FROM detail_penjualan WHERE id_penjualan = ?");
            mysqli_stmt_bind_param($query_delete, "i", $id_penjualan);
            mysqli_stmt_execute($query_delete);

            // Delete existing stok_keluar
            $query_delete_stok = mysqli_prepare($koneksi, "DELETE FROM stok_keluar WHERE id_penjualan = ?");
            mysqli_stmt_bind_param($query_delete_stok, "i", $id_penjualan);
            mysqli_stmt_execute($query_delete_stok);

            // Insert new penjualan detail and update stock
            if (isset($_POST['produk']) && is_array($_POST['produk'])) {
                foreach($_POST['produk'] as $produk) {
                    if (!empty($produk['id_produk']) && !empty($produk['qty']) && !empty($produk['harga_satuan'])) {
                        // Validate numeric values
                        $jumlah = intval($produk['qty']);
                        $harga = floatval($produk['harga_satuan']);
                        $subtotal = $jumlah * $harga;

                        // Check available stock first
                        $check_stok = mysqli_prepare($koneksi, "SELECT stok FROM produk WHERE id_produk = ? AND status_dihapus = 0");
                        mysqli_stmt_bind_param($check_stok, "i", $produk['id_produk']);
                        mysqli_stmt_execute($check_stok);
                        $result = mysqli_stmt_get_result($check_stok);
                        $stok_data = mysqli_fetch_assoc($result);

                        if($stok_data['stok'] < $jumlah) {
                            mysqli_rollback($koneksi);
                            $_SESSION['penjualan_eror'] = 'Stok tidak mencukupi untuk produk dengan kode ' . $produk['kode_produk'];
                            header('Location: edit.php?id=' . $id_penjualan);
                            exit;
                        }

                        // Insert detail penjualan
                        $query_detail = mysqli_prepare($koneksi, "INSERT INTO detail_penjualan (id_penjualan, id_produk, jumlah, harga, subtotal, status_dihapus) VALUES (?, ?, ?, ?, ?, 0)");
                        mysqli_stmt_bind_param($query_detail, "iiidd", $id_penjualan, $produk['id_produk'], $jumlah, $harga, $subtotal);
                        mysqli_stmt_execute($query_detail);

                        // Insert into stok_keluar table
                        $query_stok_keluar = mysqli_prepare($koneksi, "INSERT INTO stok_keluar (id_produk, jumlah, id_penjualan, tanggal, status_dihapus) VALUES (?, ?, ?, NOW(), 0)");
                        mysqli_stmt_bind_param($query_stok_keluar, "iii", $produk['id_produk'], $jumlah, $id_penjualan);
                        mysqli_stmt_execute($query_stok_keluar);                        

                        // Update stock in produk table
                        $query_update_stok = mysqli_prepare($koneksi, "UPDATE produk SET stok = stok - ? WHERE id_produk = ? AND status_dihapus = 0");
                        mysqli_stmt_bind_param($query_update_stok, "ii", $jumlah, $produk['id_produk']);
                        mysqli_stmt_execute($query_update_stok);
                    }
                }
            }            
            mysqli_commit($koneksi);
            $_SESSION['penjualan_sukses'] = 'Transaksi penjualan berhasil diupdate!';
            echo "<script>window.open('detail.php?id=" . $id_penjualan . "', '_blank'); window.location.href='index.php';</script>";
            exit;

        } catch(Exception $e) {
            mysqli_rollback($koneksi);
            $_SESSION['penjualan_eror'] = 'Terjadi kesalahan saat mengupdate transaksi!';
            header('Location: edit.php?id=' . $id_penjualan);
            exit;        
        }    
    }    
  
?>