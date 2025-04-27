<?php
include_once("core/loader.php");

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
    SELECT size, price, stock,discount_price
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
<div class="container py-4" style="max-width: 960px;">
    <h4 class="mb-4 fw-bold"><?= htmlspecialchars($product['name']) ?></h4>

    <!-- Layout Gambar Kiri, Deskripsi Kanan -->
    <div class="row mb-5 align-items-start">
        <div class="col-md-6">
            <div class="position-relative">
                <!-- Badge di atas gambar -->
                <div class="mb-3">
                    <?php if (!empty($product['is_recommended'])): ?>
                        <img src="assets/img/img/rekomendasi.png" alt="Recommended" style="height: 50px;">
                    <?php endif; ?>
                    <?php if (!empty($product['is_free_shipping'])): ?>
                        <img src="assets/img/img/free-shipping.png" alt="Free Shipping" style="height: 50px;">
                    <?php endif; ?>
                    <?php if (!empty($product['is_limited'])): ?>
                        <img src="assets/img/img/limited-edition.png" alt="Limited Edition" style="height: 50px;">
                    <?php endif; ?>
                </div>

                <!-- Galeri Gambar -->
                <div class="d-flex flex-wrap gap-2">
                    <?php foreach ($images as $img): ?>
                        <a href="assets/img/product/<?= $img['image'] ?>"
                            data-fancybox="detail-gallery-<?= $product['id'] ?>">
                            <img src="assets/img/product/<?= $img['image'] ?>" alt="Gambar Produk" class="rounded shadow-sm"
                                style="height: 200px; width: auto; object-fit: cover; transition: transform .3s;"
                                onmouseover="this.style.transform='scale(1.05)'"
                                onmouseout="this.style.transform='scale(1)'">
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6" style="font-size: smaller;text-align: justify;">
            <p class="text-muted small"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
            <p class="small">Note : <br>
                <hr> <?= nl2br(htmlspecialchars($product['note'])) ?>
            </p>
        </div>
    </div>

    <!-- Layout Bawah: Harga & Panduan Ukuran Berdampingan -->
    <div class="row g-4">


        <!-- Panduan Ukuran -->
        <?php if ($size_guide): ?>
            <div class="col-md-4">
                <h6 class="mb-2">Size Guide(cm):</h6>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered small text-center" style="font-size: small;">
                        <thead class="table-light">
                            <tr>
                                <th>Size</th>
                                <th>Width</th>
                                <th>Height</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($size_guide as $guide): ?>
                                <tr>
                                    <td><?= htmlspecialchars($guide['size']) ?></td>
                                    <td><?= $guide['width'] ?></td>
                                    <td><?= $guide['height'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>

        <!-- Harga per Ukuran -->
        <div class="col-md-8">
            <h6 class="mb-2">Price:</h6>
            <div class="table-responsive">
                <table class="table table-sm table-bordered small text-center" style="font-size: small;">
                    <thead class="table-light">
                        <tr>
                            <th>SIZE</th>
                            <th>EUR</th>
                            <th>USD</th>
                            <th>AUD</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($variants as $variant): ?>
                            <?php
                            $stock = $variant['stock'];
                            $tr = '';
                            if ($stock < 1) $tr = 'table-danger';
                            $hasDiscount = isset($variant['discount_price']) && $variant['discount_price'] > 0;
                            $priceEUR = $hasDiscount ? $variant['discount_price'] : $variant['price'];
                            $priceUSD = $priceEUR * $rate_usd;
                            $priceAUD = $priceEUR * $rate_aud;
                            ?>
                            <tr class='<?= $tr ?>'>
                                <td><strong><?= htmlspecialchars($variant['size']) ?></strong></td>

                                <td>
                                    <?php if ($hasDiscount): ?>
                                        <span class="text-muted text-decoration-line-through">€
                                            <?= number_format($variant['price'], 2, ',', '.') ?></span><br>
                                        <span class="text-danger fw-bold">€
                                            <?= number_format($variant['discount_price'], 2, ',', '.') ?></span>
                                    <?php else: ?>
                                        € <?= number_format($variant['price'], 2, ',', '.') ?>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if ($hasDiscount): ?>
                                        <span class="text-muted text-decoration-line-through">$
                                            <?= number_format($variant['price'] * $rate_usd, 2, ',', '.') ?></span><br>
                                        <span class="text-danger fw-bold">$ <?= number_format($priceUSD, 2, ',', '.') ?></span>
                                    <?php else: ?>
                                        $ <?= number_format($priceUSD, 2, ',', '.') ?>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php if ($hasDiscount): ?>
                                        <span class="text-muted text-decoration-line-through">$
                                            <?= number_format($variant['price'] * $rate_aud, 2, ',', '.') ?></span><br>
                                        <span class="text-danger fw-bold">$ <?= number_format($priceAUD, 2, ',', '.') ?></span>
                                    <?php else: ?>
                                        $ <?= number_format($priceAUD, 2, ',', '.') ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <table class='table table-sm table-bordered'>
                    <thead>

                        <tr>
                            <td class=''>*Status</td>
                            <td class=''>Available</td>

                        </tr>
                        <tr class='table-danger'>
                            <td></td>
                            <td>Unavailable</td>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>
</div>