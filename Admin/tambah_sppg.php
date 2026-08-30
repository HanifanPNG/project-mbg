<?php
require_once "../lib/db_helper.php";
require_once "../lib/validation.php";
require_once "../lib/csrf.php";
csrf_token();

$nama_sppg = $alamat = $gmaps = $kota = $jam_buka = $jam_tutup = "";
$sppg_password = "";

// Handle form submit
if (isset($_POST['simpan']) && csrf_verify()) {
    $nama_sppg = v_string($_POST['nama_sppg'] ?? '', 255);
    $alamat = v_string($_POST['alamat'] ?? '', 500);
    $gmaps = v_string($_POST['gmaps'] ?? '', 500);
    $kota = v_string($_POST['kota'] ?? '', 100);
    $jam_buka = v_string($_POST['jam_buka'] ?? '', 10);
    $jam_tutup = v_string($_POST['jam_tutup'] ?? '', 10);
    $sppg_password = $_POST['sppg_password'] ?? '';

    $waktu = date("Y-m-d H:i:s");
    
    // Insert SPPG
    $sppg_ok = db_exec(
        "INSERT INTO sppg (nama_sppg, alamat, gmaps, kota, waktu, jam_buka, jam_tutup) VALUES (?, ?, ?, ?, ?, ?, ?)",
        "sssssss",
        $nama_sppg, $alamat, $gmaps, $kota, $waktu, $jam_buka, $jam_tutup
    );
    
    if ($sppg_ok) {
        $sppg_id = $db->insert_id;
        
        // Create SPPG login account
        $sppg_username = sppg_generate_unique_username(sppg_username_from_name($nama_sppg));
        $pass_hash = password_hash($sppg_password, PASSWORD_DEFAULT);
        $user_ok = db_exec(
            "INSERT INTO users (username, password, level, sppg_id) VALUES (?, ?, 'sppg', ?)",
            "ssi",
            $sppg_username, $pass_hash, $sppg_id
        );
        
        // Redirect (setelah semua insert berhasil)
        header("Location: ./?p=sppg");
        exit;
    } else {
        $error_msg = "Gagal menyimpan SPPG: " . e($db->error ?? 'Unknown error');
    }
}

// Generate username preview
$sppg_username_preview = sppg_username_from_name($nama_sppg);
?>

<main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <!--begin::Col-->
              <div class="col-sm-6">
                <h3 class="mb-0">Tambah SPPG</h3>
              </div>
              <!--end::Col-->
              <!--begin::Col-->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tambah SPPG</li>
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
                    <?php if (!empty($error_msg)): ?>
                      <div class="alert alert-danger"><?= $error_msg ?></div>
                    <?php endif; ?>
                    <!--begin::Row-->
                    <div class="row">
                      <!--begin::Col-->
                      <!--end::Col-->
                      <!--begin::Col-->

                      <form action="#" method="post">
                        <?= csrf_field() ?>
                        <table>
                          <tr>
                            <td>Nama SPPG</td>
                            <td><input type="text" name="nama_sppg" class="form-control" value="<?= e($nama_sppg) ?>" required></td>
                          </tr>
                          <tr>
                            <td valign="top">Alamat</td>
                            <td><textarea name="alamat" class="form-control" style="width: 200px;" required><?= e($alamat) ?></textarea></td>
                         </tr>
                         <tr>
                            <td>Link Google Maps</td>
                            <td>
                              <input type="text" name="gmaps" class="form-control" placeholder="Masukkan link Google Maps" value="<?= e($gmaps) ?>">
                            </td>
                          </tr>
                          <tr>
                            <td valign="top">Kabupaten</td>
                            <td><select name="kota" class="form-control" required>
                                <option value="">--- pilih kabupaten ---</option>
                                <option value="Purbalingga" <?= $kota == 'Purbalingga' ? 'selected' : '' ?>>Purbalingga</option>
                              </select></td>
                          </tr>
                          <tr>
                            <td>Jam Buka</td>
                            <td>
                              <input type="time" name="jam_buka" class="form-control" value="<?= e($jam_buka) ?>" required>
                            </td>
                          </tr>
                          <tr>
                            <td>Jam Tutup</td>
                            <td>
                              <input type="time" name="jam_tutup" class="form-control" value="<?= e($jam_tutup) ?>" required>
                            </td>
                          </tr>
                          <tr>
                            <td colspan="2"><hr><strong>Akun Login SPPG (Otomatis)</strong></td>
                          </tr>
                          <tr>
                            <td>Username SPPG (Otomatis)</td>
                            <td>
                              <input type="text" class="form-control" value="<?= e($sppg_username_preview) ?>" readonly>
                              <small class="text-muted">Otomatis dari nama SPPG: lowercase, spasi jadi underscore</small>
                            </td>
                          </tr>
                          <tr>
                            <td>Password SPPG</td>
                            <td><input type="password" name="sppg_password" class="form-control" placeholder="Minimal 8 karakter" minlength="8" required></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td><button type="submit" name="simpan" value="Simpan" class="btn btn-primary mt-2">Simpan</button></td>
                          </tr>
                        </table>
                      </form>

                      <!--end::Col-->
                      <!--begin::Col-->
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