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

    <title>Update Data Profile</title>
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
                    <?php

                    // Check if ID is included in the URL
                    if (isset($_GET['Id'])) {
                        // Get employee data based on ID from the URL
                        $stmt = $conn->prepare("SELECT * FROM profil_karyawan WHERE Id = ?");
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
                        $id_karyawan = mysqli_real_escape_string($conn, $_POST['Id_Karyawan']);

                        // Memeriksa apakah file gambar diunggah
                        if (!empty($_FILES['foto']['name'])) {
                            $namafoto = $_FILES['foto']['name'];
                            $lokasifoto = $_FILES['foto']['tmp_name'];

                            // Memeriksa tipe file
                            $file_ext = strtolower(pathinfo($namafoto, PATHINFO_EXTENSION));
                            $extensions = array("jpeg", "jpg", "png");

                            // Memeriksa ekstensi file
                            if (!in_array($file_ext, $extensions)) {
                                echo "<script>alert('Ekstensi file tidak diizinkan, harap unggah file JPEG atau PNG.');</script>";
                            } elseif ($_FILES['foto']['size'] > 2097152) {
                                echo "<script>alert('Ukuran file harus lebih kecil dari 2 MB');</script>";
                            } else {
                                // Jika lolos verifikasi, pindahkan file ke direktori yang diinginkan
                                move_uploaded_file($lokasifoto, "../Foto/$namafoto");

                                // Start a transaction
                                mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);

                                try {
                                    // Update profil_karyawan with foto
                                    $stmt1 = $conn->prepare("UPDATE profil_karyawan SET Foto = ?, Nama = ?, Id_Karyawan = ? WHERE Id = ?");
                                    $stmt1->bind_param("sssi", $namafoto, $nama, $id_karyawan, $_GET['Id']);
                                    $stmt1->execute();
                                    $stmt1->close();

                                    // Update data_karyawan
                                    $stmt2 = $conn->prepare("UPDATE data_karyawan SET Nama = ?, Id_Admin = ? WHERE Id_Admin = ?");
                                    $stmt2->bind_param("ssi", $nama, $id_karyawan, $pecah['Id_Karyawan']);
                                    $stmt2->execute();
                                    $stmt2->close();

                                    mysqli_commit($conn);
                                    echo "<script>alert('Data berhasil dirubah'); window.location.href='../Admin Dashboard/Data Profile.php';</script>";
                                } catch (Exception $e) {
                                    mysqli_rollback($conn);
                                    echo "<script>alert('" . $e->getMessage() . "');</script>";
                                }
                            }
                        } else {
                            // Start a transaction
                            mysqli_begin_transaction($conn, MYSQLI_TRANS_START_READ_WRITE);

                            try {
                                // Update profil_karyawan without foto
                                $stmt1 = $conn->prepare("UPDATE profil_karyawan SET Nama = ?, Id_Karyawan = ? WHERE Id = ?");
                                $stmt1->bind_param("ssi", $nama, $id_karyawan, $_GET['Id']);
                                $stmt1->execute();
                                $stmt1->close();

                                // Update data_karyawan
                                $stmt2 = $conn->prepare("UPDATE data_karyawan SET Nama = ?, Id_Admin = ? WHERE Id_Admin = ?");
                                $stmt2->bind_param("ssi", $nama, $id_karyawan, $pecah['Id_Karyawan']);
                                $stmt2->execute();
                                $stmt2->close();

                                mysqli_commit($conn);
                                echo "<script>alert('Data berhasil dirubah'); window.location.href='../Admin Dashboard/Data Profile.php';</script>";
                            } catch (Exception $e) {
                                mysqli_rollback($conn);
                                echo "<script>alert('" . $e->getMessage() . "');</script>";
                            }
                        }
                    }

                    // Close the connection
                    $conn->close();
                    ?>



                    <!-- Formulir untuk pembaruan -->
                    <form enctype="multipart/form-data" method="post">
                        <div class="input-box">
                            <label>Foto</label>
                            <?php if (isset($pecah['Foto'])): ?>
                                <img src="../Foto/<?php echo $pecah['Foto']; ?>" alt="Foto" width="100" height="100">
                            <?php endif; ?>
                            <input type="file" name="foto">
                        </div>
                        <div class="input-box">
                            <label>Nama</label>
                            <input type="text" name="Nama"
                                value="<?php echo isset($pecah['Nama']) ? $pecah['Nama'] : ''; ?>">
                        </div>
                        <div class="input-box">
                            <label>Id Karyawan</label>
                            <input type="text" name="Id_Karyawan"
                                value="<?php echo isset($pecah['Id_Karyawan']) ? $pecah['Id_Karyawan'] : ''; ?>">
                        </div>
                        <div class="btn-update">
                            <button name="Update">Update</button>
                        </div>
                    </form>


                </div>
            </section>

        </section>
        <script src="../Js/Main.js"></script>
</body>

</html>