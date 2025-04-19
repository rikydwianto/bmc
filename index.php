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

    <header class="position-relative overflow-hidden" style="
        background: url('assets/img/bg.jpg') no-repeat center center;
        background-size: cover;
      ">
        <!-- Gradasi dari atas ke bawah (untuk gambar) -->
        <div class="position-absolute top-0 start-0 w-100" style="
          height: 40%;
          background: linear-gradient(
            to bottom,
            rgba(0, 0, 0, 0.6),
            rgba(255, 255, 255, 0)
          );
          z-index: 1;
        "></div>

        <div class="container py-5 position-relative" style="z-index: 2">
            <div class="row align-items-center">
                <!-- Left: Logo + Text -->
                <div class="col-12 col-lg-6 text-lg-start position-relative" style="z-index: 2; padding-top: 5rem">
                    <a href="#"
                        class="d-flex align-items-center justify-content-center justify-content-lg-start mb-3 text-decoration-none"
                        style="color: black">
                        <img src="assets/img/logo.png" alt="B&M Logo" title="Back to Home"
                            style="width: 80px; height: auto" class="me-3" />
                        <div class="fw-bold lh-sm" style="font-size: 18px; color: black">
                            BRYAN &<br />MARCELINA<br />CAROLINA
                        </div>
                    </a>

                    <blockquote class="fs-5 mb-3 fst-italic" style="color: black">
                        <p class="mb-1">
                            <strong>THIS IS NOT JUST AN OBJECT, BUT A STORY OF LOVE.</strong>
                        </p>
                        <small>CE N'EST PAS SEULEMENT UN OBJET, MAIS UNE HISTOIRE
                            D'AMOUR.</small>
                    </blockquote>

                    <h1 class="fw-bold display-5 mb-3" style="line-height: 1.3; color: black">
                        PARIS IS NOT JUST A<br />
                        TRAVEL DESTINATION;<br />
                        IT IS A STORY AND A HOPE.
                    </h1>
                    <p class="fs-6 fst-italic" style="color: black">
                        PARIS N'EST PAS SEULEMENT UNE DESTINATION TOURISTIQUE; C'EST UNE
                        HISTOIRE ET UN ESPOIR.
                    </p>

                    <div class="d-flex flex-wrap justify-content-center justify-content-lg-start gap-3 mt-4">
                        <!-- Tombol pertama: Kontak dalam bahasa Prancis -->
                        <a href="#contact" class="btn btn-light px-4 fw-semibold shadow-sm border border-dark">
                            <img src="https://flagcdn.com/fr.svg" width="20" class="me-2" />CONTACTEZ-NOUS
                        </a>
                        <!-- Tombol kedua: Kontak dalam bahasa Inggris -->
                        <a href="#contact" class="btn btn-light px-4 fw-semibold shadow-sm border border-dark">
                            <img src="https://flagcdn.com/gb.svg" width="20" class="me-2" />CONTACT US
                        </a>
                    </div>
                </div>

                <!-- Right: Image -->
                <div class="col-12 col-lg-6 text-center text-lg-end">
                    <div class="position-relative d-inline-block animate__animated animate__fadeInRight">
                        <img src="assets/img/header-section.png" class="img-fluid rounded shadow-lg header-image"
                            alt="Model Shirt" title="Paris Collection Model" />
                        <!-- Garis Merah -->
                        <div class="position-absolute top-0 end-0 me-2 mt-2">
                            <svg width="24" height="60" viewBox="0 0 24 60" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect x="10" width="4" height="60" rx="2" fill="#F44336" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <section class="ready-for-story text-center py-5 position-relative overflow-hidden"
        style="background-color: #d6d6d6">
        <!-- Efek gradasi blur hitam ke putih atas -->
        <div style="
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 150px;
          background: linear-gradient(to bottom, white, rgba(50, 50, 50, 0));
          z-index: 1;
          pointer-events: none;
        "></div>

        <!-- Efek gradasi blur hitam ke putih bawah -->
        <div style="
          position: absolute;
          bottom: 0;
          left: 0;
          width: 100%;
          height: 150px;
          background: linear-gradient(to top, white, rgba(171, 171, 171, 0));
          z-index: 1;
          pointer-events: none;
        "></div>

        <!-- Divider + konten -->
        <div style="position: relative; z-index: 2">
            <hr style="
            border: 0;
            border-top: 5px solid transparent;
            width: 50%;
            margin: 1.5rem auto;
            border-radius: 25px;
            background: linear-gradient(90deg, #9c27b0, #e91e63, #000000);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.15);
            animation: glowEffect 3s ease-in-out infinite alternate;
          " />

            <p style="
            font-family: 'Georgia', serif;
            font-size: 1.3rem;
            color: #727272;
          ">
                "Your Story Starts Now—Where Will You Go First?"
            </p>
        </div>
    </section>


    <?php include("layout/story.php") ?>
    <section class="ready-for-story text-center py-5 position-relative overflow-hidden"
        style="background-color: #d6d6d6">
        <!-- Efek gradasi blur hitam ke putih atas -->
        <div style="
          position: absolute;
          top: 0;
          left: 0;
          width: 100%;
          height: 50px;
          background: linear-gradient(to bottom, white, rgba(50, 50, 50, 0));
          z-index: 1;
          pointer-events: none;
        "></div>

        <!-- Efek gradasi blur hitam ke putih bawah -->
        <div style="
          position: absolute;
          bottom: 0;
          left: 0;
          width: 100%;
          height: 150px;
          background: linear-gradient(to top, white, rgba(171, 171, 171, 0));
          z-index: 1;
          pointer-events: none;
        "></div>

        <!-- Divider + konten -->
        <div style="position: relative; z-index: 2">
            <hr style="
            border: 0;
            border-top: 5px solid transparent;
            width: 50%;
            margin: 1.5rem auto;
            border-radius: 25px;
            background: linear-gradient(90deg, #9c27b0, #e91e63, #000000);
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.15);
            animation: glowEffect 3s ease-in-out infinite alternate;
          " />

            <p style="
            font-family: 'Georgia', serif;
            font-size: 1.3rem;
            color: #727272;
          ">
            </p>
        </div>
    </section>
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
    <?php 
    $limit_produk = true;
    include("proses/produk_list.php");
    ?>

    <?php include_once("layout/order-now.php") ?>



   <?php include_once("layout/footer.php") ?>
   <?php include_once("layout/footer_script.php") ?>

</body>

</html>