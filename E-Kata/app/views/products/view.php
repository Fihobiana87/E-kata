<?php
require __DIR__ . '/../partials/header.php';
$p = $product;
$img = (string)($p['image'] ?? '');
$imgPath = $img !== '' ? base_url('assets/img/' . $img) : '';
$hasPromo = !empty($p['promo_price_cents']) && (int)$p['promo_price_cents'] > 0;
$unit = (int)($hasPromo ? $p['promo_price_cents'] : $p['price_cents']);
?>

<div class="container py-4">
  <div class="row g-4 align-items-start">
    <div class="col-lg-6">
      <div class="glass p-3 reveal">
        <div class="ratio ratio-1x1 rounded-4 overflow-hidden" style="background: linear-gradient(135deg, rgba(255, 106, 0, .14), rgba(99, 102, 241, .08));">
          <?php if ($imgPath): ?>
            <img src="<?= e($imgPath) ?>" alt="<?= e((string)$p['name']) ?>" style="object-fit:cover;" onerror="this.style.display='none'">
          <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="col-lg-6">
      <div class="hero-card reveal">
        <div class="eyebrow mb-2 text-uppercase" style="letter-spacing:.18em;">
          <?= e((string)$p['gender']) ?> • <?= e((string)$p['category']) ?>
        </div>
        <h1 class="h2 fw-bold mb-2"><?= e((string)$p['name']) ?></h1>
        <p class="text-secondary mb-3"><?= e((string)($p['description'] ?? 'Pièce premium E-Kata au design futuriste.')) ?></p>

        <div class="d-flex align-items-end justify-content-between gap-3 mb-3">
          <div class="price">
            <?php if ($hasPromo): ?>
              <div class="old"><?= e(money_mga((int)$p['price_cents'])) ?></div>
            <?php endif; ?>
            <div class="fs-3"><?= e(money_mga($unit)) ?></div>
          </div>
          <div class="text-secondary">Stock: <span class="fw-semibold text-body"><?= (int)$p['stock'] ?></span></div>
        </div>

        <form method="post" action="<?= e(base_url('index.php?c=cart&a=add')) ?>" class="d-flex flex-column flex-sm-row gap-2">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
          <div class="d-flex align-items-center gap-2">
            <label class="text-secondary small" for="qty">Qté</label>
            <input id="qty" name="qty" type="number" class="form-control" min="1" max="99" value="1" style="max-width:120px;">
          </div>
          <button class="btn btn-neo" type="submit" <?= ((int)$p['stock'] <= 0) ? 'disabled' : '' ?>>
            Ajouter au panier
          </button>
          <?php if (!is_logged_in()): ?>
            <div class="text-secondary small mt-1">
              Ajout au panier disponible après connexion.
            </div>
          <?php endif; ?>
        </form>

        <div class="d-flex flex-wrap gap-2 mt-4">
          <a class="btn btn-outline-dark btn-soft" href="<?= e(base_url('index.php?c=products&a=men')) ?>">Continuer shopping</a>
          <a class="btn btn-outline-dark btn-soft" href="<?= e(base_url('index.php?c=cart&a=index')) ?>">Voir panier</a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>

