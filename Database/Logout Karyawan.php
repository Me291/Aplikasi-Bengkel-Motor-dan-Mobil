<?php
// Mulai session
session_start();

// Hapus semua data session
session_unset();

// Hancurkan session
session_destroy();
?>

<script>
    // Tampilkan pesan pop-up
    alert("Anda telah berhasil logout.");

    // Redirect ke halaman login atau halaman lainnya
    window.location.href = "../Admin/Admin.php";
</script>
