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
                                            $idx = $_GET['id'];
                                            $sppg_id = $_GET['sppg_id'];
                                            require_once "../config.php";

                                            $sql = "select * from sekolah where id='$idx'";
                                            $data = $db->query($sql);
                                            foreach ($data as $d) {
                                                switch($d['jenjang']){
                                                    case "TK": $jenjang="TK"; $tk="selected";break;
                                                    case "SD": $jenjang="SD"; $SD="selected";break;
                                                    case "SMP": $jenjang="SMP"; $SMP="selected";break;
                                                    case "SMA": $jenjang="SMA"; $SMA="selected";break;
                                                }
                                                if ($_POST['simpanEdit']) {
                                                    $nama_sekolah = $_POST['nama_sekolah'];
                                                    $jenjang = $_POST['jenjang'];
                                                    $alamat = $_POST['alamat'];
                                                    
                                                    $sql = "update sekolah set nama_sekolah='$nama_sekolah', jenjang='$jenjang', alamat='$alamat' WHERE id='$idx'";
                                                    $hasil = $db->query($sql);
                                                    if ($hasil) {
                                                        echo "<script>window.location='./?p=detail_sppg&id=$sppg_id';</script>";
                                                    }
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