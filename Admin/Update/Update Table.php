<?php
session_start();

if (!isset($_SESSION['data_karyawan'])) {
    echo "<script>
            alert('Akses Ditolak. Anda Harus Login Terlebih Dahulu');
            window.location.href = '../Admin.php'; // Mengalihkan ke halaman login
          </script>";
    exit(); // Menghentikan eksekusi skrip
}

// Periksa koneksi database
include ('../../Connection/Koneksi.php');

// Periksa apakah ID telah disertakan dalam URL
if (isset($_GET['Id'])) {
    // Peroleh data karyawan berdasarkan ID dari URL
    $stmt = $conn->prepare("SELECT * FROM input_table WHERE Id = ?");
    $stmt->bind_param("i", $_GET['Id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $pecah = $result->fetch_assoc();
    $stmt->close();
} else {
    die("ID tidak disertakan dalam URL");
}

// Proses form jika dikirim
if (isset($_POST['Update'])) {
    // Pastikan semua inputan diproses secara aman dengan fungsi mysqli_real_escape_string
    $nama = mysqli_real_escape_string($conn, $_POST['Nama_Pemilik']);
    $no_kendaraan = mysqli_real_escape_string($conn, $_POST['No_Kendaraan']);
    $no_antrian = mysqli_real_escape_string($conn, $_POST['No_Antrian']);
    $jenis_kendaraan = mysqli_real_escape_string($conn, $_POST['Jenis_Motor']);
    $Status = mysqli_real_escape_string($conn, $_POST['Status']);

    // Validasi nomor kendaraan
    $stmt = $conn->prepare("SELECT * FROM input_table WHERE No_Kendaraan = ? AND Id != ?");
    $stmt->bind_param("si", $no_kendaraan, $_GET['Id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "Nomor Kendaraan sudah ada dalam database";
        exit;
    }

    // Validasi nomor antrian
    $stmt = $conn->prepare("SELECT * FROM input_table WHERE No_Antrian = ? AND Id != ?");
    $stmt->bind_param("si", $no_antrian, $_GET['Id']);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        echo "Nomor Antrian sudah ada dalam database";
        exit;
    }

    // Gunakan prepared statement untuk mencegah serangan SQL injection
    $stmt = $conn->prepare("UPDATE input_table SET Nama_Pemilik=?, No_Kendaraan=?, No_Antrian=?, Jenis_Motor=?, Status=?, Tanggal_Waktu=NOW() WHERE Id=?");
    $stmt->bind_param("sssssi", $nama, $no_kendaraan, $no_antrian, $jenis_kendaraan, $Status, $_GET['Id']);

    // Jalankan query
    $stmt->execute();

    // Cek apakah query berhasil dijalankan
    if ($stmt->affected_rows > 0) {
        echo '<script>alert("Data Berhasil Dirubah"); window.location.href = "../Admin Dashboard/Antrian.php";</script>';
        exit;
    } else {
        echo "Gagal merubah data";
    }

    $stmt->close(); // Penutupan kedua
}
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!----======== CSS ======== -->
    <link rel="stylesheet" href="../CSS/Input Main.css" />

    <!----===== Boxicons CSS ===== -->
    <link href="https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css" rel="stylesheet" />

    <title>Update Table</title>
</head>

<body>
    <nav class="sidebar close">
        <header>
            <div class="image-text">
                <span class="image">
                    <img src="https://images.unsplash.com/photo-1553736277-055142d018f0?q=80&w=1958&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
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
                        <a href="../Admin Dashboard/Dashboard.php">
                            <i class="bx bx-home-alt icon"></i>
                            <span class="text nav-text">Dashboard</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="../Admin Dashboard/User.php">
                            <i class='bx bx-user-plus icon'></i>
                            <span class="text nav-text">User</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="../Admin Dashboard/Pesan.php">
                            <i class='bx bx-chat icon'></i>
                            <span class="text nav-text">Pesan</span>
                        </a>
                    </li>


                    <li class="nav-link">
                        <a href="../Admin Dashboard/Data Karyawan.php">
                            <i class="bx bx-user-pin icon"></i>
                            <span class="text nav-text">Data Karyawan</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="../Admin Dashboard/Data Profile.php">
                            <i class="bx bx-image-alt icon"></i>
                            <span class="text nav-text">Profil Karyawan</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="../Admin Dashboard/Data Service Now.php">
                            <i class='bx bx-wrench icon'></i>
                            <span class="text nav-text">Service</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="../Admin Dashboard/Antrian.php">
                            <i class='bx bx-user-voice icon'></i>
                            <span class="text nav-text">Antrian</span>
                        </a>
                    </li>

                    <li class="nav-link">
                        <a href="../Admin Dashboard/Tampil User.php">
                            <i class='bx bx-money-withdraw icon'></i>
                            <span class="text nav-text">Pembayaran</span>
                        </a>
                    </li>
                    <li class="nav-link">
                        <a href="../Admin Dashboard/Payment.php">
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

            <section class="attendance">
                <div class="attendance-list">
                    <h2>Tambah Data Karyawan</h2>
                    <form action="#" class="form" method="post">
                        <div class="input-box">
                            <label>Nama Pemilik</label>
                            <input type="text" placeholder="Masukan Nama Lengkap" required name="Nama_Pemilik"
                                value="<?php echo $pecah['Nama_Pemilik']; ?>" />
                        </div>
                        <div class="input-box">
                            <label>No Kendaraan</label>
                            <input type="text" placeholder="Masukan No Kendaraan" required name="No_Kendaraan"
                                value="<?php echo $pecah['No_Kendaraan']; ?>" />
                        </div>
                        <div class="input-box">
                            <label>No Antrian</label>
                            <input type="text" placeholder="Masukan No Antrian" required name="No_Antrian"
                                value="<?php echo $pecah['No_Antrian']; ?>" />
                        </div>
                        <div class="input-box">
                            <label>Jenis Mobil</label>
                            <input type="text" placeholder="Masukan Jenis Motor" required name="Jenis_Motor"
                                value="<?php echo $pecah['Jenis_Mobil']; ?>" />
                        </div>
                        <div class="input-box">
                            <label>Status</label>
                            <div class="custom_select">
                                <select name="Status">
                                    <option value="<?php echo $pecah['Status']; ?>"><?php echo $pecah['Status']; ?>
                                    </option>
                                    <option value="Belum Dikerjakan">Belum Dikerjakan</option>
                                    <option value="Menunggu">Menungu</option>
                                    <option value="Selesai">Selesai</option>
                                </select>
                            </div>
                        </div>
                        <div class="btn-update">
                            <button name="Update">Update</button>
                        </div>
                    </form>
            </section>
        </section>
        <script src="../Js/Main.js"></script>
</body>

</html>