<?php
    $judul_halaman = "Detail Pengguna";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

<!-- Content -->
<div class="p-6 animate-slide-fade">
    <div class="bg-stone-100 rounded-lg shadow-md p-6 animate-scale">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">Detail Pengguna</h2>
        
        <?php
        
        if(isset($_GET['id'])) {
            $id_pengguna = $_GET['id'];
            $query = "SELECT * FROM pengguna WHERE id_pengguna = ? AND status_dihapus = 0";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("i", $id_pengguna);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if($result->num_rows > 0) {
                $data = $result->fetch_assoc();
        ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-smooth">
                    <div class="space-y-4">
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">Nama Lengkap</label>
                            <p class="text-green-600 mt-1"><?php echo $data['nama_lengkap']; ?></p>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">Nama Pengguna</label>
                            <p class="text-green-600 mt-1"><?php echo $data['nama_pengguna']; ?></p>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">No. HP</label>
                            <p class="text-green-600 mt-1"><?php echo $data['no_hp'] ?: '-'; ?></p>
                        </div>

                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">Tanggal Dibuat</label>
                            <p class="text-green-600 mt-1"><?php echo $data['dibuat_pada'] ?></p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">Jenis Kelamin</label>
                            <p class="text-green-600 mt-1"><?php echo $data['jenis_kelamin'] ?: '-'; ?></p>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">Peran</label>
                            <p class="text-yellow-500 mt-1"><?php echo ucfirst($data['peran']); ?></p>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">Alamat</label>
                            <p class="text-green-600 mt-1"><?php echo $data['alamat'] ?: '-'; ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="edit.php?id=<?php echo $id_pengguna; ?>" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg transition duration-300">
                        Edit Data
                    </a>
                    <a href="index.php" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition duration-300">
                        Kembali
                    </a>
                </div>
        <?php
            } else {
                echo "<script>window.location.href = '" . base_url('404.php') . "';</script>";
                exit;            
            }
        } else {
            echo '<div class="bg-yellow-500 text-white p-4 rounded-lg">ID pengguna tidak valid.</div>';
        }
        ?>
    </div>
</div>


<?php include ('../../layout/footer.php'); ?>