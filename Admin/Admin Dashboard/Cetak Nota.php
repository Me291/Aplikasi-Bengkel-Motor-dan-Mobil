<?php
session_start();
include ('../../Connection/Koneksi.php');

// Periksa apakah data user ada di sesi
if (!isset($_SESSION['data_karyawan'])) {
    echo "<script>
            alert('Akses Ditolak. Anda Harus Login Terlebih Dahulu');
            window.location.href = '../Admin.php'; // Mengalihkan ke halaman login
          </script>";
    exit(); // Menghentikan eksekusi skrip
}



// Validasi keberadaan Id
if (!isset($_GET['Id']) || !is_numeric($_GET['Id'])) {
    die('Error: ID tidak valid');
}

$id_user = $_GET['Id'];

// Menggunakan prepared statement untuk menghindari SQL injection
$stmt = $conn->prepare("SELECT * FROM invoice WHERE Id_User = ?");
$stmt->bind_param("i", $id_user); // 'i' berarti tipe data integer
$stmt->execute();
$result = $stmt->get_result();

$nomor = 1;
$total_harga_semua_barang = 0;
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title></title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css"
        integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../CSS/Cetak Nota.css">

    <title>Cetak Nota User</title>
</head>

<body>

    <div class="invoice-wrapper" id="print-area">
        <div class="invoice">
            <div class="invoice-container">
                <div class="invoice-head">
                    <div class="invoice-head-top">
                        <div class="invoice-head-top-left text-start">
                            <h1>Bengkel Ride Assit</h1>
                        </div>
                        <div class="invoice-head-top-right text-end">
                            <h3>Invoice</h3>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div class="invoice-head-middle">
                        <div class="invoice-head-middle-left text-start">
                            <p><span class="text-bold">Date</span>: <?php echo date("m/d/Y"); ?></p>
                        </div>
                        <div class="invoice-head-middle-right text-end">
                            <p><span class="text-bold">Invoice No:</span> <?php echo rand(10000, 99999); ?></p>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div class="invoice-head-bottom">
                        <div class="invoice-head-bottom-left">
                            <ul>
                                <li class='text-bold'>Invoiced To:</li>
                                <li>Smith Rhodes</li>
                                <li>15 Hodges Mews, High Wycombe</li>
                                <li>HP12 3JL</li>
                                <li>United Kingdom</li>
                            </ul>
                        </div>
                        <div class="invoice-head-bottom-right">
                            <ul class="text-end">
                                <li class='text-bold'>Pay To:</li>
                                <li>Koice Inc.</li>
                                <li>2705 N. Enterprise</li>
                                <li>Orange, CA 89438</li>
                                <li>contact@koiceinc.com</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="overflow-view">
                    <div class="invoice-body">
                        <table>
                            <thead>
                                <tr>
                                    <td class="text-bold">No</td>
                                    <td class="text-bold">Nama Barang</td>
                                    <td class="text-bold">Merk Barang</td>
                                    <td class="text-bold">Jumlah</td>
                                    <td class="text-bold">Harga</td>
                                    <td class="text-bold">Harga Total</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($pecah = $result->fetch_assoc()) {
                                    $sub_harga = $pecah['Harga'] * $pecah['Jumlah']; ?>
                                    <tr>
                                        <td><?php echo $nomor; ?></td>
                                        <td><?php echo htmlspecialchars($pecah['Nama_Barang']); ?></td>
                                        <td><?php echo htmlspecialchars($pecah['Merk']); ?></td>
                                        <td><?php echo htmlspecialchars($pecah['Jumlah']); ?></td>
                                        <td><?php echo 'Rp.' . number_format($pecah['Harga']); ?></td>
                                        <td><?php echo 'Rp.' . number_format($sub_harga); ?></td>
                                    </tr>
                                    <?php
                                    $nomor++;
                                    $total_harga_semua_barang += $sub_harga;
                                } ?>
                            </tbody>

                            <?php
                            // Menghitung PPN (Pajak Pertambahan Nilai) sekitar 5%
                            $ppn = $total_harga_semua_barang * 0.05; // 5% dari total harga semua barang
                            
                            // Total adalah total harga semua barang ditambah PPN
                            $total = $total_harga_semua_barang + $ppn;
                            ?>

                            <div class="invoice-body-bottom">
                                <div class="invoice-body-info-item border-bottom">
                                    <div class="info-item-td text-end text-bold">Sub Total:</div>
                                    <div class="info-item-td text-end">
                                        <?php echo 'Rp.' . number_format($total_harga_semua_barang) ?>
                                    </div>
                                </div>
                                <div class="invoice-body-info-item border-bottom">
                                    <div class="info-item-td text-end text-bold">PPN (5%):</div>
                                    <div class="info-item-td text-end"><?php echo 'Rp.' . number_format($ppn) ?></div>
                                </div>
                                <div class="invoice-body-info-item">
                                    <div class="info-item-td text-end text-bold">Total:</div>
                                    <div class="info-item-td text-end"><?php echo 'Rp.' . number_format($total) ?></div>
                                </div>
                            </div>

                    </div>
                </div>

                <?php
                // Query untuk mengambil data Id_User dari tabel pembayaran_user
                $query_user_id = $conn->prepare("SELECT Id FROM pembayaran_user WHERE Id = ?");
                $query_user_id->bind_param("i", $_GET['Id']); // Menggunakan Id dari URL
                $query_user_id->execute();
                $result_user_id = $query_user_id->get_result();
                $row_user_id = $result_user_id->fetch_assoc();

                // Cek apakah data Id_User ditemukan
                if ($row_user_id) {
                    $id_user_invoice = $row_user_id['Id']; // Menyimpan Id_User dari tabel pembayaran_user
                } else {
                    $id_user_invoice = null; // Set $id_user_invoice menjadi null jika data tidak ditemukan
                }
                ?>

                <div class="invoice-foot text-center">
                    <?php if (!empty($id_user_invoice)): ?>
                        <p><span class="text-bold text-center">NOTE:&nbsp;</span>Silakan masukkan nomor invoice berikut
                            untuk validasi pembayaran No: <?php echo htmlspecialchars($id_user_invoice); ?></p>
                    <?php else: ?>
                        <p><span class="text-bold text-center">NOTE:&nbsp;</span>No invoice belum tersedia.</p>
                    <?php endif; ?>

                    <div class="invoice-btns">
                        <button type="button" class="invoice-btn" onclick="printInvoice()">
                            <span>
                                <i class="fa-solid fa-print"></i>
                            </span>
                            <span>Print</span>
                        </button>
                        <button type="button" class="invoice-btn">
                            <span>
                                <i class="fa-solid fa-download"></i>
                            </span>
                            <span>Download</span>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script src="../Js/Cetak.js"></script>
</body>

</html>