<?php
    $judul_halaman = "Tambah Penjualan Produk";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <div class="p-6 animate-fade-in animate-slide-fade animate-scale animate-smooth bg-stone-100">
        <div class="rounded-2xl shadow-xl p-8 animate-slide-fade animate-scale animate-smooth bg-white border-2 border-green-100">
            <h2 class="text-3xl font-bold text-green-700 mb-8 pb-4 border-b-2 border-green-200 flex items-center">
                <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
                Transaksi Penjualan Produk
            </h2>

            <?php
                if(isset($_SESSION['penjualan_eror'])) { ?>
                <div id="alert-message" class="mb-6 bg-red-50 border-l-4 border-red-500 text-red-700 p-5 rounded-lg animate-bounce flex justify-between items-center" role="alert">
                    <p class="font-medium flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <?php echo $_SESSION['penjualan_eror']; ?>
                    </p>
                    <button onclick="closeAlert()" class="text-red-700 hover:text-red-900 transition-colors">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </button>
                </div>
                <script>
                    setTimeout(() => document.getElementById('alert-message').style.display = 'none', 3000);
                    const closeAlert = () => document.getElementById('alert-message').style.display = 'none';
                </script>
            <?php 
            unset($_SESSION['penjualan_eror']);
            } 
            ?>

            <form id="formPenjualan" class="space-y-8" method="POST" action="proses_tambah.php">
                <div class="grid grid-cols-1 gap-8">
                    <div class="bg-stone-100 p-6 rounded-xl space-y-6 border-2 border-green-100">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="relative">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">No. Faktur <span class="text-yellow-500">*</span></label>
                                <?php
                                    $query = "SELECT MAX(SUBSTRING(no_faktur_penjualan, 6)) as max_number FROM penjualan";
                                    $result = mysqli_query($koneksi, $query);
                                    $row = mysqli_fetch_assoc($result);
                                    $last_number = $row['max_number'];
                                    
                                    $year = date('Y');
                                    $month = date('m');
                                    $day = date('d');
                                    $time = date('His');
                                    $random = rand(10,99);
                                    $next_number = str_pad(($last_number + 1), 4, '0', STR_PAD_LEFT);
                                    $no_faktur = "TD-" . $year . $month . $day . $time . $random;
                                ?>
                                <input type="text" id="noFaktur" name="no_faktur_penjualan" value="<?php echo $no_faktur; ?>" class="mt-1 block w-full rounded-xl border-2 border-green-200 bg-white px-4 py-3 focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none" readonly required>                            
                            </div>
                            
                            <div class="relative">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal Penjualan <span class="text-yellow-500">*</span></label>
                                <input type="datetime-local" id="tanggalPenjualan" name="tanggal" class="mt-1 block w-full rounded-xl border-2 border-green-200 bg-white px-4 py-3 focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none" required>
                                <script>
                                    const now = new Date();
                                    const year = now.getFullYear();
                                    const month = String(now.getMonth() + 1).padStart(2, '0');
                                    const day = String(now.getDate()).padStart(2, '0');
                                    const hours = String(now.getHours()).padStart(2, '0');
                                    const minutes = String(now.getMinutes()).padStart(2, '0');
                                    const currentDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
                                    document.getElementById('tanggalPenjualan').value = currentDateTime;
                                    document.getElementById('tanggalPenjualan').step = "60";
                                </script>                            
                            </div>
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pelanggan</label>
                            <select id="pelanggan" name="id_pelanggan" class="mt-1 block w-full rounded-xl border-2 border-green-200 bg-white px-4 py-3 focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none">
                                <option value="">Pilih Pelanggan</option>
                                <?php
                                $query = "SELECT * FROM pelanggan WHERE status_dihapus = 0";
                                $result = mysqli_query($koneksi, $query);
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='".$row['id_pelanggan']."'>".$row['nama_pelanggan']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-xl border-2 border-green-100 overflow-hidden">
                    <div class="flex justify-between items-center p-6 bg-stone-100 border-b-2 border-green-100">
                        <h3 class="text-xl font-bold text-green-700 flex items-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            Detail Produk
                        </h3>
                        <button type="button" id="tambahProduk" class="inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 transform hover:scale-105">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Tambah Produk
                        </button>
                    </div>

                    <div id="tabelDinamis" class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-stone-100 sticky top-0 z-10">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase tracking-wider border-b-2 border-green-100" style="min-width: 300px; width: 40%">Nama Produk</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase tracking-wider border-b-2 border-green-100" style="width: 15%">Qty</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase tracking-wider border-b-2 border-green-100" style="width: 20%">Harga Satuan</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase tracking-wider border-b-2 border-green-100" style="width: 20%">Subtotal</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-green-700 uppercase tracking-wider border-b-2 border-green-100" style="width: 5%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="detailProduk" class="divide-y divide-green-100">
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div></div>
                    <div class="bg-stone-100 p-6 rounded-xl space-y-4 border-2 border-green-100">
                        <div class="flex justify-between items-center p-4 bg-white rounded-xl border-2 border-green-100">
                            <label class="text-sm font-semibold text-gray-700">Subtotal:</label>
                            <span id="subtotal" class="text-lg font-bold text-green-600">Rp 0</span>
                        </div>
                        <div class="flex items-center gap-4 bg-white p-4 rounded-xl border-2 border-green-100">
                            <label class="text-sm font-semibold text-gray-700">Diskon (%):</label>
                            <input type="number" id="diskonPersen" name="diskon" min="0" max="100" class="w-24 rounded-xl border-2 border-green-200 px-3 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none" value="0">
                            <span id="diskonNominal" class="text-gray-700 font-medium">Rp 0</span>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-green-50 rounded-xl border-2 border-green-200">
                            <label class="text-lg font-bold text-green-700">Total:</label>
                            <span id="totalAkhir" class="text-2xl font-bold text-green-600">Rp 0</span>
                            <input type="hidden" name="total_harga" id="totalBayarInput">
                        </div>
                        <div class="flex items-center gap-4 bg-white p-4 rounded-xl border-2 border-green-100">
                            <label class="text-sm font-semibold text-gray-700">Dibayar:</label>
                            <input type="number" id="dibayar" name="dibayar" min="0" step="0.01" class="w-full rounded-xl border-2 border-green-200 px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none" value="0" required>
                        </div>
                        <div class="flex justify-between items-center p-4 bg-yellow-50 rounded-xl border-2 border-yellow-200">
                            <label class="text-lg font-bold text-yellow-600">Kembalian:</label>
                            <span id="kembalian" class="text-xl font-bold text-yellow-500">Rp 0</span>
                            <input type="hidden" name="kembalian" id="kembalianInput">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-6 border-t-2 border-green-100">
                    <a href="index.php" class="px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 font-medium hover:bg-gray-50 transition-all duration-200 transform hover:scale-105">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 bg-green-600 text-white font-medium rounded-xl hover:bg-green-700 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-green-500 transform hover:scale-105">
                        <span class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Transaksi
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let produkCounter = 0;
            const formatter = new Intl.NumberFormat('id-ID', {
                style: 'decimal',
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            
            document.getElementById('tambahProduk').addEventListener('click', function() {
                tambahBarisProduk();
            });

            const form = document.getElementById('formPenjualan');
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const dibayar = parseFloat(document.getElementById('dibayar').value);
                    const total = parseFloat(document.getElementById('totalBayarInput').value);
                    
                    if (dibayar <= 0) {
                        alert('Jumlah pembayaran harus diisi!');
                        return;
                    }
                    
                    if (dibayar < total) {
                        alert('Jumlah pembayaran harus lebih besar atau sama dengan total!');
                        return;
                    }
                    
                    if (confirm('Apakah Anda yakin ingin menyimpan transaksi ini?')) {
                        form.removeEventListener('submit', arguments.callee);
                        form.submit();
                    }
            });

            document.getElementById('diskonPersen').addEventListener('input', function() {
                hitungTotal();
            });

            document.getElementById('dibayar').addEventListener('input', function() {
                hitungKembalian();
            });

            function tambahBarisProduk() {
                produkCounter++;
                const row = document.createElement('tr');
                row.id = `produk-${produkCounter}`;
                row.innerHTML = `
                    <td class="px-4 py-3" style="min-width: 300px;">
                        <div class="relative">
                            <input type="text" 
                                class="search-produk w-full rounded-xl border-2 border-green-200 bg-white px-4 py-3 focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none" 
                                placeholder="Ketik minimal 3 huruf dari kode/nama produk untuk mencari"
                                oninput="searchProduk(event, this, ${produkCounter})">                            
                                <input type="hidden" name="produk[${produkCounter}][id_produk]" class="produk-id">
                            <input type="hidden" name="produk[${produkCounter}][kode_produk]" class="produk-kode">
                            <input type="hidden" name="produk[${produkCounter}][harga_modal]" class="harga-modal">
                            <div class="search-results absolute w-full bg-white border border-gray-300 rounded-lg mt-1 shadow-lg hidden z-50 max-h-60 overflow-y-auto"></div>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <input type="number" name="produk[${produkCounter}][qty]" class="qty w-20 rounded-xl border-2 border-green-200 bg-white px-4 py-3 focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none" min="1" value="1" required onchange="hitungSubtotal(this)">
                    </td>
                    <td class="px-4 py-3">
                        <input type="number" name="produk[${produkCounter}][harga_satuan]" class="harga w-32 rounded-xl border-2 border-green-200 bg-white px-4 py-3 focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none" min="0" step="0.01" required onchange="hitungSubtotal(this)">
                    </td>
                    <td class="px-4 py-3">
                        <span class="subtotal">Rp 0</span>
                        <input type="hidden" name="produk[${produkCounter}][subtotal]" class="subtotal-input">
                    </td>
                    <td class="px-4 py-3">
                        <button type="button" class="text-red-500 hover:text-red-700" onclick="hapusProduk(${produkCounter})">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </button>
                    </td>
                `;                
                document.getElementById('detailProduk').appendChild(row);
                
                // Set focus to the newly added search-produk input
                const newRow = document.getElementById(`produk-${produkCounter}`);
                const searchInput = newRow.querySelector('.search-produk');
                searchInput.focus();
            }
            window.searchProduk = function(event, input, counter) {
                let searchTimeout;
                const minSearchLength = 3;
                
                if (input.value.length >= minSearchLength) {
                    clearTimeout(searchTimeout);
                    searchTimeout = setTimeout(() => {
                        const searchTerm = input.value.trim();
                        const resultsDiv = input.parentElement.querySelector('.search-results');
                        const tabelDinamis = document.getElementById('tabelDinamis');
                        tabelDinamis.style.height = '400px';
                        tabelDinamis.style.overflowY = 'auto';

                        fetch(`search_produk.php?term=${encodeURIComponent(searchTerm)}`)
                            .then(response => response.json())
                            .then(data => {
                                resultsDiv.innerHTML = '';
                                if(data.length > 0) {
                                    data.forEach(item => {
                                        const div = document.createElement('div');
                                        div.className = 'p-2 hover:bg-gray-100 cursor-pointer';
                                        div.innerHTML = `${item.kode_produk} - ${item.nama_produk} - stok(${item.stok})`;
                                        div.onclick = function() {
                                            const existingProduk = document.querySelectorAll('.produk-kode');
                                            for(let produk of existingProduk) {
                                                if(produk.value === item.kode_produk) {
                                                    alert('Produk dengan kode ' + item.kode_produk + ' sudah ada dalam daftar!');
                                                    resultsDiv.classList.add('hidden');
                                                    input.value = '';
                                                    return;
                                                }
                                            }
                                            
                                            input.value = item.nama_produk;
                                            input.parentElement.querySelector('.produk-id').value = item.id_produk;
                                            input.parentElement.querySelector('.produk-kode').value = item.kode_produk;
                                            input.parentElement.querySelector('.harga-modal').value = item.harga_beli;
                                            const row = input.closest('tr');
                                            const hargaInput = row.querySelector('.harga');
                                            hargaInput.value = item.harga_jual;
                                            hitungSubtotal(hargaInput);
                                            resultsDiv.classList.add('hidden');
                                        };
                                        resultsDiv.appendChild(div);
                                    });
                                    resultsDiv.classList.remove('hidden');
                                }
                            });
                    }, 300);
                } else {
                    input.parentElement.querySelector('.search-results').classList.add('hidden');
                }            
            };

            window.hitungSubtotal = function(element) {
                const row = element.closest('tr');
                const qty = parseFloat(row.querySelector('.qty').value) || 0;
                const harga = parseFloat(row.querySelector('.harga').value) || 0;
                const subtotal = qty * harga;
                row.querySelector('.subtotal').textContent = `Rp ${formatter.format(subtotal)}`;
                row.querySelector('.subtotal-input').value = subtotal.toFixed(2);
                hitungTotal();
            }

            window.hapusProduk = function(counter) {
                if(confirm('Apakah Anda yakin ingin menghapus produk ini?')) {
                    document.getElementById(`produk-${counter}`).remove();
                    hitungTotal();
                }
            }

            function hitungTotal() {
                let total = 0;
                document.querySelectorAll('.subtotal-input').forEach(input => {
                    total += parseFloat(input.value) || 0;
                });

                const diskonPersen = parseFloat(document.getElementById('diskonPersen').value) || 0;
                const diskonNominal = total * (diskonPersen / 100);
                const totalAkhir = total - diskonNominal;

                document.getElementById('subtotal').textContent = `Rp ${formatter.format(total)}`;
                document.getElementById('diskonNominal').textContent = `Rp ${formatter.format(diskonNominal)}`;
                document.getElementById('totalAkhir').textContent = `Rp ${formatter.format(totalAkhir)}`;
                document.getElementById('totalBayarInput').value = totalAkhir.toFixed(2);
                hitungKembalian();
            }

            function hitungKembalian() {
                const totalAkhir = parseFloat(document.getElementById('totalBayarInput').value) || 0;
                const dibayar = parseFloat(document.getElementById('dibayar').value) || 0;
                const kembalian = dibayar - totalAkhir;
                
                document.getElementById('kembalian').textContent = `Rp ${formatter.format(kembalian)}`;
                document.getElementById('kembalianInput').value = kembalian.toFixed(2);
            }
        });    
        </script>


<?php include ('../../layout/footer.php'); ?>