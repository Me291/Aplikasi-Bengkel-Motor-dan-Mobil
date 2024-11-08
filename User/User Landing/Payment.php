<?php
session_start(); // Memulai sesi

include ('../../Connection/Koneksi.php');

// Periksa apakah data karyawan ada di sesi
if (!isset($_SESSION['login'])) {
    echo "<script>
              alert('Akses Ditolak. Anda Harus Login Terlebih Dahulu');
              window.location.href = '../Form.php'; // Mengalihkan ke halaman login
            </script>";
    exit(); // Menghentikan eksekusi skrip
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data dari formulir
    $nama = $_POST['Nama'];
    $email = $_POST['Email'];
    $no_telepon = $_POST['No_Telepon'];
    $bank = $_POST['Bank'];
    $jumlah = $_POST['Jumlah'];
    $tanggal_pembayaran = $_POST['Tanggal_Pembayaran'];

    $bukti_pembayaran = ""; // Inisialisasi variabel untuk menyimpan nama file bukti pembayaran

    $target_dir = "../Bukti Pembayaran/";
    $target_file = $target_dir . basename($_FILES["Bukti_Pembayaran"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Periksa apakah file adalah gambar
    $check = getimagesize($_FILES["Bukti_Pembayaran"]["tmp_name"]);
    if ($check === false) {
        echo "<script>alert('File bukan gambar.');</script>";
        $uploadOk = 0;
    }

    // Periksa apakah file sudah ada
    if (file_exists($target_file)) {
        echo "<script>alert('Maaf, file " . basename($target_file) . " sudah ada.');</script>";
        $uploadOk = 0;
    }

    // Periksa ukuran file
    if ($_FILES["Bukti_Pembayaran"]["size"] > 500000000) {
        echo "<script>alert('Maaf, file terlalu besar.');</script>";
        $uploadOk = 0;
    }

    // Izinkan format file tertentu
    $allowed_formats = ["jpg", "jpeg", "png", "gif"];
    if (!in_array($imageFileType, $allowed_formats)) {
        echo "<script>alert('Maaf, hanya format JPG, JPEG, PNG & GIF yang diperbolehkan.');</script>";
        $uploadOk = 0;
    }

    // Jika semuanya baik, coba untuk mengunggah file
    if ($uploadOk != 0) {
        if (move_uploaded_file($_FILES["Bukti_Pembayaran"]["tmp_name"], $target_file)) {
            echo "<script>alert('File " . basename($target_file) . " berhasil diunggah.');</script>";
            $bukti_pembayaran = basename($_FILES["Bukti_Pembayaran"]["name"]);

            // Validasi Email dan Nomor Telepon
            $sql_check = "SELECT * FROM pembayaran WHERE Email='$email' OR No_Telepon='$no_telepon'";
            $result_check = $conn->query($sql_check);

            if ($result_check->num_rows > 0) {
                echo "<script>alert('Email atau nomor telepon sudah terdaftar.');</script>";
            } else {
                // Pastikan koneksi ke database berhasil
                if ($conn) {
                    $sql = "INSERT INTO pembayaran (Nama, Email, No_Telepon, Nama_Bank, Jumlah, Tanggal_Pembayaran, Foto_Pembayaran)
                    VALUES ('$nama', '$email', '$no_telepon', '$bank', '$jumlah', '$tanggal_pembayaran', '$bukti_pembayaran')";

                    if ($conn->query($sql) === TRUE) {
                        echo "<script>alert('Pembayaran berhasil disimpan.');</script>";
                    } else {
                        echo "<script>alert('Terjadi kesalahan saat menyimpan pembayaran.');</script>";
                    }
                } else {
                    echo "<script>alert('Terjadi kesalahan dalam koneksi ke database.');</script>";
                }
            }
        } else {
            echo "<script>alert('Maaf, terjadi kesalahan saat mengunggah file.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }

        .centered {
            text-align: center;
        }

        .featurette-divider {
            margin-top: 50px;
            margin-bottom: 50px;
            border: 0;
            border-top: 1px solid #eee;
        }

        .jumbotron-flat {
            background-color: #f9f9f9;
            padding-top: 30px;
            padding-bottom: 30px;
            border-radius: 0;
            border: 1px solid #ccc;
        }

        .paymentAmt {
            font-size: 24px;
            text-align: center;
        }

        .hidden {
            display: none;
        }
    </style>
    <script>
        $(document).ready(function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var target = $(e.target).attr("href");
                if (target === "#qris") {
                    $("#payment-form").addClass("hidden");
                    $("#qris-image").removeClass("hidden");
                } else {
                    $("#payment-form").removeClass("hidden");
                    $("#qris-image").addClass("hidden");
                }
            });
        });
    </script>
</head>

<body>
    <div class="container">
        <div class="centered title">
            <h1>Pembayaran Service</h1>
        </div>
    </div>
    <hr class="featurette-divider">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="tab-content">
                    <div id="stripe" class="tab-pane fade in active">
                        <script src='https://js.stripe.com/v2/' type='text/javascript'></script>
                        <form accept-charset="UTF-8" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"
                            class="require-validation" data-cc-on-file="false"
                            data-stripe-publishable-key="pk_bQQaTxnaZlzv4FnnuZ28LFHccVSaj" id="payment-form"
                            method="post" enctype="multipart/form-data">
                            <div style="margin:0;padding:0;display:inline">
                                <input name="utf8" type="hidden" value="✓" />
                                <input name="_method" type="hidden" value="PUT" />
                                <input name="authenticity_token" type="hidden"
                                    value="qLZ9cScer7ZxqulsUWazw4x3cSEzv899SP/7ThPCOV8=" />
                            </div>
                            <br>
                            <div class='form-row'>
                                <div class='form-group required'>
                                    <div class='error form-group hide'>
                                        <div class='alert-danger alert'>
                                            Please correct the errors and try again.
                                        </div>
                                    </div>
                                    <label class='control-label'>Nama</label>
                                    <input class='form-control' placeholder="Masukan Nama Yang Sesuai" name="Nama"
                                        size='4' type='text'>
                                </div>
                            </div>
                            <div class='form-row'>
                                <div class='form-group card required'>
                                    <label class='control-label'>Email</label>
                                    <input autocomplete='off' placeholder="Masukan Email Yang Sesuai" name="Email"
                                        class='form-control card-number' size='20' type='text'>
                                </div>
                            </div>
                            <div class='form-row'>
                                <div class='form-group card required'>
                                    <label class='control-label'>No Telepon</label>
                                    <input autocomplete='off' placeholder="Masukan No Telepon" class='form-control'
                                        name="No_Telepon" size='20' type='text'>
                                </div>
                            </div>
                            <div class='form-row'>
                                <div class='form-group expiration required'>
                                    <label class='control-label'>Nama Bank</label>
                                    <select name="Bank" class='form-control bank-name'>
                                        <option value=''>Pilih Bank</option>
                                        <option value='Bank BNI'>Bank BNI</option>
                                        <option value='Bank BCA'>Bank BCA</option>
                                        <option value='Bank BRI'>Bank BRI</option>
                                        <option value='Bank MANDIRI'>Bank Mandiri</option>
                                        <option value='Bank SEA BANK'>Sea Bank</option>
                                    </select>
                                </div>

                                <div class='form-group expiration required'>
                                    <label class='control-label'>Jumlah</label>
                                    <input class='form-control card-expiry-year' placeholder='Jumlah' size='4'
                                        name="Jumlah" type='text'>
                                </div>

                                <div class='form-group expiration required'>
                                    <label class='control-label'>Tanggal Pembayaran</label>
                                    <input class='form-control card-expiry-year' name="Tanggal_Pembayaran"
                                        placeholder='Jumlah' size='4' type='date'>
                                </div>

                                <div class='form-group expiration required'>
                                    <label class='control-label'>Bukti Pembayaran</label>
                                    <input class='form-control card-expiry-year' placeholder='Bukti Pembayaran' size='4'
                                        name="Bukti_Pembayaran" type='file'>
                                </div>

                            </div>
                            <div class='form-row'>
                                <div class='form-group'>
                                    <label class='control-label'></label>
                                    <button class='form-control btn btn-primary' name="Bayar" type='submit'>Bayar
                                        Sekarang</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <label class='control-label'></label><!-- spacing -->
                        <div class="alert alert-info">Pilih Pembayaran Yang Sesuai Dengan Kebutuhan dan kirim Ke No
                            Rekening Berikut : 1934215681</div>
                        <br>
                        <div class="btn-group-vertical btn-block">
                            <a class="btn btn-default" style="text-align: left;" data-toggle="tab"
                                href="#stripe">Transfer Bank</a>
                            <a class="btn btn-default" style="text-align: left;" data-toggle="tab"
                                href="#qris">QRIS</a>
                        </div>
                    </div>
                </div>
                <!-- Tab QRIS -->
                <div class="tab-pane fade" id="qris">
                    <div id="qris-image" class="hidden">
                        <img src="../../Image/QR HAHAHA.jpg" alt="QRIS" style="width: 100%; max-width: 400px;">
                    </div>
                </div>
                <!-- Tombol kembali -->
                <div class="row">
                    <div class="col-sm-12">
                        <a href="Pembayaran.php" class="btn btn-primary" style="margin-top: 20px;">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
