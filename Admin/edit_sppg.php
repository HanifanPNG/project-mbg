<main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <!--begin::Col-->
              <div class="col-sm-6">
                <h3 class="mb-0">Edit SPPG</h3>
              </div>
              <!--end::Col-->
              <!--begin::Col-->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit SPPG</li>
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
                    EDIT SPPG
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
                      <!--begin::Col-->
                      <!--end::Col-->
                      <div class="col-lg-6">
                        <?php
                        require_once "../lib/db_helper.php";
                        require_once "../lib/validation.php";
                        require_once "../lib/csrf.php";
                        csrf_token();

                        $idx = (int)($_GET['id'] ?? 0);

                        $res = db_query("SELECT * FROM sppg WHERE id=?", "i", $idx);
                        $d = $res ? $res->fetch_assoc() : null;

                        if (!$d) {
                            die("SPPG tidak ditemukan");
                        }

                        // Get SPPG account info
                        $akun_res = db_query("SELECT id, username FROM users WHERE sppg_id=? AND level='sppg'", "i", $idx);
                        $akun = $akun_res ? $akun_res->fetch_assoc() : null;

                        // Initialize variables for form values
                        $nama_sppg = $d['nama_sppg'];
                        $alamat = $d['alamat'];
                        $gmaps = $d['gmaps'];
                        $kota = $d['kota'];
                        $jam_buka = $d['jam_buka'];
                        $jam_tutup = $d['jam_tutup'];

                        // Handle edit SPPG
                        if (isset($_POST['simpanEdit']) && csrf_verify()) {
                            $nama_sppg = v_string($_POST['nama_sppg'] ?? '', 255);
                            $alamat = v_string($_POST['alamat'] ?? '', 500);
                            $gmaps = v_string($_POST['gmaps'] ?? '', 500);
                            $kota = v_string($_POST['kota'] ?? '', 100);
                            $jam_buka = v_string($_POST['jam_buka'] ?? '', 10);
                            $jam_tutup = v_string($_POST['jam_tutup'] ?? '', 10);

                            $ok = db_exec(
                                "UPDATE sppg SET nama_sppg=?, alamat=?, gmaps=?, kota=?, jam_buka=?, jam_tutup=? WHERE id=?",
                                "ssssssi",
                                $nama_sppg, $alamat, $gmaps, $kota, $jam_buka, $jam_tutup, $idx
                            );
                            if ($ok) {
                                echo "<div class='alert alert-success'>Data SPPG berhasil diubah ✅</div>";
                                // Refresh data
                                $res = db_query("SELECT * FROM sppg WHERE id=?", "i", $idx);
                                $d = $res->fetch_assoc();
                                $nama_sppg = $d['nama_sppg'];
                                $alamat = $d['alamat'];
                                $gmaps = $d['gmaps'];
                                $kota = $d['kota'];
                                $jam_buka = $d['jam_buka'];
                                $jam_tutup = $d['jam_tutup'];
                            }
                        }

                        // Handle reset password SPPG
                        if (isset($_POST['resetPassword']) && csrf_verify()) {
                            $new_pass = v_string($_POST['new_password'] ?? '', 255);
                            $pass_hash = password_hash($new_pass, PASSWORD_DEFAULT);
                            $ok = db_exec("UPDATE users SET password=? WHERE sppg_id=? AND level='sppg'", "si", $pass_hash, $idx);
                            if ($ok) {
                                echo "<div class='alert alert-success'>Password akun SPPG berhasil direset ✅</div>";
                            } else {
                                echo "<div class='alert alert-danger'>Gagal reset password</div>";
                            }
                        }

                        // Handle create akun SPPG
                        if (isset($_POST['createAccount']) && csrf_verify()) {
                            $new_username = v_string($_POST['new_username'] ?? '', 50);
                            $new_password = v_string($_POST['new_password_account'] ?? '', 255);
                            $pass_hash = password_hash($new_password, PASSWORD_DEFAULT);
                            $ok = db_exec("INSERT INTO users (username, password, level, sppg_id) VALUES (?, ?, 'sppg', ?)", "ssi", $new_username, $pass_hash, $idx);
                            if ($ok) {
                                echo "<div class='alert alert-success'>Akun SPPG berhasil dibuat ✅</div>";
                                // Refresh akun data
                                $akun_res = db_query("SELECT id, username FROM users WHERE sppg_id=? AND level='sppg'", "i", $idx);
                                $akun = $akun_res ? $akun_res->fetch_assoc() : null;
                            } else {
                                echo "<div class='alert alert-danger'>Gagal membuat akun. Username mungkin sudah digunakan.</div>";
                            }
                        }
                        ?>

                        <form action="#" method="post">
                            <?= csrf_field() ?>
                            <table class='table table-striped table-hover'>
                              <tr>
                                <td>Nama SPPG</td>
                                <td><input type='text' name='nama_sppg' class="form-control" value='<?= e($nama_sppg) ?>' required></td>
                              </tr>
                              <tr>
                                <td>Alamat</td>
                                <td><textarea name='alamat' class="form-control"><?= e($alamat) ?></textarea></td>
                              </tr>
                              <tr>
                                <td>Link Google Maps</td>
                                <td><textarea name='gmaps' class="form-control"><?= e($gmaps) ?></textarea></td>
                              </tr>
                              <tr>
                                <td>Kota</td>
                                <td><input type='text' name='kota' class="form-control" value='<?= e($kota) ?>' required></td>
                              </tr>
                              <tr>
                                <td>Jam Buka</td>
                                <td><input type='time' name='jam_buka' class="form-control" value='<?= e($jam_buka) ?>' required></td>
                              </tr>
                              <tr>
                                <td>Jam Tutup</td>
                                <td><input type='time' name='jam_tutup' class="form-control" value='<?= e($jam_tutup) ?>' required></td>
                              </tr>
                              <tr>
                                <td></td>
                                <td><input type='submit' name='simpanEdit' value='Simpan Perubahan' class='btn btn-primary'></td>
                              </tr>
                            </table>
                        </form>
                        <a href="./?p=sppg">
                            <button type="button" class="btn btn-secondary">Kembali</button>
                        </a>

                      </div>
                      <!--begin::Col - Akun Login-->
                      <div class="col-lg-6">
                        <div class="card border-success">
                          <div class="card-header bg-success text-white">
                            <h5 class="mb-0"><i class="bi bi-person-circle"></i> Akun Login SPPG</h5>
                          </div>
                          <div class="card-body">
                            <?php if ($akun): ?>
                              <div class="mb-3">
                                <p><strong>Username:</strong> <?= e($akun['username']) ?></p>
                                <p><small class="text-muted">ID: <?= $akun['id'] ?></small></p>
                              </div>
                              <hr>
                              <h6>Reset Password</h6>
                              <form action="#" method="post">
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                  <label class="form-label">Password Baru (minimal 8 karakter)</label>
                                  <input type="password" name="new_password" class="form-control" required minlength="8">
                                </div>
                                <button type="submit" name="resetPassword" class="btn btn-warning">
                                  <i class="bi bi-key"></i> Reset Password
                                </button>
                              </form>
                            <?php else: ?>
                              <div class="text-center text-muted mb-3">
                                <i class="bi bi-exclamation-triangle text-warning" style="font-size: 2rem;"></i>
                                <p class="mt-2">SPPG ini belum memiliki akun login</p>
                              </div>
                              <hr>
                              <h6>Buat Akun Login Baru</h6>
                              <form action="#" method="post">
                                <?= csrf_field() ?>
                                <div class="mb-3">
                                  <label class="form-label">Username</label>
                                  <input type="text" name="new_username" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                  <label class="form-label">Password (minimal 8 karakter)</label>
                                  <input type="password" name="new_password_account" class="form-control" required minlength="8">
                                </div>
                                <button type="submit" name="createAccount" class="btn btn-success">
                                  <i class="bi bi-person-plus"></i> Buat Akun Login
                                </button>
                              </form>
                            <?php endif; ?>
                          </div>
                        </div>
                      </div>
                      <!--end::Col - Akun Login-->
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