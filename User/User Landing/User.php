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
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="https://cdn.jsdelivr.net/npm/remixicon@4.1.0/fonts/remixicon.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../CSS/User.css" />
  <title>User Landing Page</title>
  <script src="https://kit.fontawesome.com/c856ca633a.js" crossorigin="anonymous"></script>
  <script
    type="text/javascript">window.$crisp = []; window.CRISP_WEBSITE_ID = "c712886d-986d-47e7-a6be-3e6dcdb6343a"; (function () { d = document; s = d.createElement("script"); s.src = "https://client.crisp.chat/l.js"; s.async = 1; d.getElementsByTagName("head")[0].appendChild(s); })();</script>
</head>

<body>
  <nav>
    <div class="nav__header">
      <div class="nav__logo">
        <a href="User.php">Welcome!!!</a>
      </div>
      <div class="nav__menu__btn" id="menu-btn">
        <i class="ri-menu-line"></i>
      </div>
    </div>
    <ul class="nav__links" id="nav-links">
      <li><a href="User.php">HOME</a></li>
      <li><a href="Galery.php">GALERI</a></li>
      <li><a href="Antrian.php">ANTRIAN</a></li>
      <li><a href="Custom.php">CUSTOM</a></li>
      <li><a href="Pembayaran.php">PEMBAYARAN</a></li>
      <li><a href="../../Database/Logout.php">LOG OUT</li>
    </ul>
    <div class="nav__btns">
      <button class="btn"><a href="../../Database/Logout.php"><i
            class="fa-solid fa-arrow-right-from-bracket"></i></a></button>
    </div>
  </nav>
  <div class="container">
    <div class="container__left">
      <h1>Ride Assist</h1>
      <div class="container__btn">
        <button class="btn"><a href="Daftar Service.php">Service Sekarang</a></button>
      </div>
    </div>
    <div class="container__right">
      <div class="images">
        <img src="https://images.unsplash.com/photo-1490902931801-d6f80ca94fe4?q=80&w=1770&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="tent-1" class="tent-1" />
        <img src="https://images.unsplash.com/photo-1508974239320-0a029497e820?q=80&w=1770&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="tent-2" class="tent-2" />
      </div>
      <div class="content">
        <h4>Hello!!</h4>
        <?php
        // Periksa apakah ada sesi login dan apakah sesi login berisi informasi pengguna
        if (isset($_SESSION['login']) && !empty($_SESSION['login'])) {
          // Tampilkan informasi pengguna yang saat ini login
          $user = $_SESSION['login'];
          echo "<h2>" . $user['Nama'] . "</h2>"; // Misalnya Nama adalah kolom dalam tabel data_user
        } else {
          echo "<h2>Selamat Datang, Pengguna</h2>";
        }
        ?>
        <h3>Sambutlah pengalaman servis mobil yang tak tertandingi.</h3>
<p>
  Dirancang bagi mereka yang ingin <span class="cool-word">menservice mobil</span>, 
  Pilihan mekanik yang <span class="cool-word">terbaik</span> kami menawarkan <span class="cool-word">kenyamanan</span> dan <span class="cool-word">keandalan</span> tanpa embel-embel yang tidak perlu.
</p>

      </div>


    </div>
    <div class="socials">
      <span>
        <a href="#"><i class="ri-facebook-fill"></i></a>
      </span>
      <span>
        <a href="#"><i class="ri-instagram-line"></i></a>
      </span>
      <span>
        <a href="#"><i class="ri-twitter-fill"></i></a>
      </span>
    </div>
  </div>

  <script src="https://unpkg.com/scrollreveal"></script>
  <script src="../../JS/Users.js"></script>
</body>

</html>