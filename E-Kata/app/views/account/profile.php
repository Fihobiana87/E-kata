<?php
require __DIR__ . '/../partials/header.php';
?>

<div class="container py-4">
  <div class="section-title">
    <div>
      <h2>Profil</h2>
      <div class="sub">Votre compte E-Kata.</div>
    </div>
    <a class="link-neo" href="<?= e(base_url('index.php?c=account&a=orders')) ?>">Mes commandes →</a>
  </div>

  <div class="hero-card reveal">
    <div class="row g-3">
      <div class="col-md-6">
        <div class="text-secondary small">Nom</div>
        <div class="fw-semibold"><?= e((string)($dbUser['name'] ?? '')) ?></div>
      </div>
      <div class="col-md-6">
        <div class="text-secondary small">Email</div>
        <div class="fw-semibold"><?= e((string)($dbUser['email'] ?? '')) ?></div>
      </div>
      <div class="col-md-6">
        <div class="text-secondary small">Téléphone</div>
        <div class="fw-semibold"><?= e((string)($dbUser['phone'] ?? '—')) ?></div>
      </div>
      <div class="col-md-6">
        <div class="text-secondary small">Rôle</div>
        <div class="fw-semibold text-uppercase" style="letter-spacing:.14em;"><?= e((string)($dbUser['role'] ?? 'customer')) ?></div>
      </div>
      <div class="col-12">
        <div class="text-secondary small">Créé le</div>
        <div class="fw-semibold"><?= e((string)($dbUser['created_at'] ?? '')) ?></div>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>

