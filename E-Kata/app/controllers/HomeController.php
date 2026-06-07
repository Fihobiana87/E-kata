<?php
declare(strict_types=1);

final class HomeController extends Controller
{
    public function index(): void
    {
        $featured = Product::featured(6);
        $news = Product::list(['is_new' => true], 6);
        $title = 'E-Kata • Futuriste. Premium. Minimal.';
        $this->view('home/index', compact('featured', 'news', 'title'));
    }
}

