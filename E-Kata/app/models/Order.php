<?php
declare(strict_types=1);

final class Order
{
    public static function byUser(int $userId, int $limit = 50): array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM orders WHERE user_id=:u ORDER BY created_at DESC LIMIT :lim");
        $stmt->bindValue(':u', $userId, PDO::PARAM_INT);
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function items(int $orderId): array
    {
        $stmt = Database::pdo()->prepare("SELECT * FROM order_items WHERE order_id=:o ORDER BY id ASC");
        $stmt->execute([':o' => $orderId]);
        return $stmt->fetchAll();
    }

    public static function all(int $limit = 200): array
    {
        $stmt = Database::pdo()->prepare("SELECT o.*, u.email FROM orders o JOIN users u ON u.id=o.user_id ORDER BY o.created_at DESC LIMIT :lim");
        $stmt->bindValue(':lim', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public static function setStatus(int $orderId, string $status): void
    {
        $stmt = Database::pdo()->prepare("UPDATE orders SET status=:s WHERE id=:id");
        $stmt->execute([':s' => $status, ':id' => $orderId]);
    }

    public static function createFromCart(int $userId, array $cart, array $shipping): int
    {
        if (!$cart) { throw new Exception('Panier vide.'); }

        $pdo = Database::pdo();
        $pdo->beginTransaction();
        try {
            $products = self::loadCartProducts($cart);
            if (!$products) { throw new Exception('Produits introuvables.'); }

            $total = 0;
            foreach ($products as $p) {
                $qty = (int)($cart[(string)$p['id']] ?? 0);
                if ($qty < 1) { continue; }
                if ((int)$p['stock'] < $qty) {
                    throw new Exception('Stock insuffisant pour ' . $p['name'] . '.');
                }
                $unit = (int)($p['promo_price_cents'] ?: $p['price_cents']);
                $total += $unit * $qty;
            }
            if ($total <= 0) { throw new Exception('Total invalide.'); }

            $orderNumber = self::makeOrderNumber();
            $stmt = $pdo->prepare("INSERT INTO orders
                (user_id, order_number, customer_name, address, phone, payment_method, status, total_cents)
                VALUES (:u,:n,:cn,:ad,:ph,:pm,'pending',:t)");
            $stmt->execute([
                ':u' => $userId,
                ':n' => $orderNumber,
                ':cn' => $shipping['customer_name'],
                ':ad' => $shipping['address'],
                ':ph' => $shipping['phone'],
                ':pm' => $shipping['payment_method'],
                ':t' => $total,
            ]);
            $orderId = (int)$pdo->lastInsertId();

            $itemStmt = $pdo->prepare("INSERT INTO order_items
              (order_id, product_id, product_name, unit_price_cents, quantity, line_total_cents)
              VALUES (:o,:p,:pn,:up,:q,:lt)");
            $stockStmt = $pdo->prepare("UPDATE products SET stock = stock - :q WHERE id=:p");

            foreach ($products as $p) {
                $qty = (int)($cart[(string)$p['id']] ?? 0);
                if ($qty < 1) { continue; }
                $unit = (int)($p['promo_price_cents'] ?: $p['price_cents']);
                $line = $unit * $qty;

                $itemStmt->execute([
                    ':o' => $orderId,
                    ':p' => (int)$p['id'],
                    ':pn' => $p['name'],
                    ':up' => $unit,
                    ':q' => $qty,
                    ':lt' => $line,
                ]);
                $stockStmt->execute([':q' => $qty, ':p' => (int)$p['id']]);
            }

            $pdo->commit();
            return $orderId;
        } catch (Throwable $e) {
            $pdo->rollBack();
            throw $e;
        }
    }

    private static function loadCartProducts(array $cart): array
    {
        $ids = array_map('intval', array_keys($cart));
        $ids = array_values(array_filter($ids, fn($v) => $v > 0));
        if (!$ids) { return []; }

        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $sql = "SELECT * FROM products WHERE id IN ($placeholders) AND is_active=1";
        $stmt = Database::pdo()->prepare($sql);
        $stmt->execute($ids);
        return $stmt->fetchAll();
    }

    private static function makeOrderNumber(): string
    {
        return 'EK' . date('ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));
    }
}

