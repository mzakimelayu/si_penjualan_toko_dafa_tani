<?php
    $judul_halaman = "Edit Produk";
    
    include '../../cek_login.php';

    // Ambil data produk berdasarkan ID
    $id_produk = $_GET['id'];
    $query = "SELECT * FROM produk WHERE id_produk = '$id_produk'";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) == 0) {
        echo "<script>window.location.href='" . base_url('404.php') . "';</script>";                    
        exit;
    }
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <div class="p-6 animate-slide-fade">    
        <!-- Form Section -->
        <div class="bg-stone-100 rounded-lg p-6 shadow-md animate-scale">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Edit Produk</h2>
            
            <!-- Pesan Error -->
            <?php
                if(isset($_SESSION['produk_eror'])) { ?>
                <div id="alert-message" class="mb-4 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 shadow-md p-4 rounded-lg animate-fade-in-down flex justify-between items-center transform transition-all duration-300 hover:scale-[1.02]" role="alert">
                    <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="font-medium text-red-700"><?php echo $_SESSION['produk_eror']; ?></p>
                    </div>
                    <button onclick="closeAlert()" class="p-1.5 rounded-full hover:bg-red-200 transition-colors duration-200">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                    const alert = document.getElementById('alert-message');
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-100%)';
                    setTimeout(() => alert.style.display = 'none', 300);
                    }, 3000);
                    
                    function closeAlert() {
                    const alert = document.getElementById('alert-message');
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-100%)';
                    setTimeout(() => alert.style.display = 'none', 300);
                    }
                </script>
            <?php 
            unset($_SESSION['produk_eror']);
            } 
            ?>

            <form action="proses_edit.php" method="POST" class="space-y-4">
                <input type="hidden" name="id_produk" value="<?php echo $data['id_produk']; ?>">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="animate-smooth">
                        <label for="kode_produk" class="block text-gray-700 mb-2">Kode Produk</label>
                        <input type="text" id="kode_produk" name="kode_produk" required value="<?php echo $data['kode_produk']; ?>"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition duration-300">
                    </div>

                    <div class="animate-smooth">
                        <label for="nama_produk" class="block text-gray-700 mb-2">Nama Produk</label>
                        <input type="text" id="nama_produk" name="nama_produk" required value="<?php echo $data['nama_produk']; ?>"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition duration-300">
                    </div>
                    
                    <div class="animate-smooth">
                        <label for="id_kategori" class="block text-gray-700 mb-2">Kategori</label>
                        <select id="id_kategori" name="id_kategori" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition duration-300">
                            <option value="">Pilih Kategori</option>
                            <?php
                            $query_kategori = "SELECT * FROM kategori WHERE status_dihapus = 0";
                            $result_kategori = mysqli_query($koneksi, $query_kategori);
                            while($kategori = mysqli_fetch_assoc($result_kategori)) {
                                $selected = ($data['id_kategori'] == $kategori['id_kategori']) ? 'selected' : '';
                                echo "<option value='".$kategori['id_kategori']."' ".$selected.">".$kategori['nama_kategori']."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="animate-smooth">
                        <label for="id_satuan" class="block text-gray-700 mb-2">Satuan</label>
                        <select id="id_satuan" name="id_satuan" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition duration-300">
                            <option value="">Pilih Satuan</option>
                            <?php
                            $query_satuan = "SELECT * FROM satuan WHERE status_dihapus = 0";
                            $result_satuan = mysqli_query($koneksi, $query_satuan);
                            while($satuan = mysqli_fetch_assoc($result_satuan)) {
                                $selected = ($data['id_satuan'] == $satuan['id_satuan']) ? 'selected' : '';
                                echo "<option value='".$satuan['id_satuan']."' ".$selected.">".$satuan['nama_satuan']."</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="animate-smooth">
                        <label for="harga_jual" class="block text-gray-700 mb-2">Harga Jual</label>
                        <input type="number" step="0.01" id="harga_jual" name="harga_jual" required value="<?php echo $data['harga_jual']; ?>"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition duration-300">
                    </div>

                    <div class="animate-smooth">
                        <label for="harga_beli" class="block text-gray-700 mb-2">Harga Beli</label>
                        <input type="number" step="0.01" id="harga_beli" name="harga_beli" required value="<?php echo $data['harga_beli']; ?>"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition duration-300">
                    </div>

                    <div class="animate-smooth">
                        <label for="stok" class="block text-gray-700 mb-2">Stok</label>
                        <input type="number" id="stok" name="stok" required value="<?php echo $data['stok']; ?>"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition duration-300">
                    </div>

                    <div class="animate-smooth">
                        <label for="stok_minimum" class="block text-gray-700 mb-2">Stok Minimum</label>
                        <input type="number" id="stok_minimum" name="stok_minimum" required value="<?php echo $data['stok_minimum']; ?>"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition duration-300">
                    </div>

                    <div class="animate-smooth col-span-2">
                        <label for="deskripsi" class="block text-gray-700 mb-2">Deskripsi</label>
                        <textarea id="deskripsi" name="deskripsi" rows="4"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition duration-300"><?php echo $data['deskripsi']; ?></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-2 pt-4">
                    <a href="index.php" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-300">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition duration-300">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

<?php include ('../../layout/footer.php'); ?>