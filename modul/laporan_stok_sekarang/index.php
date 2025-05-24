<?php
    $judul_halaman = "Laporan Stok";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <div class="p-8 animate-fade-in">
        <div class="bg-gradient-to-br from-white to-stone-100 rounded-3xl shadow-xl p-10 animate-scale hover:shadow-2xl transition-all duration-300">
            <h2 class="text-4xl font-bold mb-10 text-green-700 border-b-2 border-green-200 pb-6 flex items-center gap-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75C20.25 16.153 16.556 18 12 18s-8.25-1.847-8.25-4.125v-3.75m16.5 0c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                </svg>
                <span class="tracking-wide">Laporan Stok Sekarang</span>
            </h2>

            <form action="" method="GET" class="mb-8">
                <div class="bg-gradient-to-r from-green-50 to-green-100 p-6 rounded-3xl shadow-lg">
                    <div class="flex flex-wrap gap-4">
                        <!-- Filter Section -->
                        <div class="flex-1 min-w-[200px]">
                            <div class="bg-white p-5 rounded-2xl shadow-inner">
                                <h3 class="text-2xl font-bold text-green-800 mb-4 border-b pb-2 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                    </svg>
                                    Kategori
                                </h3>
                                <select name="kategori" class="w-full p-3 rounded-lg bg-green-50 border-2 border-green-200 focus:border-green-500 focus:ring-0">
                                    <option value="">Semua Kategori</option>
                                    <?php
                                        $query = "SELECT id_kategori, nama_kategori FROM kategori WHERE status_dihapus = 0 ORDER BY nama_kategori ASC";
                                        $result = mysqli_query($koneksi, $query);
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='".$row['id_kategori']."'>".$row['nama_kategori']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="flex-1 min-w-[200px]">
                            <div class="bg-white p-5 rounded-2xl shadow-inner">
                                <h3 class="text-2xl font-bold text-green-800 mb-4 border-b pb-2 flex items-center gap-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Status Stok
                                </h3>
                                <select name="status" class="w-full p-3 rounded-lg bg-green-50 border-2 border-green-200 focus:border-green-500 focus:ring-0">
                                    <option value="">Semua Status</option>
                                    <option value="minimum">Stok Minimum</option>
                                    <option value="aman">Stok Aman</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex gap-4">
                            <button type="submit" name="filter" class="bg-green-700 hover:bg-green-800 text-white py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 flex items-center gap-1">
                                Terapkan
                            </button>
                            <button type="reset" class="bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105 flex items-center gap-1">
                                Atur Ulang
                            </button>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Table Section -->
            <div class="overflow-x-auto bg-white rounded-2xl shadow-sm border-2 border-green-100">
                <table class="min-w-full divide-y divide-stone-200">
                    <thead class="bg-stone-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kode Produk</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Produk</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Satuan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Harga Beli</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Harga Jual</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Stok</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Stok Minimum</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">                        
                        <?php
                        if(isset($_GET['filter'])) {
                            $where = "p.status_dihapus = 0";

                            if(!empty($_GET['kategori'])) {
                                $kategori = mysqli_real_escape_string($koneksi, $_GET['kategori']);
                                $where .= " AND p.id_kategori = '$kategori'";
                            }

                            if(!empty($_GET['status'])) {
                                if($_GET['status'] == 'minimum') {
                                    $where .= " AND p.stok <= p.stok_minimum";
                                } else if($_GET['status'] == 'aman') {
                                    $where .= " AND p.stok > p.stok_minimum";
                                }
                            }

                            $query = "SELECT 
                                    p.*,
                                    k.nama_kategori,
                                    s.nama_satuan
                                    FROM produk p
                                    LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
                                    LEFT JOIN satuan s ON p.id_satuan = s.id_satuan
                                    WHERE $where
                                    ORDER BY p.nama_produk ASC";

                            $result = mysqli_query($koneksi, $query);
                            
                            if(mysqli_num_rows($result) > 0) {
                                $no = 1;
                                while($row = mysqli_fetch_assoc($result)) {
                                    $status = ($row['stok'] <= $row['stok_minimum']) ? 'Stok Minimum' : 'Stok Aman';
                                    echo "<tr class='hover:bg-gray-50'>
                                            <td class='px-4 py-3 text-sm text-gray-700'>$no</td>
                                            <td class='px-4 py-3 text-sm text-gray-700'>".$row['kode_produk']."</td>
                                            <td class='px-4 py-3 text-sm text-gray-700'>".$row['nama_produk']."</td>
                                            <td class='px-4 py-3 text-sm text-gray-700'>".$row['nama_kategori']."</td>
                                            <td class='px-4 py-3 text-sm text-gray-700'>".$row['nama_satuan']."</td>
                                            <td class='px-4 py-3 text-sm text-gray-700'>".number_format($row['harga_beli'], 0, ',', '.')."</td>
                                            <td class='px-4 py-3 text-sm text-gray-700'>".number_format($row['harga_jual'], 0, ',', '.')."</td>
                                            <td class='px-4 py-3 text-sm text-gray-700'>".$row['stok']."</td>
                                            <td class='px-4 py-3 text-sm text-gray-700'>".$row['stok_minimum']."</td>
                                            <td class='px-4 py-3 text-sm text-gray-700'>$status</td>
                                        </tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr>
                                        <td colspan='10' class='px-4 py-3 text-sm text-gray-700 text-center'>Tidak ada data yang ditemukan.</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr>
                                    <td colspan='10' class='px-4 py-3 text-sm text-gray-700 text-center'>Silakan pilih filter untuk melihat laporan.</td>
                                </tr>";
                            
                        }
                        ?>
                        </tbody>
                </table>
            </div>

            <!-- Print Options -->
            <div class="mt-6 flex flex-wrap gap-4 justify-end">
                <?php if(isset($_GET['filter'])): ?>
                <a href="cetak.php?kategori=<?php echo isset($_GET['kategori']) ? $_GET['kategori'] : ''; ?>&status=<?php echo isset($_GET['status']) ? $_GET['status'] : ''; ?>&filter=<?php echo isset($_GET['filter']) ? $_GET['filter'] : ''; ?>" target="_blank" 
                class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak Laporan
                </a>
                <?php endif; ?>
            </div>
            
<?php include ('../../layout/footer.php'); ?>