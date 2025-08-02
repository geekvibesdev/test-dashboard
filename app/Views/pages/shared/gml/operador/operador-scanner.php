<div class="container-fluid mobile__fw">
  <div class="row">
    <div class="col-md-12">
      <div class="card mb-0 bn__br0">
        <div class="card-body py-0">
          <div class="dash__container mobile__header">
            <div class="action">
              <a class="" href="<?= base_url('gml/operador') ?>"><i class="ti ti-arrow-left" style="font-size:24px;"></i></a>
            </div>
            <span class="d-flex align-items-center justify-content-center">
              <i class="ti ti-scan me-2" style="font-size:18px;"></i> <strong>GML Scanner</strong>
            </span>
          </div> 
        </div>
      </div>
    </div>
  </div>
  <div class="card mb-2 bn__br0">
    <div class="card-body">
      <div class="row">
        <h2 class="mb-4">Selecciona acción</h2>
        <div class="col-md-6 mb-4">
          <a class="btn btn__simple border w-100 d-flex align-items-center justify-content-center operador__button" href="<?= base_url('gml/operador/scanner/recolectar') ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 81.25" height="22" class="me-2" stroke-width="1" >
              <path d="M77.6 26.39A3.13 3.13 0 0075 25h-3.12a3.13 3.13 0 00-3.13 3.13v18.75A3.13 3.13 0 0071.88 50h12.5a3.12 3.12 0 003.12-3.12v-4.69a3.17 3.17 0 00-.5-1.74zm6.78 20.48h-12.5V28.12H75l9.38 14.07z"></path>
              <path d="M98.43 38.55L85.93 19.8a9.38 9.38 0 00-7.81-4.18h-12.5V9.38A9.38 9.38 0 0056.25 0H9.38A9.39 9.39 0 000 9.38v34.37a9.38 9.38 0 009.38 9.37v9.38a9.38 9.38 0 009.37 9.38h3.57a12.44 12.44 0 0024.11 0h16.51a12.45 12.45 0 0024.12 0h3.57A9.39 9.39 0 00100 62.5V43.75a9.32 9.32 0 00-1.57-5.2zM9.37 46.88a3.13 3.13 0 01-3.12-3.13V9.38a3.13 3.13 0 013.12-3.13h46.88a3.12 3.12 0 013.12 3.13v34.37a3.12 3.12 0 01-3.12 3.13zM34.38 75a6.25 6.25 0 116.25-6.25A6.25 6.25 0 0134.38 75zM75 75a6.25 6.25 0 116.25-6.25A6.25 6.25 0 0175 75zm18.75-12.5a3.12 3.12 0 01-3.13 3.12h-3.57a12.44 12.44 0 00-24.11 0H46.43a12.44 12.44 0 00-24.11 0h-3.57a3.12 3.12 0 01-3.13-3.12v-9.38h40.63a9.38 9.38 0 009.37-9.37V21.88h12.5a3.12 3.12 0 012.6 1.39L93.22 42a3.12 3.12 0 01.53 1.73z"></path>
            </svg> Recolectar
          </a>
        </div>
        <div class="col-md-6 mb-4">
          <a class="btn btn__simple border w-100 d-flex align-items-center justify-content-center operador__button" href="<?= base_url('gml/operador/scanner/trayecto') ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 81.25" height="24" class="me-2" stroke-width="1" >
              <path d="M55.46 16.1a4 4 0 104-4 4.05 4.05 0 00-4 4zm6.56 0a2.5 2.5 0 11-2.49-2.49A2.48 2.48 0 0162 16.1z"></path>
              <path d="M88.47 32L90 30.43 74.85 15.29V6.55H72.7v6.56L59.59 0 45.31 14.3H0v29.77h3.91v6.6h-1.7v5h9.45A5.88 5.88 0 0014 59.23H0v2.15h87.68v-2.15h-2.16V29zM2.17 42V16.45h42.45v25.48zm4.05 12.1H3.81v-1.87h2.41zm5.36-.6h-3.8v-2.8h-1.7v-6.63h40.7V29.19h11.71l3.15 10.87 2.73 2.46L66 50.68h-1.56v2.82h-2a5.88 5.88 0 00-5.81-5.13h-.53a5.88 5.88 0 00-5.3 5.1H23.18a5.85 5.85 0 00-5.78-5h-.53a5.88 5.88 0 00-5.29 5zm54.76-12.11l-2.81-2.54-1.87-6.55h6.19v13.91h-.56zm2.07 10.84v1.87H66v-1.87zm-50.64 6.46h-.4a4.31 4.31 0 01-.37-8.61h.4a4.31 4.31 0 01.37 8.61zm3 .52a5.93 5.93 0 002.39-3.57H50.9a5.91 5.91 0 002.59 3.57zm35.86-.66a4.31 4.31 0 01-.38-8.61h.4a4.31 4.31 0 01.35 8.61zm26.78.66h-23.7a5.9 5.9 0 002.59-3.57H70v-5h-1.87l-.57-2.91h9.72v-17H61.19L60.09 27H46.77V15.88L59.58 3.07l23.81 23.78zm-14-13V32.34h6.34v13.87z"></path>
              <path d="M49.66 23h19.71v1.55H49.66zM26.18 50h20.89v1.55H26.18zM55.84 45.28a8.46 8.46 0 00-6.22 3.62l1.28.89a6.92 6.92 0 0111.39 0l1.28-.88a8.5 8.5 0 00-7.73-3.63zM23.14 49.79l1.27-.88a8.42 8.42 0 00-13.95 0l1.28.89a6.92 6.92 0 0111.39 0zM57.28 30.63h-8.91v8.14h11.1zm-7.35 1.55h6.16l1.35 5.07H50zM48.37 40.16h2.53v1.55h-2.53zM17.39 52.18a.58.58 0 10.48.9.59.59 0 00-.07-.74.57.57 0 00-.41-.16zM15.75 53.82a.57.57 0 00-.57.46.59.59 0 00.35.65.56.56 0 00.7-.22.58.58 0 00-.07-.73.53.53 0 00-.41-.16zM17.39 55.45a.58.58 0 00-.22 1.12.57.57 0 00.7-.22.58.58 0 00-.07-.73.58.58 0 00-.41-.17zM19 53.82a.57.57 0 00-.56.46.58.58 0 00.35.65.56.56 0 00.7-.22.59.59 0 00-.07-.73.54.54 0 00-.42-.16zM56.6 52a.58.58 0 10.48.9.56.56 0 00-.08-.7.54.54 0 00-.4-.2zM55 53.67a.57.57 0 00-.57.46.58.58 0 00.35.65.56.56 0 00.7-.22.56.56 0 00-.07-.73.53.53 0 00-.41-.16zM56.6 55.3a.58.58 0 00-.22 1.12.58.58 0 00.63-1 .58.58 0 00-.41-.12zM58.23 53.67a.57.57 0 00-.56.46.58.58 0 00.35.65.56.56 0 00.7-.22.59.59 0 00-.07-.73.54.54 0 00-.42-.16z"></path>
            </svg> En trayecto
          </a>
        </div>
        <div class="col-md-6 mb-4">
          <a class="btn btn__simple border w-100 d-flex align-items-center justify-content-center operador__button" href="<?= base_url('gml/operador/scanner/entregar') ?>">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 81.25" height="22" class="me-2" stroke-width="1" >
              <path d="M53.66 0l-33 42.16L5.12 27 0 32.3l21.43 20.82 38-48.59zM76.36 0l-33 42.16L39.12 38 34 43.29l10.13 9.83 38-48.59z" class="cls-1"></path>
            </svg> Entregar
          </a>
        </div>
        <div class="col-md-6 mb-4">
          <a class="btn btn__simple border w-100 d-flex align-items-center justify-content-center operador__button" href="<?= base_url('gml/operador/scanner/consultar') ?>">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" height="22" class="me-2" stroke-width="1" >
              <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
            </svg> Consultar
          </a>
        </div>
      </div>
    </div>
  </div>
</div>
