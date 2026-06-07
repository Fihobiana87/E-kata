<?php
declare(strict_types=1);

final class Product
{
    public static function featured(int $limit = 6): array
    {
        $sql = "SELECT * FROM products WHERE is_active=1 AND is_featured=1 ORDER BY created_at DESC LIMIT :lim";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function find(int $id): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM products WHERE id=:id AND is_active=1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function list(array $filters = [], int $limit = 48): array
    {
        $where = ["is_active=1"];
        $params = [];

        if (!empty($filters['gender'])) {
            $where[] = "gender = :gender";
            $params[':gender'] = $filters['gender'];
        }
        if (!empty($filters['category'])) {
            $where[] = "category = :category";
            $params[':category'] = $filters['category'];
        }
        if (!empty($filters['is_new'])) {
            $where[] = "is_new = 1";
        }
        if (!empty($filters['promos'])) {
            $where[] = "promo_price_cents IS NOT NULL AND promo_price_cents > 0";
        }
        if (!empty($filters['q'])) {
            $where[] = "(name LIKE :q OR category LIKE :q OR description LIKE :q)";
            $params[':q'] = '%' . $filters['q'] . '%';
        }

        $sql = "SELECT * FROM products WHERE " . implode(' AND ', $where) . " ORDER BY created_at DESC LIMIT :lim";
        $stmt = Database::pdo()->prepare($sql);
        foreach ($params as $k => $v) { $stmt->bindValue($k, $v, PDO::PARAM_STR); }
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    // --- Admin ---
    public static function adminAll(int $limit = 200): array
    {
        $sql = "SELECT * FROM products ORDER BY created_at DESC LIMIT :lim";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function adminFind(int $id): ?array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM products WHERE id=:id");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    public static function create(array $data): int
    {
        $sql = "INSERT INTO products
            (name, slug, gender, category, description, price_cents, promo_price_cents, stock, is_new, is_featured, image, is_active)
            VALUES
            (:name, :slug, :gender, :category, :description, :price_cents, :promo_price_cents, :stock, :is_new, :is_featured, :image, :is_active)";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute([
            ':name' => $data['name'],
            ':slug' => $data['slug'],
            ':gender' => $data['gender'],
            ':category' => $data['category'],
            ':description' => $data['description'] ?? null,
            ':price_cents' => (int)$data['price_cents'],
            ':promo_price_cents' => $data['promo_price_cents'] !== '' ? (int)$data['promo_price_cents'] : null,
            ':stock' => (int)$data['stock'],
            ':is_new' => !empty($data['is_new']) ? 1 : 0,
            ':is_featured' => !empty($data['is_featured']) ? 1 : 0,
            ':image' => $data['image'] ?? null,
            ':is_active' => !empty($data['is_active']) ? 1 : 0,
        ]);
        return (int)Database::pdo()->lastInsertId();
    }

    public static function update(int $id, array $data): void
    {
        $sql = "UPDATE products SET
            name=:name, slug=:slug, gender=:gender, category=:category, description=:description,
            price_cents=:price_cents, promo_price_cents=:promo_price_cents, stock=:stock,
            is_new=:is_new, is_featured=:is_featured, image=:image, is_active=:is_active
            WHERE id=:id";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':name' => $data['name'],
            ':slug' => $data['slug'],
            ':gender' => $data['gender'],
            ':category' => $data['category'],
            ':description' => $data['description'] ?? null,
            ':price_cents' => (int)$data['price_cents'],
            ':promo_price_cents' => $data['promo_price_cents'] !== '' ? (int)$data['promo_price_cents'] : null,
            ':stock' => (int)$data['stock'],
            ':is_new' => !empty($data['is_new']) ? 1 : 0,
            ':is_featured' => !empty($data['is_featured']) ? 1 : 0,
            ':image' => $data['image'] ?? null,
            ':is_active' => !empty($data['is_active']) ? 1 : 0,
        ]);
    }

    public static function delete(int $id): void
    {
        $stmt = Database::pdo()->prepare("DELETE FROM products WHERE id=:id");
        $stmt->execute([':id' => $id]);
    }
}

