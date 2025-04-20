<?php
// Ambil semua produk dengan kategori dan variant (harga dan stok)
$stmt = $pdo->prepare("
    SELECT 
        p.*,
        c.name AS category_name,
        pv.price,
        pv.discount_price,
        pv.size,
        pv.stock
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    LEFT JOIN (
        SELECT *
        FROM product_variants
        WHERE id IN (
            SELECT MIN(id) FROM product_variants GROUP BY product_id
        )
    ) pv ON pv.product_id = p.id
    ORDER BY p.created_at DESC
");
$stmt->execute();
$products = $stmt->fetchAll();
?>

<h3 class="mb-4">Products Management</h3>

<div class="card shadow-sm p-3 mb-4">
    <h5 class="mb-3">Products List</h5>
    <div class="table-responsive">
        <table id="productsTable" class="table table-bordered table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Size</th>
                    <th>Price</th>
                    <th>Discount Price</th>
                    <th>Stock</th>
                    <th>Free Shipping</th>
                    <th>Recommended</th>
                    <th>Limited</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $product['id'] ?></td>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['category_name']) ?></td>
                    <td><?= htmlspecialchars($product['size']) ?></td>
                    <td>€<?= number_format($product['price'], 2) ?></td>
                    <td>€<?= number_format($product['discount_price'], 2) ?></td>
                    <td><?= $product['stock'] ?></td>
                    <td><?= $product['is_free_shipping'] ? 'Yes' : 'No' ?></td>
                    <td><?= $product['is_recommended'] ? 'Yes' : 'No' ?></td>
                    <td><?= $product['is_limited'] ? 'Yes' : 'No' ?></td>
                    <td><?= $product['created_at'] ?></td>
                    <td><?= $product['updated_at'] ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

