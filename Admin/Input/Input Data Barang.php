<?php
session_start();

if (!isset($_SESSION['data_karyawan'])) {
    echo "<script>
            alert('Akses Ditolak. Anda Harus Login Terlebih Dahulu');
            window.location.href = '../Admin.php'; // Mengalihkan ke halaman login
          </script>";
    exit(); // Menghentikan eksekusi skrip
}

include ('../../Connection/Koneksi.php');

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil ID dari parameter URL
if (isset($_GET['Id'])) {
    $id = $_GET['Id'];
} else {
    // Tangani kasus ketika Id tidak diberikan dalam URL
    echo "<script>alert('Id tidak diberikan dalam URL');</script>";
    exit();
}

// Cek apakah tombol Tambah ditekan
if (isset($_POST['Tambah'])) {
    // Ambil nilai dari inputan form dan lakukan sanitasi
    $nama_barang = mysqli_real_escape_string($conn, $_POST['Nama_Barang']);
    $merk = mysqli_real_escape_string($conn, $_POST['Merk']);
    $jumlah = (int)$_POST['Jumlah']; // Ensure this is an integer
    $harga = (float)$_POST['Harga']; // Ensure this is a float

    // Prepare statement
    $stmt = $conn->prepare("INSERT INTO invoice (Id_User, Nama_Barang, Merk, Jumlah, Harga) VALUES (?, ?, ?, ?, ?)");
    
    // Check if prepare failed
    if ($stmt === false) {
        die("Prepare failed: " . htmlspecialchars($conn->error));
    }

    // Bind parameters
    $stmt->bind_param("issid", $id, $nama_barang, $merk, $jumlah, $harga);

    // Execute the statement
    if ($stmt->execute()) {
        // Redirect ke halaman Data Pembayaran setelah menambahkan barang
        header("Location: ../Admin Dashboard/Tampil User.php?Id=$id");
        exit();
    } else {
        // Tampilkan pesan error menggunakan alert JavaScript
        echo "<script>alert('Gagal menambahkan barang: " . htmlspecialchars($stmt->error) . "');</script>";
    }

    // Close the statement
    $stmt->close();
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

    <title>Input Data Barang</title>
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
                    <h2>Tambah Data Barang</h2>
                    <form action="#" class="form" method="post">
                        <div class="input-box">
                            <label>Nama Barang</label>
                            <input type="text" placeholder="Masukan Nama Barang" required name="Nama_Barang"
                                id="nama_barang" />
                        </div>
                        <div class="input-box">
                            <label>Merk</label>
                            <div class="custom_select">
                                <select name="Merk" id="merk">
                                    <option value="">Select</option>
                                    <option value="Honda">Honda</option>
                                    <option value="Yamaha">Yamaha</option>
                                    <option value="Suzuki">Suzuki</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-box">
                            <label>Jumlah</label>
                            <input type="text" placeholder="Masukan Jumlah" required name="Jumlah" />
                        </div>
                        <div class="input-box">
                            <label>Harga</label>
                            <input type="text" placeholder="Masukan Harga" required name="Harga" id="harga_barang"
                                readonly />
                        </div>
                        <div class="btn-update">
                            <button name="Tambah">Tambah</button>
                        </div>
                    </form>
                </div>
            </section>
        </section>
    </section>
    <script src="../Js/Main.js"></script>
    <script>
        // Data harga barang berdasarkan merk dan nama barang sparepart motor
        const hargaBarangData = {
            "Honda": {
                "Filter Udara": 100000,
                "Kampas Rem": 120000,
                "Oli Mesin": 110000,
                "Aki": 300000,
                "Kabel Busi": 25000,
                "Shock Absorber": 180000,
                "Ban Belakang": 500000,
                "Karburator": 350000,
                "Lampu Depan": 75000,
                "Lampu Belakang": 60000,
                "Spion": 40000,
                "Rantai": 120000,
                "Piston": 85000,
                "Karpet": 30000,
                "Kunci Kontak": 45000,
                "Karet Kaki": 20000,
                "Gir Depan": 160000,
                "Gir Belakang": 180000,
                "Dinamo Starter": 280000,
                "Kopling": 90000,
                "Filter Oli": 25000,
                "Radiator": 220000,
                "Koil": 150000,
                "Knalpot": 400000,
                "Selang Bensin": 30000,
                "Kompresor AC": 350000,
                "Sensor Parkir": 80000,
                "Pengatur Karburator": 120000,
                "Pegas Rem": 60000,
                "Piston Rem": 70000,
                "Saklar Lampu": 45000,
                "Starter Motor": 180000,
                "Baut Roda": 10000,
                "Kabel Kelistrikan": 25000,
                "Katup": 30000,
                "Throttle Body": 180000,
                "Timing Belt": 160000,
                "Turbocharger": 500000,
                "Valve Cover Gasket": 35000,
                "Wiper Blade": 45000,
                "Saringan Bensin": 20000,
                "Saringan Oli": 30000,
                "Saringan Udara": 25000,
                "Rem Cakram": 180000,
                "Radiator Fan": 120000,
                "Pulley": 95000,
                "Oli Rem": 70000,
                "Oil Pump": 220000,
                "Nozzle": 60000,
                "Knalpot Racing": 450000,
                "Klakson": 35000,
                "Gasket Cylinder": 80000
            },
            "Yamaha": {
                "Filter Udara": 150000,
                "Kampas Rem": 130000,
                "Oli Mesin": 140000,
                "Aki": 280000,
                "Kabel Busi": 20000,
                "Shock Absorber": 200000,
                "Ban Belakang": 550000,
                "Karburator": 380000,
                "Lampu Depan": 80000,
                "Lampu Belakang": 65000,
                "Spion": 45000,
                "Rantai": 130000,
                "Piston": 90000,
                "Karpet": 35000,
                "Kunci Kontak": 50000,
                "Karet Kaki": 25000,
                "Gir Depan": 170000,
                "Gir Belakang": 190000,
                "Dinamo Starter": 300000,
                "Kopling": 95000,
                "Filter Oli": 28000,
                "Radiator": 240000,
                "Koil": 160000,
                "Knalpot": 420000,
                "Selang Bensin": 35000,
                "Kompresor AC": 380000,
                "Sensor Parkir": 90000,
                "Pengatur Karburator": 130000,
                "Pegas Rem": 65000,
                "Piston Rem": 75000,
                "Saklar Lampu": 50000,
                "Starter Motor": 200000,
                "Baut Roda": 12000,
                "Kabel Kelistrikan": 28000,
                "Katup": 32000,
                "Throttle Body": 200000,
                "Timing Belt": 180000,
                "Turbocharger": 550000,
                "Valve Cover Gasket": 38000,
                "Wiper Blade": 50000,
                "Saringan Bensin": 22000,
                "Saringan Oli": 32000,
                "Saringan Udara": 28000,
                "Rem Cakram": 200000,
                "Radiator Fan": 130000,
                "Pulley": 105000,
                "Oli Rem": 75000,
                "Oil Pump": 240000,
                "Nozzle": 65000,
                "Knalpot Racing": 500000,
                "Klakson": 38000,
                "Gasket Cylinder": 85000
            },
            "Suzuki": {
                "Filter Udara": 90000,
                "Kampas Rem": 110000,
                "Oli Mesin": 95000,
                "Aki": 260000,
                "Kabel Busi": 18000,
                "Shock Absorber": 160000,
                "Ban Belakang": 480000,
                "Karburator": 320000,
                "Lampu Depan": 70000,
                "Lampu Belakang": 55000,
                "Spion": 35000,
                "Rantai": 110000,
                "Piston": 80000,
                "Karpet": 25000,
                "Kunci Kontak": 40000,
                "Karet Kaki": 18000,
                "Gir Depan": 150000,
                "Gir Belakang": 170000,
                "Dinamo Starter": 260000,
                "Kopling": 85000,
                "Filter Oli": 23000,
                "Radiator": 200000,
                "Koil": 140000,
                "Knalpot": 380000,
                "Selang Bensin": 28000,
                "Kompresor AC": 320000,
                "Sensor Parkir": 75000,
                "Pengatur Karburator": 110000,
                "Pegas Rem": 55000,
                "Piston Rem": 65000,
                "Saklar Lampu": 40000,
                "Starter Motor": 160000,
                "Baut Roda": 9000,
                "Kabel Kelistrikan": 20000,
                "Katup": 28000,
                "Throttle Body": 160000,
                "Timing Belt": 140000,
                "Turbocharger": 450000,
                "Valve Cover Gasket": 30000,
                "Wiper Blade": 40000,
                "Saringan Bensin": 18000,
                "Saringan Oli": 23000,
                "Saringan Udara": 20000,
                "Rem Cakram": 160000,
                "Radiator Fan": 110000,
                "Pulley": 90000,
                "Oli Rem": 65000,
                "Oil Pump": 200000,
                "Nozzle": 55000,
                "Knalpot Racing": 400000,
                "Klakson": 30000,
                "Gasket Cylinder": 75000
            },
            // Tambahkan merek lainnya dan barang sparepart motor beserta harganya di sini...
        };
        
        // Event listener saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function () {
            document.getElementById('merk').addEventListener('change', updateHarga);
            document.getElementById('nama_barang').addEventListener('input', updateHarga);

            // Panggil updateHarga() saat halaman dimuat untuk menginisialisasi nilai harga
            updateHarga();
        });

        // Fungsi untuk update harga berdasarkan input merk dan nama barang
        function updateHarga() {
            const merk = document.getElementById('merk').value;
            const namaBarang = document.getElementById('nama_barang').value;

            if (merk && namaBarang) {
                const hargaBarang = hargaBarangData[merk][namaBarang] || "";
                document.getElementById('harga_barang').value = hargaBarang;
            } else {
                document.getElementById('harga_barang').value = ""; // Reset nilai harga jika merk atau nama barang tidak lengkap
            }
        }
    </script>

</body>

</html>