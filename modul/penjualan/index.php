<?php
    $judul_halaman = "Data Penjualan Produk";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

          <!-- Main Content Area -->
          <div class="p-6 animate-slide-fade">
              <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-green-600">
                  <div class="flex flex-col lg:flex-row items-center justify-between mb-8 animate-scale">
                      <div>
                          <h2 class="text-3xl font-bold text-green-800 mb-2">Data Penjualan</h2>
                          <p class="text-gray-600">Kelola Data Penjualan Produk</p>
                      </div>
                      <a href="tambah.php" class="mt-4 lg:mt-0 inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
                          <span class="mr-2">+</span>
                          <span>Tambah Penjualan</span>
                      </a>
                  </div>

                  <!-- Pesan Data Sukses -->
                  <?php
                      if(isset($_SESSION['penjualan_sukses'])) { ?>
                      <div id="alert-message" class="mb-4 bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 shadow-md p-4 rounded-lg animate-fade-in-down flex justify-between items-center transform transition-all duration-300 hover:scale-[1.02]" role="alert">
                          <div class="flex items-center space-x-3">
                              <div class="flex-shrink-0">
                                  <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                  </svg>
                              </div>
                              <p class="font-medium text-green-700"><?php echo $_SESSION['penjualan_sukses']; ?></p>
                          </div>
                          <button onclick="closeAlert()" class="p-1.5 rounded-full hover:bg-green-200 transition-colors duration-200">
                              <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                  unset($_SESSION['penjualan_sukses']);
                  } 
                  ?>

                  <div class="mb-6">
                      <div class="relative">
                          <input type="text" id="searchInput" class="w-full pl-12 pr-4 py-3 bg-gray-50 rounded-lg border border-gray-300 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-200" placeholder="Cari penjualan...">
                          <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-green-500">
                              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                              </svg>
                          </span>
                      </div>
                  </div>

                  <div class="bg-white rounded-lg shadow overflow-hidden">
                      <div class="overflow-x-auto">
                          <table id="penggunaTable" class="min-w-full divide-y divide-gray-200 animate-smooth">
                              <thead>
                                  <tr class="bg-gradient-to-r from-green-50 to-green-100">
                                      <th class="px-4 py-4 text-xs font-semibold text-left cursor-pointer hover:bg-green-200 transition-colors duration-200" data-column="id_penjualan">
                                          <div class="flex items-center text-green-800">
                                              No
                                              <svg class="w-4 h-4 ml-1.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m-4 4v12m0 0l4-4m-4 4l-4-4"/>
                                              </svg>
                                          </div>
                                      </th>
                                      <th class="px-4 py-4 text-xs font-semibold text-left cursor-pointer hover:bg-green-200 transition-colors duration-200" data-column="no_faktur_penjualan">
                                          <div class="flex items-center text-green-800">
                                              No Faktur
                                              <svg class="w-4 h-4 ml-1.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m-4 4v12m0 0l4-4m-4 4l-4-4"/>
                                              </svg>
                                          </div>
                                      </th>
                                      <th class="px-4 py-4 text-xs font-semibold text-left cursor-pointer hover:bg-green-200 transition-colors duration-200" data-column="nama_pelanggan">
                                          <div class="flex items-center text-green-800">
                                              Pelanggan
                                              <svg class="w-4 h-4 ml-1.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m-4 4v12m0 0l4-4m-4 4l-4-4"/>
                                              </svg>
                                          </div>
                                      </th>
                                      <th class="px-4 py-4 text-xs font-semibold text-left cursor-pointer hover:bg-green-200 transition-colors duration-200" data-column="tanggal">
                                          <div class="flex items-center text-green-800">
                                              Tanggal
                                              <svg class="w-4 h-4 ml-1.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m-4 4v12m0 0l4-4m-4 4l-4-4"/>
                                              </svg>
                                          </div>
                                      </th>
                                      <th class="px-4 py-4 text-xs font-semibold text-left cursor-pointer hover:bg-green-200 transition-colors duration-200" data-column="total_harga">
                                          <div class="flex items-center text-green-800">
                                              Total Harga
                                              <svg class="w-4 h-4 ml-1.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m-4 4v12m0 0l4-4m-4 4l-4-4"/>
                                              </svg>
                                          </div>
                                      </th>
                                      <th class="px-4 py-4 text-xs font-semibold text-left cursor-pointer hover:bg-green-200 transition-colors duration-200" data-column="diskon">
                                          <div class="flex items-center text-green-800">
                                              Diskon
                                              <svg class="w-4 h-4 ml-1.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m-4 4v12m0 0l4-4m-4 4l-4-4"/>
                                              </svg>
                                          </div>
                                      </th>
                                      <th class="px-4 py-4 text-xs font-semibold text-left cursor-pointer hover:bg-green-200 transition-colors duration-200" data-column="dibayar">
                                          <div class="flex items-center text-green-800">
                                              Dibayar
                                              <svg class="w-4 h-4 ml-1.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m-4 4v12m0 0l4-4m-4 4l-4-4"/>
                                              </svg>
                                          </div>
                                      </th>
                                      <th class="px-4 py-4 text-xs font-semibold text-left cursor-pointer hover:bg-green-200 transition-colors duration-200" data-column="kembalian">
                                          <div class="flex items-center text-green-800">
                                              Kembalian
                                              <svg class="w-4 h-4 ml-1.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m-4 4v12m0 0l4-4m-4 4l-4-4"/>
                                              </svg>
                                          </div>
                                      </th>
                                      <th class="px-4 py-4 text-xs font-semibold text-center text-green-800">Status</th>
                                      <th class="px-4 py-4 text-xs font-semibold text-center text-green-800">Tindakan</th>
                                  </tr>
                              </thead>
                              <tbody class="bg-white divide-y divide-gray-100">
                              </tbody>
                          </table>
                      </div>
                  </div>

                  <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                      <div class="flex items-center gap-4">
                          <span id="paginationInfo" class="text-sm text-gray-600"></span>
                          <select id="itemsPerPage" class="bg-gray-50 rounded-lg px-3 py-2 text-sm border-none focus:ring-2 focus:ring-green-200">
                              <option value="10">10 baris</option>
                              <option value="50">50 baris</option>
                              <option value="100">100 baris</option>
                              <option value="all">Semua</option>
                          </select>
                      </div>

                      <div class="flex items-center gap-2" id="paginationButtons">
                          <button id="prevBtn" class="px-4 py-2 bg-green-50 rounded-lg hover:bg-green-100 text-green-700 transition-colors duration-200">
                              <span>Sebelumnya</span>
                          </button>

                          <div id="pageNumbers" class="flex gap-2"></div>

                          <button id="nextBtn" class="px-4 py-2 bg-green-50 rounded-lg hover:bg-green-100 text-green-700 transition-colors duration-200">
                              <span>Selanjutnya</span>
                          </button>
                      </div>
                  </div>
              </div>
          </div>          
          
          <script>
          let tableData = [];
          let currentPage = 1;
          let itemsPerPage = 10;
          let sortColumn = 'no_faktur_penjualan';
          let sortDirection = 'asc';
          
          async function fetchData() {
              try {
                  const response = await fetch('get_penjualan.php');
                  const data = await response.json();
                  if (Array.isArray(data)) {
                      tableData = data;
                      renderTable();
                  } else {
                      console.error('Data tidak valid:', data);
                  }
              } catch (error) {
                  console.error('Error fetching data:', error);
              }
          }
          
          function initTable() {
              document.querySelectorAll('th[data-column]').forEach(header => {
                  header.addEventListener('click', () => {
                      const column = header.dataset.column;
                      if (sortColumn === column) {
                          sortDirection = sortDirection === 'asc' ? 'desc' : 'asc';
                      } else {
                          sortColumn = column;
                          sortDirection = 'asc';
                      }
                      renderTable();
                  });
              });
          
              document.getElementById('searchInput').addEventListener('input', (e) => {
                  const searchTerm = e.target.value.toLowerCase();
                  filterTable(searchTerm);
              });
          
              document.getElementById('itemsPerPage').addEventListener('change', (e) => {
                  itemsPerPage = e.target.value === 'all' ? tableData.length : parseInt(e.target.value);
                  currentPage = 1;
                  renderTable();
              });
          
              document.getElementById('prevBtn').addEventListener('click', () => {
                  if (currentPage > 1) {
                      currentPage--;
                      renderTable();
                  }
              });
          
              document.getElementById('nextBtn').addEventListener('click', () => {
                  const totalPages = Math.ceil(tableData.length / itemsPerPage);
                  if (currentPage < totalPages) {
                      currentPage++;
                      renderTable();
                  }
              });
          }
          
          function filterTable(searchTerm) {
              const filteredData = tableData.filter(item => 
                  Object.values(item).some(value => 
                      value.toString().toLowerCase().includes(searchTerm)
                  )
              );
              currentPage = 1;
              renderTable(filteredData);
          }
          
          function sortData(data) {
              return [...data].sort((a, b) => {
                  let valueA = a[sortColumn];
                  let valueB = b[sortColumn];
                  
                  if (typeof valueA === 'string') {
                      valueA = valueA.toLowerCase();
                      valueB = valueB.toLowerCase();
                  }
                  
                  if (sortDirection === 'asc') {
                      return valueA > valueB ? 1 : -1;
                  } else {
                      return valueA < valueB ? 1 : -1;
                  }
              });
          }
          
          function renderTable(data = tableData) {
              const sortedData = sortData(data);
              const start = (currentPage - 1) * itemsPerPage;
              const paginatedData = sortedData.slice(start, start + itemsPerPage);
              
              const tbody = document.querySelector('tbody');
              tbody.innerHTML = '';
              
              paginatedData.forEach((row, index) => {
                  const tr = document.createElement('tr');
                  tr.className = 'bg-white hover:bg-gray-50';
                  tr.innerHTML = `
                      <td class="px-6 py-4 border-b border-r border-gray-200">${start + index + 1}</td>
                      <td class="px-6 py-4 border-b border-r border-gray-200">${row.no_faktur_penjualan}</td>
                      <td class="px-6 py-4 border-b border-r border-gray-200">${row.nama_pelanggan}</td>
                      <td class="px-6 py-4 border-b border-r border-gray-200">${row.tanggal}</td>
                      <td class="px-6 py-4 border-b border-r border-gray-200">${row.total_harga}</td>
                      <td class="px-6 py-4 border-b border-r border-gray-200">${row.diskon}</td>
                      <td class="px-6 py-4 border-b border-r border-gray-200">${row.dibayar}</td>
                      <td class="px-6 py-4 border-b border-r border-gray-200">${row.kembalian}</td>
                      <td class="px-6 py-4 border-b border-r border-gray-200">${row.status_dihapus == 1 ? 'Dibatalkan' : 'Selesai'}</td>
                      <td class="px-6 py-4 border-b border-gray-200">
                          <div class="flex justify-center space-x-3">
                              <button title="print" onclick="detailPenjualan(${row.id_penjualan})" class="text-red-500 hover:text-red-700 p-1.5 rounded-full hover:bg-red-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                </svg>                              
                              </button>
                              ${row.status_dihapus == 0 ? `
                              <button title="edit" onclick="editPenjualan(${row.id_penjualan})" class="text-yellow-500 hover:text-yellow-700 p-1.5 rounded-full hover:bg-yellow-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                              </button>
                              <button title="batal" onclick="batalPenjualan(${row.id_penjualan})" class="text-red-500 hover:text-red-700 p-1.5 rounded-full hover:bg-red-100">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                              </button>` 
                              : ''}                          
                            </div>                      
                        </td>
                  `;
                  tbody.appendChild(tr);
              });

              updatePaginationInfo(sortedData.length, start);
              updatePaginationButtons(sortedData.length);
          }

          function updatePaginationInfo(totalItems, start) {
              const end = Math.min(start + itemsPerPage, totalItems);
              const paginationInfo = document.getElementById('paginationInfo');
              paginationInfo.textContent = `Menampilkan ${start + 1} - ${end} dari ${totalItems} item`;
          }

          function updatePaginationButtons(totalItems) {
              const totalPages = Math.ceil(totalItems / itemsPerPage);
              const pageNumbers = document.getElementById('pageNumbers');
              pageNumbers.innerHTML = '';

              const maxButtons = 3;
              let startPage = Math.max(1, currentPage - Math.floor(maxButtons / 2));
              let endPage = Math.min(totalPages, startPage + maxButtons - 1);

              if (endPage - startPage + 1 < maxButtons) {
                  startPage = Math.max(1, endPage - maxButtons + 1);
              }

              for (let i = startPage; i <= endPage; i++) {
                  const button = document.createElement('button');
                  button.className = `px-3 py-1 border rounded ${i === currentPage ? 'bg-green-600 text-white' : 'bg-green-50 text-green-700 hover:bg-green-100'}`;
                  button.textContent = i;
                  button.addEventListener('click', () => {
                      currentPage = i;
                      renderTable();
                  });
                  pageNumbers.appendChild(button);
              }

              document.getElementById('prevBtn').disabled = currentPage === 1;
              document.getElementById('nextBtn').disabled = currentPage === totalPages;
          }
          
          function detailPenjualan(id) {
              window.open(`detail.php?id=${id}`, '_blank');
          }

          function editPenjualan(id) {
              window.location.href = `edit.php?id=${id}`;
          }

          async function batalPenjualan(id) {
              if (confirm('Apakah Anda yakin ingin membatalkan transaksi ini?')) {
                  try {
                      const response = await fetch(`batal.php?id=${id}`, {
                          method: 'DELETE'
                      });
                      const data = await response.json();
                      
                      if (data.success) {
                          alert(data.message);
                          fetchData();
                      } else {
                          alert(data.message);
                      }
                  } catch (error) {
                      console.error('Error deleting data:', error);
                      alert('Terjadi kesalahan saat membatalkan data penjualan!');
                      window.location.href = 'index.php';
                  }
              }
          }
          
          document.addEventListener('DOMContentLoaded', () => {
              initTable();
              fetchData();
          });
          </script>
        
<?php include ('../../layout/footer.php'); ?>