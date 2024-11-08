<?php
session_start(); // Memulai sesi

require '../../Database/dservice_homes.php';

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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Antrian Menu</title>
    <link rel="stylesheet" type="text/css" href="../../CSS/Antrian.css">
</head>

<body>
    <main class="table" id="customers_table">
        <section class="table__header">
            <h1>Antrian Service</h1>
            <div class="input-group">
                <input type="search" placeholder="Search Data...">
                <img src="../../Image/search.png" alt="">
            </div>
        </section>
        <section class="table__body">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pemilik</th>
                        <th>Nomor Kendaraan</th>
                        <th>Nomor Antrian</th>
                        <th>Jenis Motor</th>
                        <th>Tanggal Pendaftaran</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $nomor = 1; ?>
                    <?php $ambil = $conn->query("SELECT * FROM input_table"); ?>
                    <?php while ($pecah = $ambil->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $nomor; ?></td>
                        <td><?php echo $pecah['Nama_Pemilik']; ?></td>
                        <td><?php echo $pecah['No_Kendaraan']; ?></td>
                        <td><?php echo $pecah['No_Antrian']; ?></td>
                        <td><?php echo $pecah['Jenis_Mobil']; ?></td>
                        <td>
                            <?php
                            // Pastikan Tanggal_Waktu tidak kosong atau null
                            if (!empty($pecah['Tanggal_Masuk'])) {
                                echo date('H:i d F Y', strtotime($pecah['Tanggal_Masuk']));
                            } else {
                                echo "Tanggal tidak tersedia"; // Tampilkan pesan atau nilai default
                            }
                            ?>
                        </td>

                        <td><?php echo $pecah['Status']; ?></td>
                    </tr>
                </tbody>
                <?php $nomor++; ?>
                <?php } ?>
                </tbody>
            </table>
        </section>
        <a href="User.php" class="btn btn-primary mb-2 mx-1">Home</a>
    </main>
    <script src="../../JS/Antrian.js"></script>

</body>

</html>