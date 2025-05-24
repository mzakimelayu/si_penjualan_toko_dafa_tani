<?php
    $judul_halaman = "Print Laporan Stok Masuk";
    
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
            <h1 class="title">LAPORAN STOK MASUK</h1>
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
                </div>
            <?php endif; ?>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>No Invoice</th>
                    <th>Nama Supplier</th>
                    <th>Nama Produk</th>
                    <th>Jumlah Masuk</th>
                    <th>Harga Beli</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(isset($_GET['tipe_filter'])) {
                    $where = "1=1";

                    if(!empty($_GET['tanggal_awal']) && !empty($_GET['tanggal_akhir'])) {
                        $tgl_awal = mysqli_real_escape_string($koneksi, $_GET['tanggal_awal'] . ' 00:00:00');
                        $tgl_akhir = mysqli_real_escape_string($koneksi, $_GET['tanggal_akhir'] . ' 23:59:59');
                        $where .= " AND sm.tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir'";
                    }

                    if($_GET['tipe_filter'] == 'bulan' && !empty($_GET['month']) && !empty($_GET['year'])) {
                        $month = mysqli_real_escape_string($koneksi, $_GET['month']);
                        $year = mysqli_real_escape_string($koneksi, $_GET['year']);
                        $where .= " AND MONTH(sm.tanggal) = '$month' AND YEAR(sm.tanggal) = '$year'";
                    }

                    if($_GET['tipe_filter'] == 'tahun' && !empty($_GET['year_only'])) {
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
                    $total_qty = 0;
                    $total_transaksi = 0;
                    $total_transaksi_selesai = 0;
                    $total_transaksi_batal = 0;
                    $faktur_selesai = array();
                    $faktur_batal = array();
                    
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            echo "<tr>";
                            echo "<td>$no</td>";
                            echo "<td>".date('d-m-Y', strtotime($row['tanggal']))."</td>";
                            echo "<td>".$row['no_invoice']."</td>";
                            echo "<td>".$row['nama_supplier']."</td>";
                            echo "<td>".$row['nama_produk']."</td>";
                            echo "<td>".$row['jumlah']."</td>";
                            echo "<td>Rp ".number_format($row['harga_beli'],0,',','.')."</td>";
                            echo "<td>";
                            echo $row['status_dihapus'] == 1 ? "<span class='status-batal'>Dibatalkan</span>" : "<span class='status-selesai'>Selesai</span>";
                            echo "</td>";
                            echo "</tr>";
                            
                            if($row['status_dihapus'] != 1) {
                                $total_qty += $row['jumlah'];
                                if(!in_array($row['no_invoice'], $faktur_selesai)) {
                                    $faktur_selesai[] = $row['no_invoice'];
                                    $total_transaksi_selesai++;
                                }
                            } else {
                                if(!in_array($row['no_invoice'], $faktur_batal)) {
                                    $faktur_batal[] = $row['no_invoice'];
                                    $total_transaksi_batal++;
                                }
                            }
                            $no++;
                        }
                        $total_transaksi = $total_transaksi_selesai + $total_transaksi_batal;
                        echo "</tbody>";
                        echo "</table>";
                        echo "<div class='summary-section'>";
                        echo "<h3>Ringkasan:</h3>";
                        echo "<p>Total Transaksi: " . number_format($total_transaksi) . " Transaksi</p>";
                        echo "<p>Total Transaksi Selesai: " . number_format($total_transaksi_selesai) . " Transaksi</p>";
                        echo "<p>Total Transaksi Dibatalkan: " . number_format($total_transaksi_batal) . " Transaksi</p>";
                        echo "<p>Total Barang Masuk: " . number_format($total_qty) . " unit</p>";
                        echo "</div>";                    
                    } else {
                        echo "<tr><td colspan='8' style='text-align: center;'>Tidak ada data</td></tr>";
                        echo "</tbody></table>";
                    }                
                } else {
                    echo "<tr><td colspan='8' style='text-align: center;'>Silahkan pilih filter terlebih dahulu</td></tr>";
                    echo "</tbody></table>";
                }
                ?>

        <div class="footer">
            <p>Alahan Panjang, 
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
                <p>Pemilik</p>
                <div class="signature-line"></div>
                <p>(____________________)</p>
            </div>
        </div>
    </body>
</html>