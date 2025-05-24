<?php
    $judul_halaman = "Profil Pengguna";
    
    include '../cek_login.php';
?>

<?php include '../layout/header.php'; ?>

<?php include '../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <div class="p-4 md:p-6 animate-slide-fade">
        <div class="bg-stone-100 rounded-lg shadow-md p-6 max-w-3xl mx-auto animate-scale">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Data Profil Pengguna</h2>
            
            <?php
                $sql = "SELECT * FROM pengguna WHERE id_pengguna = '$sesi_id_pengguna'";
                $result = mysqli_query($koneksi, $sql);
                $data = mysqli_fetch_assoc($result);
            ?>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 animate-smooth">
                <div class="space-y-6">
                    <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                        <label class="text-gray-700 font-medium block mb-2">Nama Lengkap</label>
                        <p class="text-green-600 text-lg"><?php echo $data['nama_lengkap']; ?></p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                        <label class="text-gray-700 font-medium block mb-2">Nama Pengguna</label>
                        <p class="text-green-600 text-lg"><?php echo $data['nama_pengguna']; ?></p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                        <label class="text-gray-700 font-medium block mb-2">No. HP</label>
                        <p class="text-green-600 text-lg"><?php echo $data['no_hp']; ?></p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                        <label class="text-gray-700 font-medium block mb-2">Jenis Kelamin</label>
                        <p class="text-green-600 text-lg"><?php echo $data['jenis_kelamin']; ?></p>
                    </div>
                </div>
                
                <div class="space-y-6">
                    <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                        <label class="text-gray-700 font-medium block mb-2">Alamat</label>
                        <p class="text-green-600 text-lg"><?php echo $data['alamat']; ?></p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                        <label class="text-gray-700 font-medium block mb-2">Peran</label>
                        <p class="text-yellow-500 text-lg font-semibold"><?php echo $data['peran']; ?></p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                        <label class="text-gray-700 font-medium block mb-2">Terdaftar Pada</label>
                        <p class="text-green-600 text-lg"><?php echo $data['dibuat_pada']; ?></p>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm hover:shadow-md transition duration-300">
                        <label class="text-gray-700 font-medium block mb-2">Status</label>
                        <p class="text-green-600 text-lg"><?php echo $data['status_dihapus'] ? 'Dihapus' : 'Aktif'; ?></p>
                    </div>
                </div>
            </div>            
            <div class="flex justify-end space-x-4 mt-8">
                <a href="<?= base_url('dashboard.php') ?>" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200">
                    Kembali
                </a>
                <a href="pengaturan.php" class="px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition duration-200">
                    Edit Profil
                </a>
            </div>        
        </div>
    </div>
<?php include ('../layout/footer.php'); ?>