      <main class="app-main">
          <!--begin::App Content Header-->
          <div class="app-content-header">
              <!--begin::Container-->
              <div class="container-fluid">
                  <!--begin::Row-->
                  <div class="row">
                      <!--begin::Col-->
                      <div class="col-sm-6">
                          <h3 class="mb-0">Edit Sekolah</h3>
                      </div>
                      <!--end::Col-->
                      <!--begin::Col-->
                      <div class="col-sm-6">
                          <ol class="breadcrumb float-sm-end">
                              <li class="breadcrumb-item"><a href="#">Home</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Edit Sekolah</li>
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
                                      <!--begin::Col-->
                                      <!--end::Col-->
                                      <div class="col-lg-6">
                                            <?php
                                                require_once "../config.php";
                                                require_once "../lib/db_helper.php";
                                                $idx = (int)($_GET['id'] ?? 0);
                                                $sppg_id = (int)($_GET['sppg_id'] ?? 0);
                                                $res = db_query("SELECT * FROM sekolah WHERE id=?", "i", $idx);
                                                $d = $res ? $res->fetch_assoc() : [];
                                                $jenjang = $d['jenjang'] ?? '';
                                                $tk = $jenjang == 'TK' ? "selected" : '';
                                                $SD = $jenjang == 'SD' ? "selected" : '';
                                                $SMP = $jenjang == 'SMP' ? "selected" : '';
                                                $SMA = $jenjang == 'SMA' ? "selected" : '';
                                                if ($_POST['simpanEdit']) {
                                                    $nama_sekolah = $_POST['nama_sekolah'];
                                                    $jenjang = $_POST['jenjang'];
                                                    $alamat = $_POST['alamat'];
                                                    $ok = db_exec(
                                                        "UPDATE sekolah SET nama_sekolah=?, jenjang=?, alamat=? WHERE id=?",
                                                        "sssi",
                                                        $nama_sekolah, $jenjang, $alamat, $idx
                                                    );
                                                    if ($ok) {
                                                        echo "<script>window.location='./?p=detail_sppg&id=$sppg_id';</script>";
                                                    }
                                                }
                                                ?>


                                          <form action="#" method="post" enctype="multipart/form-data">
                                              <table class='table table-striped table-hover'>
                                                  <tr>
                                                      <td>Nama Sekolah</td>
                                                      <td><input type="text" class="form-control" name="nama_sekolah" value="<?= $d['nama_sekolah'] ?>"></td>
                                                  <tr>
                                                      <td>Jenjang Pendidikan</td>
                                                      <td><select name="jenjang" class="form-control">
                                                        <option value="TK"<?= $tk ?>>TK</option>
                                                        <option value="SD"<?= $SD ?>>SD</option>
                                                        <option value="SMP"<?= $SMP ?>>SMP</option>
                                                        <option value="SMA"<?= $SMA ?>>SMA</option>
                                                      </select></td>
                                                  </tr>
                                                  <tr>
                                                      <td>Alamat</td>
                                                      <td><input type='text' class="form-control" name='alamat' value='<?= $d['alamat'] ?>'></td>
                                                  </tr>
                                                  <tr>
                                                      <td></td>
                                                      <td><input type='submit' name='simpanEdit' value='Simpan Perubahan' class='btn btn-primary'></td>
                                                  </tr>
                                              </table>
                                          </form>

                                      </div>
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