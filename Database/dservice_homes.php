<?php
include ('../../Connection/Koneksi.php');

function Service($data)
{
    global $conn;

    // Sanitasi data input
    $username = mysqli_real_escape_string($conn, $data['Nama_Service']);
    $email = mysqli_real_escape_string($conn, $data['Email_Service']);
    $alamat = mysqli_real_escape_string($conn, $data['Alamat_Service']);
    $no_kendaraan = mysqli_real_escape_string($conn, $data['No_Kendaraan_Service']);
    $no_telepon = mysqli_real_escape_string($conn, $data['No_Telepon_Service']);
    $jenis_kendaraan = mysqli_real_escape_string($conn, $data['Jenis_Kendaraan_Service']);
    $tanggal_waktu = date("Y-m-d H:i:s"); // Mendapatkan tanggal dan waktu saat ini

    // Memeriksa apakah nomor kendaraan sudah terdaftar sebelumnya
    $result = mysqli_query($conn, "SELECT No_Kendaraan FROM service_homes WHERE No_Kendaraan = '$no_kendaraan'");
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Kendaraan Sudah Terdaftar');</script>";
        return false;
    }

    // Menyisipkan data service baru ke dalam tabel service_homes
    $query = "INSERT INTO service_homes (Nama, Email, Alamat, No_Kendaraan, No_Telepon, Jenis_Kendaraan, Tanggal_Waktu) 
              VALUES ('$username', '$email', '$alamat', '$no_kendaraan', '$no_telepon', '$jenis_kendaraan', '$tanggal_waktu')";

    if (mysqli_query($conn, $query)) {
        // Mendapatkan ID auto-increment dari service_homes
        $service_homes_id = mysqli_insert_id($conn);

        // Menyisipkan data ke dalam tabel pembayaran_user
        $insert_pembayaran_query = "INSERT INTO pembayaran_user (Id, Nama, Email, No_Telepon, No_Invoice, Status) 
                                    VALUES (NULL, '$username', '$email', '$no_telepon', '$service_homes_id', 'Belum Dibayar')";

        if (mysqli_query($conn, $insert_pembayaran_query)) {
            return mysqli_affected_rows($conn);
        } else {
            echo "Kesalahan saat menyisipkan ke pembayaran_user: " . mysqli_error($conn);
            return false;
        }
    } else {
        echo "Kesalahan saat menyisipkan ke service_homes: " . mysqli_error($conn);
        return false;
    }
}
?>
