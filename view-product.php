<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/product.php';

$product = new Product();
$products = $product->getAll();
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Producten</title>
</head>
<body>
    <h1>Producten</h1>

    <?php if (isset($_GET['deleted'])): ?>
        <p>Product verwijderd.</p>
    <?php endif; ?>

    <table>
        <tr>
            <th>Code</th>
            <th>Omschrijving</th>
            <th>Foto</th>
            <th>Prijs</th>
            <th>Acties</th>
        </tr>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['code']) ?></td>
                <td><?= htmlspecialchars($product['omschrijving']) ?></td>
                <td><?= htmlspecialchars($product['photo']) ?></td>
                <td>&euro; <?= $product['prijsPerStuk'] ?></td>
                <td>
                    <a href="product-edit.php?id=<?= (int) $product['id'] ?>">Aanpassen</a>
                    <a href="product-delete.php?id=<?= (int) $product['id'] ?>">Verwijderen</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
