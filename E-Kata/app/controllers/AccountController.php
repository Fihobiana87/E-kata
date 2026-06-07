<?php
declare(strict_types=1);

final class AccountController extends Controller
{
    public function profile(): void
    {
        require_login();
        $user = current_user();
        $dbUser = User::find((int)$user['id']);
        $title = 'Profil • E-Kata';
        $this->view('account/profile', compact('dbUser', 'title'));
    }

    public function orders(): void
    {
        require_login();
        $user = current_user();
        $orders = Order::byUser((int)$user['id']);
        $title = 'Mes commandes • E-Kata';
        $this->view('account/orders', compact('orders', 'title'));
    }

    public function order(): void
    {
        require_login();
        $user = current_user();
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) { throw new Exception('Commande introuvable.'); }

        // Vérifie que la commande appartient à l'utilisateur
        $stmt = Database::pdo()->prepare("SELECT * FROM orders WHERE id=:id AND user_id=:u");
        $stmt->execute([':id' => $id, ':u' => (int)$user['id']]);
        $order = $stmt->fetch();
        if (!$order) { throw new Exception('Commande introuvable.'); }
        $items = Order::items($id);

        $title = 'Commande ' . $order['order_number'] . ' • E-Kata';
        $this->view('account/order', compact('order', 'items', 'title'));
    }
}

