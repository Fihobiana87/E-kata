<?php
require __DIR__ . '/../partials/header.php';
?>

<div class="container py-4">
  <div class="section-title">
    <div>
      <h2>Mes commandes</h2>
      <div class="sub">Historique et statuts de livraison.</div>
    </div>
    <a class="link-neo" href="<?= e(base_url('index.php?c=products&a=men')) ?>">Retour boutique →</a>
  </div>

  <?php if (empty($orders)): ?>
    <div class="glass p-4 reveal">
      <div class="fw-semibold mb-1">Aucune commande.</div>
      <div class="text-secondary">Ajoutez des articles au panier puis validez.</div>
    </div>
  <?php else: ?>
    <div class="table-neo reveal">
      <div class="table-responsive">
        <table class="table table-borderless align-middle">
          <thead>
            <tr>
              <th>Commande</th>
              <th>Date</th>
              <th>Statut</th>
              <th class="text-end">Total</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $o): ?>
              <tr>
                <td class="fw-semibold"><?= e((string)$o['order_number']) ?></td>
                <td class="text-secondary"><?= e((string)$o['created_at']) ?></td>
                <td><span class="badge text-bg-light"><?= e((string)$o['status']) ?></span></td>
                <td class="text-end fw-semibold"><?= e(money_mga((int)$o['total_cents'])) ?></td>
                <td class="text-end">
                  <a class="btn btn-sm btn-neo" href="<?= e(base_url('index.php?c=account&a=order&id=' . (int)$o['id'])) ?>">Voir</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  <?php endif; ?>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>

