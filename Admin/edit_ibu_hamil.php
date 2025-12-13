      <main class="app-main">
          <!--begin::App Content Header-->
          <div class="app-content-header">
              <!--begin::Container-->
              <div class="container-fluid">
                  <!--begin::Row-->
                  <div class="row">
                      <!--begin::Col-->
                      <div class="col-sm-6">
                          <h3 class="mb-0">Edit Ibu Hamil</h3>
                      </div>
                      <!--end::Col-->
                      <!--begin::Col-->
                      <div class="col-sm-6">
                          <ol class="breadcrumb float-sm-end">
                              <li class="breadcrumb-item"><a href="#">Home</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Edit Ibu Hamil</li>
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

                                            $sql = "select * from ibu_hamil where id='$idx'";
                                            $data = $db->query($sql);
                                            foreach ($data as $d) {
                                                switch($d['klaster']){
                                                    case "1": $klaster="Ibu Hamil"; $t1="selected";break;
                                                    case "2": $klaster="Ibu Menyusui"; $t2="selected";break;
                                                    case "3": $klaster="Balita Non PAUD"; $t3="selected";break;
                                                }
                                                if ($_POST['simpanEdit']) {
                                                    $nama = $_POST['nama_ibu'];
                                                    $klaster = $_POST['klaster'];
                                                    $alamat = $_POST['alamat'];
                                                    
                                                    $sql = "update ibu_hamil set nama_ibu='$nama', klaster='$klaster', alamat='$alamat' WHERE id='$idx'";
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
                                                      <td>Nama</td>
                                                      <td><input type="text" class="form-control" name="nama_ibu" value="<?= $d['nama_ibu'] ?>"></td>
                                                  <tr>
                                                      <td>Klaster</td>
                                                      <td><select name="klaster" class="form-control">
                                                        <option value="1"<?= $t1 ?>>Ibu Hamil</option>
                                                        <option value="2"<?= $t2 ?>>Ibu Menyusui</option>
                                                        <option value="3"<?= $t3 ?>>Balita Non PAUD</option>
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