<?php
// Pastikan Anda memiliki koneksi ke database
include ('../../Connection/Koneksi.php');

// Periksa apakah koneksi berhasil atau tidak
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Periksa apakah ada parameter yang dikirimkan dari tombol hapus
if(isset($_GET['Id']) && isset($_GET['Id_User'])) {
    // Ambil nilai parameter
    $id_barang = $_GET['Id'];
    $id_pengguna = $_GET['Id_User'];

    // Menggunakan prepared statement untuk menghindari SQL Injection
    $stmt = $conn->prepare("DELETE FROM invoice WHERE Id = ? AND Id_User = ?");
    $stmt->bind_param("ii", $id_barang, $id_pengguna); // 'ii' menunjukkan bahwa kedua parameter adalah integer

    // Jalankan query
    if ($stmt->execute()) {
        // Barang berhasil dihapus, tampilkan alert dan refresh halaman
        echo "<script>alert('Barang berhasil dihapus dari invoice.'); window.location.href = 'Tampil User.php';</script>";
    } else {
        // Terjadi kesalahan saat menghapus barang, tampilkan pesan error
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
} else {
    // Parameter tidak lengkap, tampilkan pesan
    echo "Parameter tidak lengkap.";
}

// Tutup koneksi
$conn->close();
?>
