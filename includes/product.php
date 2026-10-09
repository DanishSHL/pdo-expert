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

    public function getById(int $id): ?array
    {
        $statement = $this->connection->prepare('SELECT * FROM products WHERE id = :id');
        $statement->execute([':id' => $id]);

        return $statement->fetch() ?: null;
    }

    public function update(
        int $id,
        string $code,
        string $omschrijving,
        string $photo,
        string $prijsPerStuk
    ): bool {
        $statement = $this->connection->prepare(
            'UPDATE products SET code = :code, omschrijving = :omschrijving,
             photo = :photo, prijsPerStuk = :prijsPerStuk WHERE id = :id'
        );

        return $statement->execute([
            ':id' => $id,
            ':code' => $code,
            ':omschrijving' => $omschrijving,
            ':photo' => $photo,
            ':prijsPerStuk' => $prijsPerStuk,
        ]);
    }

    public function delete(int $id): bool
    {
        $statement = $this->connection->prepare(
            'DELETE FROM products WHERE id = :id'
        );

        return $statement->execute([':id' => $id]);
    }
}