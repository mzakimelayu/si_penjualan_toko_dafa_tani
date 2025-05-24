<?php
  // cek apakah ada session yang aktif
  session_start();
  if (isset($_SESSION['dataPengguna'])) {
      // Jika ada, redirect ke halaman dashboard
      header("Location: dashboard.php");
      exit();
  }

  // Panggil file koneksi.php untuk membuat koneksi ke database
  include 'koneksi/db.php';

// Logika login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form login
    $username = mysqli_real_escape_string($koneksi, $_POST['nama_pengguna']);
    $password = $_POST['kata_sandi']; // Ambil password tanpa hash
    
    // Query untuk mencari user dengan username
    $query = "SELECT * FROM pengguna WHERE nama_pengguna = '$username' AND status_dihapus = 0";
    $result = mysqli_query($koneksi, $query);
    
    // Cek apakah user ditemukan
    if (mysqli_num_rows($result) == 1) {
        // Ambil data pengguna
        $data = mysqli_fetch_assoc($result);
          
        // Verifikasi password dengan password_verify
        if (password_verify($password, $data['kata_sandi'])) {
            // Simpan data pengguna ke dalam session
            $_SESSION['dataPengguna'] = $data;
            
            // Redirect ke halaman dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Jika password tidak cocok
            $_SESSION['pesan_login'] = "Username atau password salah!";
            header("Location: login.php");
            exit();
        }
    } else {
        // Jika username tidak ditemukan
        $_SESSION['pesan_login'] = "Username atau password salah!";
        header("Location: login.php");
        exit();
    }
}

?>

<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="src/output.css" rel="stylesheet">
  <title>Login | Sistem Informasi Penjualan Toko Dafa Tani</title>
</head>
<body class="bg-gradient-to-r from-stone-100 via-green-50 to-yellow-50 min-h-screen flex items-center justify-center p-4">
  <div class="bg-white/90 backdrop-blur-sm p-6 sm:p-8 md:p-12 rounded-lg shadow-xl w-full max-w-xl mx-4 sm:mx-auto border border-green-100/50 hover:border-green-200 transition-all duration-300 ease-in-out">
    <div class="text-center mb-8 sm:mb-10">
      <div class="mb-4 sm:mb-6">
        <svg class="w-12 h-12 sm:w-16 sm:h-16 mx-auto text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 6a2 2 0 012-2h14a2 2 0 012 2v2a2 2 0 01-2 2H5a2 2 0 01-2-2V6zm0 6h18M5 12v6a2 2 0 002 2h10a2 2 0 002-2v-6M12 8v8m-4-4h8"/>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 16s-1.5-2 0-4c1.5-2 3 0 3 0s1.5-2 3 0c1.5 2 0 4 0 4H9z"/>
        </svg>      
      </div>
      <h1 class="text-2xl sm:text-3xl font-bold text-green-700 mb-2 sm:mb-3">TOKO DAFA TANI</h1>
      <p class="text-sm sm:text-base text-gray-600">Selamat datang kembali!</p>
    </div>

    <!-- Pesan Error Saat Login Gagal -->
    <?php
        if(isset($_SESSION['pesan_login'])) { ?>
          <div id="alert-message" class="mb-4 sm:mb-6 bg-gradient-to-r from-red-50 to-red-100 border-l-4 border-red-500 shadow-md p-3 sm:p-4 rounded-lg animate-fade-in-down flex justify-between items-center transform transition-all duration-300 hover:scale-[1.02]" role="alert">
            <div class="flex items-center space-x-2 sm:space-x-3">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              <p class="font-medium text-red-700 text-sm sm:text-base"><?php echo $_SESSION['pesan_login']; ?></p>
            </div>
            <button onclick="closeAlert()" class="p-1 sm:p-1.5 rounded-full hover:bg-red-200 transition-colors duration-200">
              <svg class="h-4 w-4 sm:h-5 sm:w-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
      unset($_SESSION['pesan_login']);
    } 
    ?>
    
    <!-- Pesan Berhasil Saat Berhasil Logout -->
    <?php
        if(isset($_SESSION['pesan_logout'])) { ?>
          <div id="alert-message" class="mb-4 sm:mb-6 bg-gradient-to-r from-green-50 to-green-100 border-l-4 border-green-500 shadow-md p-3 sm:p-4 rounded-lg animate-fade-in-down flex justify-between items-center transform transition-all duration-300 hover:scale-[1.02]" role="alert">
            <div class="flex items-center space-x-2 sm:space-x-3">
              <div class="flex-shrink-0">
                <svg class="h-5 w-5 sm:h-6 sm:w-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
              </div>
              <p class="font-medium text-green-700 text-sm sm:text-base"><?php echo $_SESSION['pesan_logout']; ?></p>
            </div>
            <button onclick="closeAlert()" class="p-1 sm:p-1.5 rounded-full hover:bg-green-200 transition-colors duration-200">
              <svg class="h-4 w-4 sm:h-5 sm:w-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
      unset($_SESSION['pesan_logout']);
    } 
    ?>

    <form action="" method="POST" class="space-y-4 sm:space-y-6">
      <div class="space-y-3 sm:space-y-4">
        <div class="relative">
          <label for="nama_pengguna" class="block text-sm sm:text-base font-medium text-gray-700 mb-1.5 sm:mb-2">Nama Pengguna</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 sm:pl-4 text-gray-500">
              <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
              </svg>
            </span>
            <input type="text" id="nama_pengguna" name="nama_pengguna" 
                   class="w-full pl-10 sm:pl-12 pr-4 py-2.5 sm:py-3 rounded-md border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-green-400 outline-none transition-all duration-200 bg-white/50 text-sm sm:text-base"
                   placeholder="Masukkan nama pengguna"
                   maxlength="50"
                   required>
          </div>
        </div>
        
        <div class="relative">
          <label for="kata_sandi" class="block text-sm sm:text-base font-medium text-gray-700 mb-1.5 sm:mb-2">Kata Sandi</label>
          <div class="relative">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3 sm:pl-4 text-gray-500">
              <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
              </svg>
            </span>
            <input type="password" id="kata_sandi" name="kata_sandi" 
                   class="w-full pl-10 sm:pl-12 pr-10 sm:pr-12 py-2.5 sm:py-3 rounded-md border border-gray-300 focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-green-400 outline-none transition-all duration-200 bg-white/50 text-sm sm:text-base"
                   placeholder="Masukkan kata sandi"
                   required>
            <button type="button" onclick="togglePassword()" class="absolute right-3 sm:right-4 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-green-600 transition-colors duration-200">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5" id="eyeIcon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
              </svg>
            </button>
          </div>
        </div>
      </div>
      
      <button type="submit" 
              class="w-full bg-green-600 text-white py-2.5 sm:py-3 rounded-md font-medium text-sm sm:text-base hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition-all duration-200 shadow-sm hover:shadow-md mt-6 sm:mt-8 hover:cursor-pointer">
        Login
      </button>
    </form>
  </div>
</body>

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
</body>
</html>