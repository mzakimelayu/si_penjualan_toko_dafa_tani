<?php
    $judul_halaman = "Edit Profil Pengguna";
    
    include '../cek_login.php';

    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_pengguna = $sesi_id_pengguna;
        $nama_lengkap = $_POST['nama_lengkap'];
        $nama_pengguna = $_POST['nama_pengguna'];
        $kata_sandi_lama = $_POST['kata_sandi_lama'];
        $kata_sandi_baru = $_POST['kata_sandi_baru'];
        $jenis_kelamin = $_POST['jenis_kelamin'];
        $no_hp = $_POST['no_hp'];
        $alamat = $_POST['alamat'];

        // cek nama pengguna sudah ada atau belum
        $query_cek_username = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE nama_pengguna='$nama_pengguna' AND id_pengguna != '$id_pengguna'");
        if(mysqli_num_rows($query_cek_username) > 0) {
            $_SESSION['pesan_gagal'] = "Nama pengguna sudah ada!";
            header("Location: " . base_url('modul/pengaturan.php'));
            exit();
        }
        
        // Cek kata sandi lama
        $query_cek = mysqli_query($koneksi, "SELECT kata_sandi FROM pengguna WHERE id_pengguna='$id_pengguna'");
        $data_cek = mysqli_fetch_array($query_cek);
        
        if($kata_sandi_lama != "" || $kata_sandi_baru != "") {
            if(!password_verify($kata_sandi_lama, $data_cek['kata_sandi'])) {
                $_SESSION['pesan_gagal'] = "Kata sandi lama tidak sesuai!";
                header("Location: " . base_url('modul/pengaturan.php'));                
                exit();
            }
            if($kata_sandi_lama != "" && $kata_sandi_baru == "") {
                $_SESSION['pesan_gagal'] = "Kata sandi baru tidak boleh kosong!";
                header("Location: " . base_url('modul/pengaturan.php'));
                exit();
            }
            $kata_sandi = password_hash($kata_sandi_baru, PASSWORD_DEFAULT);
            $update_password = ", kata_sandi='$kata_sandi'";
        } else {
            $update_password = "";
        }

        $query = mysqli_query($koneksi, "UPDATE pengguna SET 
            nama_lengkap='$nama_lengkap',
            nama_pengguna='$nama_pengguna',
            jenis_kelamin='$jenis_kelamin',
            no_hp='$no_hp',
            alamat='$alamat'
            $update_password
            WHERE id_pengguna='$id_pengguna'");

        if($query) {
            $_SESSION['pesan_sukses'] = "Profil berhasil diupdate!";
            header("Location: " . base_url('modul/pengaturan.php'));
            exit();
        } else {
            $_SESSION['pesan_gagal'] = "Profil gagal diupdate!";
            header("Location: " . base_url('modul/pengaturan.php'));
            exit();
        }
    }?>

<?php include '../layout/header.php'; ?>

