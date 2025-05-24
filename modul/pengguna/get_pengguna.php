
<?php
header('Content-Type: application/json');
include '../../koneksi/db.php';

$query = "SELECT * FROM pengguna where status_dihapus=0 ORDER BY id_pengguna ASC";
$result = mysqli_query($koneksi, $query);

$data = array();
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = array(
        'id_pengguna' => $row['id_pengguna'],
        'nama_lengkap' => $row['nama_lengkap'], 
        'nama_pengguna' => $row['nama_pengguna'],
        'peran' => $row['peran'],
        'no_hp' => $row['no_hp'],
        'jenis_kelamin' => $row['jenis_kelamin'],
        'alamat' => $row['alamat'],
        'dibuat_pada' => $row['dibuat_pada'],
        'status_dihapus' => $row['status_dihapus']    
    );}

echo json_encode($data);
mysqli_close($koneksi);
?>
