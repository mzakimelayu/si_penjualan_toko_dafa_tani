
<?php
header('Content-Type: application/json');
include '../../koneksi/db.php';

$query = "SELECT sm.*, GROUP_CONCAT(p.nama_produk) as nama_produk, GROUP_CONCAT(dsm.jumlah) as jumlah_produk, GROUP_CONCAT(dsm.harga_beli) as harga_beli_produk 
          FROM stok_masuk sm 
          LEFT JOIN detail_stok_masuk dsm ON sm.id_stok_masuk = dsm.id_stok_masuk 
          LEFT JOIN produk p ON dsm.id_produk = p.id_produk
          GROUP BY sm.id_stok_masuk 
          ORDER BY sm.id_stok_masuk ASC";
          
$result = mysqli_query($koneksi, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'id_stok_masuk' => $row['id_stok_masuk'],
        'no_invoice' => $row['no_invoice'],
        'nama_supplier' => $row['nama_supplier'],
        'tanggal' => $row['tanggal'],
        'id_pengguna' => $row['id_pengguna'],
        'nama_produk' => $row['nama_produk'],
        'jumlah_produk' => $row['jumlah_produk'],
        'harga_beli_produk' => $row['harga_beli_produk'],
        'status_dihapus' => $row['status_dihapus']
    );
}

echo json_encode($data);
mysqli_close($koneksi);


?>
