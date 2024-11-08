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

// Check if ID is included in the URL
if (isset($_GET['Id'])) {
    // Get employee data based on ID from the URL
    $stmt = $conn->prepare("SELECT * FROM data_karyawan WHERE Id = ?");
    $stmt->bind_param("i", $_GET['Id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $pecah = $result->fetch_assoc();
    $stmt->close();
} else {
    die("ID tidak disertakan dalam URL");
}

// Process form if submitted
if (isset($_POST['Update'])) {
    // Secure all inputs using mysqli_real_escape_string function
    $nama = mysqli_real_escape_string($conn, $_POST['Nama']);
    $bagian = mysqli_real_escape_string($conn, $_POST['Bagian']);
    $jenis_kelamin = mysqli_real_escape_string($conn, $_POST['Jenis_Kelamin']);
    $ttl = mysqli_real_escape_string($conn, $_POST['TTL']);
    $id_admin = mysqli_real_escape_string($conn, $_POST['Id_Karyawan']);
    $alamat = mysqli_real_escape_string($conn, $_POST['Alamat']);
    $no_telpon = mysqli_real_escape_string($conn, $_POST['No_Telepon']);

    // Check if employee ID and phone number are already used by another employee
    $stmt = $conn->prepare("SELECT Id FROM data_karyawan WHERE Id != ? AND (Id_Admin = ? OR No_Telepon = ?)");
    $stmt->bind_param("iss", $_GET['Id'], $id_admin, $no_telpon);
    $stmt->execute();
    $result = $stmt->get_result();

    // If the query result is not empty, it means the employee ID or phone number is already used
    if ($result->num_rows > 0) {
        echo "<script>alert('ID karyawan atau nomor telepon sudah digunakan oleh karyawan lain');</script>";
    } else {
        // Start a transaction
        mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);

        try {
            // Update data_karyawan
            $stmt = $conn->prepare("UPDATE data_karyawan SET Nama=?, Bagian=?, Jenis_kelamin=?, TTL=?, Id_Admin=?, Alamat=?, No_Telepon=? WHERE Id=?");
            $stmt->bind_param("sssssssi", $nama, $bagian, $jenis_kelamin, $ttl, $id_admin, $alamat, $no_telpon, $_GET['Id']);
            $stmt->execute();

            // Check if the query was successful
            if ($stmt->affected_rows > 0) {
                // Update profil_karyawan if Nama or Id_Karyawan has changed
                $stmt = $conn->prepare("UPDATE profil_karyawan SET Nama=?, Id_Karyawan=? WHERE Id_Karyawan=?");
                $stmt->bind_param("sii", $nama, $id_admin, $pecah['Id_Admin']);
                $stmt->execute();

                mysqli_commit($conn);
                echo "<script>alert('Data berhasil dirubah'); window.location.href='../Admin Dashboard/Data Karyawan.php';</script>";
            } else {
                throw new Exception('Gagal merubah data');
            }
        } catch (Exception $e) {
            mysqli_rollback($conn);
            echo "<script>alert('" . $e->getMessage() . "');</script>";
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the connection
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

    <title>Update Data Karyawan</title>
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
                            <label>Nama</label>
                            <input type="text" placeholder="Masukan Nama Lengkap" required name="Nama"
                                value="<?php echo $pecah['Nama']; ?>" />
                        </div>
                        <div class="input-box">
                            <label>Bagian</label>
                            <div class="custom_select">
                                <select name="Bagian">
                                    <option><?php echo $pecah['Bagian']; ?></option>
                                    <option value="Admin">Admin</option>
                                    <option value="Karyawan">Karyawan</option>
                                    <option value="Karyawan Magang">Karyawan Magang</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-box">
                            <label>Jenis Kelamin</label>
                            <div class="custom_select">
                                <select name="Jenis_Kelamin">
                                    <option><?php echo $pecah['Jenis_Kelamin']; ?></option>
                                    <option value="Laki-laki">Laki-Laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>
                        <div class="input-box">
                            <label>Tempat Tanggal Lahir</label>
                            <input type="text" placeholder="Masukan Tempat Tanggal Lahir" required name="TTL"
                                value="<?php echo $pecah['TTL']; ?>" />
                        </div>
                        <div class="input-box">
                            <label>Id Karyawan</label>
                            <input type="text" placeholder="Masukan Id Karyawan" required name="Id_Karyawan"
                                value="<?php echo $pecah['Id_Admin']; ?>" />
                        </div>
                        <div class="input-box">
                            <label>Alamat</label>
                            <input type="text" placeholder="Masukan Alamat" required name="Alamat"
                                value="<?php echo $pecah['Alamat']; ?>" />
                        </div>
                        <div class="input-box">
                            <label>No Telepon</label>
                            <input type="text" placeholder="Masukan No Telepon" required name="No_Telepon"
                                value="<?php echo $pecah['No_Telepon']; ?>" />
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