  <?php

  session_start();
  
  include '../../koneksi/db.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $nama_pelanggan = $_POST['nama_pelanggan'];
      $no_hp = $_POST['no_hp'];
      $alamat = $_POST['alamat'];

      try {
          // Insert new customer
          $query = mysqli_prepare($koneksi, "INSERT INTO pelanggan (nama_pelanggan, no_hp, alamat, status_dihapus) 
                              VALUES (?, ?, ?, 0)");
                            
          mysqli_stmt_bind_param($query, "sss", $nama_pelanggan, $no_hp, $alamat);
          mysqli_stmt_execute($query);

          $_SESSION['pelanggan_sukses'] = 'Data berhasil ditambahkan!';
          header('Location: index.php');
          exit;

      } catch(Exception $e) {
          echo "<script>
              alert('Terjadi kesalahan saat menambah data!');
              window.location.href='tambah.php';
          </script>";
      }
  }  ?>