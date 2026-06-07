<?php
$title = '404 - E-Kata';
require __DIR__ . '/../partials/header.php';
?>

<div class="container py-5">
  <div class="row align-items-center g-4">
    <div class="col-lg-7">
      <div class="hero-card reveal">
        <div class="eyebrow">ERREUR 404</div>
        <h1 class="display-5 fw-bold mb-3">Cette page n’existe pas.</h1>
        <p class="text-secondary mb-4"><?= e((string)($message ?? 'Page introuvable.')) ?></p>
        <a class="btn btn-neo" href="<?= e(base_url('index.php')) ?>">Retour à l’accueil</a>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="orb reveal"></div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>

