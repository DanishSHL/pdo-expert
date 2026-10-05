<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/product.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: insert-product.php');
    exit;
}

$code = trim((string) ($_POST['code'] ?? ''));
$omschrijving = trim((string) ($_POST['omschrijving'] ?? ''));
$photo = trim((string) ($_POST['photo'] ?? ''));
$prijsPerStuk = trim((string) ($_POST['prijsPerStuk'] ?? ''));

if (
    $code === '' ||
    $omschrijving === '' ||
    $photo === '' ||
    !is_numeric($prijsPerStuk) ||
    (float) $prijsPerStuk < 0
) {
    http_response_code(422);
    exit('Vul alle velden geldig in.');
}

$product = new Product();

try {
    $product->insert($code, $omschrijving, $photo, number_format((float) $prijsPerStuk, 2, '.', ''));
} catch (PDOException $exception) {
    if ($exception->errorInfo[0] === '23000') {
        http_response_code(409);
        exit('De productcode bestaat al.');
    }

    throw $exception;
}

header('Location: insert-product.php?success=1');
exit;