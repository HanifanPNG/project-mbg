      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <!--begin::Col-->
              <div class="col-sm-6"><h3 class="mb-0">Ganti Password</h3></div>
              <!--end::Col-->
              <!--begin::Col-->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Ganti Password</li>
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
                  <div class="card-header" style="margin-top: 15px;">
                    <!--end::Card Title-->
                    <!--begin::Card Toolbar-->
                    <!-- form -->
                     <form action="" method="post">
                        <!-- old password -->
                        <label for="oldPassword" class="form-label">Password Lama</label>
                        <input 
                            type="password" 
                            class="form-control w-100" 
                            id="oldPassword" 
                            name="oldPassword" 
                            placeholder="password lama" 
                            required
                        >
                        <!-- new password -->
                        <label for="NewPassword" class="form-label mt-2">Password Baru</label>
                        <input 
                            type="password" 
                            class="form-control w-100" 
                            id="NewPassword" 
                            name="NewPassword" 
                            placeholder="password Baru" 
                            required
                        >
                        <!-- confirm password -->
                        <label for="ConfirmPassword" class="form-label mt-2">Konfirmasi Password</label>
                        <input 
                            type="password" 
                            class="form-control w-100" 
                            id="ConPassword" 
                            name="ConPassword" 
                            placeholder="Konfirmasi Password" 
                            required
                        >
                     </form>
                     <div class=" my-2 border-primary d-inline">
                      <button class="text-bg-primary">Save</button>
                     </div>
                    </div>
                  <!--end::Card Header-->
                  <!--begin::Card Body-->
    
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