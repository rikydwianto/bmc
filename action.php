<?php 
include_once("core/loader.php");
if(isset($_GET['menu'])){
    $menu=$_GET['menu'];
    if($menu=='simpancart'){
        include_once("proses/action/addtocart.php");
    }else if($menu=='data-cart'){
        include_once("proses/action/datacart.php");
    }else if ($_GET['menu'] == 'update-cart') {
        $itemId = $_GET['id'];
        $quantity = $_GET['quantity'];
    
        // Update jumlah dalam keranjang (sesuaikan dengan struktur database)
        $stmt = $pdo->prepare("UPDATE cart_items SET quantity = ? WHERE id = ?");
        $stmt->execute([$quantity, $itemId]);
    
        echo json_encode(['success' => true]);
    }
    
    else if ($_GET['menu'] == 'remove-item') {
        $itemId = $_GET['id'];
    
        // Hapus item dari keranjang
        $stmt = $pdo->prepare("DELETE FROM cart_items WHERE id = ?");
        $stmt->execute([$itemId]);
    
        echo json_encode(['success' => true]);
    }
    else if ($_GET['menu'] === 'checkout') {
        $name = $_POST['name'] ?? '';
        $address = $_POST['address'] ?? '';
        $phone = $_POST['phone'] ?? '';
        $payment = $_POST['payment_method'] ?? '';
        $country_code = $_POST['country_code'] ?? '';
$email = $_POST['email']??'';
        $phone = $country_code.' '. $phone;
        if (!$name || !$address || !$phone || !$payment) {
            echo json_encode(['success' => false, 'message' => 'Incomplete form']);
            exit;
        }
    
        $userId = $_SESSION['user_id'] ?? null;
        $sessionId = session_id();
    
        // Ambil data cart
        $stmt = $pdo->prepare("SELECT * FROM cart_items WHERE (user_id = ? OR session_id = ?) AND quantity > 0");
        $stmt->execute([$userId, $sessionId]);
        $cart = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        if (!$cart) {
            echo json_encode(['success' => false, 'message' => 'Cart is empty']);
            exit;
        }
    
        // Hitung total
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
    
        // Generate nomor transaksi unik
        $orderNumber = 'INV' . date('Ymd') . rand(1000, 9999);
    
        // Simpan ke tabel orders
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, session_id, order_number, total, name, phone, address, payment_method, created_at,email)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(),?)");
        $stmt->execute([
            $userId,
            $sessionId,
            $orderNumber,
            $total,
            $name,
            $phone,
            $address,
            $payment,
            $email
        ]);
        $orderId = $pdo->lastInsertId();
    
        // Simpan ke tabel order_items
        $stmtItem = $pdo->prepare("INSERT INTO order_items (order_id, product_id, variant_id, size, quantity, price) VALUES (?, ?, ?, ?, ?, ?)");
        foreach ($cart as $item) {
            $stmtItem->execute([
                $orderId,
                $item['product_id'],
                $item['variant_id'] ?? null,
                $item['size'],
                $item['quantity'],
                $item['price']
            ]);
        }
        addOrderStatus( $orderId, "Order Created", "Your order has been placed successfully.");

        // Hapus isi keranjang
        $pdo->prepare("DELETE FROM cart_items WHERE (user_id = ? OR session_id = ?)")->execute([$userId, $sessionId]);
    
        echo json_encode(['success' => true, 'order_id' => $orderId,'order_number'=>$orderNumber]);
        exit;
    }
    
    
    
}
?>