<?php
    $judul_halaman = "Print Laporan Penjualan";
    
    include '../../cek_login.php';
?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <title><?= $judul_utama ?></title>
        <style>
            @media print {
                body {
                    margin: 0;
                    padding: 2mm;
                    font-family: Arial, sans-serif;
                }
                @page {
                    size: landscape;
                    margin: 10mm;
                }
                .no-print {
                    display: none;
                }
            }
            body {
                font-family: Arial, sans-serif;
                background: white;
            }
            .header {
                text-align: center;
                margin-bottom: 30px;
                border-bottom: 2px solid #000;
                padding-bottom: 20px;
            }
            .title {
                font-size: 24px;
                font-weight: bold;
                margin: 0;
                padding: 0;
            }
            .subtitle {
                font-size: 20px;
                margin: 10px 0;
            }
            .period {
                font-size: 14px;
                color: #333;
            }
            table {
                width: 100%;
                border-collapse: collapse;
                margin: 20px 0;
            }
            th, td {
                border: 1px solid #000;
                padding: 8px;
                text-align: left;
                font-size: 12px;
            }
            th {
                background-color: #f0f0f0;
            }
            .footer {
                text-align: center;
                width: 280px;
                float: right;
            }
            .signature {
                margin-top: 10px;
                text-align: center;
            }
            .signature-line {
                width: 200px;
                margin-top: 80px;
            }
            .status-batal {
                color: #dc2626;
                font-weight: bold;
            }
            .status-selesai {
                color: #059669;
                font-weight: bold;
            }
        </style>
        <script>
            window.onload = function() {
                window.print();
            }
        </script>
    </head>
    <body>
        <div class="header">
            <h1 class="title">LAPORAN PENJUALAN</h1>
            <h2 class="subtitle">TOKO DAFA TANI</h2>
            <?php if(isset($_GET['tipe_filter'])): ?>
                <div class="period">
                    <?php if($_GET['tipe_filter'] == 'tanggal' && !empty($_GET['tanggal_awal']) && !empty($_GET['tanggal_akhir'])): ?>
                        <p>Periode: <?php echo date('d/m/Y', strtotime($_GET['tanggal_awal'])) . ' - ' . date('d/m/Y', strtotime($_GET['tanggal_akhir'])); ?></p>
                    <?php endif; ?>
                    <?php if($_GET['tipe_filter'] == 'bulan' && !empty($_GET['month']) && !empty($_GET['year'])): ?>
                    <?php
                    $bulan = array(
                        'January' => 'Januari',
                        'February' => 'Februari',
                        'March' => 'Maret',
                        'April' => 'April',
                        'May' => 'Mei',
                        'June' => 'Juni',
                        'July' => 'Juli',
                        'August' => 'Agustus',
                        'September' => 'September',
                        'October' => 'Oktober',
                        'November' => 'November',
                        'December' => 'Desember'
                    );
                    $periode = date('F Y', strtotime($_GET['year'].'-'.$_GET['month'].'-01'));
                    $bulan_indo = $bulan[date('F', strtotime($_GET['year'].'-'.$_GET['month'].'-01'))];
                    ?>
                    <p>Periode: <?php echo $bulan_indo . ' ' . date('Y', strtotime($_GET['year'].'-'.$_GET['month'].'-01')); ?></p>                    <?php endif; ?>
                    <?php if($_GET['tipe_filter'] == 'tahun' && !empty($_GET['year_only'])): ?>
                        <p>Tahun: <?php echo $_GET['year_only']; ?></p>
                    <?php endif; ?>
                    <?php if(!empty($_GET['pelanggan'])): ?>
                        <?php 
                            $pelanggan_query = mysqli_query($koneksi, "SELECT nama_pelanggan FROM pelanggan WHERE id_pelanggan = '".$_GET['pelanggan']."'");
                            $pelanggan_data = mysqli_fetch_assoc($pelanggan_query);
                        ?>
                        <p>Pelanggan: <?php echo $pelanggan_data['nama_pelanggan']; ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>No Faktur</th>
                    <th>Pelanggan</th>
                    <th>No HP</th>
                    <th>Alamat</th>
                    <th>Kasir</th>
                    <th>Nama Produk</th>
                    <th>Kode Produk</th>
                    <th>Jumlah</th>
                    <th>Harga Jual</th>
                    <th>Harga Beli</th>
                    <th>Subtotal</th>
                    <th>Modal Total</th>
                    <th>Keuntungan</th>
                    <th>Total</th>
                    <th>Diskon</th>
                    <th>Bayar</th>
                    <th>Kembalian</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(isset($_GET['tipe_filter'])) {
                    $where = "1=1";

                    if($_GET['tipe_filter'] == 'tanggal' && !empty($_GET['tanggal_awal']) && !empty($_GET['tanggal_akhir'])) {
                        $tgl_awal = mysqli_real_escape_string($koneksi, $_GET['tanggal_awal']) . ' 00:00:00';
                        $tgl_akhir = mysqli_real_escape_string($koneksi, $_GET['tanggal_akhir']) . ' 23:59:59';
                        $where .= " AND p.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'";
                    }

                    if($_GET['tipe_filter'] == 'bulan' && !empty($_GET['month']) && !empty($_GET['year'])) {
                        $month = mysqli_real_escape_string($koneksi, $_GET['month']);
                        $year = mysqli_real_escape_string($koneksi, $_GET['year']);
                        $where .= " AND MONTH(p.tanggal) = '$month' AND YEAR(p.tanggal) = '$year'";
                    }

                    if($_GET['tipe_filter'] == 'tahun' && !empty($_GET['year_only'])) {
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

                    $query = "SELECT 
                            p.tanggal, 
                            p.status_dihapus, 
                            p.no_faktur_penjualan,
                            p.total,
                            p.diskon,
                            p.bayar,
                            p.kembalian,
                            pl.nama_pelanggan,
                            pl.no_hp,
                            pl.alamat,
                            pn.nama_lengkap as nama_kasir,
                            pr.nama_produk,
                            pr.kode_produk,
                            dp.jumlah,
                            pr.harga_jual,
                            pr.harga_beli,
                            dp.subtotal,
                            (dp.jumlah * pr.harga_beli) as total_modal,
                            (dp.subtotal - (dp.jumlah * pr.harga_beli)) as keuntungan
                            FROM penjualan p
                            JOIN detail_penjualan dp ON p.id_penjualan = dp.id_penjualan
                            JOIN pelanggan pl ON p.id_pelanggan = pl.id_pelanggan
                            JOIN pengguna pn ON p.id_pengguna = pn.id_pengguna
                            JOIN produk pr ON dp.id_produk = pr.id_produk
                            WHERE $where
                            ORDER BY p.tanggal DESC, p.id_penjualan DESC";

                    $result = mysqli_query($koneksi, $query);
                
                    if (!$result) {
                        die("Query error: " . mysqli_error($koneksi));
                    }

                    $no = 1;
                    $total_penjualan = 0;
                    $total_modal = 0;
                    $total_keuntungan = 0;
                    $total_diskon = 0;

                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>$no</td>";
                            echo "<td>".date('d-m-Y', strtotime($row['tanggal']))."</td>";
                            echo "<td>".$row['no_faktur_penjualan']."</td>";
                            echo "<td>".$row['nama_pelanggan']."</td>";
                            echo "<td>".$row['no_hp']."</td>";
                            echo "<td>".$row['alamat']."</td>";
                            echo "<td>".$row['nama_kasir']."</td>";
                            echo "<td>".$row['nama_produk']."</td>";
                            echo "<td>".$row['kode_produk']."</td>";
                            echo "<td>".$row['jumlah']."</td>";
                            echo "<td>Rp ".number_format($row['harga_jual'],0,',','.')."</td>";
                            echo "<td>Rp ".number_format($row['harga_beli'],0,',','.')."</td>";
                            echo "<td>Rp ".number_format($row['subtotal'],0,',','.')."</td>";
                            echo "<td>Rp ".number_format($row['total_modal'],0,',','.')."</td>";
                            echo "<td>Rp ".number_format($row['keuntungan'],0,',','.')."</td>";
                            echo "<td>Rp ".number_format($row['total'],0,',','.')."</td>";
                            echo "<td>Rp ".number_format(($row['subtotal'] * $row['diskon'] / 100),0,',','.')."</td>";                            echo "<td>Rp ".number_format($row['bayar'],0,',','.')."</td>";
                            echo "<td>Rp ".number_format($row['kembalian'],0,',','.')."</td>";
                            echo "<td>";
                            echo $row['status_dihapus'] == 1 ? "<span class='status-batal'>Dibatalkan</span>" : "<span class='status-selesai'>Selesai</span>";
                            echo "</td>";
                            echo "</tr>";
                            
                            $total_penjualan += $row['subtotal'];
                            $total_modal += $row['total_modal'];
                            $total_keuntungan += $row['keuntungan'];
                            $total_diskon += ($row['subtotal'] * $row['diskon'] / 100);
                            
                            $no++;
                        }
                        echo "<tr class='summary-row'>";
                        echo "<td colspan='12' style='text-align: right;'><strong>Total:</strong></td>";
                        echo "<td><strong>Rp ".number_format($total_penjualan,0,',','.')."</strong></td>";
                        echo "<td><strong>Rp ".number_format($total_modal,0,',','.')."</strong></td>";
                        echo "<td><strong>Rp ".number_format($total_keuntungan,0,',','.')."</strong></td>";
                        echo "<td>-</td>";
                        echo "<td><strong>Rp ".number_format($total_diskon,0,',','.')."</strong></td>";
                        echo "<td colspan='3'></td>";
                        echo "</tr>";
                    } else {
                        echo "<tr><td colspan='20' style='text-align: center;'>Tidak ada data</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='20' style='text-align: center;'>Silahkan pilih filter terlebih dahulu</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <div class="footer">
            <p>Padang, 
                <?php 
                    $bulan = array(
                        'January' => 'Januari',
                        'February' => 'Februari',
                        'March' => 'Maret',
                        'April' => 'April',
                        'May' => 'Mei',
                        'June' => 'Juni',
                        'July' => 'Juli',
                        'August' => 'Agustus',
                        'September' => 'September',
                        'October' => 'Oktober', 
                        'November' => 'November',
                        'December' => 'Desember'
                    );
                    echo date('d ') . $bulan[date('F')] . date(' Y'); 
                ?>
            </p>            
            <div class="signature">
                <p>Alahan Panjang</p>
                <div class="signature-line"></div>
                <p>(____________________)</p>
            </div>
        </div>
    </body>
</html>