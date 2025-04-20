<?php 
// Pastikan koneksi $pdo sudah tersedia
$stmt = $pdo->prepare("SELECT * FROM orders ORDER BY created_at DESC");
$stmt->execute();
$orders = $stmt->fetchAll();
?>

<h3 class="mb-4">Orders Management</h3>

<div class="card shadow-sm p-3 mb-4">
    <h5 class="mb-3">All Order Details</h5>
    <div class="table-responsive">
    <table id="ordersTable" class="table table-bordered table-striped table-hover">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Order Number</th>
                <th>Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Total (€)</th>
                <th>Payment Method</th>
                <th>Is Paid</th>
                <th>Paid Status</th>
                <th>Payment Proof</th>
                <th>Payment Note</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= htmlspecialchars($order['id']) ?></td>
                <td>       <a href="#" 
       class="order-detail-link" 
       data-order-id="<?= $order['id'] ?>">
       <?= htmlspecialchars($order['order_number']) ?>
    </a>

</td>
                <td><?= htmlspecialchars($order['name']) ?></td>
                <td><?= nl2br(htmlspecialchars($order['address'])) ?></td>
                <td><?= htmlspecialchars($order['phone']) ?></td>
                <td><?= htmlspecialchars($order['email']) ?></td>
                <td><?= number_format($order['total'], 2) ?></td>
                <td><?= htmlspecialchars($order['payment_method']) ?></td>
                <td><?= $order['is_paid'] ? 'Yes' : 'No' ?></td>
                <td><?= ucfirst($order['paid_status']) ?></td>
                <td>
                <?php if (!empty($order['payment_proof'])): ?>
        <a href="#" 
           class="payment-proof-btn" 
           data-id="<?= $order['id'] ?>"
           data-image="../assets/payment_proofs/<?= htmlspecialchars($order['payment_proof']) ?>">
           View
        </a>
    <?php else: ?>
        -
    <?php endif; ?>
                </td>
                <td><?= nl2br(htmlspecialchars($order['payment_note'])) ?></td>
                <td><?= htmlspecialchars($order['created_at']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
  
</div>

