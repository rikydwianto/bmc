<?php
function getExchangeRates(): array {
    // $apiKey = '988007894c83431cb64ddca4ac077601';
    // $url = "https://api.currencyfreaks.com/v2.0/rates/latest?apikey=$apiKey&symbols=AUD,EUR,USD";

    // $response = file_get_contents($url);

    // if ($response === false) {
    //     throw new Exception("Gagal mengambil data dari API.");
    // }

    // $data = json_decode($response, true);

    // if (!isset($data['rates']['EUR'], $data['rates']['USD'], $data['rates']['AUD'])) {
    //     throw new Exception("Format data API tidak sesuai.");
    // }

    // // Karena harga di DB kamu dalam EUR, kita balik dari base USD
    // $usd_to_eur = (float) $data['rates']['EUR'];
    // $eur_to_usd = 1 / $usd_to_eur;

    // $usd_to_aud = (float) $data['rates']['AUD'];
    // $eur_to_aud = $eur_to_usd * $usd_to_aud;

    // return [
    //     'usd' => $eur_to_usd,
    //     'aud' => $eur_to_aud
    // ];
    return ['usd' => 1.09, 'aud' => 1.65];

}
function addOrderStatus($orderId, $status, $description) {
    global $pdo;
    $stmt = $pdo->prepare("INSERT INTO order_status (order_id, status, description) VALUES (?, ?, ?)");
    $stmt->execute([$orderId, $status, $description]);
}



function getStatusColor($status) {
    switch ($status) {
        case 'Order Placed':
            return 'primary'; // Blue
        case 'Payment Received':
            return 'success'; // Green
        case 'Shipped':
            return 'info'; // Light Blue
        case 'Delivered':
            return 'dark'; // Dark Gray
        case 'Canceled':
            return 'danger'; // Red
        default:
            return 'secondary'; // Gray
    }
}
?>
