<?php
session_start();

// Periksa apakah data user ada di sesi
if (!isset($_SESSION['data_karyawan'])) {
    echo "<script>
            alert('Akses Ditolak. Anda Harus Login Terlebih Dahulu');
            window.location.href = '../Admin.php'; // Mengalihkan ke halaman login
          </script>";
    exit(); // Menghentikan eksekusi skrip
}

include ('../../Connection/Koneksi.php');

// Periksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Dapatkan tanggal dari parameter query string
$tanggal = isset($_GET['report-date']) ? $_GET['report-date'] : date('Y-m-d');

// Mengambil data laporan harian dari database
$queryKaryawan = "SELECT COUNT(*) AS total_karyawan FROM data_karyawan";
$resultKaryawan = mysqli_query($conn, $queryKaryawan);
$dataKaryawan = mysqli_fetch_assoc($resultKaryawan);

// Pastikan kolom 'Tanggal_Pembayaran' ada di tabel 'pembayaran_user'
$queryPembayaran = "SELECT SUM(Jumlah) AS Jumlah FROM pembayaran WHERE DATE(Tanggal_Pembayaran) = '$tanggal'";
$resultPembayaran = mysqli_query($conn, $queryPembayaran);
$dataPembayaran = mysqli_fetch_assoc($resultPembayaran);

// Mengambil total semua pembayaran dari database
$queryTotalPembayaran = "SELECT SUM(Jumlah) AS total_semua_pembayaran FROM pembayaran";
$resultTotalPembayaran = mysqli_query($conn, $queryTotalPembayaran);
$rowTotalPembayaran = mysqli_fetch_assoc($resultTotalPembayaran);
$totalSemuaPembayaran = $rowTotalPembayaran['total_semua_pembayaran'];

// Query untuk mengambil jumlah pengguna berdasarkan bank
// Pastikan nama tabel dan kolom sesuai dengan yang ada di database
$queryBankUsers = "SELECT Nama_Bank, COUNT(*) AS Jumlah_Pengguna FROM pembayaran GROUP BY Nama_Bank";
$resultBankUsers = mysqli_query($conn, $queryBankUsers);

// Menutup koneksi database
mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!----======== CSS ======== -->
  <link rel="stylesheet" href="../CSS/Main.css" />
  <!----===== Boxicons CSS ===== -->
  <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />

  <title>Dashboard</title>
</head>

