<?php
session_start(); // Memulai sesi

// Periksa apakah data karyawan ada di sesi
if (!isset($_SESSION['login'])) {
  echo "<script>
          alert('Akses Ditolak. Anda Harus Login Terlebih Dahulu');
          window.location.href = '../Form.php'; // Mengalihkan ke halaman login
        </script>";
  exit(); // Menghentikan eksekusi skrip
}
?>



<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Konfirmasi Pembayaran</title>
</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-header">
                        <h4>Cari Data Pembayaran </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-7">
                                <form action="" method="GET">
                                    <div class="input-group mb-3">
                                        <input type="text" name="search" required value="<?php if (isset($_GET['search'])) {
                                            echo $_GET['search'];
                                        } ?>" class="form-control" placeholder="Search data">
                                        <button type="submit" class="btn btn-primary">Search</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="card mt-4">
                    <div class="card-body">
                        <?php
                        if (isset($_GET['search'])) {
                            $search_id = $_GET['search'];

                            // Connect to database
                            require '../../Database/dservice_homes.php';

                            // Fetch user information
                            $query_user = $conn->prepare("SELECT * FROM pembayaran_user WHERE Id = ?");
                            $query_user->bind_param("i", $search_id);
                            $query_user->execute();
                            $result_user = $query_user->get_result();

                            // Display user information
                            echo '<table class="table">';
                            if ($result_user->num_rows > 0) {
                                $user_info = $result_user->fetch_assoc();
                                echo '<tr>';
                                echo '<td><strong>Nama:</strong></td>';
                                echo '<td>' . $user_info['Nama'] . '</td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<td><strong>Email:</strong></td>';
                                echo '<td>' . $user_info['Email'] . '</td>';
                                echo '</tr>';
                                echo '<tr>';
                                echo '<td><strong>No. Telepon:</strong></td>';
                                echo '<td>' . $user_info['No_Telepon'] . '</td>';
                                echo '</tr>';
                            } else {
                                echo '<tr><td colspan="2">Data pengguna tidak ditemukan.</td></tr>';
                            }
                            echo '</table>';

                            // Display invoice items
                            echo '<table class="table table-bordered">';
                            echo '<thead>';
                            echo '<tr>';
                            echo '<th>Nama Barang</th>';
                            echo '<th>Jumlah</th>';
                            echo '<th>Harga Satuan</th>';
                            echo '<th>Total Harga</th>';
                            echo '</tr>';
                            echo '</thead>';
                            echo '<tbody>';

                            $query_pembayaran = $conn->prepare("SELECT * FROM invoice WHERE Id_User = ?");
                            $query_pembayaran->bind_param("i", $search_id);
                            $query_pembayaran->execute();
                            $result_pembayaran = $query_pembayaran->get_result();

                            if ($result_pembayaran->num_rows > 0) {
                                while ($row_invoice = $result_pembayaran->fetch_assoc()) {
                                    echo '<tr>';
                                    echo '<td>' . $row_invoice['Nama_Barang'] . '</td>';
                                    echo '<td>' . $row_invoice['Jumlah'] . '</td>';
                                    echo '<td>' . $row_invoice['Harga'] . '</td>';
                                    echo '<td>' . number_format($row_invoice['Jumlah'] * $row_invoice['Harga'], 0, ',', '.') . '</td>';
                                    echo '</tr>';
                                }
                            } else {
                                echo '<tr><td colspan="4">Data tidak ditemukan.</td></tr>';
                            }

                            echo '</tbody>';
                            echo '</table>';

                            // Hitung total harga
                            $query_total_harga = $conn->prepare("SELECT SUM(Jumlah * Harga) AS total_harga FROM Invoice WHERE Id_User = ?");
                            $query_total_harga->bind_param("i", $search_id);
                            $query_total_harga->execute();
                            $result_total_harga = $query_total_harga->get_result();
                            $row_total_harga = $result_total_harga->fetch_assoc();
                            $total_harga = $row_total_harga['total_harga'];

                            // Hitung PPN 5%
                            $ppn = $total_harga * 0.02;

                            // Hitung total harga dengan PPN
                            $total_harga_ppn = $total_harga + $ppn;

                            // Format total harga dan PPN menjadi format rupiah
                            $total_harga_rupiah = number_format($total_harga, 0, ',', '.');
                            $ppn_rupiah = number_format($ppn, 0, ',', '.');
                            $total_harga_ppn_rupiah = number_format($total_harga_ppn, 0, ',', '.');

                            // Menampilkan total harga dan PPN di bawah tabel
                            echo '<table class="table">';
                            echo '<tr>';
                            echo '<td colspan="3" style="text-align: right;"><strong>Total Harga (tanpa PPN):</strong></td>';
                            echo '<td colspan="2">Rp ' . $total_harga_rupiah . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<td colspan="3" style="text-align: right;"><strong>PPN 2%:</strong></td>';
                            echo '<td colspan="2">Rp ' . $ppn_rupiah . '</td>';
                            echo '</tr>';
                            echo '<tr>';
                            echo '<td colspan="3" style="text-align: right;"><strong>Total Harga (termasuk PPN):</strong></td>';
                            echo '<td colspan="2">Rp ' . $total_harga_ppn_rupiah . '</td>';
                            echo '</tr>';
                            echo '</table>';
                        }
                        ?>
                        <a href="User.php" class="btn btn-primary">Home</a>
                        <a href="Payment.php" class="btn btn-success">Bayar</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>