
<?php
header('Content-Type: application/json');
include '../../koneksi/db.php';

$query = "SELECT p.*, s.nama_satuan FROM produk p
          LEFT JOIN satuan s ON p.id_satuan = s.id_satuan 
          where p.status_dihapus = 0 ORDER BY p.id_produk ASC";
$result = mysqli_query($koneksi, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'id_produk' => $row['id_produk'],
        'nama_produk' => $row['nama_produk'],
        'id_kategori' => $row['id_kategori'],
        'id_satuan' => $row['id_satuan'],
        'nama_satuan' => $row['nama_satuan'],
        'harga_jual' => number_format($row['harga_jual'], 0, ',', '.'),
        'harga_beli' => number_format($row['harga_beli'], 0, ',', '.'),
        'stok' => $row['stok'],
        'dibuat_pada' => $row['dibuat_pada'],
        'status_dihapus' => $row['status_dihapus']
    );
}

echo json_encode($data);
mysqli_close($koneksi);
?>
