      <?php
require_once "../config.php";
require_once "../lib/db_helper.php";
require_once "../lib/validation.php";

$msg = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old = $_POST['oldPassword'] ?? '';
    $new = $_POST['NewPassword'] ?? '';
    $conf = $_POST['ConPassword'] ?? '';

    // get current user
    $uid = $_SESSION['user_id'] ?? 0;
    $res = db_query("SELECT password FROM users WHERE id=?", "i", $uid);
    $row = $res ? $res->fetch_assoc() : null;

    if (!$row) {
        $msg = "User tidak ditemukan";
    } elseif (!password_verify($old, $row['password'])) {
        $msg = "Password lama salah";
    } elseif (strlen($new) < 8) {
        $msg = "Password baru minimal 8 karakter";
    } elseif ($new !== $conf) {
        $msg = "Konfirmasi password tidak cocok";
    } else {
        $hash = password_hash($new, PASSWORD_DEFAULT);
        $ok = db_exec("UPDATE users SET password=? WHERE id=?", "si", $hash, $uid);
        if ($ok) {
            $msg = "Password berhasil diubah";
        } else {
            $msg = "Gagal mengubah password";
        }
    }
}
?>
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