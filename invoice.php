<?php 
include("core/loader.php");

$order_number = $_GET['id'] ?? null;
if (!$order_number) {
    die("Order ID is missing.");
}

// Ambil data order
$stmt = $pdo->prepare("SELECT * FROM orders WHERE order_number = ?");
$stmt->execute([$order_number]);
$order = $stmt->fetch();
$orderId = $order['id'] ?? null;
if (!$order) {
    die("Order not found.");
}

// Ambil detail item
$stmt = $pdo->prepare("
    SELECT oi.*, p.name, pi.image
    FROM order_items oi
    JOIN product_variants v ON oi.variant_id = v.id
    JOIN products p ON v.product_id = p.id
    LEFT JOIN product_images pi ON pi.product_id = p.id AND pi.is_primary = 1
    WHERE oi.order_id = ?
");
$stmt->execute([$orderId]);
$items = $stmt->fetchAll();

// Cek status bayar
$isPaid = $order['is_paid'] ?? 0;


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Invoice #<?= htmlspecialchars($order_number) ?></title>
    <?php include("layout/page_head_script.php") ?>
</head>

<body>
    <?php include("layout/navbar.php") ?>

    <section class="container my-5">
        <div class="card shadow p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0">Invoice #<?= htmlspecialchars($order_number) ?></h3>
                <span class="badge bg-<?= $isPaid ? 'success' : 'warning' ?> fs-6 px-3 py-2">
                    <?= $isPaid ? 'Paid' : 'Unpaid' ?>
                </span>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Order Date:</strong><br> <?= date('d M Y, H:i', strtotime($order['created_at'])) ?></p>
                    <p><strong>Total Amount:</strong><br> €<?= number_format($order['total'], 2) ?></p>
                    <p><strong>Payment Method:</strong><br>
                        <?= $paymentMethods[$order['payment_method']]['label'] ?? ucfirst($order['payment_method']) ?>
                    </p>
                </div>
                <div class="col-md-6">
                    <h5>Shipping Info</h5>
                    <p>
                        <strong>Name:</strong> <?= htmlspecialchars($order['name']) ?><br>
                        <strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?><br>
                        <strong>Address:</strong><br> <?= nl2br(htmlspecialchars($order['address'])) ?>
                    <p><strong>Order Status:</strong>
                        <?= $isPaid ? 'Paid' : 'Unpaid' ?>
                        <br>
                        <small>Use your <strong>Order Number</strong> to track the status of your order.</small>
                    </p>
                    </p>
                </div>
            </div>


            <?php if (!$isPaid && isset($paymentMethods[$order['payment_method']])): ?>
            <div class="alert alert-info mt-3">
                <strong>Payment Instructions:</strong><br>
                <?php
                    $method = $paymentMethods[$order['payment_method']];
                    if (isset($method['account_number'])) {
                        echo "Bank: <strong>{$method['bank_name']}</strong><br>";
                        echo "Account No: <strong>{$method['account_number']}</strong><br>";
                        echo "Account Name: <strong>{$method['account_name']}</strong><br/>";
                        echo "*<small>{$method['label']}</small>";
                    } else {
                        echo $method['label'];
                    }
                ?>
            </div>

            <form method="GET" action="confirm_payment.php" class="mt-3">
                <input type="hidden" name="order_number" value="<?= $order_number ?>">
                <button class="btn btn-success">I Have Paid</button>
            </form>
            <?php endif; ?>

            <hr>

            <h5 class="mb-3">Order Items</h5>
            <?php foreach ($items as $item): ?>
            <div class="d-flex align-items-center mb-3 border-bottom pb-2">
                <img src="assets/img/product/<?= htmlspecialchars($item['image']) ?>" width="60" class="rounded me-3"
                    alt="<?= htmlspecialchars($item['name']) ?>">
                <div>
                    <strong><?= htmlspecialchars($item['name']) ?></strong><br>
                    Size: <?= htmlspecialchars($item['size']) ?><br>
                    Quantity: <?= $item['quantity'] ?><br>
                    Price: €<?= number_format($item['price'], 2) ?>
                </div>
            </div>
            <?php endforeach; ?>

            <div class="text-end mt-4">
                <a href="index.php" class="btn btn-outline-primary">Back to Home</a>
            </div>
        </div>
    </section>

    <?php include("layout/footer.php") ?>
    <?php include("layout/footer_script.php") ?>
</body>

</html>