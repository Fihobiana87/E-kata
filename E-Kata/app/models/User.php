<?php
declare(strict_types=1);

final class User
{
    public static function findByEmail(string $email): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM users WHERE email=:email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT id,name,email,phone,role,created_at FROM users WHERE id=:id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(string $name, string $email, string $phone, string $password): int
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = Database::pdo()->prepare("INSERT INTO users (name,email,phone,password_hash,role) VALUES (:n,:e,:p,:h,'customer')");
        $stmt->execute([':n' => $name, ':e' => $email, ':p' => $phone ?: null, ':h' => $hash]);
        return (int)Database::pdo()->lastInsertId();
    }

    public static function verifyPassword(array $user, string $password): bool
    {
        $hash = (string)($user['password_hash'] ?? '');
        if ($hash === '') { return false; }

        // Support "bootstrapping" accounts from SQL demo data:
        // if password_hash is not a real hash, treat it as plain-text once, then upgrade.
        if ($hash[0] !== '$') {
            $ok = hash_equals($hash, $password);
            if ($ok && !empty($user['id'])) {
                self::upgradeHash((int)$user['id'], $password);
            }
            return $ok;
        }

        return password_verify($password, $hash);
    }

    private static function upgradeHash(int $userId, string $password): void
    {
        $newHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = Database::pdo()->prepare("UPDATE users SET password_hash=:h WHERE id=:id");
        $stmt->execute([':h' => $newHash, ':id' => $userId]);
    }
}

