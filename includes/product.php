<?php

declare(strict_types=1);

require_once __DIR__ . '/database.php';

class Product
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
    }

    public function insert(
        string $code,
        string $omschrijving,
        string $photo,
        string $prijsPerStuk
    ): bool {
        $statement = $this->connection->prepare(
            'INSERT INTO products (code, omschrijving, photo, prijsPerStuk)
             VALUES (:code, :omschrijving, :photo, :prijsPerStuk)'
        );

        return $statement->execute([
            ':code' => trim($code),
            ':omschrijving' => trim($omschrijving),
            ':photo' => trim($photo),
            ':prijsPerStuk' => $prijsPerStuk,
        ]);
    }

    public function getAll(): array
    {
        return $this->connection
            ->query('SELECT * FROM products')
            ->fetchAll();
    }
}