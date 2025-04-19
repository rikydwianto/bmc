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
                Checkout
            </h1>
        </div>
    </section>
    <section class="container my-5">
  <h2 class="mb-4">Checkout</h2>
  <form id="checkoutForm">
    <div class="row">
      <!-- Info Pengiriman -->
      <div class="col-md-6 mb-4">
        <div class="card shadow-sm p-4">
          <h5 class="mb-3">Shipping Information</h5>
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" class="form-control" name="name" >
          </div>
          <div class="mb-3">
            <label class="form-label">Phone Number</label>
            <input type="text" class="form-control" name="phone" >
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" >
          </div>
          <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea class="form-control" name="address" rows="4" ></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label">Note (Optional)</label>
            <textarea class="form-control" name="note" rows="2"></textarea>
          </div>
        </div>
      </div>

      <!-- Ringkasan Order + Pembayaran -->
      <div class="col-md-6 mb-4">
        <div class="card shadow-sm p-4">
          <h5 class="mb-3">Order Summary</h5>
          <div id="orderSummary">
            <!-- Akan diisi lewat JS -->
            <p class="text-muted">Loading cart...</p>
          </div>
          <hr>
          <div class="mb-3">
            <label class="form-label">Payment Method</label>
            <select class="form-select" name="payment_method" id="paymentMethod" >
  <option value="">-- Select --</option>
  <?php foreach ($paymentMethods as $key => $method): ?>
    <option value="<?= htmlspecialchars($key) ?>"><?= htmlspecialchars($method['label']) ?></option>
  <?php endforeach; ?>
</select>
          </div>
          <button type="submit" class="btn btn-primary w-100 mt-3">Place Order</button>
        </div>
      </div>
    </div>
  </form>
</section>

<?php include_once("layout/order-now.php") ?>




   <?php include_once("layout/footer.php") ?>
   <?php include_once("layout/footer_script.php") ?>

</body>

</html>