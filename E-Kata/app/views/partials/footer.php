  <div class="container py-5">
    <div class="footer-top glass reveal">
      <div class="row g-4 align-items-start">
        <div class="col-lg-5">
          <div class="brand footer-brand">
            <span class="brand-mark">E</span><span class="brand-name">-Kata</span>
          </div>
          <p class="text-secondary mb-0">
            E-Kata conçoit des pièces premium au design futuriste : minimal, impactant, et taillé pour le mouvement.
          </p>
        </div>
        <div class="col-lg-3">
          <h6 class="text-uppercase text-muted mb-3">Boutique</h6>
          <ul class="list-unstyled mb-0">
            <li><a class="link-neo" href="<?= e(base_url('index.php?c=products&a=men')) ?>">Homme</a></li>
            <li><a class="link-neo" href="<?= e(base_url('index.php?c=products&a=women')) ?>">Femme</a></li>
            <li><a class="link-neo" href="<?= e(base_url('index.php?c=products&a=news')) ?>">Nouveautés</a></li>
            <li><a class="link-neo" href="<?= e(base_url('index.php?c=products&a=promos')) ?>">Promotions</a></li>
          </ul>
        </div>
        <div class="col-lg-4">
          <h6 class="text-uppercase text-muted mb-3">Contact</h6>
          <div class="text-secondary small">
            <div>Support : support@ekata.local</div>
            <div>Horaires : Lun–Sam / 08:00–18:00</div>
            <div>Antananarivo, Madagascar</div>
          </div>
        </div>
      </div>
    </div>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center pt-4 gap-2">
      <div class="text-secondary small">© <?= (int)date('Y') ?> E-Kata. Tous droits réservés.</div>
      <div class="text-secondary small">Design futuriste • Rapide • Responsive</div>
    </div>
  </div>
</main>

<?php $jsVer = (int)@filemtime(__DIR__ . '/../../../public/assets/js/app.js'); ?>
<script src="<?= e(base_url('assets/js/popper.min.js')) ?>"></script>
<script src="<?= e(base_url('assets/js/bootstrap.min.js')) ?>"></script>
<script src="<?= e(base_url('assets/js/app.js?v=' . $jsVer)) ?>"></script>
</body>
</html>

