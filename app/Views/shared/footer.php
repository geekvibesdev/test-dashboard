      <div class="modal" id="modalFilter" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalViewContent" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h1 class="modal-title fs-5" id="modalViewContentTitle">Filtrar</h1>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body mb-3" id="modalFilterBody"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script> var base_url = '<?= base_url() ?>'; </script>
  <?php
    if (isset($assets['js']) && is_array($assets['js'])) {
      foreach ($assets['js'] as $js) {
        echo '<script src="'.$js.'"></script>' . PHP_EOL;
      }
    }
  ?>
  </body> 
</html>