<?php
$userId = $_SESSION['user_id'] ?? null;
$sessionId = session_id(); // Menggunakan session ID untuk tamu

// Ambil data keranjang berdasarkan user_id atau session_id
$stmt = $pdo->prepare("
    SELECT c.id, p.name, c.variant_id, c.size,sum( c.quantity) as quantity, sum(c.price) as price, sum(c.price) *  sum( c.quantity) as total_price,
           pi.image AS image
    FROM cart_items c
    JOIN products p ON c.product_id = p.id
    LEFT JOIN product_images pi ON p.id = pi.product_id AND pi.is_primary = 1
    WHERE (c.user_id = ? OR c.session_id = ?) AND c.quantity > 0 group by c.variant_id
");
$stmt->execute([$userId, $sessionId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Mengirimkan data dalam format JSON
echo json_encode($cartItems);
?>
