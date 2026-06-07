<?php
require __DIR__ . '/../partials/header.php';
?>

<div class="container py-4">
  <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-end gap-3 mb-3 reveal">
    <div>
      <div class="eyebrow">ADMIN</div>
      <h1 class="h2 fw-bold mb-1">Produits</h1>
      <div class="text-secondary">Ajouter / Modifier / Supprimer + gestion stock.</div>
    </div>
    <div class="d-flex gap-2">
      <a class="btn btn-neo" href="<?= e(base_url('index.php?c=admin&a=product_new')) ?>">Ajouter</a>
      <a class="btn btn-outline-dark btn-soft" href="<?= e(base_url('index.php?c=admin&a=orders')) ?>">Commandes</a>
    </div>
  </div>

  <div class="table-neo reveal">
    <div class="table-responsive">
      <table class="table table-borderless align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Nom</th>
            <th>Genre</th>
            <th>Catégorie</th>
            <th class="text-end">Prix</th>
            <th class="text-end">Promo</th>
            <th class="text-end">Stock</th>
            <th>Actif</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $p): ?>
            <tr>
              <td class="text-secondary"><?= (int)$p['id'] ?></td>
              <td class="fw-semibold"><?= e((string)$p['name']) ?></td>
              <td><?= e((string)$p['gender']) ?></td>
              <td><?= e((string)$p['category']) ?></td>
              <td class="text-end"><?= e(money_mga((int)$p['price_cents'])) ?></td>
              <td class="text-end"><?= $p['promo_price_cents'] ? e(money_mga((int)$p['promo_price_cents'])) : '—' ?></td>
              <td class="text-end fw-semibold"><?= (int)$p['stock'] ?></td>
              <td><?= !empty($p['is_active']) ? 'Oui' : 'Non' ?></td>
              <td class="text-end">
                <div class="d-flex justify-content-end gap-2">
                  <a class="btn btn-sm btn-neo" href="<?= e(base_url('index.php?c=admin&a=product_edit&id=' . (int)$p['id'])) ?>">Éditer</a>
                  <form method="post" action="<?= e(base_url('index.php?c=admin&a=product_delete')) ?>" onsubmit="return confirm('Supprimer ce produit ?')">
                    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
                    <input type="hidden" name="id" value="<?= (int)$p['id'] ?>">
                    <button class="btn btn-sm btn-outline-dark btn-soft" type="submit">Supprimer</button>
                  </form>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>

