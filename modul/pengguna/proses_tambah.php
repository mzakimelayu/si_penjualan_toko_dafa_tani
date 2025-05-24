  <?php

  session_start();
  
  include '../../koneksi/db.php';

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $nama_lengkap = $_POST['nama_lengkap'];
      $nama_pengguna = $_POST['nama_pengguna'];
      $kata_sandi = $_POST['kata_sandi'];
      $no_hp = $_POST['no_hp'];
      $jenis_kelamin = $_POST['jenis_kelamin'];
      $peran = $_POST['peran'];
      $alamat = $_POST['alamat'];

      try {
          // Check if username already exists
          $check = mysqli_prepare($koneksi, "SELECT nama_pengguna FROM pengguna WHERE nama_pengguna = ?");
          mysqli_stmt_bind_param($check, "s", $nama_pengguna);
          mysqli_stmt_execute($check);
          $result = mysqli_stmt_get_result($check);
        
          if (mysqli_num_rows($result) > 0) {
            $_SESSION['pengguna_eror'] = 'Nama pengguna sudah digunakan!';
            header('Location: tambah.php');
            exit;       
          }

          // Hash password only if not empty
          if (!empty($kata_sandi)) {
              $hashed_password = password_hash($kata_sandi, PASSWORD_DEFAULT);
          } else {
              $_SESSION['pengguna_eror'] = 'Kata sandi tidak boleh kosong!';
              header('Location: tambah.php');
              exit;
          }

          // Insert new user
          $query = mysqli_prepare($koneksi, "INSERT INTO pengguna (nama_lengkap, nama_pengguna, kata_sandi, 
                              peran, no_hp, jenis_kelamin, alamat, status_dihapus) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, 0)");
                            
          mysqli_stmt_bind_param($query, "sssssss", $nama_lengkap, $nama_pengguna, $hashed_password, $peran, $no_hp, $jenis_kelamin, $alamat);
          mysqli_stmt_execute($query);

          
          $_SESSION['pengguna_sukses'] = 'Data berhasil ditambahkan!';
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