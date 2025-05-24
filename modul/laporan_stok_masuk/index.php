<?php
    $judul_halaman = "Laporan Stok Masuk";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <div class="p-6 animate-fade-in">
        <div class="bg-gradient-to-br from-white to-stone-100 rounded-2xl shadow-lg p-8 animate-scale hover:shadow-xl transition-all duration-300">
            <h2 class="text-3xl font-bold mb-8 text-green-700 border-b-2 border-green-200 pb-4 flex items-center gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Laporan Stok Masuk
            </h2>

            <!-- Enhanced Filter Form -->
            <form action="" method="GET" class="mb-8">
                <div class="bg-gradient-to-r from-green-50 to-green-100 p-6 rounded-3xl shadow-lg">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kolom Kiri -->
                        <div class="bg-white p-5 rounded-2xl shadow-inner">
                            <h3 class="text-2xl font-bold text-green-800 mb-4 border-b pb-2">Filter Data</h3>
                            
                            <!-- Pilihan Rentang Tanggal -->
                            <div class="mb-6">
                                <div class="flex flex-wrap gap-4">
                                    <label class="flex-1 bg-green-50 p-4 rounded-lg cursor-pointer hover:bg-green-100 transition">
                                        <input type="radio" name="tipe_filter" value="tanggal" class="hidden peer" checked>
                                        <div class="flex items-center peer-checked:text-green-700">
                                            <span class="material-icons mr-2"></span>
                                            <span>Rentang Tanggal</span>
                                        </div>
                                    </label>
                                    <label class="flex-1 bg-green-50 p-4 rounded-lg cursor-pointer hover:bg-green-100 transition">
                                        <input type="radio" name="tipe_filter" value="bulan" class="hidden peer">
                                        <div class="flex items-center peer-checked:text-green-700">
                                            <span class="material-icons mr-2"></span>
                                            <span>Bulan</span>
                                        </div>
                                    </label>
                                    <label class="flex-1 bg-green-50 p-4 rounded-lg cursor-pointer hover:bg-green-100 transition">
                                        <input type="radio" name="tipe_filter" value="tahun" class="hidden peer">
                                        <div class="flex items-center peer-checked:text-green-700">
                                            <span class="material-icons mr-2"></span>
                                            <span>Tahun</span>
                                        </div>
                                    </label>
                                </div>
                            </div>

                            <!-- Bagian Filter Dinamis -->
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

                        <!-- Kolom Kanan -->
                        <div class="space-y-6">
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
                                            <span class="material-icons mr-2"></span>
                                            <span>Terapkan</span>
                                        </div>
                                    </button>
                                    <button type="reset" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-700 py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-105">
                                        <div class="flex items-center justify-center">
                                            <span class="material-icons mr-2"></span>
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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">No Invoice</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Supplier</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Nama Produk</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Harga Beli</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        <?php
                        if(isset($_GET['filter'])) {
                            $where = "1=1";
                            
                            if(!empty($_GET['tanggal_awal']) && !empty($_GET['tanggal_akhir'])) {
                                $tgl_awal = mysqli_real_escape_string($koneksi, $_GET['tanggal_awal'] . ' 00:00:00');
                                $tgl_akhir = mysqli_real_escape_string($koneksi, $_GET['tanggal_akhir'] . ' 23:59:59');
                                $where .= " AND sm.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'";
                            }
                            
                            if(!empty($_GET['month']) && !empty($_GET['year'])) {
                                $month = mysqli_real_escape_string($koneksi, $_GET['month']);
                                $year = mysqli_real_escape_string($koneksi, $_GET['year']);
                                $where .= " AND MONTH(sm.tanggal) = '$month' AND YEAR(sm.tanggal) = '$year'";
                            }

                            if(!empty($_GET['year_only'])) {
                                $year_only = mysqli_real_escape_string($koneksi, $_GET['year_only']);
                                $where .= " AND YEAR(sm.tanggal) = '$year_only'";
                            }

                            if(isset($_GET['status']) && $_GET['status'] !== '') {
                                $status = mysqli_real_escape_string($koneksi, $_GET['status']);
                                $where .= " AND sm.status_dihapus = '$status'";
                            }

                            $query = "SELECT sm.tanggal, sm.status_dihapus, sm.no_invoice, sm.nama_supplier,
                                    p.nama_produk, dsm.jumlah, dsm.harga_beli
                                    FROM stok_masuk sm
                                    JOIN detail_stok_masuk dsm ON sm.id_stok_masuk = dsm.id_stok_masuk
                                    JOIN produk p ON dsm.id_produk = p.id_produk
                                    WHERE $where 
                                    ORDER BY sm.id_stok_masuk DESC, sm.tanggal DESC";

                            $result = mysqli_query($koneksi, $query);
                            
                            if (!$result) {
                                die("Query error: " . mysqli_error($koneksi));
                            }

                            $no = 1;
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr class='hover:bg-stone-50'>";
                                    echo "<td class='px-6 py-4 text-sm text-gray-700'>$no</td>";
                                    echo "<td class='px-6 py-4 text-sm text-gray-700'>".date('d-m-Y H:i', strtotime($row['tanggal']))."</td>";
                                    echo "<td class='px-6 py-4 text-sm text-gray-700'>".$row['no_invoice']."</td>";
                                    echo "<td class='px-6 py-4 text-sm text-gray-700'>".$row['nama_supplier']."</td>";
                                    echo "<td class='px-6 py-4 text-sm text-gray-700'>".$row['nama_produk']."</td>";
                                    echo "<td class='px-6 py-4 text-sm text-gray-700'>".$row['jumlah']."</td>";
                                    echo "<td class='px-6 py-4 text-sm text-gray-700'>Rp ".number_format($row['harga_beli'], 0, ',', '.')."</td>";
                                    echo "<td class='px-6 py-4'>";
                                    echo $row['status_dihapus'] == 1 
                                        ? "<span class='px-3 py-1 text-red-700 bg-red-100 rounded-full text-xs font-medium'>Dibatalkan</span>" 
                                        : "<span class='px-3 py-1 text-green-700 bg-green-100 rounded-full text-xs font-medium'>Selesai</span>";
                                    echo "</td>";
                                    echo "</tr>";
                                    $no++;
                                }
                            } else {
                                echo "<tr><td colspan='8' class='px-6 py-4 text-center text-sm text-gray-700'>Tidak ada data</td></tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='px-6 py-4 text-center text-sm text-gray-700'>Silakan terapkan filter untuk melihat data</td></tr>";
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


<?php include ('../../layout/footer.php'); ?>