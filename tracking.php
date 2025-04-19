<?php
include("core/loader.php");

$order_number = $_GET['id'] ?? null;

if (!$order_number) {
    // Jika ID tidak ada, tampilkan form untuk memasukkan order_number
    ?>
    <!DOCTYPE html>
    <html lang="en">
    <head>
        <title>Track Your Order</title>
        <?php include("layout/page_head_script.php") ?>
    </head>
    <body>
    <?php include("layout/navbar.php") ?>

    <section class="container my-5">
        <h2 class="mb-4">Track Your Order</h2>

        <div class="card shadow p-4">
            <h5>Please enter your Order Number</h5>
            <form action="tracking.php" method="GET">
                <div class="mb-3">
                    <label for="order_number" class="form-label">Order Number</label>
                    <input type="text" class="form-control" id="order_number" name="id" placeholder="Enter your order number" required>
                </div>
                <button type="submit" class="btn btn-primary">Track Order</button>
            </form>
        </div>
    </section>

    <?php include("layout/footer.php") ?>
    <?php include("layout/footer_script.php") ?>
    </body>
    </html>
    <?php
    exit; // Menghentikan eksekusi agar tidak melanjutkan ke bagian berikutnya
}

// Jika ID ada, lanjutkan proses seperti sebelumnya
$stmt = $pdo->prepare("SELECT * FROM orders WHERE order_number = ?");
$stmt->execute([$order_number]);
$order = $stmt->fetch();
if (!$order) {
    die("Order not found.");
}

// Ambil status dan timeline (history) dari order
$stmt = $pdo->prepare("SELECT * FROM order_status WHERE order_id = ? ORDER BY timestamp ASC");
$stmt->execute([$order['id']]);
$order_status = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Track Order #<?= htmlspecialchars($order_number) ?></title>
    <?php include("layout/page_head_script.php") ?>
    <style>
        .timeline {
            list-style: none;
            padding-left: 0;
            margin-top: 20px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 20px;
        }

        .timeline-icon {
            position: absolute;
            left: -20px;
            top: 0;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background-color: #007bff;
            box-shadow: 0 0 0 3px #fff;
        }

        .timeline-content {
            padding-left: 30px;
            padding-top: 5px;
        }

        .timeline-content h6 {
            font-size: 1.1em;
            margin: 0;
        }

        .timeline-content small {
            font-size: 0.85em;
            color: #6c757d;
        }

        .timeline-item .timeline-icon.bg-primary {
            background-color: #007bff;
        }

        .timeline-item .timeline-icon.bg-success {
            background-color: #28a745;
        }

        .timeline-item .timeline-icon.bg-info {
            background-color: #17a2b8;
        }

        .timeline-item .timeline-icon.bg-dark {
            background-color: #343a40;
        }

        .timeline-item .timeline-icon.bg-danger {
            background-color: #dc3545;
        }

    </style>
</head>
<body>
<?php include("layout/navbar.php") ?>

<section class="container my-5">
    <h2 class="mb-4">Track Order #<?= htmlspecialchars($order_number) ?></h2>

    <div class="card shadow p-4">
        <h5>Order Information</h5>
        <p><strong>Order Date:</strong> <?= date('d M Y, H:i', strtotime($order['created_at'])) ?></p>
        <p><strong>Total Amount:</strong> €<?= number_format($order['total'], 2) ?></p>

        <hr>

        <h5>Order Timeline</h5>
        <div class="timeline">
            <?php foreach ($order_status as $status): ?>
                <div class="timeline-item">
                    <div class="timeline-icon bg-<?= getStatusColor($status['status']) ?>"></div>
                    <div class="timeline-content">
                        <h6><?= htmlspecialchars($status['status']) ?></h6>
                        <p><?= nl2br(htmlspecialchars($status['description'])) ?></p>
                        <small><strong>Timestamp:</strong> <?= date('d M Y, H:i', strtotime($status['timestamp'])) ?></small>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <hr>
        <a href="index.php" class="btn btn-outline-primary">Back to Home</a>
    </div>
</section>

<?php include("layout/footer.php") ?>
<?php include("layout/footer_script.php") ?>

</body>
</html>
