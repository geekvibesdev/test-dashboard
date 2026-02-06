<!-- Sidebar Start -->
<aside class="left-sidebar left-sidebar-collapse" id="left__sidebar">
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="<?= base_url('dashboard') ?>" class="text-nowrap logo-img py-4">
        <img src="<?= base_url('assets/images/logos/logo-gm-4.png') ?>" height="45" alt="" />
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>
    <nav class="sidebar-nav scroll-sidebar mt-2" data-simplebar="">
      <div class="accordion" id="accordionSidebar">
        <!-- Informes -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingInformes">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInformes" aria-expanded="false" aria-controls="collapseInformes">
              Informes
            </button>
          </h2>
          <div id="collapseInformes" class="accordion-collapse collapse" aria-labelledby="headingInformes" data-bs-parent="#accordionSidebar">
            <div class="accordion-body px-0 py-1">
              <ul class="list-unstyled mb-0">
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('dashboard') ?>">
                    <i class="ti ti-layout-dashboard"></i> Dashboard
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('informes/ordenes') ?>">
                    <i class="ti ti-inbox"></i> Ordenes
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('informes/productos-vendidos') ?>">
                    <i class="ti ti-box"></i> Productos vendidos
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('informes/promociones-tienda') ?>">
                    <i class="ti ti-calendar"></i> Promociones
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('informes/gastos-paqueteria') ?>">
                    <i class="ti ti-truck"></i> Gastos paqueteria
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('informes/reporte-de-ventas') ?>">
                    <i class="ti ti-chart-bar"></i> Reporte de ventas
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('informes/agente-reporte') ?>">
                    <i class="ti ti-robot"></i> Agente de reporte
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- Contabilidad -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingContabilidad">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseContabilidad" aria-expanded="false" aria-controls="collapseContabilidad">
              Contabilidad
            </button>
          </h2>
          <div id="collapseContabilidad" class="accordion-collapse collapse" aria-labelledby="headingContabilidad" data-bs-parent="#accordionSidebar">
            <div class="accordion-body px-0 py-1">
              <ul class="list-unstyled mb-0">
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('contabilidad/cuenta-por-pagar') ?>">
                    <i class="ti ti-inbox"></i> Cuentas por pagar
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('settings/proveedor') ?>">
                    <i class="ti ti-news"></i> Proveedores
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- Ventas -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingVentas">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseVentas" aria-expanded="false" aria-controls="collapseVentas">
              Ventas
            </button>
          </h2>
          <div id="collapseVentas" class="accordion-collapse collapse" aria-labelledby="headingVentas" data-bs-parent="#accordionSidebar">
            <div class="accordion-body px-0 py-1">
              <ul class="list-unstyled mb-0">
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('ventas/ordenes') ?>">
                    <i class="ti ti-inbox"></i> Ordenes
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('ventas/personalizables') ?>">
                    <i class="ti ti-gift-card"></i> Personalizaciones
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('ventas/personalizables/reporte') ?>">
                    <i class="ti ti-gift-card"></i> Personalizaciones costos
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- GML -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingGML">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGML" aria-expanded="false" aria-controls="collapseGML">
              GML
            </button>
          </h2>
          <div id="collapseGML" class="accordion-collapse collapse" aria-labelledby="headingGML" data-bs-parent="#accordionSidebar">
            <div class="accordion-body px-0 py-1">
              <ul class="list-unstyled mb-0">
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('gml/guias/nuevo') ?>">
                    <i class="ti ti-truck"></i> Crear guia
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('gml/guias') ?>">
                    <img src="<?= base_url('assets/images/logos/logo-short-1.png') ?>" height="18" class="me-1"> Guias
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('gml/operador') ?>" >
                    <i class="ti ti-user-x"></i> Operador
                  </a>
                </li>
                 <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('settings/gml/remitentes') ?>">
                    <i class="ti ti-truck"></i> Remitentes
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- CustomerService -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingCustomerService">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseCustomerService" aria-expanded="false" aria-controls="collapseCustomerService">
              Soporte
            </button>
          </h2>
          <div id="collapseCustomerService" class="accordion-collapse collapse" aria-labelledby="headingCustomerService" data-bs-parent="#accordionSidebar">
            <div class="accordion-body px-0 py-1">
              <ul class="list-unstyled mb-0">
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('soporte/tickets') ?>">
                    <i class="ti ti-mailbox"></i> Incidentes
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
        <!-- Recursos -->
        <!-- <div class="accordion-item">
          <h2 class="accordion-header" id="headingRecursos">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseRecursos" aria-expanded="false" aria-controls="collapseRecursos">
              Recursos
            </button>
          </h2>
          <div id="collapseRecursos" class="accordion-collapse collapse" aria-labelledby="headingRecursos" data-bs-parent="#accordionSidebar">
            <div class="accordion-body px-0 py-1">
              <ul class="list-unstyled mb-0">
                <li class="sidebar-item">
                  <a class="sidebar-link" href="https://xanic-app.sites.geekvibes.agency" target="_blank">
                    <i class="ti ti-keyboard"></i> Inventario
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="https://xanic-tickets.sites.geekvibes.agency/tickets" target="_blank">
                    <i class="ti ti-device-desktop"></i> Soporte
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="https://smartship.mx/index.php" target="_blank">
                    <i class="ti ti-truck"></i> ACL
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="https://dhlexpresscommerce.com/Account/MemberLogin.aspx?ReturnUrl=%2fdefault.aspx" target="_blank">
                    <i class="ti ti-truck-delivery"></i> DHL
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div> -->
        <!-- Administrador -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingAdministrador">
            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAdministrador" aria-expanded="false" aria-controls="collapseAdministrador">
              Settings
            </button>
          </h2>
          <div id="collapseAdministrador" class="accordion-collapse collapse" aria-labelledby="headingAdministrador" data-bs-parent="#accordionSidebar">
            <div class="accordion-body px-0 py-1">
              <ul class="list-unstyled mb-0">
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('settings/productos') ?>">
                    <i class="ti ti-box"></i> Productos
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('settings/promociones') ?>">
                    <i class="ti ti-calendar"></i> Promociones
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('settings/envios') ?>">
                    <i class="ti ti-cash-banknote"></i> Envíos
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('settings/paqueteria') ?>">
                    <i class="ti ti-send"></i> Paqueterias
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('settings/openai') ?>">
                    <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" height="20"><path d="M474.123 209.81c11.525-34.577 7.569-72.423-10.838-103.904-27.696-48.168-83.433-72.94-137.794-61.414a127.14 127.14 0 00-95.475-42.49c-55.564 0-104.936 35.781-122.139 88.593-35.781 7.397-66.574 29.76-84.637 61.414-27.868 48.167-21.503 108.72 15.826 150.007-11.525 34.578-7.569 72.424 10.838 103.733 27.696 48.34 83.433 73.111 137.966 61.585 24.084 27.18 58.833 42.835 95.303 42.663 55.564 0 104.936-35.782 122.139-88.594 35.782-7.397 66.574-29.76 84.465-61.413 28.04-48.168 21.676-108.722-15.654-150.008v-.172zm-39.567-87.218c11.01 19.267 15.139 41.803 11.354 63.65-.688-.516-2.064-1.204-2.924-1.72l-101.152-58.49a16.965 16.965 0 00-16.687 0L206.621 194.5v-50.232l97.883-56.597c45.587-26.32 103.732-10.666 130.052 34.921zm-227.935 104.42l49.888-28.9 49.887 28.9v57.63l-49.887 28.9-49.888-28.9v-57.63zm23.223-191.81c22.364 0 43.867 7.742 61.07 22.02-.688.344-2.064 1.204-3.097 1.72L186.666 117.26c-5.161 2.925-8.258 8.43-8.258 14.45v136.934l-43.523-25.116V130.333c0-52.64 42.491-95.13 95.131-95.302l-.172.172zM52.14 168.697c11.182-19.268 28.557-34.062 49.544-41.803V247.14c0 6.02 3.097 11.354 8.258 14.45l118.354 68.295-43.695 25.288-97.711-56.425c-45.415-26.32-61.07-84.465-34.75-130.052zm26.665 220.71c-11.182-19.095-15.139-41.802-11.354-63.65.688.516 2.064 1.204 2.924 1.72l101.152 58.49a16.965 16.965 0 0016.687 0l118.354-68.467v50.232l-97.883 56.425c-45.587 26.148-103.732 10.665-130.052-34.75h.172zm204.54 87.39c-22.192 0-43.867-7.741-60.898-22.02a62.439 62.439 0 003.097-1.72l101.152-58.317c5.16-2.924 8.429-8.43 8.257-14.45V243.527l43.523 25.116v113.022c0 52.64-42.663 95.303-95.131 95.303v-.172zM461.22 343.303c-11.182 19.267-28.729 34.061-49.544 41.63V264.687c0-6.021-3.097-11.526-8.257-14.45L284.893 181.77l43.523-25.116 97.883 56.424c45.587 26.32 61.07 84.466 34.75 130.053l.172.172z" fill-rule="nonzero"/></svg> 
                    OpenAI
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('settings/logs/wc') ?>">
                    <i class="ti ti-code"></i> Logs
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('settings/user') ?>">
                    <i class="ti ti-users"></i> Usuarios
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <!-- Collapse Sidebar -->
      <div class="sidebar__collapse" id="sidebar__collapse__container">
        <div id="" class="accordion-collapse">
          <div class="accordion-body py-1">
            <ul class="list-unstyled mb-0">
              <li class="sidebar-item">
                <a class="sidebar-link" href="#" id="sidebar__collapse__btn">
                  <i class="ti ti-layout-sidebar-left-collapse"></i> Ocultar
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- Expand Sidebar -->
      <div class="sidebar__expand" id="sidebar__expand__container">
        <div id="" class="accordion-collapse">
          <div class="accordion-body py-1">
            <ul class="list-unstyled mb-0">
              <li class="sidebar-item">
                <a class="sidebar-link sidebar-link-expand" href="#" id="sidebar__expand__btn">
                  <i class="ti ti-layout-sidebar-left-expand"></i>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </nav>
  </div>
</aside>
<div class="body-wrapper body-wrapper__min body-wrapper-collapse" id="body__wrapper">