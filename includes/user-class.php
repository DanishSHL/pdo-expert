<?php

declare(strict_types=1);

require_once __DIR__ . '/database.php';

class User
{
    private PDO $connection;

    public function __construct()
    {
        $this->connection = Database::getConnection();
        $this->startSession();
    }

    public function register(string $name, string $email, string $password): bool
    {
        $name = trim($name);
        $email = strtolower(trim($email));

        if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) < 8) {
            return false;
        }

        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $query = 'INSERT INTO users (name, email, password) VALUES (:name, :email, :password)';
        $statement = $this->connection->prepare($query);

        try {
            return $statement->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $passwordHash,
            ]);
        } catch (PDOException $exception) {
            if ($exception->errorInfo[0] === '23000') {
                return false;
            }

            throw $exception;
        }
    }

    public function login(string $email, string $password): bool
    {
        $email = strtolower(trim($email));
        $statement = $this->connection->prepare(
            'SELECT id, name, email, password FROM users WHERE email = :email LIMIT 1'
        );
        $statement->execute([':email' => $email]);
        $user = $statement->fetch();

        if ($user === false || !password_verify($password, $user['password'])) {
            return false;
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_email'] = $user['email'];

        if (password_needs_rehash($user['password'], PASSWORD_DEFAULT)) {
            $this->updatePasswordHash((int) $user['id'], $password);
        }

        return true;
    }

    public function isLoggedIn(): bool
    {
        return isset($_SESSION['user_id']);
    }

    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], (bool) $params['secure'], (bool) $params['httponly']);
        }

        session_destroy();
    }

    private function startSession(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_set_cookie_params([
                'lifetime' => 31536000,
                'path' => '/',
                'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            session_start();
        }
    }

    private function updatePasswordHash(int $userId, string $password): void
    {
        $statement = $this->connection->prepare(
            'UPDATE users SET password = :password WHERE id = :id'
        );
        $statement->execute([
            ':password' => password_hash($password, PASSWORD_DEFAULT),
            ':id' => $userId,
        ]);
    }
}
