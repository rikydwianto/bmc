<?php 
include("core/loader.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
<?php
    include_once("layout/page_head_script.php");
    ?>
</head>

<body>
    <?php include_once("layout/navbar.php") ?>



    <section id="our-product" style="
  background: url('assets/img/bg-our-product.jpg') no-repeat top center;
  background-size: cover;
  min-height: 50vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background-position: 0 -30px; /* Geser background sedikit ke bawah */
">
        <div class="container text-center">
            <h1 style="
      margin-top: 10px;
      font-family: 'Khand', sans-serif;
      font-weight: 700;
      font-size: 10vw; /* Menggunakan vw untuk ukuran teks responsif */
      color: white;
      text-transform: uppercase;
      letter-spacing: 20px; /* Menambah jarak antar huruf */
      text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5); /* Menambahkan shadow pada teks */
    ">
                Our Product
            </h1>
        </div>
    </section>

<?php include_once("layout/order-now.php") ?>




   <?php include_once("layout/footer.php") ?>
   <?php include_once("layout/footer_script.php") ?>

</body>

</html>