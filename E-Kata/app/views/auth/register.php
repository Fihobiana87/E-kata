<?php
require __DIR__ . '/../partials/header.php';
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-7">
      <div class="hero-card reveal">
        <div class="eyebrow mb-2">INSCRIPTION</div>
        <h1 class="h3 fw-bold mb-3">Créer votre compte</h1>
        <form method="post" class="row g-3">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <div class="col-12 col-md-6">
            <label class="form-label text-secondary">Nom</label>
            <input type="text" class="form-control" name="name" required placeholder="Votre nom" autocomplete="name">
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label text-secondary">Téléphone</label>
            <input type="text" class="form-control" name="phone" placeholder="034..." autocomplete="tel">
          </div>
          <div class="col-12">
            <label class="form-label text-secondary">Email</label>
            <input type="email" class="form-control" name="email" required placeholder="nom@email.com" autocomplete="email">
          </div>
          <div class="col-12">
            <label class="form-label text-secondary">Mot de passe</label>
            <input type="password" class="form-control" name="password" required placeholder="8 caractères minimum" autocomplete="new-password">
          </div>
          <div class="col-12 d-flex justify-content-between align-items-center">
            <button class="btn btn-neo" type="submit">S’inscrire</button>
            <a class="link-neo" href="<?= e(base_url('index.php?c=auth&a=login')) ?>">Déjà un compte ? Login</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>

