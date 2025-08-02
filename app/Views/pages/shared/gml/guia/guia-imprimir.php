<style>
  @media print {
    .separator__guia {
      -webkit-print-color-adjust: exact !important;
      print-color-adjust: exact !important;
      background: #000 !important;
    }
    .separator__guia_light {
      -webkit-print-color-adjust: exact !important;
      print-color-adjust: exact !important;
      background: #000 !important;
    }
    @page {
      margin: 0; /* Elimina márgenes para intentar ocultar encabezados/pies */
    }
    body {
      margin: 0;
    }
  }
</style>
<div class="min__h__100 guia__body mt-5">
  <div class="card mb-2" style="box-shadow: none;">
    <div class="card-body">
      <div class="row">
        <div class="col-8 d-flex align-items-center">
          <div class="remitente">
            <h1><?= strtoupper($remitente->nombre_completo) ?></h1>
            <h5 style="font-weight:400"><?= strtoupper($remitente->direccion_completa) ?></h5>
            <h5 style="font-weight:400">TEL <?= strtoupper($remitente->telefono) ?></h5>
          </div>
        </div>
        <div class="col-4 p-4 text-center">
          <img src="<?= base_url('assets/images/logos/logo-gm-4.png') ?>" height="80">
        </div>
      </div>
    </div>
  </div>
</div>
<div class="separator__guia"></div>
<div class="min__h__100 guia__body">
  <div class="card mb-2" style="box-shadow: none;">
    <div class="card-body">
      <div class="row">
        <div class="col-12 d-flex align-items-center">
          <div class="destinatario">
            <h1><?= strtoupper($destinatario->nombre_completo) ?></h1>
            <h5 style="font-weight:400"><?= strtoupper($destinatario->direccion_completa) ?></h5>
            <h5 style="font-weight:400">REF: <?= strtoupper($destinatario->referencias) ?></h5>
            <h5 style="font-weight:400">TEL: <?= strtoupper($destinatario->telefono) ?></h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="separator__guia"></div>
<div class="min__h__100 guia__body">
  <div class="card mb-2" style="box-shadow: none;">
    <div class="card-body">
      <div class="row">
        <div class="col-8 d-flex align-items-center">
          <div class="detalle">
            <h5 style="font-weight:400">O: <?= $guia->wc_orden ?></h5>
            <h5 style="font-weight:400">T: <?= strtoupper($guia->tipo_envio) ?></h5>
            <h5 style="font-weight:400">D: <?= $guia->largo_cm ?> x <?= $guia->ancho_cm ?> x <?= $guia->alto_cm ?></h5>
            <h5 style="font-weight:400">P: <?= $guia->peso_kg ?> KG</h5>
            <h5 style="font-weight:400">F: <?= $guia->guia_fecha_creada ?></h5>
          </div>
        </div>
         <div class="col-4 text-center">
          <div class="destinatario text-center">
            <img src="<?=$qr?><?= $guia->uid ?>" height="180">
            <h1 style="font-size:20px"><?= strtoupper($guia->guia) ?></h1>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="separator__guia"></div>
<div class="min__h__100 guia__body">
  <div class="card mb-2" style="box-shadow: none;">
    <div class="card-body">
      <div class="row">
        <div class="col-12 d-flex align-items-end guia__firma">
          <div class="">
            <div class="separator__guia_light"></div>
            <h4>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NOMBRE Y FIRMA DE QUIEN RECIBE&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h4>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  window.onload = function() {
    window.print();
  };
</script>
