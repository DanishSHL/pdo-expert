<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/product.php';

$id = (int) ($_GET['id'] ?? 0);

if ($id === 0) {
    exit('Geen product gekozen.');
}

$product = new Product();
$product->delete($id);

header('Location: view-product.php?deleted=1');
exit;
