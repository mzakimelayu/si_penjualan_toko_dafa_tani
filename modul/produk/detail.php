<?php
    $judul_halaman = "Detail Produk";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

<!-- Content -->
<div class="p-6 animate-slide-fade">
    <div class="bg-stone-100 rounded-lg shadow-md p-6 animate-scale">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">Detail Produk</h2>
        
        <?php
        
        if(isset($_GET['id'])) {
            $id_produk = $_GET['id'];
            $query = "SELECT p.*, k.nama_kategori, s.nama_satuan FROM produk p 
                     LEFT JOIN kategori k ON p.id_kategori = k.id_kategori 
                     LEFT JOIN satuan s ON p.id_satuan = s.id_satuan 
                     WHERE p.id_produk = ? AND p.status_dihapus = 0";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("i", $id_produk);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if($result->num_rows > 0) {
                $data = $result->fetch_assoc();
        ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-smooth">
                    <div class="space-y-4">
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">Kode Produk</label>
                            <p class="text-green-600 mt-1"><?php echo $data['kode_produk']; ?></p>
                        </div>

                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">Nama Produk</label>
                            <p class="text-green-600 mt-1"><?php echo $data['nama_produk']; ?></p>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">Kategori</label>
                            <p class="text-green-600 mt-1"><?php echo $data['nama_kategori'] ?: '-'; ?></p>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">Satuan</label>
                            <p class="text-green-600 mt-1"><?php echo $data['nama_satuan'] ?: '-'; ?></p>
                        </div>

                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">Deskripsi</label>
                            <p class="text-green-600 mt-1"><?php echo $data['deskripsi'] ?: '-'; ?></p>
                        </div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">Harga Jual</label>
                            <p class="text-green-600 mt-1">Rp <?php echo number_format($data['harga_jual'], 0, ',', '.'); ?></p>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">Harga Beli</label>
                            <p class="text-green-600 mt-1">Rp <?php echo number_format($data['harga_beli'], 0, ',', '.'); ?></p>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">Stok</label>
                            <p class="text-green-600 mt-1"><?php echo $data['stok']; ?></p>
                        </div>

                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">Stok Minimum</label>
                            <p class="text-green-600 mt-1"><?php echo $data['stok_minimum']; ?></p>
                        </div>

                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">Tanggal Dibuat</label>
                            <p class="text-green-600 mt-1"><?php echo $data['dibuat_pada'] ?></p>
                        </div>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <a href="edit.php?id=<?php echo $id_produk; ?>" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg transition duration-300">
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
            echo '<div class="bg-yellow-500 text-white p-4 rounded-lg">ID produk tidak valid.</div>';
        }
        ?>
    </div>
</div>


<?php include ('../../layout/footer.php'); ?>