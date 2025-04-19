<?php
$addLimit = ""; 
if($limit_produk){
    $addLimit=' LIMIT 15';
}
$query = "SELECT 
            p.id AS product_id,
            p.name AS product_name,
            p.description AS product_description,
            c.name AS category_name,
            pi.image AS product_image,
            MIN(pv.price) AS min_price,
            MAX(pv.price) AS max_price,
            GROUP_CONCAT(DISTINCT pv.size ORDER BY FIELD(pv.size, 'S', 'M', 'L', 'XL', 'XXL') SEPARATOR ' / ') AS sizes,
            p.is_recommended,
            p.is_free_shipping,
            p.is_limited
        FROM 
            products p
        JOIN 
            categories c ON p.category_id = c.id
        JOIN 
            product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
        JOIN 
            product_variants pv ON p.id = pv.product_id AND pv.stock > 0
        GROUP BY 
            p.id
        ORDER BY 
            p.id ASC $addLimit;

";

$stmt = $pdo->prepare($query);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<section id="products" style="background-color: #f8f9fa; padding: 80px 0;">
    <div class="container">
        <div class="row g-4">

            <?php foreach ($products as $product): ?>
            <div class="col-6 col-md-4 col-lg-4">
                <div class="card border-0 shadow h-100 transition-card">
                    <div class="position-relative overflow-hidden rounded-top">
                        <img src="assets/img/product/<?php echo $product['product_image']; ?>"
                            class="card-img-top product-img" alt="Produk <?php echo $product['product_id']; ?>">
                        <div class="position-absolute d-flex gap-2 flex-wrap"
                            style="top: 8px; left: 8px; z-index: 2; max-width: 100%;">
                            <?php if ($product['is_recommended']): ?>
                            <img src="assets/img/img/rekomendasi.png" alt="Recommended" style="height: 40px;">
                            <?php endif; ?>

                            <?php if ($product['is_free_shipping']): ?>
                            <img src="assets/img/img/free-shipping.png" alt="Free Shipping" style="height: 40px;">
                            <?php endif; ?>

                            <?php if ($product['is_limited']): ?>
                            <img src="assets/img/img/limited-edition.png" alt="Limited Edition" style="height: 40px;">
                            <?php endif; ?>
                        </div>

                    </div>
                    <div class="card-body">
                        <h6 class="card-title fw-semibold mb-1"><?php echo $product['product_name']; ?></h6>
                        <p class="text-danger fw-bold mb-2">
                            € <?php echo number_format($product['min_price'], 2, ',', '.'); ?>
                            <?php if ($product['min_price'] != $product['max_price']): ?>
                            – € <?php echo number_format($product['max_price'], 2, ',', '.'); ?>
                            <?php endif; ?>
                        </p>
                        <ul class="list-unstyled small text-muted mb-3">
                            <li><i class="bi bi-palette me-2 text-success"></i>Category: <?=$product['category_name']?>
                            </li>
                            <li><i class="bi bi-arrows-fullscreen me-2 text-success"></i>Size:
                                <?= htmlspecialchars($product['sizes']) ?></li>
                        </ul>
                        <!-- Tombol Lihat Detail -->
                        <div class="d-flex flex-column flex-md-row gap-2">
                            <!-- Tombol Lihat Detail -->
                            <a href="detail_produk.php?id=<?=$product['product_id']?>" data-fancybox data-type="ajax"
                                data-caption="<?php echo $product['product_name']; ?>"
                                class="btn btn-dark w-100 w-md-auto">
                                Detail
                            </a>
                            <!-- Tombol Add to Cart -->
                            <a href="javascript:void(0)" onclick="openCart('<?=$product['product_id']?>')"
                                data-type="ajax"
                                data-caption="Add to Cart | <?php echo htmlspecialchars($product['product_name']); ?>"
                                class="btn btn-primary w-100 addToCartBtn">
                                Add to Cart
                            </a>

                        </div>

                    </div>
                </div>
            </div>
            <?php endforeach; ?>

        </div>
        <!-- Tombol More Product -->
        <?php 
         if($limit_produk){
            ?>
        <div class="text-center mt-5">
            <a href="produk.php" class="btn btn-outline-dark px-4 py-2">
                More Products <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
        <?php
         }
         ?>

    </div>
</section>