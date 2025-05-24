<?php 
$judul_halaman = "Dashboard";
include 'cek_login.php'; 
?>

<!-- header -->
<?php include 'layout/header.php'; ?>

<!-- Sidebar -->
<?php include 'layout/sidebar.php'; ?>


        <!-- Content -->
        <div class="p-4 md:p-6 animate-slide-fade">
          <h1 class="text-xl md:text-2xl font-bold mb-4 animate-slide-fade flex items-center gap-2">
            <span class="text-green-600">🌾</span>
            Dashboard Toko Dafa Tani
            <span class="text-xs md:text-sm ml-2 font-normal text-gray-500 animate-pulse">Sahabat Petani Modern</span>
          </h1>          

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
            <!-- Dashboard cards with responsive sizing -->
            <div class="bg-white p-3 md:p-4 rounded-lg shadow-md border-l-4 border-green-500 animate-scale">
              <h3 class="text-gray-500 text-xs md:text-sm">Total Penjualan Hari Ini</h3>
              <?php
                $today = date('Y-m-d');
                $query = mysqli_query($koneksi, "SELECT SUM(total) as total FROM penjualan WHERE DATE(tanggal)='$today' AND status_dihapus=0");
                $data = mysqli_fetch_assoc($query);
              ?>
              <p class="text-xl md:text-2xl font-bold">Rp <?= number_format($data['total'],0,',','.') ?></p>
            </div>
            <div class="bg-white p-3 md:p-4 rounded-lg shadow-md border-l-4 border-blue-500 animate-scale">
              <h3 class="text-gray-500 text-xs md:text-sm">Total Produk</h3>
              <?php
                $query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM produk WHERE status_dihapus=0");
                $data = mysqli_fetch_assoc($query);
              ?>
              <p class="text-xl md:text-2xl font-bold"><?= $data['total'] ?></p>
            </div>
            <div class="bg-white p-3 md:p-4 rounded-lg shadow-md border-l-4 border-yellow-500 animate-scale">
              <h3 class="text-gray-500 text-xs md:text-sm">Stok Masuk Hari Ini</h3>
              <?php
                $query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM stok_masuk WHERE DATE(tanggal)='$today' AND status_dihapus=0");
                $data = mysqli_fetch_assoc($query);
              ?>
              <p class="text-xl md:text-2xl font-bold"><?= $data['total'] ?></p>
            </div>
            <div class="bg-white p-3 md:p-4 rounded-lg shadow-md border-l-4 border-red-500 animate-scale">
              <h3 class="text-gray-500 text-xs md:text-sm">Produk Stok < Minimum</h3>
              <?php
                $query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM produk WHERE stok <= stok_minimum AND status_dihapus=0");
                $data = mysqli_fetch_assoc($query);
              ?>
              <p class="text-xl md:text-2xl font-bold"><?= $data['total'] ?></p>
            </div>
          </div>
          
          <?php if ($sesi_peran_pengguna == "pemilik" || $sesi_peran_pengguna == "admin") { ?>
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 md:gap-4 mb-6">
            <!-- Dashboard cards with responsive sizing -->
            <div class="bg-white p-3 md:p-4 rounded-lg shadow-md border-l-4 border-green-500 animate-scale">
              <h3 class="text-gray-500 text-xs md:text-sm">Total Pengguna</h3>
              <?php
                $query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pengguna WHERE status_dihapus=0");
                $data = mysqli_fetch_assoc($query);
              ?>
              <p class="text-xl md:text-2xl font-bold"><?= $data['total'] ?></p>
            </div>
            <div class="bg-white p-3 md:p-4 rounded-lg shadow-md border-l-4 border-blue-500 animate-scale">
              <h3 class="text-gray-500 text-xs md:text-sm">Total Pelanggan</h3>
              <?php
                $query = mysqli_query($koneksi, "SELECT COUNT(*) as total FROM pelanggan WHERE status_dihapus=0");
                $data = mysqli_fetch_assoc($query);
              ?>
              <p class="text-xl md:text-2xl font-bold"><?= $data['total'] ?></p>
            </div>
            <div class="bg-white p-3 md:p-4 rounded-lg shadow-md border-l-4 border-yellow-500 animate-scale">
              <h3 class="text-gray-500 text-xs md:text-sm">Penjualan Bulan Ini</h3>
              <?php
                $bulan = date('Y-m');
                $query = mysqli_query($koneksi, "SELECT SUM(total) as total FROM penjualan WHERE DATE_FORMAT(tanggal, '%Y-%m')='$bulan' AND status_dihapus=0");
                $data = mysqli_fetch_assoc($query);
              ?>
              <p class="text-xl md:text-2xl font-bold">Rp <?= number_format($data['total'],0,',','.') ?></p>
            </div>
            <div class="bg-white p-3 md:p-4 rounded-lg shadow-md border-l-4 border-red-500 animate-scale">
              <h3 class="text-gray-500 text-xs md:text-sm">Penjualan Tahun Ini</h3>
              <?php
                $tahun = date('Y');
                $query = mysqli_query($koneksi, "SELECT SUM(total) as total FROM penjualan WHERE YEAR(tanggal)='$tahun' AND status_dihapus=0");
                $data = mysqli_fetch_assoc($query);
              ?>
              <p class="text-xl md:text-2xl font-bold">Rp <?= number_format($data['total'],0,',','.') ?></p>
            </div>
          </div>
          <?php } ?>

          <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
            <div class="bg-white p-3 md:p-4 rounded-lg shadow-md animate-smooth">
              <h2 class="text-base md:text-lg font-semibold mb-3 md:mb-4">Penjualan Terakhir</h2>
              <div class="overflow-x-auto">
                <table class="w-full text-xs md:text-sm">
                  <thead>
                    <tr class="bg-gray-50">
                      <th class="px-4 py-2">No Faktur</th>
                      <th class="px-4 py-2">Pelanggan</th>
                      <th class="px-4 py-2">Total</th>
                      <th class="px-4 py-2">Tanggal</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      $query = mysqli_query($koneksi, "SELECT p.*, pl.nama_pelanggan 
                        FROM penjualan p 
                        LEFT JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
                        WHERE p.status_dihapus=0 
                        ORDER BY p.tanggal DESC LIMIT 5");
                      while($row = mysqli_fetch_assoc($query)) {
                    ?>
                    <tr class="border-t">
                      <td class="px-4 py-2"><?= $row['no_faktur_penjualan'] ?></td>
                      <td class="px-4 py-2"><?= $row['nama_pelanggan'] ?></td>
                      <td class="px-4 py-2">Rp <?= number_format($row['total'],0,',','.') ?></td>
                      <td class="px-4 py-2"><?= date('d/m/Y H:i', strtotime($row['tanggal'])) ?></td>
                    </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            </div>
            
            <?php if ($sesi_peran_pengguna == "pemilik" || $sesi_peran_pengguna == "admin") { ?>

            <div class="bg-white p-3 md:p-4 rounded-lg shadow-md animate-smooth">
              <h2 class="text-base md:text-lg font-semibold mb-3 md:mb-4">Grafik Penjualan Per Bulan</h2>
              <div class="w-full">
                <canvas id="salesChart"></canvas>
              </div>
              <?php
                $tahun = date('Y');
                $query = mysqli_query($koneksi, "SELECT 
                    DATE_FORMAT(tanggal, '%m') as bulan,
                    DATE_FORMAT(tanggal, '%M') as nama_bulan,
                    SUM(total) as total_penjualan
                    FROM penjualan 
                    WHERE YEAR(tanggal) = '$tahun'
                    AND status_dihapus = 0
                    GROUP BY DATE_FORMAT(tanggal, '%m')
                    ORDER BY bulan ASC");
                
                $labels = [];
                $data = [];
                
                while($row = mysqli_fetch_assoc($query)) {
                    $labels[] = $row['nama_bulan'];
                    $data[] = $row['total_penjualan'];
                }
              ?>
              <script>
                const ctx = document.getElementById('salesChart');
                new Chart(ctx, {
                  type: 'bar',
                  data: {
                    labels: <?= json_encode($labels) ?>,
                    datasets: [{
                      label: 'Total Penjualan',
                      data: <?= json_encode($data) ?>,
                      backgroundColor: 'rgba(54, 162, 235, 0.5)',
                      borderColor: 'rgba(54, 162, 235, 1)',
                      borderWidth: 1
                    }]
                  },
                  options: {
                    responsive: true,
                    scales: {
                      y: {
                        beginAtZero: true,
                        ticks: {
                          callback: function(value) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                          }
                        }
                      }
                    },
                    plugins: {
                      tooltip: {
                        callbacks: {
                          label: function(context) {
                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.raw);
                          }
                        }
                      }
                    }
                  }
                });
              </script>
            </div>
            <?php } ?>
          </div>
        </div>
<!-- footer -->
<?php include 'layout/footer.php'; ?>