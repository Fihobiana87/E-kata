<?php
/** @var string $title */
$title = $title ?? 'E-Kata';
$user = current_user();
$flash = flash_get();
$cssVer = (int)@filemtime(__DIR__ . '/../../../public/assets/css/app.css');
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= e($title) ?></title>
  <link href="<?= e(base_url('assets/css/bootstrap.min.css')) ?>" rel="stylesheet">
  <link href="<?= e(base_url('assets/css/app.css?v=' . $cssVer)) ?>" rel="stylesheet">
</head>
<body class="bg-neo text-body">
<div class="noise"></div>

<nav class="navbar navbar-expand-lg navbar-light nav-glass sticky-top">
  <div class="container py-2">
    <a class="navbar-brand brand" href="<?= e(base_url('index.php')) ?>">
      <img class="brand-logo" src="<?= e(base_url('assets/img/logo-ekata.png')) ?>" alt="E-Kata" loading="eager" decoding="async">
    </a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navMain" aria-controls="navMain" aria-expanded="false" aria-label="Menu">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMain">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0 gap-lg-1">
        <li class="nav-item"><a class="nav-link" href="<?= e(base_url('index.php?c=products&a=men')) ?>">Homme</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= e(base_url('index.php?c=products&a=women')) ?>">Femme</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= e(base_url('index.php?c=products&a=news')) ?>">Nouveautés</a></li>
        <li class="nav-item"><a class="nav-link" href="<?= e(base_url('index.php?c=products&a=promos')) ?>">Promotions</a></li>
      </ul>

      <form class="d-flex me-lg-3 my-2 my-lg-0" role="search" method="get" action="<?= e(base_url('index.php')) ?>">
        <input type="hidden" name="c" value="products">
        <input type="hidden" name="a" value="search">
        <div class="search-wrap">
          <input class="form-control search" name="q" type="search" placeholder="Rechercher (ex: t-shirt)" aria-label="Recherche" value="<?= e((string)($_GET['q'] ?? '')) ?>">
          <button class="btn btn-neo" type="submit">Go</button>
        </div>
      </form>

      <div class="d-flex align-items-center gap-2">
        <a class="btn btn-outline-dark btn-sm btn-soft" href="<?= e(base_url('index.php?c=cart&a=index')) ?>">
          Panier <span class="badge text-bg-light ms-1"><?= (int)cart_count() ?></span>
        </a>

        <div class="dropdown">
          <button class="btn btn-light btn-sm btn-soft dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
            <?= $user ? e(($user['name'] ?? 'Mon compte')) : 'Mon compte' ?>
          </button>
          <ul class="dropdown-menu dropdown-menu-end dropdown-neo">
            <?php if (!$user): ?>
              <li><a class="dropdown-item" href="<?= e(base_url('index.php?c=auth&a=login')) ?>">Login</a></li>
              <li><a class="dropdown-item" href="<?= e(base_url('index.php?c=auth&a=register')) ?>">Inscription</a></li>
            <?php else: ?>
              <li><a class="dropdown-item" href="<?= e(base_url('index.php?c=account&a=profile')) ?>">Profil</a></li>
              <li><a class="dropdown-item" href="<?= e(base_url('index.php?c=account&a=orders')) ?>">Mes commandes</a></li>
              <?php if (is_admin()): ?>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="<?= e(base_url('index.php?c=admin&a=dashboard')) ?>">Admin</a></li>
              <?php endif; ?>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="<?= e(base_url('index.php?c=auth&a=logout')) ?>">Déconnexion</a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>

<main class="content">
  <div class="container pt-4">
    <?php if ($flash): ?>
      <div class="alert alert-<?= e($flash['type']) ?> neo-alert reveal" role="alert">
        <?= e((string)$flash['message']) ?>
      </div>
    <?php endif; ?>
  </div>

