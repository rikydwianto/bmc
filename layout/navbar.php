

<nav id="scrollNavbar" class="navbar navbar-expand-lg fixed-top euro-navbar" style="display: none; background-color: #f2f2f2;">
    <div class="container">
        <!-- Logo dan Nama -->
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="assets/img/logo.png" alt="Logo" width="80" height="36" class="me-2" />
            <div class="fw-bold lh-sm" style="font-size: 16px; color: #333;">
                BRYAN &<br />MARCELINA<br />CAROLINA
            </div>
        </a>

        <!-- Hamburger -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto gap-3">
                <li class="nav-item">
                    <a class="nav-link active" href="<?=$url?>" style="color: #333;">Home</a>
                </li>

                <!-- Submenu Dropdown untuk Story -->
                <li class="nav-item">
                    <a class="nav-link " href="#story" >
                        Story
                    </a>
                    
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="produk.php" style="color: #333;">Product</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tracking.php" style="color: #333;">Tracking</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact" style="color: #333;">Contact</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
