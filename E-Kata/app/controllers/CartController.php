<?php
declare(strict_types=1);

final class CartController extends Controller
{
    public function index(): void
    {
        $cart = $_SESSION['cart'] ?? [];
        if (!is_array($cart)) { $cart = []; }
        $items = $this->hydrate($cart);
        $title = 'Panier • E-Kata';
        $this->view('cart/index', compact('items', 'cart', 'title'));
    }

    public function add(): void
    {
        require_login();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect(base_url('index.php?c=cart&a=index')); }
        if (!csrf_validate($_POST['csrf'] ?? null)) {
            flash_set('danger', 'Session expirée. Réessayez.');
            redirect(base_url('index.php'));
        }

        $id = (int)($_POST['id'] ?? 0);
        $qty = (int)($_POST['qty'] ?? 1);
        $qty = max(1, min(99, $qty));

        $p = $id ? Product::find($id) : null;
        if (!$p) {
            flash_set('danger', 'Produit introuvable.');
            redirect(base_url('index.php'));
        }
        if ((int)$p['stock'] <= 0) {
            flash_set('warning', 'Stock épuisé pour ce produit.');
            redirect(base_url('index.php?c=products&a=show&id=' . $id));
        }

        $_SESSION['cart'] = $_SESSION['cart'] ?? [];
        if (!is_array($_SESSION['cart'])) { $_SESSION['cart'] = []; }
        $key = (string)$id;
        $_SESSION['cart'][$key] = min(99, ((int)($_SESSION['cart'][$key] ?? 0)) + $qty);

        flash_set('success', 'Ajouté au panier.');
        redirect(base_url('index.php?c=cart&a=index'));
    }

    public function update(): void
    {
        require_login();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect(base_url('index.php?c=cart&a=index')); }
        if (!csrf_validate($_POST['csrf'] ?? null)) {
            flash_set('danger', 'Session expirée. Réessayez.');
            redirect(base_url('index.php?c=cart&a=index'));
        }

        $cart = $_SESSION['cart'] ?? [];
        if (!is_array($cart)) { $cart = []; }

        foreach (($_POST['qty'] ?? []) as $id => $qty) {
            $pid = (int)$id;
            $q = max(0, min(99, (int)$qty));
            if ($q === 0) { unset($cart[(string)$pid]); }
            else { $cart[(string)$pid] = $q; }
        }
        $_SESSION['cart'] = $cart;
        flash_set('success', 'Panier mis à jour.');
        redirect(base_url('index.php?c=cart&a=index'));
    }

    public function clear(): void
    {
        require_login();
        unset($_SESSION['cart']);
        flash_set('success', 'Panier vidé.');
        redirect(base_url('index.php?c=cart&a=index'));
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

