<?php

session_start();

include '../../koneksi/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_stok_masuk = $_POST['id_stok_masuk'];
    $no_invoice = $_POST['no_invoice'];
    $nama_supplier = $_POST['nama_supplier'];
    $tanggal = $_POST['tanggal'];
    $id_pengguna = $_SESSION['dataPengguna']['id_pengguna'];
    $id_produk = $_POST['id_produk'];
    $jumlah = $_POST['jumlah'];
    $harga_beli = $_POST['harga_beli'];

    try {
        // Validate required fields
        if (empty($no_invoice) || empty($nama_supplier) || empty($tanggal)) {
            throw new Exception("Semua field harus diisi!");
        }

        if (empty($id_produk) || empty($jumlah) || empty($harga_beli)) {
            throw new Exception("Detail produk harus diisi lengkap!");
        }

        // Start transaction
        mysqli_begin_transaction($koneksi);

            // Get old quantities and products
            $query_old = mysqli_prepare($koneksi, "SELECT id_produk, jumlah FROM detail_stok_masuk WHERE id_stok_masuk = ?");
            mysqli_stmt_bind_param($query_old, "i", $id_stok_masuk);
            mysqli_stmt_execute($query_old);
            $result_old = mysqli_stmt_get_result($query_old);
            $old_details = [];
            while($row = mysqli_fetch_assoc($result_old)) {
                $old_details[$row['id_produk']] = $row['jumlah'];
            }

            // Check if stock is sufficient after reverting old quantities
            $query_check = mysqli_prepare($koneksi, "SELECT stok FROM produk WHERE id_produk = ?");
            for($i = 0; $i < count($id_produk); $i++) {
                mysqli_stmt_bind_param($query_check, "i", $id_produk[$i]);
                mysqli_stmt_execute($query_check);
                $result_check = mysqli_stmt_get_result($query_check);
                $current_stock = mysqli_fetch_assoc($result_check)['stok'];
            
                // Add back old quantity if it exists
                if(isset($old_details[$id_produk[$i]])) {
                    $current_stock -= $old_details[$id_produk[$i]];
                }
            
                // Check if new quantity can be accommodated
                if($current_stock < 0) {
                    throw new Exception("Stok produk tidak mencukupi untuk diupdate!, Cek Bagian Transaksi Stok Keluar");
                }
            }

            // Update stok_masuk
            $query = mysqli_prepare($koneksi, "UPDATE stok_masuk SET no_invoice = ?, nama_supplier = ?, tanggal = ?, id_pengguna = ? 
                              WHERE id_stok_masuk = ?");
            mysqli_stmt_bind_param($query, "sssii", $no_invoice, $nama_supplier, $tanggal, $id_pengguna, $id_stok_masuk);
            mysqli_stmt_execute($query);

            // Delete old detail_stok_masuk
            $query_delete = mysqli_prepare($koneksi, "DELETE FROM detail_stok_masuk WHERE id_stok_masuk = ?");
            mysqli_stmt_bind_param($query_delete, "i", $id_stok_masuk);
            mysqli_stmt_execute($query_delete);

            // Revert old stock
            $query_revert = mysqli_prepare($koneksi, "UPDATE produk SET stok = stok - ? WHERE id_produk = ?");
            foreach($old_details as $prod_id => $qty) {
                mysqli_stmt_bind_param($query_revert, "ii", $qty, $prod_id);
                mysqli_stmt_execute($query_revert);
            }

            // Insert new detail_stok_masuk and update product stock
            $query_detail = mysqli_prepare($koneksi, "INSERT INTO detail_stok_masuk (id_stok_masuk, id_produk, jumlah, harga_beli) 
                                        VALUES (?, ?, ?, ?)");
        
            $query_update_stok = mysqli_prepare($koneksi, "UPDATE produk SET stok = stok + ?, harga_beli = ? WHERE id_produk = ?");

            for($i = 0; $i < count($id_produk); $i++) {
                if(empty($id_produk[$i]) || empty($jumlah[$i]) || empty($harga_beli[$i])) {
                    throw new Exception("Detail produk harus diisi lengkap!");
                }

                mysqli_stmt_bind_param($query_detail, "iiid", $id_stok_masuk, $id_produk[$i], $jumlah[$i], $harga_beli[$i]);
                mysqli_stmt_execute($query_detail);

                mysqli_stmt_bind_param($query_update_stok, "idi", $jumlah[$i], $harga_beli[$i], $id_produk[$i]);
                mysqli_stmt_execute($query_update_stok);
            }

            mysqli_commit($koneksi);

            $_SESSION['stok_masuk_sukses'] = 'Data stok masuk berhasil diupdate!';
            header('Location: index.php');
            exit;
    } catch(Exception $e) {
        mysqli_rollback($koneksi);
        $_SESSION['stok_masuk_error'] = $e->getMessage();
        header('Location: edit.php?id='.$id_stok_masuk);
        exit;
    }
}

?>