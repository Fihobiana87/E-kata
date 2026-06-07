<?php
require __DIR__ . '/../partials/header.php';

$cats = ['t-shirt' => 'T-shirt', 'chemise' => 'Chemise', 'pantalon' => 'Pantalon', 'hoodie' => 'Hoodie', 'veste' => 'Veste'];
$baseParams = [];
if (!empty($gender)) { $baseParams['gender'] = $gender; }
if (!empty($q)) { $baseParams['q'] = $q; }
?>

<div class="container py-4">
  <div class="d-flex flex-column flex-lg-row justify-content-between align-items-start align-items-lg-end gap-3 mb-3">
    <div class="reveal">
      <div class="eyebrow">E-KATA STORE</div>
      <h1 class="h2 fw-bold mb-1"><?= e((string)($pageTitle ?? 'Produits')) ?></h1>
      <div class="text-secondary">Filtrez par catégorie, et découvrez une sélection premium.</div>
    </div>

    <div class="d-flex flex-wrap gap-2 reveal">
      <?php
        $makeUrl = function (?string $cat) use ($baseParams) {
          $params = $baseParams;
          if ($cat) { $params['category'] = $cat; }
          $qs = http_build_query(array_filter($params, fn($v) => $v !== '' && $v !== null));

          // on conserve la route courante (?c=products&a=xxx)
          $c = (string)($_GET['c'] ?? 'products');
          $a = (string)($_GET['a'] ?? 'men');
          return base_url('index.php?c=' . urlencode($c) . '&a=' . urlencode($a) . ($qs ? '&' . $qs : ''));
        };
      ?>
      <a class="btn btn-sm filter-pill <?= ($category ?? '') === '' ? 'active' : '' ?>" href="<?= e($makeUrl(null)) ?>">Tout</a>
      <?php foreach ($cats as $k => $label): ?>
        <a class="btn btn-sm filter-pill <?= ($category ?? '') === $k ? 'active' : '' ?>" href="<?= e($makeUrl($k)) ?>"><?= e($label) ?></a>
      <?php endforeach; ?>
    </div>
  </div>

  <?php if (empty($products)): ?>
    <div class="glass p-4 reveal">
      <div class="fw-semibold mb-1">Aucun produit trouvé.</div>
      <div class="text-secondary">Essayez une autre recherche ou retirez les filtres.</div>
    </div>
  <?php else: ?>
    <div class="row g-3">
      <?php foreach ($products as $p): ?>
        <div class="col-12 col-md-6 col-lg-4">
          <?php require __DIR__ . '/../partials/product_card.php'; ?>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<?php require __DIR__ . '/../partials/footer.php'; ?>

