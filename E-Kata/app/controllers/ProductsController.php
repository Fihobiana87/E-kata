<?php
declare(strict_types=1);

final class ProductsController extends Controller
{
    public function men(): void
    {
        $this->listing('homme', 'Homme');
    }

    public function women(): void
    {
        $this->listing('femme', 'Femme');
    }

    public function news(): void
    {
        $category = (string)($_GET['category'] ?? '');
        $filters = ['is_new' => true];
        if ($category !== '') { $filters['category'] = $category; }
        $products = Product::list($filters);
        $title = 'Nouveautés • E-Kata';
        $pageTitle = 'Nouveautés';
        $this->view('products/list', compact('products', 'title', 'pageTitle', 'category'));
    }

    public function promos(): void
    {
        $category = (string)($_GET['category'] ?? '');
        $filters = ['promos' => true];
        if ($category !== '') { $filters['category'] = $category; }
        $products = Product::list($filters);
        $title = 'Promotions • E-Kata';
        $pageTitle = 'Promotions';
        $this->view('products/list', compact('products', 'title', 'pageTitle', 'category'));
    }

    public function search(): void
    {
        $q = trim((string)($_GET['q'] ?? ''));
        $category = (string)($_GET['category'] ?? '');
        $filters = ['q' => $q];
        if ($category !== '') { $filters['category'] = $category; }
        $products = $q === '' ? [] : Product::list($filters);
        $title = 'Recherche • E-Kata';
        $pageTitle = $q === '' ? 'Recherche' : 'Résultats pour “' . $q . '”';
        $this->view('products/list', compact('products', 'title', 'pageTitle', 'category', 'q'));
    }

    public function show(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $product = $id ? Product::find($id) : null;
        if (!$product) {
            throw new Exception('Produit introuvable.');
        }
        $title = $product['name'] . ' • E-Kata';
        $this->view('products/view', compact('product', 'title'));
    }

    private function listing(string $gender, string $label): void
    {
        $category = (string)($_GET['category'] ?? '');
        $filters = ['gender' => $gender];
        if ($category !== '') { $filters['category'] = $category; }
        $products = Product::list($filters);
        $title = $label . ' • E-Kata';
        $pageTitle = $label;
        $this->view('products/list', compact('products', 'title', 'pageTitle', 'category', 'gender'));
    }
}

