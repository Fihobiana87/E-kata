<?php
require __DIR__ . '/../partials/header.php';
$rows = $items['rows'] ?? [];
$total = (int)($items['total'] ?? 0);
?>

<div class="container py-4">
  <div class="section-title">
    <div>
      <h2>Validation commande</h2>
      <div class="sub">Renseignez vos informations et choisissez un paiement.</div>
    </div>
    <div class="text-secondary">Total: <span class="text-body fw-semibold"><?= e(money_mga($total)) ?></span></div>
  </div>

  <div class="row g-4">
    <div class="col-lg-7">
      <div class="hero-card reveal">
        <div class="eyebrow mb-2">INFORMATIONS</div>
        <form method="post" action="<?= e(base_url('index.php?c=orders&a=place')) ?>" class="row g-3">
          <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
          <div class="col-12">
            <label class="form-label text-secondary">Nom</label>
            <input class="form-control" name="customer_name" required placeholder="Votre nom complet">
          </div>
          <div class="col-12">
            <label class="form-label text-secondary">Adresse</label>
            <input class="form-control" name="address" required placeholder="Adresse de livraison">
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label text-secondary">Téléphone</label>
            <input class="form-control" name="phone" required placeholder="034...">
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label text-secondary">Mode de paiement</label>
            <select class="form-select" name="payment_method" required>
              <option value="orange_money">Orange Money</option>
              <option value="airtel_money">Airtel Money</option>
              <option value="mvola">MVola</option>
              <option value="cod">Paiement à la livraison</option>
            </select>
          </div>
          <div class="col-12 d-flex gap-2">
            <button class="btn btn-neo" type="submit">Confirmer la commande</button>
            <a class="btn btn-outline-dark btn-soft" href="<?= e(base_url('index.php?c=cart&a=index')) ?>">Retour panier</a>
          </div>
        </form>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="glass p-4 reveal">
        <div class="eyebrow mb-2">RÉCAP</div>
        <?php foreach ($rows as $r): ?>
          <div class="d-flex justify-content-between gap-3 py-2" style="border-bottom:1px solid rgba(15, 23, 42, 0.10);">
            <div>
              <div class="fw-semibold"><?= e((string)$r['product']['name']) ?></div>
              <div class="text-secondary small">Qté: <?= (int)$r['qty'] ?></div>
            </div>
            <div class="text-end fw-semibold"><?= e(money_mga((int)$r['line'])) ?></div>
          </div>
        <?php endforeach; ?>
        <div class="d-flex justify-content-between mt-3">
          <div class="text-secondary">Total</div>
          <div class="fs-5 fw-bold"><?= e(money_mga($total)) ?></div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>

