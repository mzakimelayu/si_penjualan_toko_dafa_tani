  <?php

  session_start();
  
  include '../../koneksi/db.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $kode_produk = $_POST['kode_produk'];
      $nama_produk = $_POST['nama_produk'];
      $id_kategori = $_POST['id_kategori'];
      $id_satuan = $_POST['id_satuan'];
      $harga_jual = $_POST['harga_jual'];
      $harga_beli = $_POST['harga_beli'];
      $stok = $_POST['stok'];
      $stok_minimum = $_POST['stok_minimum'];
      $deskripsi = $_POST['deskripsi'];

      try {
          // Check if product code already exists
          $check = mysqli_prepare($koneksi, "SELECT kode_produk FROM produk WHERE kode_produk = ? AND status_dihapus = 0");
          mysqli_stmt_bind_param($check, "s", $kode_produk);
          mysqli_stmt_execute($check);
          $result = mysqli_stmt_get_result($check);
        
          if (mysqli_num_rows($result) > 0) {
            $_SESSION['produk_eror'] = 'Kode produk sudah digunakan!';
            header('Location: tambah.php');
            exit;       
          }

          // Insert new product
          $query = mysqli_prepare($koneksi, "INSERT INTO produk (kode_produk, nama_produk, id_kategori, id_satuan, 
                              harga_jual, harga_beli, stok, stok_minimum, deskripsi, status_dihapus) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 0)");
                            
          mysqli_stmt_bind_param($query, "ssiiddiis", $kode_produk, $nama_produk, $id_kategori, $id_satuan, 
                               $harga_jual, $harga_beli, $stok, $stok_minimum, $deskripsi);
          mysqli_stmt_execute($query);

          $_SESSION['produk_sukses'] = 'Data berhasil ditambahkan!';
          header('Location: index.php');
          exit;

      } catch(Exception $e) {
          echo "<script>
              alert('Terjadi kesalahan saat menambah data!');
              window.location.href='tambah.php';
          </script>";
      }
  }  
  
  ?>