<body>
  <nav class="sidebar close">
    <header>
      <div class="image-text">
        <span class="image">
          <img
            src="https://images.unsplash.com/photo-1553736277-055142d018f0?q=80&w=1958&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
            alt="" />
        </span>

        <div class="text logo-text">
          <span class="name">Tegar</span>
          <span class="profession">Karyawan</span>
        </div>
      </div>

      <i class="bx bx-chevron-right toggle"></i>
    </header>

    <div class="menu-bar">
      <div class="menu">
        <ul class="menu-links">
          <li class="nav-link">
            <a href="Dashboard.php">
              <i class="bx bx-home-alt icon"></i>
              <span class="text nav-text">Dashboard</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="User.php">
              <i class='bx bx-user-plus icon'></i>
              <span class="text nav-text">User</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="Pesan.php">
              <i class='bx bx-chat icon'></i>
              <span class="text nav-text">Pesan</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="Data Karyawan.php">
              <i class="bx bx-user-pin icon"></i>
              <span class="text nav-text">Data Karyawan</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="Data Profile.php">
              <i class="bx bx-image-alt icon"></i>
              <span class="text nav-text">Profil Karyawan</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="Data Service Now.php">
              <i class='bx bx-wrench icon'></i>
              <span class="text nav-text">Service</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="Antrian.php">
              <i class='bx bx-user-voice icon'></i>
              <span class="text nav-text">Antrian</span>
            </a>
          </li>

          <li class="nav-link">
            <a href="Tampil User.php">
              <i class='bx bx-money-withdraw icon'></i>
              <span class="text nav-text">Pembayaran</span>
            </a>
          </li>
          <li class="nav-link">
            <a href="Payment.php">
              <i class='bx bx-credit-card-alt bx-flip-horizontal icon'></i>
              <span class="text nav-text">Info Pembayaran</span>
            </a>
          </li>
        </ul>
      </div>

      <div class="bottom-content">
        <li class="">
          <a href="../../Database/Logout Karyawan.php">
            <i class="bx bx-log-out icon"></i>
            <span class="text nav-text">Logout</span>
          </a>
        </li>
      </div>
    </div>
  </nav>

  <section class="home">
    <section class="main">
      <div class="main-top">
        <i class="fas fa-user-cog"></i>
      </div>
      <div class="users">
        <div class="card">
          <img src="1.webp">
          <h4>Benediktus Prayoga</h4>
          <p>Ceo</p>
          <div class="per">
            <table>
              <tr>
                <td><span>85%</span></td>
                <td><span>87%</span></td>
              </tr>
              <tr>
                <td>Month</td>
                <td>Year</td>
              </tr>
            </table>
          </div>
          <!-- Tambahkan kelas unik ke tombol -->
          <button class="card-button">Profile</button>
        </div>
        <div class="card">
          <img src="1.webp">
          <h4>Rama Dhani</h4>
          <p>Admin</p>
          <div class="per">
            <table>
              <tr>
                <td><span>85%</span></td>
                <td><span>87%</span></td>
              </tr>
              <tr>
                <td>Month</td>
                <td>Year</td>
              </tr>
            </table>
          </div>
          <!-- Tambahkan kelas unik ke tombol -->
          <button class="card-button">Profile</button>
        </div>
        <div class="card">
          <img src="1.webp">
          <h4>Dio Maulana Nurjayadi</h4>
          <p>Admin</p>
          <div class="per">
            <table>
              <tr>
                <td><span>85%</span></td>
                <td><span>87%</span></td>
              </tr>
              <tr>
                <td>Month</td>
                <td>Year</td>
              </tr>
            </table>
          </div>
          <!-- Tambahkan kelas unik ke tombol -->
          <button class="card-button">Profile</button>
        </div>
        <div class="card">
          <img src="1.webp">
          <h4>Muhamad Rifky Fahriza</h4>
          <p>Admin</p>
          <div class="per">
            <table>
              <tr>
                <td><span>85%</span></td>
                <td><span>87%</span></td>
              </tr>
              <tr>
                <td>Month</td>
                <td>Year</td>
              </tr>
            </table>
          </div>
          <!-- Tambahkan kelas unik ke tombol -->
          <button class="card-button">Profile</button>
        </div>
        <div class="card">
          <img src="1.webp">
          <h4>Fadhil Nugraha</h4>
          <p>Admin</p>
          <div class="per">
            <table>
              <tr>
                <td><span>85%</span></td>
                <td><span>87%</span></td>
              </tr>
              <tr>
                <td>Month</td>
                <td>Year</td>
              </tr>
            </table>
          </div>
          <!-- Tambahkan kelas unik ke tombol -->
          <button class="card-button">Profile</button>
        </div>
      </div>
      <div class="daily-report">
        <h2>Laporan Keuangan Harian</h2>
        <form action="" method="get">
          <label for="report-date">Pilih Tanggal: </label>
          <input type="date" id="report-date" name="report-date" value="<?php echo htmlspecialchars($tanggal); ?>">
          <button type="submit">Cari</button>
        </form>
        <section class="section-total-employees">
          <h3>Total Karyawan</h3>
          <table class="report-table">
            <tr>
              <th>Deskripsi</th>
              <th>Jumlah</th>
            </tr>
            <tr>
              <td>Total Karyawan</td>
              <td><?php echo $dataKaryawan['total_karyawan']; ?></td>
            </tr>
          </table>
        </section>
        <section class="section-daily-income">
          <h3>Total Pemasukan Hari Ini</h3>
          <table class="report-table">
            <tr>
              <th>Deskripsi</th>
              <th>Jumlah</th>
            </tr>
            <?php if ($dataPembayaran !== null && isset($dataPembayaran['Jumlah'])): ?>
            <tr>
              <td>Total Pemasukan Hari Ini</td>
              <td><?php echo 'Rp ' . number_format($dataPembayaran['Jumlah'], 0, ',', '.') . ',00'; ?></td>
            </tr>
            <?php else: ?>
            <tr>
              <td colspan="2" class="error-cell">Tanggal tidak valid atau belum ada transaksi</td>
            </tr>
            <?php endif; ?>
          </table>
        </section>
        <section class="section-total-payments">
          <h3>Total Semua Pembayaran</h3>
          <table class="report-table">
            <tr>
              <th>Deskripsi</th>
              <th>Jumlah</th>
            </tr>
            <tr>
              <td>Total Semua Pembayaran</td>
              <td><?php echo 'Rp ' . number_format($totalSemuaPembayaran, 0, ',', '.') . ',00'; ?></td>
            </tr>
          </table>
        </section>
        <section class="section-bank-users">
          <h3>Pengguna Berdasarkan Bank</h3>
          <table class="report-table">
            <tr>
              <th>Bank</th>
              <th>Jumlah Pengguna</th>
            </tr>
            <?php
            while ($row = mysqli_fetch_assoc($resultBankUsers)) {
              echo "<tr>";
              echo "<td>" . htmlspecialchars($row['Nama_Bank']) . "</td>";
              echo "<td>" . $row['Jumlah_Pengguna'] . "</td>";
              echo "</tr>";
            }
            ?>
          </table>
        </section>
        <!-- Tambahan bagian-bagian lainnya dapat ditambahkan sesuai kebutuhan -->
      </div>

    </section>
  </section>
  <script src="../Js/Main.js"></script>
</body>

</html>