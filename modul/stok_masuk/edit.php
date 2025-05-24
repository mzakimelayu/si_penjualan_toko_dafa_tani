<?php
    ob_start();
    $judul_halaman = "Tambah Stok Masuk";
    
    include '../../cek_login.php';
?>
  <?php include '../../layout/header.php'; ?>

  <?php include '../../layout/sidebar.php'; ?>

      <!-- Main Content Area -->
      <div class="p-6 animate-fade-in animate-slide-fade animate-scale animate-smooth bg-stone-100">    
          <!-- Form Section -->
          <div class="rounded-2xl shadow-xl p-8 animate-slide-fade animate-scale animate-smooth bg-white border-2 border-green-100">
              <h2 class="text-3xl font-bold text-green-700 mb-8 pb-4 border-b-2 border-green-200 flex items-center">
                  <svg class="w-8 h-8 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                  </svg>
                  Edit Stok Masuk
              </h2>            
              <!-- Pesan Error -->
            <?php
                if(isset($_SESSION['stok_masuk_error'])) { ?>
                <div id="alert-message" class="mb-4 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 shadow-md p-4 rounded-lg animate-fade-in-down flex justify-between items-center transform transition-all duration-300 hover:scale-[1.02]" role="alert">
                    <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="font-medium text-red-700"><?php echo $_SESSION['stok_masuk_error']; ?></p>
                    </div>
                    <button onclick="closeAlert()" class="p-1.5 rounded-full hover:bg-red-200 transition-colors duration-200">
                    <svg class="h-4 w-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    </button>
                </div>
                <script>
                    setTimeout(function() {
                    const alert = document.getElementById('alert-message');
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-100%)';
                    setTimeout(() => alert.style.display = 'none', 300);
                    }, 3000);
                    
                    function closeAlert() {
                    const alert = document.getElementById('alert-message');
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-100%)';
                    setTimeout(() => alert.style.display = 'none', 300);
                    }
                </script>
            <?php 
            unset($_SESSION['stok_masuk_error']);
            } 
            ?>


              <?php

              // Ambil data stok masuk
              $id_stok_masuk = $_GET['id'];
              $query = "SELECT * FROM stok_masuk WHERE id_stok_masuk = ?";
              $stmt = $koneksi->prepare($query);
              $stmt->bind_param("i", $id_stok_masuk);
              $stmt->execute();
              $result = $stmt->get_result();
              $stok_masuk = $result->fetch_assoc();

              if ($stok_masuk['status_dihapus'] == 1) {
                  $_SESSION['stok_masuk_eror'] = "Stok masuk tidak bisa di edit karena telah dibatalkan";
                  header("Location: index.php");
                  exit();
              }

              // Ambil detail stok masuk
              $query_detail = "SELECT d.*, p.kode_produk, p.nama_produk FROM detail_stok_masuk d 
                           JOIN produk p ON d.id_produk = p.id_produk 
                           WHERE d.id_stok_masuk = ? AND d.status_dihapus = 0";
              $stmt_detail = $koneksi->prepare($query_detail);
              $stmt_detail->bind_param("i", $id_stok_masuk);
              $stmt_detail->execute();
              $result_detail = $stmt_detail->get_result();
              $details = $result_detail->fetch_all(MYSQLI_ASSOC);
              
              if (empty($details)) {
                  echo "<script>window.location.href = '" . base_url('404.php') . "';</script>";
                  exit;  
              }
              ?>

              <form action="proses_edit.php" method="POST" class="space-y-8">
                  <input type="hidden" name="id_stok_masuk" value="<?php echo $stok_masuk['id_stok_masuk']; ?>">
                  <div class="grid grid-cols-1 gap-8">
                      <div class="bg-white p-6 rounded-lg shadow-sm space-y-6 border border-gray-200">
                          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                              <div class="w-full">
                                  <label class="block text-sm font-semibold text-gray-700 mb-2">No. Invoice <span class="text-red-500">*</span></label>
                                  <input type="text" name="no_invoice" value="<?php echo $stok_masuk['no_invoice']; ?>" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none" required>
                              </div>
                              <div class="w-full">
                                  <label class="block text-sm font-semibold text-gray-700 mb-2">Tanggal <span class="text-red-500">*</span></label>
                                  <input type="datetime-local" name="tanggal" value="<?php echo date('Y-m-d\TH:i', strtotime($stok_masuk['tanggal'])); ?>" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none" required>
                              </div>
                              <div class="w-full">
                                  <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Supplier <span class="text-red-500">*</span></label>
                                  <input type="text" name="nama_supplier" value="<?php echo $stok_masuk['nama_supplier']; ?>" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none" required>
                              </div>
                          </div>
                        
                          <div class="border-t border-gray-200 pt-6">
                              <h3 class="text-lg font-semibold text-gray-700 mb-4">Detail Produk</h3>
                              <div id="produk-container">
                                  <?php foreach($details as $index => $detail) { ?>
                                  <div class="produk-item bg-gray-50 p-4 rounded-lg mb-4 border border-gray-200">
                                      <div class="flex justify-between items-center mb-4">
                                          <h4 class="font-medium text-gray-700">Produk #<?php echo $index + 1; ?></h4>
                                          <button type="button" onclick="hapusProduk(this)" class="text-red-500 hover:text-red-700 <?php echo $index === 0 ? 'hidden' : ''; ?> delete-btn">
                                              <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                              </svg>
                                          </button>
                                      </div>
                                      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                          <div class="w-full relative">
                                              <label class="block text-sm font-semibold text-gray-700 mb-2">Produk <span class="text-red-500">*</span></label>
                                              <input type="text" class="produk-search mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none" value="<?php echo $detail['kode_produk'] . ' - ' . $detail['nama_produk']; ?>" placeholder="Cari produk (minimal 3 karakter)..." minlength="3" autocomplete="off">
                                              <input type="hidden" name="id_produk[]" class="produk-id" value="<?php echo $detail['id_produk']; ?>" required>
                                              <div class="produk-suggestions absolute z-50 w-full md:w-[calc(100%-2px)] bg-white border border-gray-300 rounded-lg mt-1 shadow-lg hidden max-h-60 overflow-y-auto"></div>
                                              <small class="text-gray-500 mt-1 block">Ketikkan minimal 3 karakter untuk mencari produk</small>
                                          </div>
                                          <div class="w-full">
                                              <label class="block text-sm font-semibold text-gray-700 mb-2">Jumlah <span class="text-red-500">*</span></label>
                                              <input type="number" name="jumlah[]" value="<?php echo $detail['jumlah']; ?>" class="mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none" required>
                                          </div>
                                          <div class="w-full">
                                              <label class="block text-sm font-semibold text-gray-700 mb-2">Harga Beli <span class="text-red-500">*</span></label>
                                              <input type="number" name="harga_beli[]" value="<?php echo $detail['harga_beli']; ?>" class="harga-beli mt-1 block w-full rounded-lg border border-gray-300 bg-white px-4 py-2 focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:outline-none" required>
                                          </div>
                                      </div>
                                  </div>
                                  <?php } ?>
                              </div>

                              <div class="flex justify-center mt-6">
                                  <button type="button" onclick="tambahProduk()" class="inline-flex items-center px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors duration-200">
                                      <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                      </svg>
                                      Tambah Produk
                                  </button>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="flex justify-end gap-4 pt-6 border-t border-gray-300">
                      <a href="index.php" class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50 transition-colors duration-200">
                          <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                          </svg>
                          Batal
                      </a>
                      <button type="submit" class="inline-flex items-center px-8 py-3 bg-green-700 text-white font-medium rounded-lg hover:bg-green-800 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-green-500">
                          <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                          </svg>
                          Simpan
                      </button>
                  </div>
              </form>
          </div>
      </div>

    <script>
        let searchTimeout;

        function initProdukSearch(produkItem) {
            const searchInput = produkItem.querySelector('.produk-search');
            const suggestionsDiv = produkItem.querySelector('.produk-suggestions');
            const idInput = produkItem.querySelector('.produk-id');
            const hargaBeliInput = produkItem.querySelector('.harga-beli');

            searchInput.addEventListener('input', function() {
                clearTimeout(searchTimeout);
                const searchTerm = this.value.trim();
                idInput.value = ''; // Reset ID when user types

                if (searchTerm.length < 3) {
                    suggestionsDiv.innerHTML = '';
                    suggestionsDiv.classList.add('hidden');
                    return;
                }

                searchTimeout = setTimeout(() => {
                    fetch(`search_produk.php?term=${encodeURIComponent(searchTerm)}`)
                        .then(response => response.json())
                        .then(data => {
                            suggestionsDiv.innerHTML = '';
                            if (data.length > 0) {
                                const ul = document.createElement('ul');
                                ul.className = 'py-2';
                                data.slice(0, 5).forEach(item => {
                                    const li = document.createElement('li');
                                    li.className = 'px-4 py-2 hover:bg-gray-100 cursor-pointer text-sm';
                                    li.textContent = `${item.kode_produk} - ${item.nama_produk}`;
                                    li.addEventListener('click', () => {
                                        searchInput.value = `${item.kode_produk} - ${item.nama_produk}`;
                                        idInput.value = item.id_produk;
                                        hargaBeliInput.value = item.harga_beli;
                                        suggestionsDiv.classList.add('hidden');
                                    });
                                    ul.appendChild(li);
                                });
                                suggestionsDiv.appendChild(ul);
                                suggestionsDiv.classList.remove('hidden');
                            } else {
                                suggestionsDiv.classList.add('hidden');
                            }
                        });
                }, 500);
            });

            document.addEventListener('click', function(e) {
                if (!produkItem.contains(e.target)) {
                    suggestionsDiv.classList.add('hidden');
                }
            });

            // Handle touch events for mobile
            searchInput.addEventListener('touchstart', function(e) {
                e.stopPropagation();
            });

            document.addEventListener('touchstart', function(e) {
                if (!produkItem.contains(e.target)) {
                    suggestionsDiv.classList.add('hidden');
                }
            });
        }

        function validateProdukSelection() {
            const produkItems = document.getElementsByClassName('produk-item');
            for (let item of produkItems) {
                const idInput = item.querySelector('.produk-id');
                if (!idInput.value) {
                    return false;
                }
            }
            return true;
        }

        function tambahProduk() {
            if (!validateProdukSelection()) {
                alert('Harap pilih produk dari daftar pencarian terlebih dahulu sebelum menambah produk baru!');
                return;
            }

            const container = document.getElementById('produk-container');
            const produkItems = container.getElementsByClassName('produk-item');
            const produkItem = produkItems[0].cloneNode(true);
            
            const nomorProduk = produkItems.length + 1;
            produkItem.querySelector('h4').textContent = `Produk #${nomorProduk}`;
            
            produkItem.querySelectorAll('input').forEach(input => input.value = '');
            produkItem.querySelector('.delete-btn').classList.remove('hidden');
            
            container.appendChild(produkItem);
            initProdukSearch(produkItem);
        }

        function hapusProduk(button) {
            const produkItems = document.getElementsByClassName('produk-item');
            if (produkItems.length > 1) {
                const produkItem = button.closest('.produk-item');
                produkItem.remove();
                
                Array.from(document.getElementsByClassName('produk-item')).forEach((item, index) => {
                    item.querySelector('h4').textContent = `Produk #${index + 1}`;
                });
            } else {
                alert('Minimal harus ada satu produk!');
            }
        }

        // Initialize search for the first product item
        document.addEventListener('DOMContentLoaded', function() {
            const firstProdukItem = document.querySelector('.produk-item');
            initProdukSearch(firstProdukItem);
        });
    </script>
    
<?php include ('../../layout/footer.php'); ?>