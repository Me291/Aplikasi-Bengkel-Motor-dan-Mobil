<?php
include ('../../Connection/Koneksi.php');
function Tambah_User($data)
{
    global $conn;

    $nama = mysqli_real_escape_string($conn, $data['Nama']);
    $email = mysqli_real_escape_string($conn, $data['Email']);
    $no_telepon = mysqli_real_escape_string($conn, $data['No_Telepon']);
    $no_invoice = mysqli_real_escape_string($conn, $data['No_Invoice']);
    $status = mysqli_real_escape_string($conn, $data['Status']);
   
    mysqli_query($conn, "INSERT INTO pembayaran_user VALUES ('', '$nama', '$email','$no_telepon','$no_invoice','$status')");
    return mysqli_affected_rows($conn);
}
?>