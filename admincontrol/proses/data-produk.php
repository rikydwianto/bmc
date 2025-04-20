<?php
$stmt = $pdo->prepare("
SELECT 
    p.id AS product_id,
    p.name AS product_name,
    c.name AS category_name,
    p.description,
    p.note,
    p.is_recommended,
    p.is_free_shipping,
    p.is_limited,
    p.created_at,
    p.updated_at,
    pv.size,
    pv.price,
    pv.discount_price,
    pv.stock,
    pv.created_at AS variant_created_at,
    pv.updated_at AS variant_updated_at
FROM products p
LEFT JOIN categories c ON p.category_id = c.id
LEFT JOIN product_variants pv ON pv.product_id = p.id
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
                <?php
                $current_product_id = null;
                $product_variants = [];
$no=1;
                foreach ($products as $product) {
                    // Jika produk baru, tampilkan header produk
                    if ($current_product_id != $product['product_id']) {
                        if ($current_product_id !== null) {
                            // Tampilkan varian produk sebelumnya
                            echo render_product_row($product_variants);
                        }
                        // Reset untuk produk baru
                        $current_product_id = $product['product_id'];
                        $product_variants = [
                            [
                                'product_name' => $product['product_name'],
                                'category_name' => $product['category_name'],
                                'description' => $product['description'],
                                'note' => $product['note'],
                                'is_recommended' => $product['is_recommended'] ? 'Yes' : 'No',
                                'is_free_shipping' => $product['is_free_shipping'] ? 'Yes' : 'No',
                                'is_limited' => $product['is_limited'] ? 'Yes' : 'No',
                                'created_at' => $product['created_at'],
                                'updated_at' => $product['updated_at'],
                                'variants' => []
                            ]
                        ];
                    }
                    // Menambahkan varian produk
                    $product_variants[0]['variants'][] = [
                        'size' => $product['size'],
                        'price' => $product['price'],
                        'discount_price' => $product['discount_price'],
                        'stock' => $product['stock'],
                        'variant_created_at' => $product['variant_created_at'],
                        'variant_updated_at' => $product['variant_updated_at'],
                    ];
                }

                // Tampilkan produk terakhir
                if ($current_product_id !== null) {
                    echo render_product_row($product_variants);
                }

                function render_product_row($product_variants) {
                    $product = $product_variants[0];
                    $variant_rows = '';
                    foreach ($product['variants'] as $variant) {
                        $variant_rows .= "<tr>
                                            <td>{$product['product_name']}</td>
                                            <td>{$product['category_name']}</td>
                                            <td>{$variant['size']}</td>
                                            <td>€" . number_format($variant['price'], 2) . "</td>
                                            <td>€" . number_format($variant['discount_price'], 2) . "</td>
                                            <td>{$variant['stock']}</td>
                                            <td>{$product['is_free_shipping']}</td>
                                            <td>{$product['is_recommended']}</td>
                                            <td>{$product['is_limited']}</td>
                                            <td>{$variant['variant_created_at']}</td>
                                            <td>{$variant['variant_updated_at']}</td>
                                        </tr>";
                    }
                    return $variant_rows;
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
