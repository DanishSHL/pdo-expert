# PDO User Authentication

## Instellen

1. Voer `schema.sql` uit in MySQL.
2. Stel eventueel deze omgevingsvariabelen in:
   - `DB_HOST`
   - `DB_NAME`
   - `DB_USER`
   - `DB_PASSWORD`
3. Gebruik de class in een PHP-pagina:

```php
require_once __DIR__ . '/includes/user-class.php';

$user = new User();

if ($user->register('Voorbeeld', 'voorbeeld@example.com', 'een-sterk-wachtwoord')) {
    echo 'Account aangemaakt';
}

if ($user->login('voorbeeld@example.com', 'een-sterk-wachtwoord')) {
    echo 'Ingelogd';
}

if ($user->isLoggedIn()) {
    echo 'De gebruiker is ingelogd';
}

// Uitloggen:
// $user->logout();
```

Registratie gebruikt `password_hash()` en login controleert met `password_verify()`. De sessiecookie blijft een jaar geldig en wordt bij `logout()` verwijderd.