<?php include '../layout/sidebar.php'; ?>

    <!-- Main Content Area -->
    <?php
    // Select data pengguna
    $id_pengguna = $sesi_id_pengguna;
    $query = mysqli_query($koneksi, "SELECT * FROM pengguna WHERE id_pengguna='$id_pengguna' AND status_dihapus=0");
    $data_pengguna = mysqli_fetch_array($query);
    ?>
    
    <div class="p-4 md:p-6 animate-slide-fade">
        <div class="bg-stone-100 rounded-lg p-6 shadow-lg animate-scale">
            <h2 class="text-2xl font-bold text-green-700 mb-6">Pengaturan Profil</h2>


            <!-- Pesan Error Saat Update Profil -->
            <?php
                if(isset($_SESSION['pesan_gagal'])) { ?>
                <div id="alert-message" class="mb-4 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 shadow-md p-4 rounded-lg animate-fade-in-down flex justify-between items-center transform transition-all duration-300 hover:scale-[1.02]" role="alert">
                    <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <p class="font-medium text-red-700"><?php echo $_SESSION['pesan_gagal']; ?></p>
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
            unset($_SESSION['pesan_gagal']);
            } 
            ?>
            
            <!-- Pesan Berhasil Saat Berhasil Update Profil -->
            <?php
                if(isset($_SESSION['pesan_sukses'])) { ?>
                <div id="alert-message" class="mb-4 bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 shadow-md p-4 rounded-lg animate-fade-in-down flex justify-between items-center transform transition-all duration-300 hover:scale-[1.02]" role="alert">
                    <div class="flex items-center space-x-3">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <p class="font-medium text-green-700"><?php echo $_SESSION['pesan_sukses']; ?></p>
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
            unset($_SESSION['pesan_sukses']);
            } 
            ?>
            
            <form action="" method="POST" class="space-y-8 animate-smooth">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="nama_lengkap">Nama Lengkap</label>
                        <input type="text" name="nama_lengkap" id="nama_lengkap" value="<?= $data_pengguna['nama_lengkap'] ?>" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 shadow-sm focus:border-green-600 focus:ring-4 focus:ring-green-100 focus:outline-none transition-all duration-300 bg-white" required>
                    </div>
                    
                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="nama_pengguna">Nama Pengguna</label>
                        <input type="text" name="nama_pengguna" id="nama_pengguna" value="<?= $data_pengguna['nama_pengguna'] ?>" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 shadow-sm focus:border-green-600 focus:ring-4 focus:ring-green-100 focus:outline-none transition-all duration-300 bg-white" required>
                    </div>

                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 shadow-sm focus:border-green-600 focus:ring-4 focus:ring-green-100 focus:outline-none transition-all duration-300 bg-white appearance-none">
                            <option value="Laki-laki" <?= $data_pengguna['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= $data_pengguna['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>

                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="no_hp">Nomor HP</label>
                        <input type="text" name="no_hp" id="no_hp" value="<?= $data_pengguna['no_hp'] ?>" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 shadow-sm focus:border-green-600 focus:ring-4 focus:ring-green-100 focus:outline-none transition-all duration-300 bg-white">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="alamat">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="4" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 shadow-sm focus:border-green-600 focus:ring-4 focus:ring-green-100 focus:outline-none transition-all duration-300 bg-white resize-none"><?= $data_pengguna['alamat'] ?></textarea>
                    </div>

                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="kata_sandi_lama">Kata Sandi Lama</label>
                        <div class="relative">
                            <input type="password" name="kata_sandi_lama" id="kata_sandi_lama" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 shadow-sm focus:border-green-600 focus:ring-4 focus:ring-green-100 focus:outline-none transition-all duration-300 bg-white pr-12">
                            <button type="button" onclick="togglePasswordLama()" class="absolute right-4 top-1/2 transform -translate-y-1/2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 hover:text-green-600 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="eyeIconLama">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="group">
                        <label class="block text-sm font-semibold text-gray-700 mb-2" for="kata_sandi_baru">Kata Sandi Baru</label>
                        <div class="relative">
                            <input type="password" name="kata_sandi_baru" id="kata_sandi_baru" class="w-full px-4 py-3 rounded-lg border-2 border-gray-200 shadow-sm focus:border-green-600 focus:ring-4 focus:ring-green-100 focus:outline-none transition-all duration-300 bg-white pr-12">
                            <button type="button" onclick="togglePasswordBaru()" class="absolute right-4 top-1/2 transform -translate-y-1/2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 hover:text-green-600 transition-colors duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="eyeIconBaru">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-4 pt-4">
                    <a href="<?= base_url('dashboard.php') ?>" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition duration-200 flex items-center justify-center">
                        Batal
                    </a>
                    <button type="submit" name="submit" class="px-8 py-3 bg-green-700 hover:bg-green-800 text-white font-semibold rounded-lg transition-all duration-300 shadow-lg transform focus:ring-4 focus:ring-green-200 active:bg-green-900">
                        Simpan Perubahan
                    </button>
                </div>            
            </form>
        </div>
    </div>
    
    <script>
        function togglePasswordLama() {
            const passwordInput = document.getElementById('kata_sandi_lama');
            const eyeIcon = document.getElementById('eyeIconLama');
            
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
                }
                `;
            }
        }

        function togglePasswordBaru() {
            const passwordInput = document.getElementById('kata_sandi_baru');
            const eyeIcon = document.getElementById('eyeIconBaru');

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

<?php include ('../layout/footer.php'); ?>