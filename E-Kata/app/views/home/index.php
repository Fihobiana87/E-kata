<?php
require __DIR__ . '/../partials/header.php';
?>

<section class="hero">
  <div class="container">
    <div class="row g-4 align-items-center">
      <div class="col-lg-7">
        <div class="hero-card reveal">
          <div class="eyebrow mb-2">E-KATA • FUTURISTE • PREMIUM</div>
          <h1 class="display-5 fw-bold mb-3">
            <span class="typewriter" data-motion="force" data-words="Bienvenue sur E-Kata|Nouveautés chaque semaine|Promos exclusives|Collections Homme & Femme|Personnalise ton style">Bienvenue sur E-Kata</span>
          </h1>
          <p class="text-secondary fs-5 mb-4">
            Découvrez des pièces essentielles, des coupes modernes et des matières premium — inspirées par un style Nike-like, net et impactant.
          </p>
          <div class="d-flex flex-wrap gap-2">
            <a class="btn btn-neo" href="<?= e(base_url('index.php?c=products&a=news')) ?>">Explorer les nouveautés</a>
            <a class="btn btn-outline-dark btn-soft" href="<?= e(base_url('index.php?c=products&a=promos')) ?>">Voir les promos</a>
          </div>
        </div>
      </div>
      <div class="col-lg-5">
        <div class="orb reveal"></div>
      </div>
    </div>
  </div>
</section>

<section class="py-4">
  <div class="container">
    <div class="section-title">
      <div>
        <h2>Produits en vedette</h2>
        <div class="sub">Sélection premium E-Kata.</div>
      </div>
      <a class="link-neo" href="<?= e(base_url('index.php?c=products&a=men')) ?>">Voir tout →</a>
    </div>
    <div class="row g-3">
      <?php foreach (($featured ?? []) as $p): ?>
        <div class="col-12 col-md-6 col-lg-4">
          <?php require __DIR__ . '/../partials/product_card.php'; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="py-4">
  <div class="container">
    <div class="section-title">
      <div>
        <h2>Tendances & nouvelles collections</h2>
        <div class="sub">Une vibe moderne, une exécution propre.</div>
      </div>
      <a class="link-neo" href="<?= e(base_url('index.php?c=products&a=news')) ?>">Nouveautés →</a>
    </div>
    <div class="row g-3">
      <?php foreach (($news ?? []) as $p): ?>
        <div class="col-12 col-md-6 col-lg-4">
          <?php require __DIR__ . '/../partials/product_card.php'; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../partials/footer.php'; ?>

