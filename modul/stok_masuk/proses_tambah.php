<?php

session_start();

include '../../koneksi/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $no_invoice = $_POST['no_invoice'];
    $nama_supplier = $_POST['nama_supplier'];
    $tanggal = $_POST['tanggal'];
    $id_pengguna = $_SESSION['dataPengguna']['id_pengguna'];;
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

        // Insert stok_masuk
        $query = mysqli_prepare($koneksi, "INSERT INTO stok_masuk (no_invoice, nama_supplier, tanggal, id_pengguna) 
                          VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($query, "sssi", $no_invoice, $nama_supplier, $tanggal, $id_pengguna);
        mysqli_stmt_execute($query);
      
        $id_stok_masuk = mysqli_insert_id($koneksi);

        // Insert detail_stok_masuk and update product stock
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

        $_SESSION['stok_masuk_sukses'] = 'Data stok masuk berhasil ditambahkan!';
        header('Location: index.php');
        exit;

    } catch(Exception $e) {
        mysqli_rollback($koneksi);
        $_SESSION['stok_masuk_error'] = $e->getMessage();
        header('Location: tambah.php');
        exit;
    }
}
?>