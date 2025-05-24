<?php
    $judul_halaman = "Edit Pengguna";
    
    include '../../cek_login.php';

    // Ambil data pengguna berdasarkan ID
    $id_pengguna = $_GET['id'];
    $query = "SELECT * FROM pengguna WHERE id_pengguna = '$id_pengguna'";
    $result = mysqli_query($koneksi, $query);
    $data = mysqli_fetch_assoc($result);

    if (mysqli_num_rows($result) == 0) {
        echo "<script>window.location.href='" . base_url('404.php') . "';</script>";                    
        exit;
    }
?>

<?php include '../../layout/header.php'; ?>

<?php include '../../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <div class="p-6 animate-slide-fade">    
        <!-- Form Section -->
        <div class="bg-stone-100 rounded-lg p-6 shadow-md animate-scale">
            <h2 class="text-2xl font-semibold text-gray-700 mb-6">Edit Pengguna</h2>
            
            <!-- Pesan Error Saat Login Gagal -->
            <?php
                if(isset($_SESSION['pengguna_eror'])) { ?>
                <div id="alert-message" class="mb-4 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 shadow-md p-4 rounded-lg animate-fade-in-down flex justify-between items-center transform transition-all duration-300 hover:scale-[1.02]" role="alert">
                    <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="font-medium text-red-700"><?php echo $_SESSION['pengguna_eror']; ?></p>
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
            unset($_SESSION['pengguna_eror']);
            } 
            ?>

            <form action="proses_edit.php" method="POST" class="space-y-4">
                <input type="hidden" name="id_pengguna" value="<?php echo $data['id_pengguna']; ?>">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="animate-smooth">
                        <label for="nama_lengkap" class="block text-gray-700 mb-2">Nama Lengkap</label>
                        <input type="text" id="nama_lengkap" name="nama_lengkap" required value="<?php echo $data['nama_lengkap']; ?>"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition duration-300">
                    </div>
                    
                    <div class="animate-smooth">
                        <label for="nama_pengguna" class="block text-gray-700 mb-2">Nama Pengguna</label>
                        <input type="text" id="nama_pengguna" name="nama_pengguna" required value="<?php echo $data['nama_pengguna']; ?>"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition duration-300">
                    </div>

                    <div class="animate-smooth">
                        <label for="kata_sandi" class="block text-gray-700 mb-2">Kata Sandi</label>
                        <div class="relative">
                            <input type="password" id="kata_sandi" name="kata_sandi" placeholder="Kosongkan jika tidak ingin mengubah kata sandi"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition duration-300">
                            <button type="button" onclick="togglePassword()" class="absolute right-2 top-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="eyeIcon">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="animate-smooth">
                        <label for="no_hp" class="block text-gray-700 mb-2">Nomor HP</label>
                        <input type="tel" id="no_hp" name="no_hp" value="<?php echo $data['no_hp']; ?>"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition duration-300">
                    </div>

                    <div class="animate-smooth">
                        <label for="jenis_kelamin" class="block text-gray-700 mb-2">Jenis Kelamin</label>
                        <select id="jenis_kelamin" name="jenis_kelamin"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition duration-300">
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" <?php echo ($data['jenis_kelamin'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                            <option value="Perempuan" <?php echo ($data['jenis_kelamin'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                        </select>
                    </div>

                    <div class="animate-smooth">
                        <label for="peran" class="block text-gray-700 mb-2">Peran</label>
                        <select id="peran" name="peran" required
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition duration-300">
                            <option value="">Pilih Peran</option>
                            <option value="admin" <?php echo ($data['peran'] == 'admin') ? 'selected' : ''; ?>>Admin</option>
                            <option value="kasir" <?php echo ($data['peran'] == 'kasir') ? 'selected' : ''; ?>>Kasir</option>
                            <option value="pemilik" <?php echo ($data['peran'] == 'pemilik') ? 'selected' : ''; ?>>Pemilik</option>
                        </select>
                    </div>

                    <div class="col-span-2 animate-smooth">
                        <label for="alamat" class="block text-gray-700 mb-2">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="3"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-600 focus:border-green-600 transition duration-300"><?php echo $data['alamat']; ?></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-2 pt-4">
                    <a href="index.php" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-300">
                        Batal
                    </a>
                    <button type="submit" class="px-4 py-2 bg-green-700 text-white rounded-lg hover:bg-green-800 transition duration-300">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script>
    function togglePassword() {
      const passwordInput = document.getElementById('kata_sandi');
      const eyeIcon = document.getElementById('eyeIcon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
        `;
      } else {
        passwordInput.type = 'password';
        eyeIcon.innerHTML = `
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
        `;
      }
    }
  </script>

<?php include ('../../layout/footer.php'); ?>