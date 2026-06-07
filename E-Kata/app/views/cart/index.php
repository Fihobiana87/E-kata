<?php
require __DIR__ . '/../partials/header.php';

$rows = $items['rows'] ?? [];
$total = (int)($items['total'] ?? 0);
?>

<div class="container py-4">
  <div class="section-title">
    <div>
      <h2>Votre panier</h2>
      <div class="sub">Modifiez les quantités puis validez la commande.</div>
    </div>
    <div class="text-secondary">Articles: <span class="text-body fw-semibold"><?= (int)cart_count() ?></span></div>
  </div>

  <?php if (!is_logged_in()): ?>
    <div class="glass p-4 reveal">
      <div class="fw-semibold mb-1">Connexion requise</div>
      <div class="text-secondary mb-3">Pour ajouter/valider un panier, veuillez vous connecter.</div>
      <a class="btn btn-neo" href="<?= e(base_url('index.php?c=auth&a=login')) ?>">Login</a>
      <a class="btn btn-outline-dark btn-soft" href="<?= e(base_url('index.php?c=auth&a=register')) ?>">Inscription</a>
    </div>
  <?php elseif (!$rows): ?>
    <div class="glass p-4 reveal">
      <div class="fw-semibold mb-1">Panier vide</div>
      <div class="text-secondary mb-3">Explorez nos collections pour ajouter des articles.</div>
      <a class="btn btn-neo" href="<?= e(base_url('index.php?c=products&a=men')) ?>">Boutique Homme</a>
      <a class="btn btn-outline-dark btn-soft" href="<?= e(base_url('index.php?c=products&a=women')) ?>">Boutique Femme</a>
    </div>
  <?php else: ?>
    <form method="post" action="<?= e(base_url('index.php?c=cart&a=update')) ?>" class="reveal">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <div class="table-neo">
        <div class="table-responsive">
          <table class="table table-borderless align-middle">
            <thead>
              <tr>
                <th>Produit</th>
                <th style="width:140px;">Qté</th>
                <th class="text-end">Prix</th>
                <th class="text-end">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($rows as $r): $p = $r['product']; ?>
                <tr>
                  <td>
                    <div class="fw-semibold"><?= e((string)$p['name']) ?></div>
                    <div class="text-secondary small text-uppercase" style="letter-spacing:.14em;"><?= e((string)$p['category']) ?></div>
                  </td>
                  <td>
                    <input class="form-control" type="number" min="0" max="99" name="qty[<?= (int)$p['id'] ?>]" value="<?= (int)$r['qty'] ?>">
                    <div class="text-secondary small mt-1">0 = retirer</div>
                  </td>
                  <td class="text-end"><?= e(money_mga((int)$r['unit'])) ?></td>
                  <td class="text-end fw-semibold"><?= e(money_mga((int)$r['line'])) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>

      <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mt-3">
        <div class="d-flex gap-2">
          <button class="btn btn-neo" type="submit">Mettre à jour</button>
          <a class="btn btn-outline-dark btn-soft" href="<?= e(base_url('index.php?c=cart&a=clear')) ?>">Vider</a>
        </div>
        <div class="glass p-3">
          <div class="text-secondary small">Total</div>
          <div class="fs-4 fw-bold mb-2"><?= e(money_mga($total)) ?></div>
          <a class="btn btn-neo w-100" href="<?= e(base_url('index.php?c=orders&a=checkout')) ?>">Valider la commande</a>
        </div>
      </div>
    </form>
  <?php endif; ?>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>

