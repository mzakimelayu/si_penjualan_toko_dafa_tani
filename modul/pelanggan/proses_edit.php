
<?php
session_start();
include '../../koneksi/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pelanggan = $_POST['id_pelanggan'];
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    $query = "UPDATE pelanggan SET 
              nama_pelanggan = '$nama_pelanggan',
              no_hp = '$no_hp',
              alamat = '$alamat'
              WHERE id_pelanggan = '$id_pelanggan'";

    if(mysqli_query($koneksi, $query)) {
        $_SESSION['pelanggan_sukses'] = "Data pelanggan berhasil diupdate!";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['pelanggan_eror'] = "Terjadi kesalahan: " . mysqli_error($koneksi);
        header("Location: edit.php?id=" . $id_pelanggan);
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}?>