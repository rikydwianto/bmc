<?php
require_once '../core/loader.php'; // Pastikan koneksi PDO sudah dibuat di file ini

// Cek jika user belum login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php'); // Arahkan ke halaman login jika belum login
    exit;
}

// Ambil parameter 'menu' dari URL
$currentMenu = isset($_GET['menu']) ? $_GET['menu'] : 'home'; // Default halaman 'home'

// Ambil data dari tabel products
$productStmt = $pdo->prepare("SELECT * FROM products ORDER BY created_at DESC");
$productStmt->execute();
$products = $productStmt->fetchAll();

// Ambil data dari tabel categories
$categoryStmt = $pdo->prepare("SELECT * FROM categories ORDER BY created_at DESC");
$categoryStmt->execute();
$categories = $categoryStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">Admin Dashboard</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentMenu === 'home' ? 'active' : ''); ?>" href="?menu=home">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentMenu === 'orders' ? 'active' : ''); ?>" href="?menu=orders">Orders</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentMenu === 'products' ? 'active' : ''); ?>" href="?menu=products">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo ($currentMenu === 'categories' ? 'active' : ''); ?>" href="?menu=categories">Categories</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- Konten Dinamis -->
<div class="container">
    <?php if ($currentMenu === 'home'): ?>
        <h3>Welcome to Admin Dashboard</h3>
        <p>Manage your store from here.</p>
    <?php elseif ($currentMenu === 'orders'):
        include_once("proses/orders.php");
        elseif ($currentMenu === 'products'):
            include_once("proses/data-produk.php");
        elseif ($currentMenu === 'categories'): ?>
        <h3 class="mb-4">Categories Management</h3>
        <!-- Tabel Categories -->
        <div class="card shadow-sm p-3 mb-4">
            <h5 class="mb-3">Categories List</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Created At</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?= htmlspecialchars($category['id']) ?></td>
                        <td><?= htmlspecialchars($category['name']) ?></td>
                        <td><?= htmlspecialchars($category['description']) ?></td>
                        <td><?= htmlspecialchars($category['created_at']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="assets/js//script.js"></script>

<script>
    $(document).ready(function () {
        $('#ordersTable').DataTable({
            pageLength: 10,
            order: [[12, 'desc']], // Urut berdasarkan Created At
            columnDefs: [
                { targets: [3, 11], orderable: false } // Disable sorting untuk kolom address & payment note
            ]
        });
    });
</script>

</body>
</html>
