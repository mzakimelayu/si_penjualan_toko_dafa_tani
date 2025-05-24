<?php
    $judul_halaman = "Laporan Stok Keluar";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <div class="p-6 animate-fade-in">
        <div class="bg-gradient-to-br from-white to-stone-100 rounded-2xl shadow-lg p-8 animate-scale hover:shadow-xl transition-all duration-300">
            <h2 class="text-3xl font-bold mb-8 text-green-700 border-b-2 border-green-200 pb-4 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" />
                </svg>                
                Laporan Stok Keluar
            </h2>

            <form action="" method="GET" class="mb-8">
                <div class="bg-gradient-to-r from-green-50 to-green-100 p-6 rounded-3xl shadow-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Left Column -->
                        <div class="bg-white p-5 rounded-2xl shadow-inner">
                            <h3 class="text-2xl font-bold text-green-800 mb-4 border-b pb-2">Filter Data</h3>
                            
                            <div class="mb-6">
                                <div class="flex flex-wrap gap-4">
                                    <label class="flex-1 bg-green-50 p-4 rounded-lg cursor-pointer hover:bg-green-100 transition">
                                        <input type="radio" name="tipe_filter" value="tanggal" class="hidden peer" checked>
                                        <div class="flex items-center peer-checked:text-green-700">
                                            <span>Rentang Tanggal</span>
                                        </div>
                                    </label>
                                    <label class="flex-1 bg-green-50 p-4 rounded-lg cursor-pointer hover:bg-green-100 transition">
                                        <input type="radio" name="tipe_filter" value="bulan" class="hidden peer">
                                        <div class="flex items-center peer-checked:text-green-700">
                                            <span>Bulan</span>
                                        </div>
                                    </label>
                                    <label class="flex-1 bg-green-50 p-4 rounded-lg cursor-pointer hover:bg-green-100 transition">
                                        <input type="radio" name="tipe_filter" value="tahun" class="hidden peer">
                                        <div class="flex items-center peer-checked:text-green-700">
                                            <span>Tahun</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <div id="filter_tanggal_section" class="space-y-4">
                                <div class="flex gap-4">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                                        <input type="date" name="tanggal_awal" class="w-full p-2 rounded-lg border-2 border-green-200 focus:border-green-500 focus:ring-0">
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                                        <input type="date" name="tanggal_akhir" class="w-full p-2 rounded-lg border-2 border-green-200 focus:border-green-500 focus:ring-0">
                                    </div>
                                </div>
                            </div>

                            <div id="filter_bulan_section" class="space-y-4 hidden">
                                <div class="flex gap-4">
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Bulan</label>
                                        <select name="month" class="w-full p-2 rounded-lg border-2 border-green-200 focus:border-green-500 focus:ring-0">
                                            <option value="">Pilih Bulan</option>
                                            <?php
                                                $months = array(1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni', 
                                                            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember');
                                                foreach($months as $num => $name) {
                                                    echo "<option value='$num'>$name</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="flex-1">
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                                        <select name="year" class="w-full p-2 rounded-lg border-2 border-green-200 focus:border-green-500 focus:ring-0">
                                            <option value="">Pilih Tahun</option>
                                            <?php
                                                $currentYear = date('Y');
                                                for($year = $currentYear; $year >= $currentYear - 5; $year--) {
                                                    echo "<option value='$year'>$year</option>";
                                                }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div id="filter_tahun_section" class="space-y-4 hidden">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tahun</label>
                                <select name="year_only" class="w-full p-2 rounded-lg border-2 border-green-200 focus:border-green-500 focus:ring-0">
                                    <option value="">Pilih Tahun</option>
                                    <?php
                                        $currentYear = date('Y');
                                        for($year = $currentYear; $year >= $currentYear - 5; $year--) {
                                            echo "<option value='$year'>$year</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-6">
                            <div class="bg-white p-5 rounded-2xl shadow-inner">
                                <h3 class="text-2xl font-bold text-green-800 mb-4 border-b pb-2">Pelanggan</h3>
                                <select name="pelanggan" class="w-full p-3 rounded-lg bg-green-50 border-2 border-green-200 focus:border-green-500 focus:ring-0">
                                    <option value="">Semua Pelanggan</option>
                                    <?php
                                        $query = "SELECT id_pelanggan, nama_pelanggan FROM pelanggan WHERE status_dihapus = 0 ORDER BY nama_pelanggan ASC";
                                        $result = mysqli_query($koneksi, $query);
                                        while($row = mysqli_fetch_assoc($result)) {
                                            echo "<option value='".$row['id_pelanggan']."'>".$row['nama_pelanggan']."</option>";
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="bg-white p-5 rounded-2xl shadow-inner">
                                <h3 class="text-2xl font-bold text-green-800 mb-4 border-b pb-2">Status</h3>
                                <select name="status" class="w-full p-3 rounded-lg bg-green-50 border-2 border-green-200 focus:border-green-500 focus:ring-0">
                                    <option value="">Semua Status</option>
                                    <option value="0">Selesai</option>
                                    <option value="1">Dibatalkan</option>
                                </select>
                            </div>

                            <div class="bg-white p-5 rounded-2xl shadow-inner">
                                <h3 class="text-2xl font-bold text-green-800 mb-4 border-b pb-2">Aksi</h3>
                                <div class="flex gap-4">
                                    <button type="submit" name="filter" class="flex-1 bg-green-700 hover:bg-green-800 text-white py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105">
                                        <div class="flex items-center justify-center">
                                            <span>Terapkan</span>
                                        </div>
                                    </button>
                                    <button type="reset" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105">
                                        <div class="flex items-center justify-center">
                                            <span>Atur Ulang</span>
                                        </div>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                const radioButtons = document.querySelectorAll('input[name="tipe_filter"]');
                const tanggalSection = document.getElementById('filter_tanggal_section');
                const bulanSection = document.getElementById('filter_bulan_section');
                const tahunSection = document.getElementById('filter_tahun_section');

                function showSection(filterType) {
                    tanggalSection.classList.add('hidden');
                    bulanSection.classList.add('hidden');
                    tahunSection.classList.add('hidden');

                    switch(filterType) {
                        case 'tanggal':
                            tanggalSection.classList.remove('hidden');
                            break;
                        case 'bulan':
                            bulanSection.classList.remove('hidden');
                            break;
                        case 'tahun':
                            tahunSection.classList.remove('hidden');
                            break;
                    }
                }

                radioButtons.forEach(radio => {
                    radio.addEventListener('change', function() {
                        showSection(this.value);
                    });
                });

                showSection('tanggal');
            });
            </script>

            <!-- Table Section -->
            <div class="overflow-x-auto bg-white rounded-2xl shadow-sm border-2 border-green-100">
                <table class="min-w-full divide-y divide-stone-200">
                    <thead class="bg-stone-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Tanggal</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No Faktur</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Pelanggan</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Barang</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jumlah Keluar</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">                        
                        <?php
                        if(isset($_GET['filter'])) {
                            $where = "1=1"; // Initialize with valid condition
                                               
                            if(!empty($_GET['tanggal_awal']) && !empty($_GET['tanggal_akhir'])) {
                                $tgl_awal = mysqli_real_escape_string($koneksi, $_GET['tanggal_awal']);
                                $tgl_akhir = mysqli_real_escape_string($koneksi, $_GET['tanggal_akhir']);
                                $where .= " AND p.tanggal BETWEEN '$tgl_awal 00:00:00' AND '$tgl_akhir 23:59:59'";
                            }
                            
                            if(!empty($_GET['month']) && !empty($_GET['year'])) {
                                $month = mysqli_real_escape_string($koneksi, $_GET['month']);
                                $year = mysqli_real_escape_string($koneksi, $_GET['year']);
                                $where .= " AND MONTH(p.tanggal) = '$month' AND YEAR(p.tanggal) = '$year'";
                            }

                            if(!empty($_GET['year_only'])) {
                                $year_only = mysqli_real_escape_string($koneksi, $_GET['year_only']);
                                $where .= " AND YEAR(p.tanggal) = '$year_only'";
                            }
                            
                            if(!empty($_GET['pelanggan'])) {
                                $pelanggan = mysqli_real_escape_string($koneksi, $_GET['pelanggan']);
                                $where .= " AND p.id_pelanggan = '$pelanggan'";
                            }

                            if(isset($_GET['status']) && $_GET['status'] !== '') {
                                $status = mysqli_real_escape_string($koneksi, $_GET['status']);
                                $where .= " AND p.status_dihapus = '$status'";
                            }

                            $query = "SELECT p.tanggal, p.status_dihapus, p.no_faktur_penjualan, pl.nama_pelanggan, 
                                    pr.nama_produk, dp.jumlah
                                    FROM penjualan p
                                    JOIN detail_penjualan dp ON p.id_penjualan = dp.id_penjualan
                                    JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
                                    JOIN produk pr ON dp.id_produk = pr.id_produk
                                    WHERE $where 
                                    ORDER BY p.id_penjualan DESC, p.tanggal DESC";

                            $result = mysqli_query($koneksi, $query);   
                            if (!$result) {
                                die("Query error: " . mysqli_error($koneksi));
                            }

                            $no = 1;
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td class='px-4 py-3 text-sm text-gray-700'>$no</td>";
                                    echo "<td class='px-4 py-3 text-sm text-gray-700'>".date('d-m-Y', strtotime($row['tanggal']))."</td>";
                                    echo "<td class='px-4 py-3 text-sm text-gray-700'>".$row['no_faktur_penjualan']."</td>";
                                    echo "<td class='px-4 py-3 text-sm text-gray-700'>".$row['nama_pelanggan']."</td>";
                                    echo "<td class='px-4 py-3 text-sm text-gray-700'>".$row['nama_produk']."</td>";
                                    echo "<td class='px-4 py-3 text-sm text-gray-700'>".$row['jumlah']."</td>";
                                    echo "<td class='px-4 py-3 text-sm text-gray-700'>";
                                    echo $row['status_dihapus'] == 1 ? "<span class='px-2 py-1 text-red-700 bg-red-100 rounded-full text-sm'>Dibatalkan</span>" : "<span class='px-2 py-1 text-green-700 bg-green-100 rounded-full text-sm'>Selesai</span>";
                                    echo "</td>";
                                    echo "</tr>";
                                    $no++;  
                                }
                            } else {
                                echo "<tr><td colspan='7' class='px-4 py-3 text-sm text-gray-700 text-center'>Tidak ada data</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' class='px-4 py-3 text-sm text-gray-700 text-center'>Silahkan pilih filter terlebih dahulu</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- Print Options -->
            <div class="mt-6 flex flex-wrap gap-4 justify-end">
                <?php if(isset($_GET['filter'])): ?>
                <a href="cetak.php?<?php 
                    $params = array();
                    if(!empty($_GET['tanggal_awal'])) $params['tanggal_awal'] = $_GET['tanggal_awal'];
                    if(!empty($_GET['tanggal_akhir'])) $params['tanggal_akhir'] = $_GET['tanggal_akhir'];
                    if(!empty($_GET['month'])) $params['month'] = $_GET['month'];
                    if(!empty($_GET['year'])) $params['year'] = $_GET['year'];
                    if(!empty($_GET['year_only'])) $params['year_only'] = $_GET['year_only'];
                    if(!empty($_GET['pelanggan'])) $params['pelanggan'] = $_GET['pelanggan'];
                    if(isset($_GET['status'])) $params['status'] = $_GET['status'];
                    if(isset($_GET['tipe_filter'])) $params['tipe_filter'] = $_GET['tipe_filter'];
                    echo http_build_query($params);
                ?>" target="_blank" 
                class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg transition duration-200 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak Laporan
                </a>
                <?php endif; ?>
            </div>

        </div>
    </div>




<?php include ('../../layout/footer.php'); ?>