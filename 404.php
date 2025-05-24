<?php

function base_url($path = '') {
    $host = $_SERVER['HTTP_HOST'];
    
    // Jika menggunakan Ngrok, paksa HTTPS
    if (strpos($host, "ngrok-free.app") !== false) {
        $protocol = "https";
    } else {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";
    }

    $project_folder = "/si_penjualan_toko_dafa_tani/"; 

    return $protocol . '://' . $host . $project_folder . $path;
}
?>

<!doctype html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="src/output.css" rel="stylesheet">
  <title>404 Not Found | Data Tidak Ditemukan</title>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen flex items-center justify-center p-4">
  <div class="max-w-3xl w-full bg-white rounded-2xl shadow-2xl overflow-hidden transform hover:scale-[1.02] transition-all duration-300">
    <div class="bg-gradient-to-r from-green-600 to-green-700 p-12 text-white text-center relative overflow-hidden">
      <div class="absolute top-0 left-0 w-full h-full opacity-10">
        <div class="absolute transform rotate-45 -translate-y-1/2 -translate-x-1/2" style="width: 600px; height: 600px; background: linear-gradient(rgba(255,255,255,0.1), rgba(255,255,255,0.05));"></div>
      </div>
      <h1 class="text-8xl font-extrabold mb-4 tracking-tighter">404</h1>
      <h2 class="text-3xl font-bold mb-3">Data Tidak Ditemukan</h2>
      <div class="w-24 h-1.5 bg-yellow-400 mx-auto my-6 rounded-full shadow-lg"></div>
    </div>
    
    <div class="bg-white p-12">
      <div class="text-center">
        <p class="text-gray-700 text-xl mb-8 leading-relaxed">Maaf, data atau halaman yang Anda cari tidak dapat ditemukan.</p>
        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
          <a href="<?= base_url('dashboard.php') ?>" class="px-8 py-4 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-xl hover:from-green-700 hover:to-green-800 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1">
            <span class="flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
              </svg>
              Kembali ke Beranda
            </span>
          </a>
          <a href="javascript:history.back()" class="px-8 py-4 bg-gradient-to-r from-yellow-400 to-yellow-500 text-white rounded-xl hover:from-yellow-500 hover:to-yellow-600 transition-all duration-300 font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-1">
            <span class="flex items-center">
              <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
              </svg>
              Kembali
            </span>
          </a>
        </div>
      </div>
    </div>
    
    <div class="bg-gray-50 p-6 border-t border-gray-100">
      <p class="text-center text-gray-600 text-sm flex items-center justify-center">
        <svg class="w-5 h-5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Jika Anda merasa ini adalah kesalahan, silakan hubungi administrator sistem
      </p>
    </div>
  </div>
</body>
</html>