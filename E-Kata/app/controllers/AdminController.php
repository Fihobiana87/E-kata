<?php
declare(strict_types=1);

final class AdminController extends Controller
{
    public function dashboard(): void
    {
        require_admin();
        $products = Product::adminAll(12);
        $orders = Order::all(12);
        $title = 'Admin • Dashboard • E-Kata';
        $this->view('admin/dashboard', compact('products', 'orders', 'title'));
    }

    public function products(): void
    {
        require_admin();
        $products = Product::adminAll();
        $title = 'Admin • Produits • E-Kata';
        $this->view('admin/products', compact('products', 'title'));
    }

    public function product_new(): void
    {
        require_admin();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!csrf_validate($_POST['csrf'] ?? null)) {
                flash_set('danger', 'Session expirée.');
                redirect(base_url('index.php?c=admin&a=products'));
            }
            $data = $this->productPayload($_POST);
            Product::create($data);
            flash_set('success', 'Produit ajouté.');
            redirect(base_url('index.php?c=admin&a=products'));
        }
        $title = 'Admin • Ajouter produit • E-Kata';
        $product = null;
        $this->view('admin/product_form', compact('product', 'title'));
    }

    public function product_edit(): void
    {
        require_admin();
        $id = (int)($_GET['id'] ?? 0);
        $product = $id ? Product::adminFind($id) : null;
        if (!$product) { throw new Exception('Produit introuvable.'); }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!csrf_validate($_POST['csrf'] ?? null)) {
                flash_set('danger', 'Session expirée.');
                redirect(base_url('index.php?c=admin&a=products'));
            }
            $data = $this->productPayload($_POST);
            Product::update($id, $data);
            flash_set('success', 'Produit mis à jour.');
            redirect(base_url('index.php?c=admin&a=products'));
        }

        $title = 'Admin • Modifier produit • E-Kata';
        $this->view('admin/product_form', compact('product', 'title'));
    }

    public function product_delete(): void
    {
        require_admin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect(base_url('index.php?c=admin&a=products')); }
        if (!csrf_validate($_POST['csrf'] ?? null)) {
            flash_set('danger', 'Session expirée.');
            redirect(base_url('index.php?c=admin&a=products'));
        }
        $id = (int)($_POST['id'] ?? 0);
        if ($id > 0) {
            Product::delete($id);
            flash_set('success', 'Produit supprimé.');
        }
        redirect(base_url('index.php?c=admin&a=products'));
    }

    public function orders(): void
    {
        require_admin();
        $orders = Order::all();
        $title = 'Admin • Commandes • E-Kata';
        $this->view('admin/orders', compact('orders', 'title'));
    }

    public function order_view(): void
    {
        require_admin();
        $id = (int)($_GET['id'] ?? 0);
        if ($id <= 0) { throw new Exception('Commande introuvable.'); }

        $stmt = Database::pdo()->prepare("SELECT o.*, u.email FROM orders o JOIN users u ON u.id=o.user_id WHERE o.id=:id");
        $stmt->execute([':id' => $id]);
        $order = $stmt->fetch();
        if (!$order) { throw new Exception('Commande introuvable.'); }
        $items = Order::items($id);

        $title = 'Admin • Commande ' . $order['order_number'] . ' • E-Kata';
        $this->view('admin/order', compact('order', 'items', 'title'));
    }

    public function order_status(): void
    {
        require_admin();
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { redirect(base_url('index.php?c=admin&a=orders')); }
        if (!csrf_validate($_POST['csrf'] ?? null)) {
            flash_set('danger', 'Session expirée.');
            redirect(base_url('index.php?c=admin&a=orders'));
        }
        $id = (int)($_POST['id'] ?? 0);
        $status = (string)($_POST['status'] ?? '');
        $allowed = ['pending','paid','validated','shipped','cancelled'];
        if ($id > 0 && in_array($status, $allowed, true)) {
            Order::setStatus($id, $status);
            flash_set('success', 'Statut mis à jour.');
        }
        redirect(base_url('index.php?c=admin&a=orders'));
    }

    private function productPayload(array $src): array
    {
        $name = trim((string)($src['name'] ?? ''));
        $slug = trim((string)($src['slug'] ?? ''));
        $gender = (string)($src['gender'] ?? 'unisex');
        $category = trim((string)($src['category'] ?? ''));

        if ($name === '' || $slug === '' || $category === '') {
            throw new Exception('Champs requis manquants.');
        }
        $allowedGender = ['homme','femme','unisex'];
        if (!in_array($gender, $allowedGender, true)) { $gender = 'unisex'; }

        $price = (int)round(((float)($src['price'] ?? 0)) * 100);
        $promo = trim((string)($src['promo_price'] ?? ''));
        $promoCents = $promo === '' ? '' : (string)((int)round(((float)$promo) * 100));

        return [
            'name' => $name,
            'slug' => $slug,
            'gender' => $gender,
            'category' => strtolower($category),
            'description' => trim((string)($src['description'] ?? '')),
            'price_cents' => max(0, $price),
            'promo_price_cents' => $promoCents,
            'stock' => (int)($src['stock'] ?? 0),
            'is_new' => !empty($src['is_new']),
            'is_featured' => !empty($src['is_featured']),
            'image' => trim((string)($src['image'] ?? '')),
            'is_active' => !empty($src['is_active']),
        ];
    }
}

