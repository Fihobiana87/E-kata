<?php
require __DIR__ . '/../partials/header.php';
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-6">
      <div class="hero-card reveal">
        <div class="eyebrow mb-2">CONNEXION</div>
        <h1 class="h3 fw-bold mb-3">Bienvenue sur E-Kata</h1>
        <form method="post" class="row g-3">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <div class="col-12">
            <label class="form-label text-secondary">Email</label>
            <input type="email" class="form-control" name="email" required placeholder="ex: nom@email.com" autocomplete="email">
          </div>
          <div class="col-12">
            <label class="form-label text-secondary">Mot de passe</label>
            <input type="password" class="form-control" name="password" required placeholder="••••••••" autocomplete="current-password">
          </div>
          <div class="col-12 d-flex justify-content-between align-items-center">
            <button class="btn btn-neo" type="submit">Se connecter</button>
            <a class="link-neo" href="<?= e(base_url('index.php?c=auth&a=register')) ?>">Créer un compte</a>
          </div>
          <div class="col-12">
            <div class="text-secondary small">
              Compte admin démo : <span class="text-body fw-semibold">admin@ekata.local</span> / <span class="text-body fw-semibold">Admin123!</span>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>

