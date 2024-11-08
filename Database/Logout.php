<?php
// Mulai sesi
session_start();

// Hancurkan sesi
session_destroy();
?>

<script>
    // Tampilkan pesan logout dengan menggunakan fungsi alert JavaScript
    alert('Anda Telah Logout');

    // Alihkan pengguna kembali ke halaman Form.php setelah pesan alert ditampilkan
    window.location.href = '../User/Form.php';
</script>
