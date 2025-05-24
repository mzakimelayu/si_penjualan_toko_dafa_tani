
<?php
header('Content-Type: application/json');
include '../../koneksi/db.php';

$query = "SELECT * FROM pelanggan where status_dihapus=0 ORDER BY id_pelanggan ASC";
$result = mysqli_query($koneksi, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'id_pelanggan' => $row['id_pelanggan'],
        'nama_pelanggan' => $row['nama_pelanggan'],
        'no_hp' => $row['no_hp'],
        'alamat' => $row['alamat'],
        'dibuat_pada' => $row['dibuat_pada'],
        'status_dihapus' => $row['status_dihapus']    
    );
}

echo json_encode($data);
mysqli_close($koneksi);
?>
