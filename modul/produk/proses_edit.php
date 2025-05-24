
<?php
session_start();
include '../../koneksi/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_produk = $_POST['id_produk'];
    $kode_produk = $_POST['kode_produk'];
    $nama_produk = $_POST['nama_produk'];
    $id_kategori = $_POST['id_kategori'];
    $id_satuan = $_POST['id_satuan'];
    $harga_jual = $_POST['harga_jual'];
    $harga_beli = $_POST['harga_beli'];
    $stok = $_POST['stok'];
    $stok_minimum = $_POST['stok_minimum'];
    $deskripsi = $_POST['deskripsi'];

    $query = "UPDATE produk SET 
              kode_produk = '$kode_produk',
              nama_produk = '$nama_produk',
              id_kategori = '$id_kategori',
              id_satuan = '$id_satuan',
              harga_jual = '$harga_jual',
              harga_beli = '$harga_beli',
              stok = '$stok',
              stok_minimum = '$stok_minimum',
              deskripsi = '$deskripsi'
              WHERE id_produk = '$id_produk'";

    if(mysqli_query($koneksi, $query)) {
        $_SESSION['produk_sukses'] = "Data produk berhasil diupdate!";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['produk_eror'] = "Terjadi kesalahan: " . mysqli_error($koneksi);
        header("Location: edit.php?id=" . $id_produk);
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}?>