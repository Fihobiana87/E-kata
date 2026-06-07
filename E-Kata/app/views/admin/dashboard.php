<?php
require __DIR__ . '/../partials/header.php';
?>

<div class="container py-4">
  <div class="section-title">
    <div>
      <h2>Admin • Dashboard</h2>
      <div class="sub">Gestion produits, stocks et commandes.</div>
    </div>
    <div class="d-flex gap-2">
      <a class="btn btn-neo btn-sm" href="<?= e(base_url('index.php?c=admin&a=products')) ?>">Produits</a>
      <a class="btn btn-outline-dark btn-soft btn-sm" href="<?= e(base_url('index.php?c=admin&a=orders')) ?>">Commandes</a>
    </div>
  </div>

  <div class="row g-3">
    <div class="col-lg-6">
      <div class="glass p-4 reveal">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="fw-semibold">Derniers produits</div>
          <a class="link-neo" href="<?= e(base_url('index.php?c=admin&a=product_new')) ?>">Ajouter →</a>
        </div>
        <?php foreach ($products as $p): ?>
          <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom:1px solid rgba(255,255,255,.10);">
            <div>
              <div class="fw-semibold"><?= e((string)$p['name']) ?></div>
              <div class="text-secondary small"><?= e((string)$p['gender']) ?> • <?= e((string)$p['category']) ?> • stock <?= (int)$p['stock'] ?></div>
            </div>
            <a class="btn btn-sm btn-neo" href="<?= e(base_url('index.php?c=admin&a=product_edit&id=' . (int)$p['id'])) ?>">Éditer</a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="col-lg-6">
      <div class="glass p-4 reveal">
        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="fw-semibold">Dernières commandes</div>
          <a class="link-neo" href="<?= e(base_url('index.php?c=admin&a=orders')) ?>">Voir tout →</a>
        </div>
        <?php foreach ($orders as $o): ?>
          <div class="d-flex justify-content-between align-items-center py-2" style="border-bottom:1px solid rgba(255,255,255,.10);">
            <div>
              <div class="fw-semibold"><?= e((string)$o['order_number']) ?></div>
              <div class="text-secondary small"><?= e((string)$o['email']) ?> • <?= e((string)$o['status']) ?></div>
            </div>
            <div class="fw-semibold"><?= e(money_mga((int)$o['total_cents'])) ?></div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>

