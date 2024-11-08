<?php
session_start(); // Memulai sesi

// Periksa apakah data karyawan ada di sesi
if (!isset($_SESSION['login'])) {
  echo "<script>
          alert('Akses Ditolak. Anda Harus Login Terlebih Dahulu');
          window.location.href = '../Form.php'; // Mengalihkan ke halaman login
        </script>";
  exit(); // Menghentikan eksekusi skrip
}


require '../../Database/dservice_homes.php';

if (isset($_POST['Service'])) {
  if (Service($_POST) > 0) {
    echo "<script>
        alert('Terima Kasih Data Sudah Dikirim Konsumen Dapat Menunggu Informasi berikutnya');
        </script>";
    echo "<meta http-equiv='refresh' content='1;url=User.php'>";
  } else {
    // Menampilkan pesan kesalahan yang lebih informatif
    echo "<script>
        alert('Gagal mengirim data service: " . mysqli_error($conn) . "');
        </script>";
  }

  // Menutup koneksi setelah selesai menggunakan mysqli
  mysqli_close($conn);
}
?>

<?php

// Periksa apakah data user ada di sesi
if (!isset($_SESSION['login'])) {
  echo "<script>
          alert('Akses Ditolak. Anda Harus Login Terlebih Dahulu');
          window.location.href = '../Form.php'; // Mengalihkan ke halaman login
        </script>";
  exit(); // Menghentikan eksekusi skrip
}
?>

<?php
require '../../Database/dservice.php';

if (isset($_POST['Service_Now'])) {
  if (Service_Now($_POST) > 0) {
    echo "<script>
        alert('Terima Kasih Data Sudah Dikirim Konsumen Dapat Menunggu Informasi berikutnya');
        </script>";
    echo "<meta http-equiv='refresh' content='1;url=User.php'>";
  } else {
    // Menampilkan pesan kesalahan yang lebih informatif
    echo "<script>
        alert('Gagal mengirim data service: " . mysqli_error($conn) . "');
        </script>";
  }

  // Menutup koneksi setelah selesai menggunakan mysqli
  mysqli_close($conn);
}

// Periksa apakah data user ada di sesi

if (!isset($_SESSION['login'])) {
  echo "<script>alert('Akses Ditolak Anda Harus Login Terlebih Dahulu');</script>";
  echo "<script>window.location='../Form.php';</script>"; // Menggunakan window.location untuk mengalihkan
  exit(); // Menghentikan eksekusi skrip
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Service</title>
  <link rel="stylesheet" href="../../CSS/Daftar Service.css" />
</head>

<body>
  <main>
    <div class="box">
      <div class="inner-box">
        <div class="forms-wrap">
          <form action="" autocomplete="off" class="sign-in-form" method="post">
            <div class="logo">
              <h4>Bengkel Ride Assist</h4>
            </div>

            <div class="heading">
              <h2>Service</h2>
              <h6>Daftar Service Rumah Disini</h6>
              <a href="#" class="toggle">Homes</a>
            </div>


            <div class="actual-form">
              <div class="input-wrap">
                <input type="text" minlength="4" class="input-field" autocomplete="off" required name="Nama" />
                <label>Nama</label>
              </div>

              <div class="input-wrap">
                <input type="text" minlength="4" class="input-field" autocomplete="off" required name="Email" />
                <label>Email</label>
              </div>
              <div class="input-wrap">
                <input type="text" minlength="4" class="input-field" autocomplete="off" required name="No_Kendaraan" />
                <label>No Kendaraan</label>
              </div>
              <div class="input-wrap">
                <input type="text" minlength="4" class="input-field" autocomplete="off" required name="No_Telepon" />
                <label>No Telepon</label>
              </div>
              <div class="input-wrap">
                <input type="text" minlength="4" class="input-field" autocomplete="off" required
                  name="Jenis_Kendaraan" />
                <label>Jenis kendaraan</label>
              </div>
              <input type="submit" value="Daftar" class="sign-btn" name="Service_Now" />

              <p class="text">
                Kembali Ke Home Tekan
                <a href="User.php">Ini</a>
              </p>
            </div>
          </form>

          <form action="" autocomplete="off" method="post" class="sign-up-form">
            <div class="logo">
              <h4>Bengkel Ride Assist</h4>
            </div>

            <div class="heading">
              <h2>Service Homes</h2>
              <h6>Service ditempat disini</h6>
              <a href="#" class="toggle">Service</a>
            </div>

            <div class="actual-form">
              <div class="input-wrap">
                <input type="text" minlength="4" class="input-field" autocomplete="off" required name="Nama_Service" />
                <label>Nama</label>
              </div>

              <div class="input-wrap">
                <input type="text" minlength="4" class="input-field" autocomplete="off" required name="Email_Service" />
                <label>Email</label>
              </div>
              <div class="input-wrap">
                <input type="text" minlength="4" class="input-field" autocomplete="off" required
                  name="Alamat_Service" />
                <label>Alamat</label>
              </div>
              <div class="input-wrap">
                <input type="text" minlength="4" class="input-field" autocomplete="off" required
                  name="No_Kendaraan_Service" />
                <label>No Kendaraan</label>
              </div>
              <div class="input-wrap">
                <input type="text" minlength="4" class="input-field" autocomplete="off" required
                  name="No_Telepon_Service" />
                <label>No Telepon</label>
              </div>
              <div class="input-wrap">
                <input type="text" minlength="4" class="input-field" autocomplete="off" required
                  name="Jenis_Kendaraan_Service" />
                <label>Jenis kendaraan</label>
              </div>
              <input type="submit" value="Daftar" name="Service" class="sign-btn" />

              <p class="text">
                Kembali Ke Home Tekan
                <a href="User.php">Ini</a>
              </p>
            </div>
          </form>
        </div>

        <div class="carousel">
          <div class="images-wrapper">
            <img src="../../Image/image1.png" class="image img-1 show" alt="" />
            <img src="../../Image/image2.png" class="image img-2" alt="" />
            <img src="../../Image/image3.png" class="image img-3" alt="" />
          </div>

          <div class="text-slider">
            <div class="text-wrap">
              <div class="text-group">
                <h2>Create your own courses</h2>
                <h2>Customize as you like</h2>
                <h2>Invite students to your class</h2>
              </div>
            </div>

            <div class="bullets">
              <span class="active" data-value="1"></span>
              <span data-value="2"></span>
              <span data-value="3"></span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Javascript file -->

  <script src="../../JS/Daftar Service.js"></script>
</body>

</html>