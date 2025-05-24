<?php 

// koneksi ke database dengan mysqli

// $koneksi = mysqli_connect("localhost", "root", "", "db_penjualan_toko_dafa_tani");
$koneksi = mysqli_connect("localhost:3308", "root", "", "db_penjualan_toko_dafa_tani");

// cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}