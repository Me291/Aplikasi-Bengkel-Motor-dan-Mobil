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

// Periksa apakah ID telah disertakan dalam URL dan merupakan angka
if (isset($_GET['Id']) && is_numeric($_GET['Id'])) {
    $id = $_GET['Id'];
    // Peroleh data karyawan berdasarkan ID dari URL
    $stmt = $conn->prepare("SELECT * FROM service_homes WHERE Id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $pecah = $result->fetch_assoc();
    } else {
        die("Data karyawan tidak ditemukan");
    }
    $stmt->close();
} else {
    die("ID tidak valid atau tidak disertakan dalam URL");
}

if (isset($_POST['Update'])) {
    // Pastikan semua inputan diproses secara aman dengan fungsi mysqli_real_escape_string
    $nama = mysqli_real_escape_string($conn, $_POST['Nama']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $alamat = mysqli_real_escape_string($conn, $_POST['Alamat']);
    $no_kendaraan = mysqli_real_escape_string($conn, $_POST['No_Kendaraan']);
    $no_telepon = mysqli_real_escape_string($conn, $_POST['No_Telepon']);
    $jenis_kendaraan = mysqli_real_escape_string($conn, $_POST['Jenis_Kendaraan']);

    // Periksa apakah nomor telepon sudah digunakan oleh user lain
    $stmt = $conn->prepare("SELECT Id FROM service_homes WHERE Id != ? AND No_Telepon = ?");
    $stmt->bind_param("is", $id, $no_telepon);
    $stmt->execute();
    $result_no_telepon = $stmt->get_result();

    // Periksa apakah nomor kendaraan sudah digunakan oleh user lain
    $stmt = $conn->prepare("SELECT Id FROM service_homes WHERE Id != ? AND No_Kendaraan = ?");
    $stmt->bind_param("is", $id, $no_kendaraan);
    $stmt->execute();
    $result_no_kendaraan = $stmt->get_result();

    // Jika hasil query tidak kosong, berarti nomor telepon atau nomor kendaraan sudah digunakan
    if ($result_no_telepon->num_rows > 0) {
        echo "<script>alert('Nomor telepon sudah digunakan oleh user lain');</script>";
    } elseif ($result_no_kendaraan->num_rows > 0) {
        echo "<script>alert('Nomor kendaraan sudah digunakan oleh user lain');</script>";
    } else {
        // Gunakan prepared statement untuk mencegah serangan SQL injection
        $stmt = $conn->prepare("UPDATE service_homes SET Nama=?, Email=?, Alamat=?, No_Kendaraan=?, No_Telepon=?, Jenis_Kendaraan=? WHERE Id=?");
        $stmt->bind_param("ssssssi", $nama, $email, $alamat, $no_kendaraan, $no_telepon, $jenis_kendaraan, $id);

        // Jalankan query
        if ($stmt->execute()) {
            echo "<script>alert('Data berhasil dirubah'); window.location.href = '../Admin Dashboard/Data Service Homes.php';</script>";
        } else {
            echo "<script>alert('Gagal merubah data');</script>";
        }
    }

    // Tutup statement
    $stmt->close();
}

// Tutup koneksi
$conn->close();
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

    <title>Update Data Service Homes</title>
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
                    <h2>Update Data Service Homes</h2>
                    <form action="#" class="form" method="post">
                        <div class="input-box">
                            <label>Nama</label>
                            <input type="text" placeholder="Masukan Nama Lengkap" required name="Nama"
                                value="<?php echo $pecah['Nama']; ?>" />
                        </div>
                        <div class="input-box">
                            <label>Email</label>
                            <input type="text" placeholder="Masukan Email" required name="Email"
                                value="<?php echo $pecah['Email']; ?>" />
                        </div>
                        <div class="input-box">
                            <label>Alamat</label>
                            <input type="text" placeholder="Masukan Alamat" required name="Alamat"
                                value="<?php echo $pecah['Alamat']; ?>" />
                        </div>
                        <div class="input-box">
                            <label>No Kendaraan</label>
                            <input type="text" placeholder="Masukan No Kendaraan " required name="No_Kendaraan"
                                value="<?php echo $pecah['No_Kendaraan']; ?>" />
                        </div>
                        <div class="input-box">
                            <label>No Telepon</label>
                            <input type="text" placeholder="Masukan No Telepon" required name="No_Telepon"
                                value="<?php echo $pecah['No_Telepon']; ?>" />
                        </div>
                        <div class="input-box">
                            <label>Jenis Kendaraan</label>
                            <input type="text" placeholder="Masukan Jenis Kendaraan" required name="Jenis_Kendaraan"
                                value="<?php echo $pecah['Jenis_Kendaraan']; ?>" />
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