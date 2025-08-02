<!-- Sidebar Start -->
<aside class="left-sidebar left-sidebar-collapse" id="left__sidebar">
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="<?= base_url('ventas/personalizables') ?>" class="text-nowrap logo-img">
        <img src="<?= base_url('assets/images/logos/logo-gm-4.png') ?>" height="45" alt="" />
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>
    <nav class="sidebar-nav scroll-sidebar mt-2" data-simplebar="">
      <div class="accordion" id="accordionSidebar">
        <!-- Ventas -->
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingVentas">
            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseVentas" aria-expanded="true" aria-controls="collapseVentas">
              Ventas
            </button>
          </h2>
          <div id="collapseVentas" class="accordion-collapse collapse show" aria-labelledby="headingVentas" data-bs-parent="#accordionSidebar">
            <div class="accordion-body px-0 py-1">
              <ul class="list-unstyled mb-0">
                <li class="sidebar-item">
                  <a class="sidebar-link" href="<?= base_url('ventas/personalizables') ?>">
                    <i class="ti ti-gift-card"></i> Personalizables
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