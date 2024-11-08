<?php
include ('../../Connection/Koneksi.php');

function Service_Now($data)
{
    global $conn;

    // Sanitize input data
    $username = mysqli_real_escape_string($conn, $data['Nama']);
    $email = mysqli_real_escape_string($conn, $data['Email']);
    $no_kendaraan = mysqli_real_escape_string($conn, $data['No_Kendaraan']);
    $no_telepon = mysqli_real_escape_string($conn, $data['No_Telepon']);
    $jenis_kendaraan = mysqli_real_escape_string($conn, $data['Jenis_Kendaraan']);

    // Get the current date and time for Tanggal_Masuk
    $tanggal_masuk = date('Y-m-d H:i:s');

    // Check if vehicle already exists
    $result = mysqli_query($conn, "SELECT No_Kendaraan FROM service_now WHERE No_Kendaraan = '$no_kendaraan'");
    if (mysqli_fetch_assoc($result)) {
        echo "<script>alert('Kendaraan Sudah Terdaftar');</script>";
        return false;
    }

    // Insert new service record into service_now table
    $query = "INSERT INTO service_now (Nama, Email, No_Kendaraan, No_Telepon, Jenis_Kendaraan, Tanggal_Waktu) 
              VALUES ('$username', '$email', '$no_kendaraan', '$no_telepon', '$jenis_kendaraan', '$tanggal_masuk')";

    if (mysqli_query($conn, $query)) {
        // Retrieve the auto-increment ID from service_now
        $service_now_id = mysqli_insert_id($conn);

        // Insert into input_table
        $nama_pemilik = $username;
        $no_antrian = $service_now_id;
        $jenis_mobil = $jenis_kendaraan;
        $status = 'Baru';

        $insert_query = "INSERT INTO input_table (Id, Nama_Pemilik, No_Kendaraan, No_Antrian, Jenis_Mobil, Status, Tanggal_Masuk) 
                         VALUES (NULL, '$nama_pemilik', '$no_kendaraan', '$no_antrian', '$jenis_mobil', '$status', '$tanggal_masuk')";

        if (mysqli_query($conn, $insert_query)) {
            // Insert into pembayaran_user table
            // Retrieve the last inserted ID (service_now ID) for invoice number
            $id_invoice = mysqli_insert_id($conn); // Assuming this is the auto-increment ID from pembayaran_user

            $insert_pembayaran_query = "INSERT INTO pembayaran_user (Id, Nama, Email, No_Telepon, No_Invoice, Status) 
                                       VALUES (NULL, '$username', '$email', '$no_telepon', '$id_invoice', 'Belum Dibayar')";

            if (mysqli_query($conn, $insert_pembayaran_query)) {
                return mysqli_affected_rows($conn);
            } else {
                echo "Error inserting into pembayaran_user: " . mysqli_error($conn);
                return false;
            }
        } else {
            echo "Error inserting into input_table: " . mysqli_error($conn);
            return false;
        }
    } else {
        echo "Error inserting into service_now: " . mysqli_error($conn);
        return false;
    }
}
?>
