<?php
    $judul_halaman = "Detail Stok Masuk";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

<!-- Content -->
<div class="p-6 animate-slide-fade">
    <div class="bg-stone-100 rounded-lg shadow-md p-6 animate-scale">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">Detail Stok Masuk</h2>
        
        <?php
        
        if(isset($_GET['id'])) {
            $id_stok_masuk = $_GET['id'];
            $query = "SELECT sm.*, p.nama_pengguna FROM stok_masuk sm 
                     LEFT JOIN pengguna p ON sm.id_pengguna = p.id_pengguna 
                     WHERE sm.id_stok_masuk = ?";
            $stmt = $koneksi->prepare($query);
            $stmt->bind_param("i", $id_stok_masuk);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if($result->num_rows > 0) {
                $data = $result->fetch_assoc();
        ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 animate-smooth">
                    <div class="space-y-4">
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">No. Invoice</label>
                            <?php if($data['status_dihapus'] == 1): ?>
                                <span class="inline-block mt-2 px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm font-semibold">
                                    <i class="fas fa-times-circle mr-1"></i> Dibatalkan
                                </span>
                            <?php else: ?>
                                <span class="inline-block mt-2 px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-semibold">
                                    <i class="fas fa-check-circle mr-1"></i> Selesai
                                </span>
                            <?php endif; ?>                            
                            <p class="text-green-600 mt-1"><?php echo $data['no_invoice']; ?></p>
                        </div>
                        
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">Nama Supplier</label>
                            <p class="text-green-600 mt-1"><?php echo $data['nama_supplier'] ?: '-'; ?></p>
                        </div>                        
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">Tanggal</label>
                            <p class="text-green-600 mt-1"><?php echo $data['tanggal'] ?></p>
                        </div>
                        <div class="bg-white p-4 rounded-lg shadow-sm">
                            <label class="text-gray-700 font-medium">Dibuat Oleh</label>
                            <p class="text-green-600 mt-1"><?php echo $data['nama_pengguna']; ?></p>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <h3 class="text-xl font-bold text-gray-700 mb-4">Detail Produk</h3>
                    <div class="bg-white rounded-lg shadow-sm overflow-x-auto">
                        <table class="w-full table-auto">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left">Nama Produk</th>
                                    <th class="px-4 py-2 text-right">Jumlah</th>
                                    <th class="px-4 py-2 text-right">Harga Beli</th>
                                    <th class="px-4 py-2 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query_detail = "SELECT dsm.*, p.nama_produk 
                                               FROM detail_stok_masuk dsm
                                               LEFT JOIN produk p ON dsm.id_produk = p.id_produk
                                               WHERE dsm.id_stok_masuk = ?";
                                $stmt_detail = $koneksi->prepare($query_detail);
                                $stmt_detail->bind_param("i", $id_stok_masuk);
                                $stmt_detail->execute();
                                $result_detail = $stmt_detail->get_result();
                                $total = 0;

                                while($detail = $result_detail->fetch_assoc()) {
                                    $subtotal = $detail['jumlah'] * $detail['harga_beli'];
                                    $total += $subtotal;
                                ?>
                                <tr class="border-t">
                                    <td class="px-4 py-2"><?php echo $detail['nama_produk']; ?></td>
                                    <td class="px-4 py-2 text-right"><?php echo number_format($detail['jumlah']); ?></td>
                                    <td class="px-4 py-2 text-right"><?php echo number_format($detail['harga_beli'], 2); ?></td>
                                    <td class="px-4 py-2 text-right"><?php echo number_format($subtotal, 2); ?></td>
                                </tr>
                                <?php } ?>
                                <tr class="border-t font-bold bg-gray-50">
                                    <td colspan="3" class="px-4 py-2 text-right">Total</td>
                                    <td class="px-4 py-2 text-right"><?php echo number_format($total, 2); ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <?php if ($data['status_dihapus'] == 0) { ?>
                    <a href="edit.php?id=<?php echo $id_stok_masuk; ?>" class="bg-green-700 hover:bg-green-800 text-white px-4 py-2 rounded-lg transition duration-300">
                        Edit Data
                    </a>
                    <?php } ?>
                    <a href="index.php" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg transition duration-300">
                        Kembali
                    </a>
                </div>
        <?php
            } else {
                echo "<script>window.location.href = '" . base_url('404.php') . "';</script>";
                exit;            
            }
        } else {
            echo '<div class="bg-yellow-500 text-white p-4 rounded-lg">ID stok masuk tidak valid.</div>';
        }
        ?>
    </div>
</div>


<?php include ('../../layout/footer.php'); ?>