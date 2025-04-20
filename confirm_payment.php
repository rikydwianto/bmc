<?php
include("core/loader.php");

$order_number = $_GET['order_number'] ?? null;
$order = null;

if ($order_number) {
    // Ambil data order
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE order_number = ?");
    $stmt->execute([$order_number]);
    $order = $stmt->fetch();

    if ($order) {
        $orderId = $order['id'];

        // Proses jika form dikirim
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $note = $_POST['note'] ?? '';
            $uploadDir = 'assets/payment_proofs/';
            $fileName = '';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            if (isset($_FILES['proof']) && $_FILES['proof']['error'] === UPLOAD_ERR_OK) {
                $ext = pathinfo($_FILES['proof']['name'], PATHINFO_EXTENSION);
                $fileName = uniqid('proof_') . '.' . $ext;
                move_uploaded_file($_FILES['proof']['tmp_name'], $uploadDir . $fileName);
            }

            // Update order
            $stmt = $pdo->prepare("UPDATE orders SET is_paid = 0, paid_status = 'confirm', payment_proof = ?, payment_note = ? WHERE id = ?");
            $stmt->execute([$fileName, $note, $orderId]);
            addOrderStatus($orderId, 'Payment Received', 'Payment has been confirmed. We will process your order soon.');

            header("Location: invoice.php?id=" . $order['order_number']);
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Confirm Payment</title>
    <?php include("layout/page_head_script.php") ?>
</head>
<body>
<?php include("layout/navbar.php") ?>

<section class="container my-5">
    <div class="card shadow p-4">
        <h3 class="mb-4">Confirm Payment</h3>

        <?php if (!$order): ?>
            <!-- Form pencarian order -->
            <form method="GET">
                <div class="mb-3">
                    <label for="order_number" class="form-label">Enter Your Order Number</label>
                    <input type="text" name="order_number" id="order_number" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
        <?php else: ?>
            <div class="mb-3">
                <strong>Order Number:</strong> <?= htmlspecialchars($order['order_number']) ?><br>
                <strong>Total:</strong> €<?= number_format($order['total'], 2) ?><br>
                <strong>Status:</strong> 
                <span class="badge bg-<?= $order['paid_status'] === 'confirmed' ? 'success' : ($order['paid_status'] === 'pending' ? 'warning' : 'secondary') ?>">
                    <?= ucfirst($order['paid_status']) ?>
                </span>
            </div>

            <?php if (!empty($order['payment_proof'])): ?>
                <div class="mb-4">
                    <strong>Previously Uploaded Proof:</strong><br>
                    <img src="assets/payment_proofs/<?= htmlspecialchars($order['payment_proof']) ?>" alt="Payment Proof" style="max-width: 300px;" class="rounded border">
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="proof" class="form-label">Upload Payment Proof</label>
                    <input type="file" name="proof" id="proof" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="note" class="form-label">Note (Optional)</label>
                    <textarea name="note" id="note" class="form-control" rows="3" placeholder="E.g., Transfer from BCA, a/n Riky"></textarea>
                </div>
                <button type="submit" class="btn btn-success">Submit Confirmation</button>
                <a href="invoice.php?id=<?= htmlspecialchars($order['order_number']) ?>" class="btn btn-outline-secondary">Back</a>
            </form>
        <?php endif; ?>
    </div>
</section>

<?php include("layout/footer.php") ?>
<?php include("layout/footer_script.php") ?>
</body>
</html>
