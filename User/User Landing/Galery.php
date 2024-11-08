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


<!DOCTYPE html>
<!-- Website - www.codingnepalweb.com -->
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Galery</title>
    <link rel="stylesheet" href="../../CSS/Galery.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
  </head>
  <body>
    <div class="container">
      <!-- Images Filter Buttons Section -->
      <div class="row mt-5" id="filter-buttons">
        <div class="col-12">
          <button class="btn mb-2 me-1 active" data-filter="all">Show all</button>
          <button class="btn mb-2 mx-1" data-filter="nature">Nature</button>
          <button class="btn mb-2 mx-1" data-filter="cars">Motorcyle</button>
          <button class="btn mb-2 mx-1" data-filter="people">People</button>
          <a href="User.php" class="btn btn-primary mb-2 mx-1">Home</a>
        </div>
      </div>

      <!-- Filterable Images / Cards Section -->
      <div class="row px-2 mt-4 gap-3" id="filterable-cards">
        <div class="card p-0" data-name="nature">
          <img src="https://images.unsplash.com/photo-1713541493823-2238651de0a1?q=80&w=1934&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="img">
          <div class="card-body">
            <h6 class="card-title">Mountains</h6>
            <p class="card-text">Lorem ipsum dolor..</p>
          </div>
        </div>
        <div class="card p-0" data-name="nature">
          <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=1770&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="img">
          <div class="card-body">
            <h6 class="card-title">Lights</h6>
            <p class="card-text">Lorem ipsum dolor..</p>
          </div>
        </div>
        <div class="card p-0" data-name="nature">
          <img src="https://images.unsplash.com/photo-1519681393784-d120267933ba?q=80&w=1770&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="img">
          <div class="card-body">
            <h6 class="card-title">Nature</h6>
            <p class="card-text">Lorem ipsum dolor..</p>
          </div>
        </div>
        <div class="card p-0" data-name="nature">
          <img src="https://images.unsplash.com/photo-1666923839082-c7ae2f5ccd48?q=80&w=1932&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="img">
          <div class="card-body">
            <h6 class="card-title">Nature</h6>
            <p class="card-text">Lorem ipsum dolor..</p>
          </div>
        </div>
        <div class="card p-0" data-name="nature">
          <img src="https://images.unsplash.com/photo-1707651020201-f8ccbb481361?q=80&w=1770&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="img">
          <div class="card-body">
            <h6 class="card-title">Nature</h6>
            <p class="card-text">Lorem ipsum dolor..</p>
          </div>
        </div>
        <div class="card p-0" data-name="nature">
          <img src="https://images.unsplash.com/photo-1695479566085-750c0bfa0735?q=80&w=1996&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="img">
          <div class="card-body">
            <h6 class="card-title">Nature</h6>
            <p class="card-text">Lorem ipsum dolor..</p>
          </div>
        </div>
        <div class="card p-0" data-name="nature">
          <img src="https://images.unsplash.com/photo-1704734951214-a33ac14ecbcf?w=500&auto=format&fit=crop&q=60&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHx0b3BpYy1mZWVkfDgxfENEd3V3WEpBYkV3fHxlbnwwfHx8fHw%3D" alt="img">
          <div class="card-body">
            <h6 class="card-title">Nature</h6>
            <p class="card-text">Lorem ipsum dolor..</p>
          </div>
        </div>
        <div class="card p-0" data-name="cars">
          <img src="https://images.unsplash.com/photo-1502744688674-c619d1586c9e?q=80&w=1770&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="img">
          <div class="card-body">
            <h6 class="card-title">Retro</h6>
            <p class="card-text">Lorem ipsum dolor..</p>
          </div>
        </div>
        <div class="card p-0" data-name="cars">
          <img src="https://images.unsplash.com/photo-1508357941501-0924cf312bbd?q=80&w=1770&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="img">
          <div class="card-body">
            <h6 class="card-title">Fast</h6>
            <p class="card-text">Lorem ipsum dolor..</p>
          </div>
        </div>
        <div class="card p-0" data-name="cars">
          <img src="https://images.unsplash.com/photo-1515777315835-281b94c9589f?q=80&w=1824&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="img">
          <div class="card-body">
            <h6 class="card-title">Classic</h6>
            <p class="card-text">Lorem ipsum dolor..</p>
          </div>
        </div>
        <div class="card p-0" data-name="people">
          <img src="https://images.unsplash.com/photo-1532635241-17e820acc59f?q=80&w=2015&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="img">
          <div class="card-body">
            <h6 class="card-title">Girl</h6>
            <p class="card-text">Lorem ipsum dolor..</p>
          </div>
        </div>
        <div class="card p-0" data-name="people">
          <img src="https://images.unsplash.com/photo-1517732306149-e8f829eb588a?q=80&w=1772&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="img">
          <div class="card-body">
            <h6 class="card-title">People</h6>
            <p class="card-text">Lorem ipsum dolor..</p>
          </div>
        </div>
      </div>
    </div>

  </body>
  <script src="../../JS/Galery.js"></script>
</html>