<?php 
session_start();

include_once(__DIR__."/koneksi/db.php");
include_once(__DIR__."/helpers/function.php");
$paymentMethods = [
    'bank' => [
        'label' => 'Bank Transfer - BCA',
        'account_name' => 'Riky Pratama',
        'account_number' => '1234567890',
        'bank_name' => 'BCA'
    ],
    'ria' => [
        'label' => 'Ria - Kirim melalui agen Ria terdekat. Nama penerima: Riky Pratama.'
    ],
    'swift' => [
        'label' => 'Swift - Transfer internasional ke Bank Mandiri. SWIFT: BMRIIDJA.'
    ]
];
