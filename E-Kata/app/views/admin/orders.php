<?php
require __DIR__ . '/../partials/header.php';
?>

<div class="container py-4">
  <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-end gap-3 mb-3 reveal">
    <div>
      <div class="eyebrow">ADMIN</div>
      <h1 class="h2 fw-bold mb-1">Commandes</h1>
      <div class="text-secondary">Voir et valider les commandes.</div>
    </div>
    <a class="btn btn-outline-dark btn-soft" href="<?= e(base_url('index.php?c=admin&a=dashboard')) ?>">Dashboard</a>
  </div>

  <div class="table-neo reveal">
    <div class="table-responsive">
      <table class="table table-borderless align-middle">
        <thead>
          <tr>
            <th>Commande</th>
            <th>Email</th>
            <th>Date</th>
            <th>Paiement</th>
            <th>Statut</th>
            <th class="text-end">Total</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orders as $o): ?>
            <tr>
              <td class="fw-semibold"><?= e((string)$o['order_number']) ?></td>
              <td class="text-secondary"><?= e((string)$o['email']) ?></td>
              <td class="text-secondary"><?= e((string)$o['created_at']) ?></td>
              <td><?= e((string)$o['payment_method']) ?></td>
              <td>
                <form method="post" action="<?= e(base_url('index.php?c=admin&a=order_status')) ?>" class="d-flex gap-2 align-items-center">
                  <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                  <input type="hidden" name="id" value="<?= (int)$o['id'] ?>">
                  <select class="form-select" name="status" style="min-width:160px;">
                    <?php $st = (string)$o['status']; ?>
                    <?php foreach (['pending','paid','validated','shipped','cancelled'] as $s): ?>
                      <option value="<?= e($s) ?>" <?= $st===$s?'selected':'' ?>><?= e($s) ?></option>
                    <?php endforeach; ?>
                  </select>
                  <button class="btn btn-sm btn-neo" type="submit">OK</button>
                </form>
              </td>
              <td class="text-end fw-semibold"><?= e(money_mga((int)$o['total_cents'])) ?></td>
              <td class="text-end">
                <a class="btn btn-sm btn-outline-dark btn-soft" href="<?= e(base_url('index.php?c=admin&a=order_view&id=' . (int)$o['id'])) ?>">Détail</a>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>

