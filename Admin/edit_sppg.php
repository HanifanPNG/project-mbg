      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <!--begin::Col-->
              <div class="col-sm-6">
                <h3 class="mb-0"></h3>
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
                          $idx = $_GET['id'];
                          require_once "../config.php";

                          $sql = "SELECT * FROM sppg WHERE id='$idx'";
                          $data = $db->query($sql);

                          // Jika tombol simpan ditekan
                          foreach ($data as $d) {
                            if ($_POST['simpanEdit']) {
                              $nama_sppg = $_POST['nama_sppg'];
                              $alamat = $_POST['alamat'];
                              $gmaps = $_POST['gmaps'];
                              $kota = $_POST['kota'];
                              $jam_buka = $_POST['jam_buka'];
                              $jam_tutup = $_POST['jam_tutup'];

                              $sql = "UPDATE sppg SET nama_sppg='$nama_sppg', alamat='$alamat', gmaps='$gmaps', kota='$kota', jam_buka='$jam_buka', jam_tutup='$jam_tutup' WHERE id='$idx'";
                              $hasil = $db->query($sql);
                              if ($hasil) {
                                echo "<div class='alert alert-success'>Berhasil di ubah</div>";
                              }
                            }
                          }
                          ?>

                          <form action="#" method="post">
                            <table class='table table-striped table-hover'>
                              <tr>
                                <td>Nama SPPG</td>
                                <td><input type='text' name='nama_sppg' class="form-control" value='<?= $d['nama_sppg'] ?>'></td>
                              </tr>
                              <tr>
                                <td>Alamat</td>
                                <td><textarea name='alamat' class="form-control" ><?= $d['alamat'] ?></textarea></td>
                              </tr>
                              <tr>
                                <td>Link Google Maps</td>
                                <td><textarea name='gmaps' class="form-control" ><?= $d['gmaps'] ?></textarea></td>
                              </tr>
                              <tr>
                                <td>Kota</td>
                                <td><input type='text' name='kota' class="form-control" value='<?= $d['kota'] ?>'></td>
                              </tr>
                              <tr>
                                <td>Jam Buka</td>
                                <td><input type='time' name='jam_buka' class="form-control" value='<?= $d['jam_buka'] ?>'></td>
                              </tr>
                              <tr>
                                <td>Jam Tutup</td>
                                <td><input type='time' name='jam_tutup' class="form-control" value='<?= $d['jam_tutup'] ?>'></td>
                              </tr>
                              <tr>
                                <td></td>
                                <td><input type='submit' name='simpanEdit' value='Simpan Perubahan' class='btn btn-primary'></td>
                              </tr>
                            </table>
                          </form>
                          <a href="./?p=sppg">
                            <input type="submit" class="btn btn-primary" value="kembali">
                          </a>

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