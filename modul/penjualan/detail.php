<?php
    $judul_halaman = "Detail Penjualan";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

    <!-- Main Content Area -->
    <div class="p-6 bg-white">
        <?php
            $id_penjualan = $_GET['id'];
            
            // Get penjualan data
            $query = "SELECT p.*, pl.nama_pelanggan, pl.alamat, u.nama_lengkap
                     FROM penjualan p 
                     LEFT JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan 
                     JOIN pengguna u ON p.id_pengguna = u.id_pengguna 
                     WHERE p.id_penjualan = $id_penjualan";
            $result = mysqli_query($koneksi, $query);
            $penjualan = mysqli_fetch_assoc($result);

            if (mysqli_num_rows($result) == 0) {
                echo "<script>window.location.href='" . base_url('404.php') . "';</script>";
                exit;
            }        
        ?>
        
        <div class="max-w-sm mx-auto bg-white p-2" id="printArea">
            <!-- Header -->
            <div class="text-center mb-4">
                <h1 class="text-base font-bold mb-2">TOKO DAFA TANI</h1>
                <p class="text-xs mb-1">Jln. Alahan Panjang - Solok</p>
                <p class="text-xs mb-2">Telp: 081290098989</p>
                <div class="border-b border-gray-300 my-2"></div>
            </div>

            <div class="text-xs mb-3">
                <div class="grid grid-cols-2 gap-2">
                    <p>No: <?php echo $penjualan['no_faktur_penjualan']; ?></p>
                    <p>Kasir: <?php echo $penjualan['nama_lengkap']; ?></p>
                    <p>Tgl: <?php echo date('d/m/Y', strtotime($penjualan['tanggal'])); ?></p>
                    <?php if($penjualan['id_pelanggan']) { ?>
                    <p>Plg: <?php echo $penjualan['nama_pelanggan']; ?></p>
                    <?php } ?>
                </div>
            </div>

            <div class="border-b border-gray-300 my-2"></div>

            <!-- Items -->
            <?php
                $subtotal = 0;
                $query_detail = "SELECT dp.*, b.nama_produk 
                               FROM detail_penjualan dp 
                               JOIN produk b ON dp.id_produk = b.id_produk 
                               WHERE dp.id_penjualan = $id_penjualan";
                $result_detail = mysqli_query($koneksi, $query_detail);
                while($row = mysqli_fetch_assoc($result_detail)) {
            ?>
            <div class="text-xs mb-3">
                <p class="font-bold mb-1"><?php echo $row['nama_produk']; ?></p>
                <div class="flex justify-between">
                    <p><?php echo $row['jumlah'] . 'x Rp.' . number_format($row['harga'], 0, ',', '.'); ?></p>
                    <p>Rp.<?php echo number_format($row['subtotal'], 0, ',', '.'); ?></p>
                </div>
            </div>
            <?php 
            $subtotal += $row['subtotal'];
            } ?>

            <div class="border-b border-gray-300 my-2"></div>

            <!-- Totals -->
            <div class="text-xs mb-3">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <p>Total:</p>
                        <p>Rp.<?php echo number_format($penjualan['total'], 0, ',', '.'); ?></p>
                    </div>
                    <div class="flex justify-between">
                        <p>Disk(<?php echo number_format($penjualan['diskon'], 2) ?>%):</p>
                        <p>Rp.<?php echo number_format(($penjualan['diskon'] / 100) * $penjualan['total'], 0, ',', '.'); ?></p>
                    </div>
                    <div class="flex justify-between font-bold">
                        <p>Total Bayar:</p>
                        <p>Rp.<?php echo number_format($penjualan['total'] - (($penjualan['diskon'] / 100) * $penjualan['total']), 0, ',', '.'); ?></p>
                    </div>
                    <div class="flex justify-between">
                        <p>Bayar:</p>
                        <p>Rp.<?php echo number_format($penjualan['bayar'], 0, ',', '.'); ?></p>
                    </div>
                    <div class="flex justify-between font-bold">
                        <p>Kembali:</p>
                        <p>Rp.<?php echo number_format($penjualan['kembalian'], 0, ',', '.'); ?></p>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="text-center mt-4 text-xs">
                <p class="font-bold mb-1">Terima Kasih</p>
                <p>Atas Kunjungan Anda</p>
                <p>Barang yang sudah dibeli tidak dapat dikembalikan</p>
            </div>

            <?php if($penjualan['status_dihapus'] == 1): ?>
            <div class="text-center text-xs font-bold mt-4 border border-black p-2">
                <p class="mb-1">STRUK TIDAK BERLAKU</p>
                <p>BELANJA DIBATALKAN</p>
            </div>
            <?php endif; ?>
            
        </div>
        <style>
            @media print {
                body * {
                    visibility: hidden;
                }
                #printArea, #printArea * {
                    visibility: visible;
                }
                #printArea {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 80mm;
                    margin: 0;
                    padding: 5mm;
                    box-sizing: border-box;
                }
                @page {
                    size: 80mm auto;
                    margin: 0;
                    padding: 0;
                }
                * {
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }
            }
        </style>

        <script>
            window.onload = function() {
                window.print();
                setTimeout(function() {
                    window.close();
                }, 1000);
            };
        </script>
    </div>

<?php include ('../../layout/footer.php'); ?>