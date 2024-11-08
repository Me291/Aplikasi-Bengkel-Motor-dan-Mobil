<?php
include ('../../Connection/Koneksi.php');


// Fungsi untuk memperbarui tabel
function Update_Table($data) {
    global $conn;

    // Mengambil data dari $data
    $nama_pemilik = $data['Nama_Pemilik'];
    $no_kendaraan = $data['No_Kendaraan'];
    $no_antrian = $data['No_Antrian'];
    $jenis_motor = $data['Jenis_Motor'];
    $status = $data['Status'];

    // Memeriksa apakah kendaraan sudah terdaftar
    $stmt = $conn->prepare("SELECT No_Kendaraan FROM input_table WHERE No_Kendaraan = ?");
    $stmt->bind_param("s", $no_kendaraan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Kendaraan Sudah Terdaftar',
                });
             </script>";
        return false;
    }

    // Menyiapkan dan mengeksekusi pernyataan SQL untuk memasukkan data baru
    $stmt = $conn->prepare("INSERT INTO input_table (Nama_Pemilik, No_Kendaraan, No_Antrian, Jenis_Motor, Status) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $nama_pemilik, $no_kendaraan, $no_antrian, $jenis_motor, $status);
    $stmt->execute();

    // Memeriksa apakah pengisian berhasil
    if ($stmt->affected_rows > 0) {
        echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: 'Data Berhasil Ditambahkan',
                });
             </script>";
        return true;
    } else {
        return false;
    }
}
?>
