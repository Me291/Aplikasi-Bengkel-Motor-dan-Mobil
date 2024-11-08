<?php
session_start();
include ('../../Connection/Koneksi.php');

// Periksa apakah data user ada di sesi
if (!isset($_SESSION['data_karyawan'])) {
    echo "<script>
            alert('Akses Ditolak. Anda Harus Login Terlebih Dahulu');
            window.location.href = '../Admin.php'; // Mengalihkan ke halaman login
          </script>";
    exit(); // Menghentikan eksekusi skrip
}


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
    <script src="https://kit.fontawesome.com/b99e675b6e.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />


    <title>Tampil Barang</title>
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
                    <h2>Informasi Data Barang</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Barang</th>
                                <th>Merk</th>
                                <th>Jumlah</th>
                                <th>Harga</th>
                                <th>Harga Total</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $nomor = 1;
                            // Ambil ID pengguna dari URL
                            $id_pengguna = filter_input(INPUT_GET, 'Id', FILTER_SANITIZE_NUMBER_INT);
                            if ($id_pengguna) {
                                // Ambil data barang dari tabel invoice berdasarkan ID pengguna
                                $ambil_barang = $conn->prepare("SELECT * FROM invoice WHERE Id_User = ?");
                                $ambil_barang->bind_param("i", $id_pengguna);
                                if (!$ambil_barang->execute()) {
                                    error_log('Error executing query: ' . $ambil_barang->error);
                                    // Tampilkan pesan error ke pengguna
                                }
                                $result_barang = $ambil_barang->get_result();

                                while ($pecah_barang = $result_barang->fetch_assoc()) {
                                    // Hitung harga total
                                    $harga_total = $pecah_barang['Jumlah'] * $pecah_barang['Harga'];
                                    // Format harga total menjadi Rupiah
                                    $harga_total_rupiah = "Rp " . number_format($harga_total, 0, ',', '.');
                                    ?>
                            <tr>
                                <td><?php echo $nomor; ?></td>
                                <td><?php echo htmlspecialchars($pecah_barang['Nama_Barang']); ?></td>
                                <td><?php echo htmlspecialchars($pecah_barang['Merk']); ?></td>
                                <td><?php echo htmlspecialchars($pecah_barang['Jumlah']); ?></td>
                                <td><?php echo "Rp " . number_format($pecah_barang['Harga'], 0, ',', '.'); ?></td>
                                <td><?php echo $harga_total_rupiah; ?></td> <!-- Kolom harga total -->
                                <td>
                                    <button class="edit-button"
                                        onclick="location.href='../Update/Update Data Barang.php?halaman=ubah_barang&Id=<?php echo htmlspecialchars($pecah_barang['Id']); ?>'">Edit</button>
                                    <button class="delete-btn">
                                        <a href="#"
                                            onclick="confirmDelete(<?php echo $pecah_barang['Id']; ?>, <?php echo $id_pengguna; ?>)">Hapus</a>
                                    </button>
                                    <script>
                                        function confirmDelete(Id, Id_User) {
                                            // Tampilkan konfirmasi penghapusan
                                            var confirmation = confirm(
                                                "Apakah Anda yakin ingin menghapus barang ini dari invoice?");

                                            // Jika pengguna menekan tombol OK pada konfirmasi
                                            if (confirmation) {
                                                // Redirect ke halaman atau skrip yang akan menangani penghapusan barang dari tabel invoice
                                                window.location.href = "hapus barang.php?Id=" + Id + "&Id_User=" +
                                                    Id_User;
                                            }
                                        }
                                    </script>

                                </td>
                            </tr>
                            <?php $nomor++;
                                }
                            } else {
                                echo "Id_User tidak ditemukan!";
                            }
                            ?>
                        </tbody>
                    </table>
            </section>
        </section>
        <script src="../Js/Main.js"></script>
</body>

</html>

</html>