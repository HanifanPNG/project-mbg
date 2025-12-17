      <style>
        .hover-scale {
          transition: transform 0.3s ease;
        }

        .hover-scale:hover {
          transform: scale(1.03);
        }
        .bg-biru{
          background: linear-gradient(to right, #09427bff, #0b62ccff);
        }
        .bg-ijo{
          background: linear-gradient(to right, #117032ff, #0c9d3aff);
        }
        .bg-oren{
          background: linear-gradient(to right, #b58706ff, #dfcf1aff);
        }
      </style>

<?php 
require_once "../config.php";
$total_sppg = $db->query("select count(*) as jumlah from sppg")->fetch_assoc()['jumlah'];
$total_menu = $db->query("select count(*) as jumlah_menu from menu_sppg")->fetch_assoc()['jumlah_menu'];
$total_user = $db->query("SELECT COUNT(*) AS jumlah_user FROM users WHERE level = 'user'")->fetch_assoc()['jumlah_user'];?>
      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <!--begin::Col-->
              <div class="col-sm-6">
                <h3 class="mb-0">Dashboard Admin</h3>
              </div>
              <!--end::Col-->
              <!--begin::Col-->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Dashboard Admin</li>
                </ol>
              </div>
              <!--end::Col-->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content Header-->
        <!--begin::App Content-->
        <div class="app-content">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <!--begin::Col-->
              <div class="col-12">
                <!--begin::Card-->
                <div class="card">
                  <!--begin::Card Header-->
                  <div class="card-header">
                    <!--end::Card Title-->
                    <!--begin::Card Toolbar-->
                    <div class="card-tools">
                      <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                        <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                        <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                      </button>
                    </div>
                    <!--end::Card Toolbar-->
                  </div>
                  <!--end::Card Header-->
                  <!--begin::Card Body-->
                  <div class="card-body">
                    <!--begin::Row-->
                    <div class="row">

                      <!-- Total sppg -->
                      <div class="col-md-4 mb-3">
                        <div class="bg-ijo text-white p-4 rounded hover-scale">
                          <div class="d-flex align-items-center justify-content-between">
                            <div>
                              <h4 class="fw-bold mb-1">Total SPPG</h4>
                            </div>
                            <i class="bi bi-truck fs-1 opacity-75"></i>
                          </div>
                          <div class="justify-content-start align-items-center d-flex">
                            <h2 class="fw-bold mt-3 mb-0 "><?= $total_sppg ?></h2>
                          </div>
                        </div>
                      </div>
                      <!-- total menu -->
                      <div class="col-md-4 mb-3">
                        <div class="bg-biru text-white p-4 rounded hover-scale">
                          <div class="d-flex align-items-center justify-content-between">
                            <div>
                              <h4 class="fw-bold mb-1">Total Menu</h4>
                            </div>
                            <i class="bi bi-apple fs-1 opacity-75"></i>
                          </div>
                          <div class="justify-content-start align-items-center d-flex">
                            <h2 class="fw-bold mt-3 mb-0 "><?= $total_menu ?></h2>
                          </div>
                        </div>
                      </div>
                      <!-- total sekolah -->
                      <div class="col-md-4 mb-3">
                        <div class="bg-oren text-white p-4 rounded hover-scale">
                          <div class="d-flex align-items-center justify-content-between">
                            <div>
                              <h4 class="fw-bold mb-1">Total User</h4>
                            </div>
                            <i class="bi bi-person fs-1 opacity-75"></i>
                          </div>
                          <div class="justify-content-start align-items-center d-flex">
                            <h2 class="fw-bold mt-3 mb-0 "><?= $total_user?></h2>
                          </div>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div id="sidebar-color-code" class="w-100"></div>
                      </div>
                      <!--end::Col-->
                    </div>
                    <!--end::Row-->
                  </div>
                  <!--end::Card Body-->
                  <!--begin::Card Footer-->

                  <!--end::Card Footer-->
                </div>
                <!--end::Card-->
                <!--end::Card-->
              </div>
              <!--end::Col-->
            </div>
            <!--end::Row-->
          </div>
          <!--end::Container-->
        </div>
        <!--end::App Content-->
      </main>