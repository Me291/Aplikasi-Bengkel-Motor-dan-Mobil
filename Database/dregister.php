<?php
include ('../Connection/Koneksi.php');

function registrasi($data)
{
    global $conn;

    // Melakukan escape terhadap nilai-nilai yang diambil dari form
    $username = mysqli_real_escape_string($conn, $data['username']);
    $email = mysqli_real_escape_string($conn, strtolower($data['email']));
    $password = mysqli_real_escape_string($conn, $data['password']);
    $password2 = mysqli_real_escape_string($conn, $data['konfirmasi_password']);

    // Memeriksa apakah username sudah terdaftar sebelumnya
    $result = mysqli_query($conn, "SELECT Nama FROM data_user WHERE Nama = '$username'");
    if (mysqli_num_rows($result) > 0) {
        echo "<script>alert('Username sudah terdaftar');</script>";
        return false;
    }

    // Memeriksa apakah password dan konfirmasi password sesuai
    if ($password != $password2) {
        echo "<script>alert('Password tidak sesuai, Mohon cek kembali dengan benar');</script>";
        return false;
    }

    // Memasukkan data user ke dalam tabel 'data_user'
    $query = "INSERT INTO data_user (Nama, Email, Password, Konfirmasi_Password) 
              VALUES ('$username', '$email', '$password','$password2')";
              
    if (mysqli_query($conn, $query)) {
        return mysqli_affected_rows($conn);
    } else {
        // Menampilkan pesan error jika terjadi kesalahan saat mengeksekusi query INSERT
        echo "Error: " . $query . "<br>" . mysqli_error($conn);
        return false;
    }
}
?>
