<?php

declare(strict_types=1);

require_once __DIR__ . '/includes/product.php';

$id = (int) ($_GET['id'] ?? 0);
$product = new Product();
$productData = $product->getById($id);

if ($productData === null) {
    exit('Product niet gevonden.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product->update(
        $id,
        (string) $_POST['code'],
        (string) $_POST['omschrijving'],
        (string) $_POST['photo'],
        (string) $_POST['prijsPerStuk']
    );
    $productData = $product->getById($id);
    $message = 'Product aangepast.';
}
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product aanpassen</title>
</head>
<body>
    <h1>Product aanpassen</h1>

    <?php if (isset($message)): ?>
        <p><?= $message ?></p>
    <?php endif; ?>

    <form method="post">
        <p>
            <label for="code">Code</label>
            <input type="text" id="code" name="code" required maxlength="50"
                   value="<?= htmlspecialchars($productData['code']) ?>">
        </p>
        <p>
            <label for="omschrijving">Omschrijving</label>
            <input type="text" id="omschrijving" name="omschrijving" required maxlength="255"
                   value="<?= htmlspecialchars($productData['omschrijving']) ?>">
        </p>
        <p>
            <label for="photo">Foto</label>
            <input type="text" id="photo" name="photo" required maxlength="255"
                   value="<?= htmlspecialchars($productData['photo']) ?>">
        </p>
        <p>
            <label for="prijsPerStuk">Prijs per stuk</label>
            <input type="number" id="prijsPerStuk" name="prijsPerStuk" required min="0" step="0.01"
                   value="<?= htmlspecialchars((string) $productData['prijsPerStuk']) ?>">
        </p>
        <button type="submit">Product aanpassen</button>
    </form>
</body>
</html>
