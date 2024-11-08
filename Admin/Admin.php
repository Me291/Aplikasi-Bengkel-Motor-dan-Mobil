<?php
session_start();

// Mengatur koneksi ke database
include ('../Connection/Koneksi.php');

// Memeriksa apakah form 'masuk' telah disubmit
if (isset($_POST['masuk'])) {
    // Mengambil nilai yang di-submit dari form
    $namaKaryawan = $_POST['Nama_Karyawan'];
    $idKaryawan = $_POST['Id_Karyawan'];

    // Membuat prepared statement untuk menghindari SQL injection
    $query = "SELECT * FROM data_karyawan WHERE Nama = ? AND Id_Admin = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $namaKaryawan, $idKaryawan);
    $stmt->execute();
    $result = $stmt->get_result();

    // Memeriksa jumlah baris yang cocok dengan kriteria pencarian
    if ($result->num_rows == 1) {
        // Jika ditemukan 1 baris, simpan data karyawan ke dalam session
        $row = $result->fetch_assoc();
        $_SESSION['data_karyawan'] = $row;
        echo "<script>alert('Berhasil Login');</script>";
        echo "<meta http-equiv='refresh' content='1;url=Admin Dashboard/Dashboard.php'>";
    } else {
        // Jika tidak ditemukan baris yang cocok, tampilkan pesan error
        echo "<script>alert('Karyawan Tidak Terdaftar!!!');</script>";
        echo "<meta http-equiv='refresh' content='1;url=Admin.php'>";
    }

    // Menutup prepared statement
    $stmt->close();
}

// Menutup koneksi ke database
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/Admin_Form.css">
    <title>Karyawan Form</title>
</head>

<body>
    <div class="login-box">
        <div class="login-header">
            <header>Admin Login</header>
        </div>
        <form action="" method="post">
            <div class="input-box">
                <input type="text" name="Nama_Karyawan" class="input-field" placeholder="Nama Karyawan" required>
            </div>
            <div class="input-box">
                <input type="text" name="Id_Karyawan" class="input-field" placeholder="Id Karyawan" required>
            </div>
            <div class="input-submit">
                <button class="submit-btn" name="masuk"></button>
                <label for="submit">Masuk</label>
            </div>
        </form>
        <div class="sign-up-link">
            <p>Back To Home <a href="../Home.php">Here</a></p>
        </div>
    </div>
</body>

</html>