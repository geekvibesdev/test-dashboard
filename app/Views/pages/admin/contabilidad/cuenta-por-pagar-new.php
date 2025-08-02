<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
      <div class="card w-100">
        <div class="card-body p-4">
          <div class="d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-semibold m-0">Nueva cuenta por pagar</h5>
            <a href="<?= base_url('contabilidad/cuenta-por-pagar') ?>" class="btn btn__simple border d-block"><i class="ti ti-arrow-back"></i> Volver</a>
          </div>
          <form method="post" class="pt-4" action="<?= base_url('cuenta-por-pagar/new') ?>" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-4">
                  <label class="form-label">Proveedor <small style="color:red;">*</small></label>
                  <select class="form-select select2" name="id_proveedor" id="id_proveedor" required>
                    <option value="">Selecciona un proveedor</option>
                    <?php foreach($proveedores as $proveedor): ?>
                    <option value="<?= $proveedor->id ?>"><?= $proveedor->razon_social ?> - <?= $proveedor->rfc ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Folio de factura <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Folio factura"
                      type="text" 
                      id="factura_folio" 
                      name="factura_folio" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Tipo de factura <small style="color:red;">*</small></label>
                  <select class="form-select " name="factura_tipo" id="factura_tipo" required>
                    <option value="">Selecciona</option>
                    <option value="pue">PUE</option>
                    <option value="ppd">PPD</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Monto de factura <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Monto factura"
                      type="text" 
                      id="factura_monto" 
                      name="factura_monto" 
                      class="form-control" 
                      required=""
                      maxlength="8"
                      pattern="\d+(\.\d{1,2})?"
                      oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Fecha de emisión <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Fecha de emisión"
                      type="date" 
                      id="fecha_emision" 
                      name="fecha_emision" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Días de crédito <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Días de crédito"
                      type="text" 
                      id="credito_dias" 
                      name="credito_dias" 
                      class="form-control" 
                      required=""
                      maxlength="3"
                      pattern="\d+"
                      oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-label">Fecha de pago <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="Fecha de pago"
                      type="date" 
                      id="fecha_pago" 
                      name="fecha_pago" 
                      class="form-control" 
                      required=""
                    >
                  </div>
                </div>
              </div>
            </div>
            <div class="row my-3">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">PDF <small style="color:red;">*</small></label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="ti ti-topology-complex"></i></span>
                    <input 
                      placeholder="PDF"
                      type="file" 
                      id="factura_pdf" 
                      name="factura_pdf" 
                      class="form-control" 
                      required=""
                      accept="application/pdf"
                    >
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3 d-flex align-items-end">
                  <div class="w-100">
                    <label class="form-label">Categoría <small style="color:red;">*</small></label>
                    <select class="form-select" name="factura_categoria" id="factura_categoria" required>
                      <option value="">Selecciona categoría o crea una</option>
                      <?php foreach($factura_categorias as $factura_categoria): ?>
                      <option id="categoria_option_<?= $factura_categoria->id ?>" value="<?= $factura_categoria->id ?>"><?= $factura_categoria->nombre ?> </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                  <button type="button" class="btn btn__simple border ms-2" id="crearCategoria"><i class="ti ti-plus"></i></button>
                </div>
              </div>
            </div>
            <?php if (session('message') !== null) : ?>
              <div class="alert alert-danger">
                <?= session('message'); ?>
              </div>
            <?php endif; ?>
            <?php if (session('success') !== null) : ?>
              <div class="alert alert-success">
                <?= session('success'); ?>
              </div>
            <?php endif; ?>
            <button type="submit" class="btn btn-primary d-block"><i class="ti ti-edit"></i> Crear cuenta por pagar</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="modal" id="modalFacturaCategoria" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalFacturaCategoria" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5">Categorias factura</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <?php echo csrf_field(); ?>
        <div id="crearCategoriaFormContainer">
          <div class="d-flex justify-content-between align-items-center" id="crearCategoriaFormContainer">
            <input type="text" class="form-control me-3" id="factura_categoria_nombre" placeholder="Nueva categoría" required>
            <button type="button" class="btn btn__simple border" id="crearCategoriaForm">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#5D87FF" width="18" height="18">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
              </svg>
            </button>
          </div>
        </div>
        <div id="editarCategoriaFormContainer" style="display:none;">
          <div class="d-flex justify-content-between align-items-center">
            <input type="hidden" class="form-control me-3" id="factura_categoria_edit_id">
            <input type="text" class="form-control me-3" id="factura_categoria_edit_nombre" placeholder="Edita categoría" required>
            <button type="button" class="btn btn__simple border me-2" id="editarCategoriaFormAccept">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#5D87FF" width="18" height="18">
                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
              </svg>
            </button>
            <button type="button" class="btn btn__simple border" id="editarCategoriaFormCancel">
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="red" width="18" height="18">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
              </svg>
            </button>
          </div>
        </div>
        <hr class="mb-0">
        <table class="table text-nowrap table-hover mb-3 align-middle dt_table">
          <tbody id="facturaCategoriaList">
            <?php foreach($factura_categorias as $factura_categoria): ?>
            <tr>
              <td class="px-1">
                <div class="d-flex justify-content-between align-items-center">
                  <span id="categoria_nombre_<?= $factura_categoria->id ?>"><?= $factura_categoria->nombre ?></span>
                  <button id="categoria_nombre_btn_<?= $factura_categoria->id ?>" type="button" class="btn btn__simple border editarCategoriaBtn" id_categoria="<?= $factura_categoria->id ?>" nombre_categoria="<?= $factura_categoria->nombre ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="#5D87FF" width="18" height="18">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                    </svg>
                  </button>
                </div>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <div class="col-12">
        <div class="alert alert-danger" id="errorAlert" style="display:none">
          <strong id="errorMessage"></strong>
        </div>
      </div>
    </div>
  </div>
</div>