<?php
include ('../../Connection/Koneksi.php');


function registrasi($data)
{
    global $conn;

    $username = mysqli_real_escape_string($conn, $data['Nama']);
    $bagian = mysqli_real_escape_string($conn, $data['Bagian']);
    $jeniskelamin = mysqli_real_escape_string($conn, $data['Jenis_Kelamin']);
    $ttl = mysqli_real_escape_string($conn, $data['TTL']);
    $alamat = mysqli_real_escape_string($conn, $data['Alamat']);
    $no_telpon = mysqli_real_escape_string($conn, $data['No_Telepon']);
    $id_admin = mysqli_real_escape_string($conn, $data['Id_Karyawan']);
    
    // Check if username, Id_Admin, and No_Telepon already exist using Prepared Statements
    $stmt_username = mysqli_prepare($conn, "SELECT Nama FROM data_karyawan WHERE Nama = ?");
    mysqli_stmt_bind_param($stmt_username, "s", $username);
    mysqli_stmt_execute($stmt_username);
    mysqli_stmt_store_result($stmt_username);
    
    $stmt_id_admin = mysqli_prepare($conn, "SELECT Id_Admin FROM data_karyawan WHERE Id_Admin = ?");
    mysqli_stmt_bind_param($stmt_id_admin, "s", $id_admin);
    mysqli_stmt_execute($stmt_id_admin);
    mysqli_stmt_store_result($stmt_id_admin);
    
    $stmt_no_telpon = mysqli_prepare($conn, "SELECT No_Telepon FROM data_karyawan WHERE No_Telepon = ?");
    mysqli_stmt_bind_param($stmt_no_telpon, "s", $no_telpon);
    mysqli_stmt_execute($stmt_no_telpon);
    mysqli_stmt_store_result($stmt_no_telpon);

    if (mysqli_stmt_num_rows($stmt_username) > 0) {
        echo "<script>alert('Nama sudah digunakan. Silakan gunakan Nama lain.');</script>";
        return false;
    }
    if (mysqli_stmt_num_rows($stmt_id_admin) > 0) {
        echo "<script>alert('Id_Admin sudah digunakan. Silakan gunakan Id_Admin lain.');</script>";
        return false;
    }
    if (mysqli_stmt_num_rows($stmt_no_telpon) > 0) {
        echo "<script>alert('No Telepon sudah digunakan. Silakan gunakan No Telepon lain.');</script>";
        return false;
    }

    // If everything is fine, proceed with the registration using Prepared Statements
    $stmt = mysqli_prepare($conn, "INSERT INTO data_karyawan (Nama, Bagian, Jenis_Kelamin, TTL, Id_Admin, Alamat, No_Telepon) VALUES (?, ?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sssssss", $username, $bagian, $jeniskelamin, $ttl, $id_admin, $alamat, $no_telpon);
    mysqli_stmt_execute($stmt);

    return mysqli_stmt_affected_rows($stmt);
}
?>
