<?php
include ('../../Connection/Koneksi.php');
function Tambah_Barang($data)
{
    global $conn;

    $nama_barang = mysqli_real_escape_string($conn, $data['Nama_Barang']);
    $merk = mysqli_real_escape_string($conn, $data['Merk']);
    $jumlah = mysqli_real_escape_string($conn, $data['Jumlah']);
    $harga = mysqli_real_escape_string($conn, $data['Harga']);
   
    mysqli_query($conn, "INSERT INTO invoice VALUES ('', '$nama_barang', '$merk','$jumlah','$harga')");
    return mysqli_affected_rows($conn);
}
?>