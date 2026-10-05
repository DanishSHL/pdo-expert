<?php

declare(strict_types=1);
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product toevoegen</title>
</head>
<body>
    <h1>Product toevoegen</h1>

    <form action="product-insert.php" method="post">
        <p>
            <label for="code">Code</label>
            <input type="text" id="code" name="code" required maxlength="50">
        </p>
        <p>
            <label for="omschrijving">Omschrijving</label>
            <input type="text" id="omschrijving" name="omschrijving" required maxlength="255">
        </p>
        <p>
            <label for="photo">Foto</label>
            <input type="text" id="photo" name="photo" required maxlength="255">
        </p>
        <p>
            <label for="prijsPerStuk">Prijs per stuk</label>
            <input type="number" id="prijsPerStuk" name="prijsPerStuk" required min="0" step="0.01">
        </p>
        <button type="submit">Product toevoegen</button>
    </form>
</body>
</html>