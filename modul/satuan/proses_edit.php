
<?php
session_start();
include '../../koneksi/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_satuan = $_POST['id_satuan'];
    $nama_satuan = $_POST['nama_satuan'];

    // Cek nama satuan apakah sudah ada yang menggunakan
    $check_satuan = mysqli_query($koneksi, "SELECT * FROM satuan WHERE nama_satuan = '$nama_satuan' AND id_satuan != '$id_satuan' AND status_dihapus = 0");
    if(mysqli_num_rows($check_satuan) > 0) {
        $_SESSION['satuan_eror'] = "Nama satuan sudah digunakan!";
        header("Location: edit.php?id=" . $id_satuan);
        exit();
    }

    $query = "UPDATE satuan SET 
              nama_satuan = '$nama_satuan'
              WHERE id_satuan = '$id_satuan'";

    if(mysqli_query($koneksi, $query)) {
        $_SESSION['satuan_sukses'] = "Data satuan berhasil diupdate!";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['satuan_eror'] = "Terjadi kesalahan: " . mysqli_error($koneksi);
        header("Location: edit.php?id=" . $id_satuan);
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>