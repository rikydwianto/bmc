<?php
// Cek apakah data produk dikirimkan via POST
if (isset($_POST['product_id'], $_POST['variants'])) {
    $productId = $_POST['product_id'];
    $variants = $_POST['variants'];
    // Ambil data produk berdasarkan ID
    $stmt = $pdo->prepare("SELECT id, name FROM products WHERE id = ?");
    $stmt->execute([$productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        // Cek apakah pengguna sudah login
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $sessionId = null; // Tidak perlu session_id jika pengguna login
        } else {
            // Jika pengguna belum login, gunakan session ID
            $userId = null;
            $sessionId = session_id(); // Menggunakan session ID untuk tamu
        }

        // Loop untuk setiap varian yang dipilih
        foreach ($variants as $variant_id => $variant_data) {
            $quantity = $variant_data['quantity'];
            $size = $variant_data['size'];

            // Ambil data varian berdasarkan variant_id dan size
            $stmt = $pdo->prepare("SELECT id, size, price, discount_price, stock FROM product_variants WHERE id = ? AND size = ?");
            $stmt->execute([$variant_id, $size]);
            $variant = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($variant && $quantity > 0) {
                // Menentukan harga yang akan digunakan (diskon atau harga biasa)
                $price = $variant['discount_price'] > 0 ? $variant['discount_price'] : $variant['price'];

               // Cek apakah item sudah ada di keranjang
$stmt = $pdo->prepare("SELECT id FROM cart_items WHERE (user_id = ? OR session_id = ?) 
AND product_id = ? AND variant_id = ? AND size = ?");
$stmt->execute([$userId, $sessionId, $productId, $variant_id, $size]);
$existingItem = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existingItem) {
// Jika item sudah ada, update quantity
$stmt = $pdo->prepare("UPDATE cart_items 
    SET quantity = ? 
    WHERE id = ?");
$stmt->execute([$quantity, $existingItem['id']]);
} else {
// Jika item belum ada, insert item baru ke keranjang
$stmt = $pdo->prepare("INSERT INTO cart_items (user_id, session_id, product_id, variant_id, size, quantity, price) 
    VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->execute([$userId, $sessionId, $productId, $variant_id, $size, $quantity, $price]);
}

            }
        }

        // Kirim respons sukses
        echo json_encode([
            'message' => 'The item(s) have been added to your cart.'
        ]);
    } else {
        // Produk tidak ditemukan
        echo json_encode([
            'message' => 'Product not found.'
        ]);
    }
} else {
    // Data tidak lengkap
    echo json_encode([
        'message' => 'Invalid data received.'
    ]);
}
?>