<?php
    require '../Database/dregister.php';
    if(isset($_POST['register']))
    {
        if(registrasi($_POST) > 0)
        {
            echo "<script>
            alert('User baru telah berhasil ditambahkan!');
            </script>";
            echo "<meta http-equiv='refresh' content='1;url= Form.php'>";
        }  else {
            echo mysqli_error($conn);
        }
    }
?>

<?php
session_start();
include ('../Connection/Koneksi.php');

if (isset($_POST['login'])) 
{
    // Prepare and bind SQL statement
    $stmt = $conn->prepare("SELECT * FROM data_user WHERE Nama = ? AND Password = ?");
    $stmt->bind_param("ss", $sign_username, $sign_password);

    // Set parameters and execute
    $sign_username = $_POST['sign_username'];
    $sign_password = $_POST['sign_password'];
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    // Check if there is a matching user
    if ($result->num_rows == 1) 
    {
        $_SESSION['login'] = $result->fetch_assoc();
        echo "<script>alert('Berhasil Login');</script>";
        echo "<meta http-equiv='refresh' content='1;url=../User/User Landing/User.php'>";
    }
    else
    {
        echo "<script>alert('User Tidak Terdaftar!!!');</script>";
        echo "<meta http-equiv='refresh' content='1;url=Form.php'>";
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script src="https://kit.fontawesome.com/c856ca633a.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../CSS/Form.css" />
    <title>User Form</title>
  </head>
  <body>
    <div class="container">
      <div class="forms-container">
        <div class="signin-signup">
          <form action="#" method="post" class="sign-in-form" >
            <h2 class="title">SIGN IN</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name="sign_username" placeholder="Username" required />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="sign_password" placeholder="Password" required />
            </div>
            <input type="submit" name="login" value="Login" class="btn solid" />
            <p class="social-text">Klik dibawah ini untuk kembali ke Home</p>
            <div class="social-media">
              <a href="../Home.php" class="social-icon">
                <i class="fa-solid fa-house"></i>
              </a>
            </div>
          </form>
          <form action="#" method="post" class="sign-up-form">
            <h2 class="title">SIGN UP</h2>
            <div class="input-field">
              <i class="fas fa-user"></i>
              <input type="text" name= "username" placeholder="Username" required />
            </div>
            <div class="input-field">
              <i class="fas fa-envelope"></i>
              <input type="email" name="email" placeholder="Email" required/>
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="password" placeholder="Password" required />
            </div>
            <div class="input-field">
              <i class="fas fa-lock"></i>
              <input type="password" name="konfirmasi_password" placeholder="Konfirmasi Password" required />
            </div>
            <input type="submit" name="register" class="btn" value="Sign up" />
            <p class="social-text">Klik dibawah ini untuk kembali ke Home</p>
            <div class="social-media">
              <a href="../Home.php" class="social-icon">
                <i class="fa-solid fa-house"></i>
              </a>
            </div>
          </form>
        </div>
      </div>

      <div class="panels-container">
        <div class="panel left-panel">
          <div class="content">
            <h3>Daftar Disini</h3>
            <p>
              Bagi yang belum memiliki akun mohon untuk mendaftarkan akun terlebih dahulu
            </p>
            <button class="btn transparent" id="sign-up-btn">
              Sign up
            </button>
          </div>
          <img src="../Image/log.svg" class="image" alt="" />
        </div>
        <div class="panel right-panel">
          <div class="content">
            <h3>Login Disini</h3>
            <p>
              Bagi yang sudah memiliki akun silahkan login dengan tombol di bawah
            </p>
            <button class="btn transparent" id="sign-in-btn">
              Sign in
            </button>
          </div>
          <img src="../Image/register.svg" class="image" alt="" />
        </div>
      </div>
    </div>
    <script src="../JS/Form.js"></script>
  </body>
</html>