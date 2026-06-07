<?php
require __DIR__ . '/../partials/header.php';

$isEdit = !empty($product);
$action = $isEdit ? base_url('index.php?c=admin&a=product_edit&id=' . (int)$product['id']) : base_url('index.php?c=admin&a=product_new');
?>

<div class="container py-4">
  <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-end gap-3 mb-3 reveal">
    <div>
      <div class="eyebrow">ADMIN</div>
      <h1 class="h2 fw-bold mb-1"><?= $isEdit ? 'Modifier produit' : 'Ajouter produit' ?></h1>
      <div class="text-secondary">Renseignez les champs puis enregistrez.</div>
    </div>
    <a class="btn btn-outline-dark btn-soft" href="<?= e(base_url('index.php?c=admin&a=products')) ?>">Retour</a>
  </div>

  <div class="hero-card reveal">
    <form method="post" action="<?= e($action) ?>" class="row g-3">
      <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
      <div class="col-12 col-md-8">
        <label class="form-label text-secondary">Nom</label>
        <input class="form-control" name="name" required value="<?= e((string)($product['name'] ?? '')) ?>" placeholder="Ex: T-shirt Neo Black">
      </div>
      <div class="col-12 col-md-4">
        <label class="form-label text-secondary">Slug</label>
        <input class="form-control" name="slug" required value="<?= e((string)($product['slug'] ?? '')) ?>" placeholder="t-shirt-neo-black">
      </div>
      <div class="col-12 col-md-4">
        <label class="form-label text-secondary">Genre</label>
        <select class="form-select" name="gender" required>
          <?php $g = (string)($product['gender'] ?? 'unisex'); ?>
          <option value="homme" <?= $g==='homme'?'selected':'' ?>>Homme</option>
          <option value="femme" <?= $g==='femme'?'selected':'' ?>>Femme</option>
          <option value="unisex" <?= $g==='unisex'?'selected':'' ?>>Unisex</option>
        </select>
      </div>
      <div class="col-12 col-md-4">
        <label class="form-label text-secondary">Catégorie</label>
        <input class="form-control" name="category" required value="<?= e((string)($product['category'] ?? '')) ?>" placeholder="t-shirt / chemise / pantalon">
      </div>
      <div class="col-12 col-md-4">
        <label class="form-label text-secondary">Stock</label>
        <input class="form-control" type="number" min="0" name="stock" required value="<?= (int)($product['stock'] ?? 0) ?>">
      </div>
      <div class="col-12 col-md-4">
        <label class="form-label text-secondary">Prix (Ar)</label>
        <input class="form-control" type="number" min="0" step="1" name="price" required value="<?= isset($product['price_cents']) ? (int)round(((int)$product['price_cents'])/100) : '' ?>">
      </div>
      <div class="col-12 col-md-4">
        <label class="form-label text-secondary">Prix promo (Ar)</label>
        <input class="form-control" type="number" min="0" step="1" name="promo_price" value="<?= isset($product['promo_price_cents']) && $product['promo_price_cents'] ? (int)round(((int)$product['promo_price_cents'])/100) : '' ?>">
      </div>
      <div class="col-12 col-md-4">
        <label class="form-label text-secondary">Image (fichier dans `public/assets/img/`)</label>
        <input class="form-control" name="image" value="<?= e((string)($product['image'] ?? '')) ?>" placeholder="prod_xxx.jpg">
      </div>
      <div class="col-12">
        <label class="form-label text-secondary">Description</label>
        <textarea class="form-control" name="description" rows="4" placeholder="Description du produit..."><?= e((string)($product['description'] ?? '')) ?></textarea>
      </div>
      <div class="col-12 d-flex flex-wrap gap-3">
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="is_new" id="is_new" <?= !empty($product['is_new']) ? 'checked' : '' ?>>
          <label class="form-check-label" for="is_new">Nouveau</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" <?= !empty($product['is_featured']) ? 'checked' : '' ?>>
          <label class="form-check-label" for="is_featured">En vedette</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" name="is_active" id="is_active" <?= !isset($product['is_active']) || !empty($product['is_active']) ? 'checked' : '' ?>>
          <label class="form-check-label" for="is_active">Actif</label>
        </div>
      </div>
      <div class="col-12 d-flex gap-2">
        <button class="btn btn-neo" type="submit">Enregistrer</button>
        <a class="btn btn-outline-dark btn-soft" href="<?= e(base_url('index.php?c=admin&a=products')) ?>">Annuler</a>
      </div>
    </form>
  </div>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>

