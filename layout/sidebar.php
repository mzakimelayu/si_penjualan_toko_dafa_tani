<body class="bg-stone-100">
    <div class="min-h-screen flex flex-col md:flex-row w-full max-w-full overflow-x-hidden">
      <!-- Overlay -->
      <div id="overlay" class="overlay" onclick="closeMobileSidebar()"></div>

      <!-- Sidebar -->
      <aside id="sidebar" class="sidebar bg-green-700 h-full min-h-screen">
        <div class="sidebar-content h-screen sticky top-0">
          <div class="p-4">
            <div class="flex items-center justify-between">
              <h2 class="text-xl font-bold text-white menu-text">Admin Penjualan</h2>
              <button onclick="toggleSidebar()" class="text-white">
                <svg id="toggleIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
              </button>
            </div>
          </div>

          <nav class="sidebar-menu custom-scrollbar ">
            <!-- Dashboard -->
            <a href="<?= base_url('dashboard.php') ?>" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'dashboard.php') !== false) ? 'active' : ''; ?>">
              <svg class="menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
              </svg>
              <span class="menu-text">Dashboard</span>
            </a>

            <!-- Kelola Produk -->
            <?php if ($sesi_peran_pengguna == "pemilik" || $sesi_peran_pengguna == "admin") { ?>
            <div class="menu-group">
              <button onclick="toggleSubmenu('produkMenu')" class="menu-item w-full flex justify-between items-center <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/produk') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/kategori') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/satuan') !== false) ? 'active' : ''; ?>">
                <div class="flex items-center">
                  <svg class="menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                  </svg>
                  <span class="menu-text">Kelola Produk</span>
                </div>
                <svg class="w-4 h-4 menu-arrow transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
              </button>
            
              <div id="produkMenu" class="submenu bg-green-800 <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/produk') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/kategori') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/satuan') !== false) ? 'open' : ''; ?>">
                <a href="<?= base_url('modul/produk/index.php') ?>" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/produk') !== false) ? 'bg-green-900' : 'hover:bg-green-600'; ?>">
                  <div class="pl-4"></div>
                  <svg class="menu-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                  </svg>                  
                  <span class="menu-text">Produk</span>
                </a>
                <a href="<?= base_url('modul/kategori/index.php') ?>" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/kategori') !== false) ? 'bg-green-900' : 'hover:bg-green-600'; ?>">
                  <div class="pl-4"></div>
                  <svg class="menu-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zm10 0a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                  </svg>                  
                  <span class="menu-text">Kategori</span>
                </a>
                <a href="<?= base_url('modul/satuan/index.php') ?>" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/satuan') !== false) ? 'bg-green-900' : 'hover:bg-green-600'; ?>">
                  <div class="pl-4"></div>
                  <svg class="menu-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                  </svg>                  
                  <span class="menu-text">Satuan</span>
                </a>
              </div>
            </div>

            <!-- Kelola Stok -->
            <a href="<?= base_url('modul/stok_masuk/index.php') ?>" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/stok_masuk') !== false) ? 'active' : ''; ?>">
              <svg class="menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
              </svg>
              <span class="menu-text">Kelola Stok Masuk</span>
            </a>
            
            <?php } ?>

            <!-- Kelola Penjualan -->
            <?php if ($sesi_peran_pengguna == "kasir" || $sesi_peran_pengguna == "admin") { ?>
            <div class="menu-group">
              <button onclick="toggleSubmenu('penjualanMenu')" class="menu-item w-full flex justify-between items-center <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/pelanggan') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/penjualan') !== false) ? 'active' : ''; ?>">
                <div class="flex items-center">
                  <svg class="menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                  </svg>                  
                  <span class="menu-text">Kelola Penjualan</span>
                </div>
                <svg class="w-4 h-4 menu-arrow transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
              </button>
            
              <div id="penjualanMenu" class="submenu bg-green-800 <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/pelanggan') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/penjualan') !== false) ? 'open' : ''; ?>">
                <a href="<?= base_url('modul/pelanggan/index.php') ?>" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/pelanggan') !== false) ? 'bg-green-900' : 'hover:bg-green-600'; ?>">
                  <div class="pl-4"></div>
                  <svg class="menu-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                  </svg>                  
                  <span class="menu-text">Pelanggan</span>
                </a>
                <a href="<?= base_url('modul/penjualan/index.php') ?>" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/penjualan') !== false) ? 'bg-green-900' : 'hover:bg-green-600'; ?>">
                  <div class="pl-4"></div>
                  <svg class="menu-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                  </svg>                  
                  <span class="menu-text">Transaksi Penjualan</span>
                </a>                
              </div>
            </div>
            <?php } ?>
            
            <!-- Kelola Laporan -->
            <?php if ($sesi_peran_pengguna == "pemilik" || $sesi_peran_pengguna == "admin") { ?>
            <div class="menu-group">
              <button onclick="toggleSubmenu('laporanMenu')" class="menu-item w-full flex justify-between items-center <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/laporan_stok_masuk') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/laporan_stok_keluar') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/laporan_stok') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/laporan_penjualan') !== false) ? 'active' : ''; ?>">
                <div class="flex items-center">
                  <svg class="menu-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                  </svg>                  
                  <span class="menu-text">Kelola Laporan</span>
                </div>
                <svg class="w-4 h-4 menu-arrow transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
              </button>
            
              <div id="laporanMenu" class="submenu bg-green-800 <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/laporan_stok_masuk') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/laporan_stok_keluar') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/laporan_stok_sekarang') !== false || strpos($_SERVER['REQUEST_URI'], 'modul/laporan_penjualan') !== false) ? 'open' : ''; ?>">
                <a href="<?= base_url('modul/laporan_stok_masuk/index.php') ?>" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/laporan_stok_masuk') !== false) ? 'bg-green-900' : 'hover:bg-green-600'; ?>">
                  <div class="pl-4"></div>
                  <svg class="menu-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3V3zm4 10l3-3m0 0l3 3m-3-3v6M14 7h4v4h-4V7z"/>
                  </svg>                  
                  <span class="menu-text">Laporan Stok Masuk</span>
                </a>
                <a href="<?= base_url('modul/laporan_stok_keluar/index.php') ?>" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/laporan_stok_keluar') !== false) ? 'bg-green-900' : 'hover:bg-green-600'; ?>">
                  <div class="pl-4"></div>
                  <svg class="menu-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v18H3V3zm4 10l3 3m0 0l3-3m-3 3v-6M14 7h4v4h-4V7z"/>
                  </svg>                  
                  <span class="menu-text">Laporan Stok Keluar</span>
                </a>                
                <a href="<?= base_url('modul/laporan_stok_sekarang/index.php') ?>" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/laporan_stok_sekarang') !== false) ? 'bg-green-900' : 'hover:bg-green-600'; ?>">
                  <div class="pl-4"></div>
                  <svg class="menu-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                  </svg>                  
                  <span class="menu-text">Laporan Stok</span>
                </a>
                <a href="<?= base_url('modul/laporan_penjualan/index.php') ?>" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/laporan_penjualan') !== false) ? 'bg-green-900' : 'hover:bg-green-600'; ?>">
                  <div class="pl-4"></div>
                  <svg class="menu-icon w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>                  
                  <span class="menu-text">Laporan Penjualan</span>
                </a>
              </div>
            </div>

            <!-- Pengguna -->
            <a href="<?= base_url('modul/pengguna/index.php') ?>" class="menu-item <?php echo (strpos($_SERVER['REQUEST_URI'], 'modul/pengguna') !== false) ? 'active' : ''; ?>">
              <svg class="menu-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
              <span class="menu-text">Kelola Pengguna</span>
            </a>

            <?php } ?>
          </nav>

          <div class="p-4 mt-auto border-t border-green-600">
            <div class="text-center text-sm text-white menu-text">
              © 2025 TOKO DAFA TANI
            </div>
          </div>
        </div>
      </aside>
      <!-- Main Content -->
      <main class="flex-1 overflow-y-auto max-h-screen custom-scrollbar">
        <!-- Header -->
        <header class="bg-white shadow-md p-4">
          <div class="flex justify-between items-center">
            <div class="flex items-center">
              <button onclick="toggleMobileSidebar()" class="md:hidden mr-4 text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
              </button>
              <a href="<?= base_url('dashboard.php') ?>" class="text-xl font-bold text-green-700">TOKO DAFA TANI</a>
            </div>
            
            <div class="flex items-center space-x-4">
              <?php
              // Query untuk mengecek produk dengan stok di bawah minimum
              $query = "SELECT id_produk, nama_produk, stok, stok_minimum FROM produk WHERE stok <= stok_minimum AND status_dihapus = 0 ORDER BY stok ASC";
              $result = mysqli_query($koneksi, $query);
              $low_stock_count = mysqli_num_rows($result);
              ?>
              
              <!-- Notification Bell -->
              <div class="relative z-50">
                <button onclick="toggleNotificationMenu()" class="p-2 text-gray-600 hover:text-green-700 focus:outline-none transition duration-300">
                  <svg class="w-6 h-6 sm:w-7 sm:h-7 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                  </svg>
                  <?php if ($low_stock_count > 0): ?>
                  <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full"><?= $low_stock_count ?></span>
                  <?php endif; ?>
                </button>
            
                <!-- Notification Dropdown -->
                <div id="notificationMenu" class="hidden absolute right-0 mt-2 w-[280px] sm:w-[320px] md:w-[380px] lg:w-[400px] bg-white rounded-lg shadow-xl border border-gray-200 max-w-[95vw]">
                  <div class="p-3 sm:p-4 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-700 text-sm sm:text-base">Notifikasi Stok</h3>
                  </div>
                  <div class="max-h-[60vh] sm:max-h-[70vh] md:max-h-96 overflow-y-auto custom-scrollbar">
                    <?php if ($low_stock_count > 0): ?>
                      <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <div class="p-3 sm:p-4 border-b border-gray-100 hover:bg-gray-50 transition duration-200">
                          <div class="flex items-center space-x-2 sm:space-x-3">
                            <div class="flex-shrink-0">
                              <?php if ($row['stok'] <= 0): ?>
                              <svg class="w-6 h-6 sm:w-7 sm:h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                              </svg>
                              <?php else: ?>
                              <svg class="w-6 h-6 sm:w-7 sm:h-7 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                              </svg>
                              <?php endif; ?>
                            </div>
                            <div class="flex-1 min-w-0">
                              <p class="text-sm sm:text-base font-medium <?= $row['stok'] <= 0 ? 'text-red-600' : 'text-gray-900' ?> truncate">
                                <?= htmlspecialchars($row['nama_produk']) ?>
                              </p>
                              <p class="text-xs sm:text-sm text-gray-500">
                                Stok: <span class="font-semibold <?= $row['stok'] <= 0 ? 'text-red-600' : 'text-yellow-600' ?>"><?= $row['stok'] ?></span> 
                                (Min: <?= $row['stok_minimum'] ?>)
                              </p>
                            </div>
                          </div>
                        </div>
                      <?php endwhile; ?>
                    <?php else: ?>
                      <div class="p-3 sm:p-4 text-center text-gray-500 text-sm sm:text-base">
                        Tidak ada notifikasi stok
                      </div>
                    <?php endif; ?>
                  </div>
                  <?php if ($low_stock_count > 0): ?>
                  <div class="p-3 sm:p-4 border-t border-gray-200 bg-gray-50">
                    <a href="<?= base_url('modul/laporan_stok_sekarang/index.php') ?>" class="block text-center text-xs sm:text-sm font-medium text-green-600 hover:text-green-700 transition duration-200">
                      Lihat Semua Stok
                    </a>
                  </div>
                  <?php endif; ?>
                </div>
              </div>

              
              <!-- Profile Menu -->
              <div class="relative z-50">    
                <button onclick="toggleProfileMenu()" class="flex items-center space-x-3 bg-green-700 hover:bg-green-800 hover:cursor-pointer text-white px-4 py-2 rounded-lg transition-all duration-300">
                  <span class="hidden md:block font-medium"><?php echo $sesi_nama_lengkap_pengguna ?></span>
                  <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                  </svg>
                </button>
              
                <div id="profileMenu" class="hidden absolute right-0 mt-2 w-64 bg-stone-100 rounded-lg shadow-xl border border-green-100 overflow-hidden">
                  <div class="p-4 bg-green-600 text-white">
                    <p class="font-semibold"><?php echo $sesi_nama_lengkap_pengguna ?></p>
                    <p class="text-sm text-green-100"><?php echo ucfirst($sesi_peran_pengguna) ?></p>
                  </div>
                  <div class="py-2">
                    <a href="<?= base_url('modul/profil.php') ?>" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors duration-200">
                      <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                      </svg>
                      Profil Saya
                    </a>
                    <a href="<?= base_url('modul/pengaturan.php') ?>" class="flex items-center px-4 py-2 text-gray-700 hover:bg-green-50 hover:text-green-700 transition-colors duration-200">
                      <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                      </svg>
                      Pengaturan
                    </a>
                    <hr class="my-2 border-gray-200">
                    <a href="<?= base_url('logout.php') ?>" class="flex items-center px-4 py-2 text-red-600 hover:bg-red-50 transition-colors duration-200">
                      <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                      </svg>
                      Keluar
                    </a>
                  </div>
                </div>
              </div>
            </div>          
          </div>

          <script>
          function toggleNotificationMenu() {
            const menu = document.getElementById('notificationMenu');
            menu.classList.toggle('hidden');
          }
          
          // Close notification menu when clicking outside
          document.addEventListener('click', function(event) {
            const menu = document.getElementById('notificationMenu');
            const button = event.target.closest('button');
            
            if (!menu.contains(event.target) && !button?.contains(event.target)) {
              menu.classList.add('hidden');
            }
          });
          </script>
        </header>