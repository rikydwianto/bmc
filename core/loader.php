<?php 
session_start();

include_once(__DIR__."/koneksi/db.php");
include_once(__DIR__."/helpers/function.php");
$paymentMethods = [
    'bank' => [
        'label' => 'Bank Transfer - BCA',
        'account_name' => 'Carolina Helena Frederika',
        'account_number' => '-',
        'bank_name' => 'BCA'
    ],
    'ria' => [
        'label' => 'Ria - Kirim melalui agen Ria terdekat. Nama penerima: Carolina Helena Frederika.'
    ],
    'swift' => [
        'label' => 'Swift - Transfer internasional ke Bank Mandiri. SWIFT: BMRIIDJA.'
    ]
];
