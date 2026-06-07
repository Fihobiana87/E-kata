<?php
/** @var array $p */
$img = (string)($p['image'] ?? '');
$imgPath = $img !== '' ? base_url('assets/img/' . $img) : '';
$hasPromo = !empty($p['promo_price_cents']) && (int)$p['promo_price_cents'] > 0;
$unit = (int)($hasPromo ? $p['promo_price_cents'] : $p['price_cents']);
?>
<div class="card-neo h-100 reveal">
  <a class="text-decoration-none" href="<?= e(base_url('index.php?c=products&a=show&id=' . (int)$p['id'])) ?>">
    <div class="thumb">
      <?php if (!empty($p['is_new'])): ?><div class="badge-neo">Nouveau</div><?php endif; ?>
      <?php if ($hasPromo): ?><div class="badge-neo" style="left:auto; right:12px;">Promo</div><?php endif; ?>
      <?php if ($imgPath): ?>
        <img src="<?= e($imgPath) ?>" alt="<?= e((string)$p['name']) ?>" onerror="this.style.display='none'">
      <?php endif; ?>
    </div>
  </a>
  <div class="p-3">
    <div class="d-flex justify-content-between align-items-start gap-2">
      <div>
        <div class="fw-semibold"><?= e((string)$p['name']) ?></div>
        <div class="text-secondary small text-uppercase" style="letter-spacing:.14em;"><?= e((string)$p['category']) ?></div>
      </div>
      <div class="text-end price">
        <?php if ($hasPromo): ?>
          <div class="old small"><?= e(money_mga((int)$p['price_cents'])) ?></div>
        <?php endif; ?>
        <div><?= e(money_mga($unit)) ?></div>
      </div>
    </div>

    <div class="d-flex align-items-center justify-content-between mt-3">
      <div class="text-secondary small">Stock: <?= (int)$p['stock'] ?></div>
      <a class="btn btn-neo btn-sm" href="<?= e(base_url('index.php?c=products&a=show&id=' . (int)$p['id'])) ?>">Voir</a>
    </div>
  </div>
</div>

