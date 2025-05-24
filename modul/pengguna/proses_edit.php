
<?php
session_start();
include '../../koneksi/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_pengguna = $_POST['id_pengguna'];
    $nama_lengkap = $_POST['nama_lengkap'];
    $nama_pengguna = $_POST['nama_pengguna'];
    $kata_sandi = $_POST['kata_sandi'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $peran = $_POST['peran'];

    // Cek username apakah sudah ada yang menggunakan
    $check_username = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE nama_pengguna = '$nama_pengguna' AND id_pengguna != '$id_pengguna'");
    if(mysqli_num_rows($check_username) > 0) {
        $_SESSION['pengguna_eror'] = "Nama pengguna sudah digunakan!";
        header("Location: edit.php?id=" . $id_pengguna);
        exit();
    }

    // Jika password diisi, update dengan password baru
    if (!empty($kata_sandi)) {
        $hashed_password = password_hash($kata_sandi, PASSWORD_DEFAULT);
        $query = "UPDATE pengguna SET 
                  nama_lengkap = '$nama_lengkap',
                  nama_pengguna = '$nama_pengguna',
                  kata_sandi = '$hashed_password',
                  no_hp = '$no_hp',
                  alamat = '$alamat',
                  jenis_kelamin = '$jenis_kelamin',
                  peran = '$peran'
                  WHERE id_pengguna = '$id_pengguna'";
    } else {
        // Jika password kosong, update tanpa mengubah password
        $query = "UPDATE pengguna SET 
                  nama_lengkap = '$nama_lengkap',
                  nama_pengguna = '$nama_pengguna',
                  no_hp = '$no_hp',
                  alamat = '$alamat',
                  jenis_kelamin = '$jenis_kelamin',
                  peran = '$peran'
                  WHERE id_pengguna = '$id_pengguna'";
    }

    if(mysqli_query($koneksi, $query)) {
        $_SESSION['pengguna_sukses'] = "Data pengguna berhasil diupdate!";
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['pengguna_eror'] = "Terjadi kesalahan: " . mysqli_error($koneksi);
        header("Location: edit.php?id=" . $id_pengguna);
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}?>
