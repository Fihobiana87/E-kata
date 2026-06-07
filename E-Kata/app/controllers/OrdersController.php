<?php
declare(strict_types=1);

final class OrdersController extends Controller
{
    public function checkout(): void
    {
        require_login();
        $cart = $_SESSION['cart'] ?? [];
        if (!is_array($cart) || !$cart) {
            flash_set('warning', 'Votre panier est vide.');
            redirect(base_url('index.php?c=products&a=men'));
        }

        $items = $this->hydrate($cart);
        $title = 'Validation commande • E-Kata';
        $this->view('orders/checkout', compact('items', 'title'));
    }

    public function place(): void
    {
        require_login();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect(base_url('index.php?c=orders&a=checkout')); }
        if (!csrf_validate($_POST['csrf'] ?? null)) {
            flash_set('danger', 'Session expirée. Réessayez.');
            redirect(base_url('index.php?c=orders&a=checkout'));
        }

        $user = current_user();
        $cart = $_SESSION['cart'] ?? [];
        if (!is_array($cart) || !$cart) {
            flash_set('warning', 'Votre panier est vide.');
            redirect(base_url('index.php?c=products&a=men'));
        }

        $shipping = [
            'customer_name' => trim((string)($_POST['customer_name'] ?? '')),
            'address' => trim((string)($_POST['address'] ?? '')),
            'phone' => trim((string)($_POST['phone'] ?? '')),
            'payment_method' => (string)($_POST['payment_method'] ?? ''),
        ];

        if ($shipping['customer_name'] === '' || $shipping['address'] === '' || $shipping['phone'] === '') {
            flash_set('warning', 'Veuillez renseigner Nom, Adresse et Téléphone.');
            redirect(base_url('index.php?c=orders&a=checkout'));
        }

        $allowed = ['orange_money', 'airtel_money', 'mvola', 'cod'];
        if (!in_array($shipping['payment_method'], $allowed, true)) {
            flash_set('warning', 'Mode de paiement invalide.');
            redirect(base_url('index.php?c=orders&a=checkout'));
        }

        try {
            $orderId = Order::createFromCart((int)$user['id'], $cart, $shipping);
            unset($_SESSION['cart']);
            flash_set('success', 'Commande validée. Merci !');
            redirect(base_url('index.php?c=account&a=order&id=' . $orderId));
        } catch (Throwable $e) {
            flash_set('danger', $e->getMessage());
            redirect(base_url('index.php?c=orders&a=checkout'));
        }
    }

    private function hydrate(array $cart): array
    {
        $items = [];
        $total = 0;
        foreach ($cart as $id => $qty) {
            $p = Product::find((int)$id);
            if (!$p) { continue; }
            $unit = (int)($p['promo_price_cents'] ?: $p['price_cents']);
            $line = $unit * (int)$qty;
            $total += $line;
            $items[] = ['product' => $p, 'qty' => (int)$qty, 'unit' => $unit, 'line' => $line];
        }
        return ['rows' => $items, 'total' => $total];
    }
}

