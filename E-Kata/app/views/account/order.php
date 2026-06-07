<?php
require __DIR__ . '/../partials/header.php';
?>

<div class="container py-4">
  <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-end gap-3 mb-3 reveal">
    <div>
      <div class="eyebrow">COMMANDE</div>
      <h1 class="h2 fw-bold mb-1"><?= e((string)$order['order_number']) ?></h1>
      <div class="text-secondary">Statut : <span class="text-body fw-semibold"><?= e((string)$order['status']) ?></span></div>
    </div>
    <a class="btn btn-outline-dark btn-soft" href="<?= e(base_url('index.php?c=account&a=orders')) ?>">Retour</a>
  </div>

  <div class="row g-4">
    <div class="col-lg-7">
      <div class="table-neo reveal">
        <div class="table-responsive">
          <table class="table table-borderless align-middle">
            <thead>
              <tr>
                <th>Produit</th>
                <th class="text-end">Prix</th>
                <th class="text-end">Qté</th>
                <th class="text-end">Total</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($items as $it): ?>
                <tr>
                  <td class="fw-semibold"><?= e((string)$it['product_name']) ?></td>
                  <td class="text-end"><?= e(money_mga((int)$it['unit_price_cents'])) ?></td>
                  <td class="text-end"><?= (int)$it['quantity'] ?></td>
                  <td class="text-end fw-semibold"><?= e(money_mga((int)$it['line_total_cents'])) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="hero-card reveal">
        <div class="eyebrow mb-2">LIVRAISON</div>
        <div class="mb-2">
          <div class="text-secondary small">Nom</div>
          <div class="fw-semibold"><?= e((string)$order['customer_name']) ?></div>
        </div>
        <div class="mb-2">
          <div class="text-secondary small">Adresse</div>
          <div class="fw-semibold"><?= e((string)$order['address']) ?></div>
        </div>
        <div class="mb-2">
          <div class="text-secondary small">Téléphone</div>
          <div class="fw-semibold"><?= e((string)$order['phone']) ?></div>
        </div>
        <div class="mb-3">
          <div class="text-secondary small">Paiement</div>
          <div class="fw-semibold"><?= e((string)$order['payment_method']) ?></div>
        </div>
        <div class="glass p-3">
          <div class="text-secondary small">Total</div>
          <div class="fs-4 fw-bold"><?= e(money_mga((int)$order['total_cents'])) ?></div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>

