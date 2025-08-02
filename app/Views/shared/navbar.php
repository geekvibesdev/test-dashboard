<!--  Navbar Start -->
<header class="app-header app-header-collapse" id="app__header">
  <nav class="navbar navbar-expand-lg navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item d-block d-xl-none">
        <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
          <i class="ti ti-menu-2"></i>
        </a>
      </li>
    </ul>
    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
      <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-between">
        <div class="navbar-nav align-items-center me-auto">
          <div class="nav-item d-flex align-items-center">
            <span class="w-px-22 h-px-22"><i class="ti ti-search"></i></span>
            <input 
              style="border:none!important"
              type="text" 
              id="buscarOrden" 
              class="form-control border-0 shadow-none ps-1 ps-sm-2 d-md-block d-none" 
              placeholder="# orden" 
              aria-label="Buscar..."
              maxlength="8"
              pattern="\d+"
              oninput="this.value = this.value.replace(/[^0-9]/g, '');"
            >
          </div>
        </div>
        <li class="nav-item dropdown">
          <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
            aria-expanded="false">
            <img src="<?= base_url(session('user')->photo) ?>" alt="" width="35" height="35" class="rounded-circle">
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
            <div class="message-body">
              <a href="<?=base_url('/profile')?>" class="d-flex align-items-center gap-2 dropdown-item">
                <i class="ti ti-user fs-6"></i>
                <p class="mb-0 fs-3">Perfil </p>
              </a>
              <a href="<?=base_url('/auth/logout')?>" class="d-flex align-items-center gap-2 dropdown-item">
                 <i class="ti ti-logout fs-6"></i>
                <p class="mb-0 fs-3">Cerrar sesión </p>
              </a>
            </div>
          </div>
          
        </li>
      </ul>
    </div>
  </nav>
</header>
<!--  Navbar End -->
<script>
  document.getElementById('buscarOrden').addEventListener('keypress', function (e) {
    if (e.key === 'Enter') {
      const valor = e.target.value.trim(); // Obtener el valor del input
      if(valor.length < 5) return
      if (valor) {
        const url = "<?=base_url()?>" + `ventas/ordenes/${valor}`; // Construir la URL
        window.open(url, '_blank'); // Abrir en una nueva pestaña
      }
    }
  });
</script>