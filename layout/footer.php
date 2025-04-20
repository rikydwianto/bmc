<!-- Modal untuk menampilkan konten yang dimuat -->
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Cart Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalContent">
                <!-- Konten yang dimuat via AJAX akan ditampilkan di sini -->
            </div>
        </div>
    </div>
</div>
<!-- Footer -->
<footer class="text-light pt-5 pb-4" id="contact" style="background-color: #1a1a1a">
    <div class="container">
        <div class="row justify-content-between align-items-start text-center text-md-start">
            <!-- Logo Kiri -->
            <div class="col-lg-4 mb-4 ms-lg-0 mb-lg-0">
                <a href="index.php"
                   class="d-flex align-items-center justify-content-center justify-content-lg-start text-decoration-none text-white logo-link mb-3">
                    <img src="assets/img/logo.png" alt="B&M Logo" title="Back to Home"
                         style="width: 80px; height: auto" class="me-3" />
                    <div class="fw-bold lh-sm" style="font-size: 18px">
                        BRYAN &<br />MARCELINA<br />CAROLINA
                    </div>
                </a>
            </div>

            <!-- Menu Tengah -->
            <div class="col-lg-4 mb-4 mb-lg-0 text-center">
                <h6 class="text-uppercase fw-bold mb-3">Menu</h6>
                <ul class="list-unstyled">
                    <li><a href="index.php" class="text-light text-decoration-none">Home</a></li>
                    <li><a href="index.php#story" class="text-light text-decoration-none">Story</a></li>
                    <li><a href="produk.php" class="text-light text-decoration-none">Products</a></li>
                    <li><a href="tracking.php" class="text-light text-decoration-none">Tracking Order</a></li>
                </ul>
            </div>

            <!-- Sosial Media Kanan -->
            <div class="col-lg-4 text-center text-lg-end">
                <div class="mb-2">
                    <a href="https://wa.me/6287860322676?text=Hallo" target="_blank" class="text-light text-decoration-none me-3">
                        <i class="bi bi-whatsapp" style="font-size: 1.5rem"></i>
                    </a>
                </div>
                <small class="d-block">Telp: <a href="https://wa.me/6287860322676?text=Hallo" class="text-light text-decoration-none">+62 878-6032-2676</a></small>
                <small class="d-block mt-2">
                    <strong>We accept custom orders. Please contact our admin.</strong><br>
                    <strong>Nous acceptons les commandes personnalisées. Veuillez contacter notre admin.</strong>
                </small>
            </div>
        </div>

        <!-- Garis & Copyright -->
        <hr class="my-4 border-light" />
        <div class="text-center">
            <small>&copy; 2025 Bryan & Marcelina Carolina. All rights reserved.</small>
        </div>
    </div>
</footer>

<!-- Floating Cart Button -->
<button class="btn btn-dark rounded-circle shadow cart-floating-btn" onclick="getCart()" type="button" data-bs-toggle="offcanvas" data-bs-target="#cartOffcanvas" aria-controls="cartOffcanvas">
    <i class="bi bi-cart-fill fs-4"></i>
</button>
<div class="offcanvas offcanvas-start" tabindex="-1" id="cartOffcanvas" aria-labelledby="cartOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="cartOffcanvasLabel">Your Cart</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <!-- Content keranjang -->
        <div id="cartContent">
            <p class="text-muted">Your cart is empty.</p>
        </div>
        <hr>
        <div class="text-end">
            <a href="checkout.php" class="btn btn-primary w-100">Checkout</a>
        </div>
    </div>
</div>
