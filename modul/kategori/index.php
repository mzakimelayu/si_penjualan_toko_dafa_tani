<?php
    $judul_halaman = "Data Kategori";
    
    include '../../cek_login.php';
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

<!-- Content -->
<div class="p-6 animate-slide-fade">
  <div class="bg-white rounded-xl shadow-lg p-6 border-t-4 border-green-600">
    <div class="flex flex-col lg:flex-row items-center justify-between mb-8 animate-scale">
      <div class="text-center lg:text-left">
        <h2 class="text-3xl font-bold text-green-800 mb-2">Data Kategori</h2>
        <p class="text-gray-600">Kelola Data Kategori</p>      
      </div>
      <a href="tambah.php" class="mt-4 lg:mt-0 inline-flex items-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200">
        <span class="mr-2">+</span>
        <span>Tambah Kategori</span>
      </a>
    </div>

    <!-- Pesan Berhasil -->
    <?php
        if(isset($_SESSION['kategori_sukses'])) { ?>
          <div id="alert-message" class="mb-4 bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 shadow-md p-4 rounded-lg animate-fade-in-down flex justify-between items-center transform transition-all duration-300 hover:scale-[1.02]" role="alert">
            <div class="flex items-center space-x-3">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
              </div>
              <p class="font-medium text-green-700"><?php echo $_SESSION['kategori_sukses']; ?></p>
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
      unset($_SESSION['kategori_sukses']);
    } 
    ?>

    <div class="mb-6">
      <div class="relative">
        <input type="text" id="searchInput" class="w-full pl-12 pr-4 py-3 bg-gray-50 rounded-lg border border-gray-300 focus:outline-none focus:border-green-500 focus:ring-1 focus:ring-green-500 transition-all duration-200" placeholder="Cari kategori...">
        <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-green-500">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
          </svg>
        </span>
      </div>
    </div>
    
    <div class="bg-white rounded-lg shadow overflow-hidden">
      <div class="overflow-x-auto">
        <table id="kategoriTable" class="min-w-full divide-y divide-gray-200 animate-smooth">
          <thead>
            <tr class="bg-gradient-to-r from-green-50 to-green-100">
              <th class="px-4 py-4 text-xs font-semibold text-left cursor-pointer hover:bg-green-200 transition-colors duration-200" data-column="id_kategori">
                <div class="flex items-center text-green-800">
                  No
                  <svg class="w-4 h-4 ml-1.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m-4 4v12m0 0l4-4m-4 4l-4-4"/>
                  </svg>
                </div>
              </th>
              <th class="px-4 py-4 text-xs font-semibold text-left cursor-pointer hover:bg-green-200 transition-colors duration-200" data-column="nama_kategori">
                <div class="flex items-center text-green-800">
                  Nama Kategori
                  <svg class="w-4 h-4 ml-1.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m-4 4v12m0 0l4-4m-4 4l-4-4"/>
                  </svg>
                </div>
              </th>
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
  let sortColumn = 'id_kategori';
  let sortDirection = 'asc';

  async function fetchData() {
      try {
          const response = await fetch('get_kategori.php');
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
          const rowIndex = start + index + 1;
          const tr = document.createElement('tr');
          tr.className = 'bg-white hover:bg-gray-50';
          tr.innerHTML = `
              <td class="px-4 py-4 border-b border-gray-200">${rowIndex}</td>
              <td class="px-4 py-4 border-b border-gray-200">${row.nama_kategori}</td>
              <td class="px-4 py-4 border-b border-gray-200">
                  <div class="flex justify-center gap-4">
                      <button title="Edit Data Kategori" onclick="editKategori(${row.id_kategori})" class="bg-amber-50 text-amber-600 p-2 rounded-lg hover:bg-amber-100 transition-colors group relative">
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                          </svg>
                          <span class="invisible group-hover:visible absolute -top-8 left-1/2 -translate-x-1/2 px-2 py-1 bg-gray-900 text-white text-xs rounded-md whitespace-nowrap">Edit Data</span>
                      </button>
                      <button title="Hapus Data Kategori" onclick="hapusKategori(${row.id_kategori})" class="bg-rose-50 text-rose-600 p-2 rounded-lg hover:bg-rose-100 transition-colors group relative">
                          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                          </svg>
                          <span class="invisible group-hover:visible absolute -top-8 left-1/2 -translate-x-1/2 px-2 py-1 bg-gray-900 text-white text-xs rounded-md whitespace-nowrap">Hapus Data</span>
                      </button>
                  </div>
              </td>`;
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
          button.className = `px-3 py-1 rounded-lg ${i === currentPage ? 'bg-green-600 text-white' : 'bg-green-50 text-green-700 hover:bg-green-100'}`;
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

  function editKategori(id) {
      window.location.href = `edit.php?id=${id}`;
  }

  async function hapusKategori(id) {
      if (confirm('Apakah Anda yakin ingin menghapus kategori ini?')) {
          try {
              const response = await fetch(`hapus.php?id=${id}`, {
                  method: 'DELETE'
              });
              if (response.ok) {
                  alert('Kategori berhasil dihapus!');
                  fetchData();
              } else {
                  alert('Gagal menghapus kategori!');
              }
          } catch (error) {
              console.error('Error deleting data:', error);
              alert('Terjadi kesalahan saat menghapus kategori!');
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