<?php
include ('../Connection/Koneksi.php');
function kirim_pesan($data)
{
    global $conn;

    // Melakukan escape terhadap nilai-nilai yang diambil dari form
    $first_name = mysqli_real_escape_string($conn, $data['First_Name']);
    $last_name = mysqli_real_escape_string($conn, $data['Last_Name']);
    $email = mysqli_real_escape_string($conn, $data['Email']);
    $no_telepon = mysqli_real_escape_string($conn, $data['No_Telepon']);
    $pesan = mysqli_real_escape_string($conn, $data['Pesan']);

    // Memasukkan data pesan ke dalam tabel 'pesan'
    $query = "INSERT INTO pesan (First_Name, Last_Name, Email, No_Telepon, Pesan) 
              VALUES ('$first_name', '$last_name', '$email', '$no_telepon', '$pesan')";
              
    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        // Menampilkan pesan error jika terjadi kesalahan saat mengeksekusi query INSERT
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
        return false;
    }
}
?>
