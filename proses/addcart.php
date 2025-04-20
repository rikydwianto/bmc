<?php 
// include("core/loader.php");

$id = $_GET['id'] ?? null;

if (!$id) {
    echo "<p class='text-danger'>Produk tidak ditemukan.</p>";
    exit;
}

// Ambil data produk
$stmt = $pdo->prepare("
    SELECT 
        p.id,
        p.name,
        p.description,
        p.is_recommended,
        p.is_free_shipping,
        p.is_limited,
        p.note

    FROM products p
    WHERE p.id = ?
    LIMIT 1
");
$stmt->execute([$id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    echo "<p class='text-danger'>Produk tidak ditemukan.</p>";
    exit;
}

// Gambar
$stmt = $pdo->prepare("
    SELECT image
    FROM product_images
    WHERE product_id = ?
    ORDER BY is_primary DESC, id ASC
");
$stmt->execute([$id]);
$images = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Varian ukuran
$stmt = $pdo->prepare("
    SELECT id,size, price, stock,discount_price
    FROM product_variants
    WHERE product_id = ?
    ORDER BY FIELD(size, 'S', 'M', 'L', 'XL', 'XXL');
");
$stmt->execute([$id]);
$variants = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Nilai tukar
$rates = getExchangeRates();
$rate_usd = $rates['usd'];
$rate_aud = $rates['aud'];
// Panduan ukuran
$stmt = $pdo->prepare("
    SELECT size, width, height
    FROM size_guide
    WHERE product_id = ?
    ORDER BY  FIELD(size, 'S', 'M', 'L', 'XL', 'XXL');
 
");
$stmt->execute([$id]);
$size_guide = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<form id="add-to-cart-form" action="cart.php" method="POST">
    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
    <h5 class="mb-3">Select Size & Quantity</h5>
    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light text-center">
                <tr>
                    <th>Size</th>
                    <th>Price (€)</th>
                    <th>USD</th>
                    <th>AUD</th>
                    <th>Stock</th>
                    <th>Quantity</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($variants as $variant): 
                    $variant_id = $variant['id'];
                    $has_discount = $variant['discount_price'] > 0;
                    $price = $has_discount ? $variant['discount_price'] : $variant['price'];
                    $usd_price = $price * $rate_usd;
                    $aud_price = $price * $rate_aud;
                    $usd_price_ori = $variant['price'] * $rate_usd;
                    $aud_price_ori = $variant['price'] * $rate_aud;
                ?>
                <tr class="text-center">
                    <td><strong><?= htmlspecialchars($variant['size']) ?></strong></td>
                    <td class="text-danger">
                        <?php if ($has_discount): ?>
                            <span style="text-decoration: line-through; color: gray;">
                                €<?= number_format($variant['price'], 2, ',', '.') ?>
                            </span><br>
                            €<?= number_format($variant['discount_price'], 2, ',', '.') ?>
                        <?php else: ?>
                            €<?= number_format($price, 2, ',', '.') ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($has_discount): ?>
                            <span style="text-decoration: line-through; color: gray;">
                                $<?= number_format($usd_price_ori, 2, '.', ',') ?>
                            </span><br>
                            $<?= number_format($usd_price, 2, '.', ',') ?>
                        <?php else: ?>
                            $<?= number_format($usd_price, 2, '.', ',') ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($has_discount): ?>
                            <span style="text-decoration: line-through; color: gray;">
                                $<?= number_format($aud_price_ori, 2, '.', ',') ?>
                            </span><br>
                            $<?= number_format($aud_price, 2, '.', ',') ?>
                        <?php else: ?>
                            $<?= number_format($aud_price, 2, '.', ',') ?>
                        <?php endif; ?>
                    </td>
                    <td><?= $variant['stock'] ?></td>
                    <td>
                        <div class="input-group input-group-sm justify-content-center">
                            <button type="button" class="btn btn-outline-secondary"
                                onclick="updateQty('qty_<?= $variant_id ?>', -1)">–</button>
                            <input type="number" class="form-control text-center"
                                name="variants[<?= $variant_id ?>][quantity]" id="qty_<?= $variant_id ?>" value="0"
                                min="0" max="<?= $variant['stock'] ?>" style="min-width: 20px;max-width: 60px;" readonly>
                            <button type="button" class="btn btn-outline-secondary"
                                onclick="updateQty('qty_<?= $variant_id ?>', 1)">+</button>
                        </div>
                        <input type="hidden" name="variants[<?= $variant_id ?>][size]" value="<?= $variant['size'] ?>">
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="text-end mt-3">
        <button type="button" id="addToCartBtn" onclick="simpanCart()" class="btn btn-dark">
            <i class="bi bi-cart-plus me-2"></i> Add to Cart
        </button>
    </div>
</form>
