<?php
    $judul_halaman = "Print Laporan Stok";
    
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
            <h1 class="title">LAPORAN PEMBELIAN</h1>
            <h2 class="subtitle">TOKO DAFA TANI</h2>
            <?php if(isset($_GET['kategori']) || isset($_GET['status'])): ?>
                <div class="period">
                    <?php if(!empty($_GET['kategori'])): ?>
                        <?php 
                            $kategori_query = mysqli_query($koneksi, "SELECT nama_kategori FROM kategori WHERE id_kategori = '".$_GET['kategori']."'");
                            $kategori_data = mysqli_fetch_assoc($kategori_query);
                        ?>
                        <p>Kategori: <?php echo $kategori_data['nama_kategori']; ?></p>
                    <?php endif; ?>
                    <?php if(!empty($_GET['status'])): ?>
                        <p>Status: <?php echo $_GET['status'] == 'minimum' ? 'Stok Minimum' : 'Stok Aman'; ?></p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>

        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Produk</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Satuan</th>
                    <th>Harga Beli</th>
                    <th>Harga Jual</th>
                    <th>Stok</th>
                    <th>Stok Minimum</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(isset($_GET['kategori']) || isset($_GET['status'])) {
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
                
                    if (!$result) {
                        die("Query error: " . mysqli_error($koneksi));
                    }

                    $no = 1;

                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $status = ($row['stok'] <= $row['stok_minimum']) ? 'Stok Minimum' : 'Stok Aman';
                            echo "<tr>";
                            echo "<td>$no</td>";
                            echo "<td>".$row['kode_produk']."</td>";
                            echo "<td>".$row['nama_produk']."</td>";
                            echo "<td>".$row['nama_kategori']."</td>";
                            echo "<td>".$row['nama_satuan']."</td>";
                            echo "<td>Rp ".number_format($row['harga_beli'],0,',','.')."</td>";
                            echo "<td>Rp ".number_format($row['harga_jual'],0,',','.')."</td>";
                            echo "<td>".$row['stok']."</td>";
                            echo "<td>".$row['stok_minimum']."</td>";
                            echo "<td>".$status."</td>";
                            echo "</tr>";
                            $no++;
                        }
                    } else {
                        echo "<tr><td colspan='10' style='text-align: center;'>Tidak ada data</td></tr>";
                    }
                } else {
                    echo "<tr><td colspan='10' style='text-align: center;'>Silahkan pilih filter terlebih dahulu</td></tr>";
                }
                ?>
            </tbody>
        </table>
        
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