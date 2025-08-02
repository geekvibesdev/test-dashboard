<!-- Sidebar Start -->
<aside class="left-sidebar left-sidebar-collapse" id="left__sidebar">
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="<?= base_url('mx/dashboard') ?>" class="text-nowrap logo-img py-4">
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
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInformesMx" aria-expanded="true" aria-controls="collapseInformesMx">
              Informes MX
            </button>
          </h2>
          <div id="collapseInformesMx" class="accordion-collapse collapse show" aria-labelledby="headingInformes" data-bs-parent="#accordionSidebar">
            <div class="accordion-body px-0 py-1">
              <ul class="list-unstyled mb-0">
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('mx/dashboard') ?>">
                    <i class="ti ti-layout-dashboard"></i> Dashboard
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('mx/informes/ordenes') ?>">
                    <i class="ti ti-inbox"></i> Ordenes
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('mx/informes/productos-vendidos') ?>">
                    <i class="ti ti-box"></i> Productos vendidos
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('mx/informes/promociones-tienda') ?>">
                    <i class="ti ti-calendar"></i> Promociones
                  </a>
                </li>
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('informes/reporte-de-ventas') ?>">
                    <i class="ti ti-chart-bar"></i> Reporte de ventas
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