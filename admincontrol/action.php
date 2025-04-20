<?php 
include_once("../core/loader.php");
if(isset($_GET['menu'])){
    $menu=$_GET['menu'];
    if($menu=='update-payment'){
        $id = $_POST['id'] ?? null;
        $status = $_POST['status'] ?? null;
    
        if ($id && in_array($status, ['approved', 'rejected'])) {
            if ($status === 'approved') {
                $stmt = $pdo->prepare("UPDATE orders SET paid_status = ?, is_paid = 1 WHERE id = ?");
                addOrderStatus($orderId, 'Payment Received', 'Payment has been Approved. We will process your order soon.');

            } else {
                $stmt = $pdo->prepare("UPDATE orders SET paid_status = ?, is_paid = 0 WHERE id = ?");
            }
            $stmt->execute([$status, $id]);
        
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid data']);
        }
            }
            else if($menu == 'order-detail') {
                $id = intval($_GET['id']);
            
                // Ambil data order utama
                $stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
                $stmt->execute([$id]);
                $order = $stmt->fetch();
            
                if ($order) {
                    // Ambil data item produk yang dibeli
                    $stmtItems = $pdo->prepare("
                        SELECT 
                            oi.quantity,
                            oi.price,
                            oi.size,
                            p.name AS product_name
                        FROM order_items oi
                        JOIN product_variants pv ON oi.variant_id = pv.id
                        JOIN products p ON pv.product_id = p.id
                        WHERE oi.order_id = ?
                    ");
                    $stmtItems->execute([$id]);
                    $items = $stmtItems->fetchAll();
            
                    echo json_encode([
                        'success' => true,
                        'data' => $order,
                        'items' => $items
                    ]);
                } else {
                    echo json_encode([
                        'success' => false,
                        'message' => 'Order not found'
                    ]);
                }
            }
            
}