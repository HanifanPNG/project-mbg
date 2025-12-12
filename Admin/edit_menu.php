      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <!--begin::Col-->
              <div class="col-sm-6">
                <h3 class="mb-0">Edit Menu</h3>
              </div>
              <!--end::Col-->
              <!--begin::Col-->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Edit Menu</li>
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
                        $sppg_id = $_GET['sppg_id'];
                        $idx = $_GET['id'];

                        require_once "../config.php";

                        $sql = "select * from menu_sppg WHERE id='$idx'";
                        $data = $db->query($sql);
                        foreach ($data as $d) {
                          switch ($d['hari']) {
                            case '1': $hari="Senin"; $sen = "selected";break;
                            case '2': $hari="Selasa"; $sel = "selected";break;
                            case '3': $hari="Rabu"; $rab = "selected";break;
                            case '4': $hari="Kamis"; $kam = "selected";break;
                            case '5': $hari="Jum'at"; $jum = "selected";break;
                          }
                        }

                        if ($_POST['simpanEdit']) {
                          $hari = $_POST['hari'];
                          $nama_menu = $_POST['nama_menu'];
                          $deskripsi_menu = $_POST['deskripsi_menu'];

                          if (!empty($_FILES['image']['name'])) {
                            $image = $_FILES['image']['name'];
                            move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $image);
                          } else {
                            $image = $d['image'];
                          }

                          $sql = "update menu_sppg set hari='$hari', nama_menu='$nama_menu', deskripsi_menu='$deskripsi_menu', image='$image' WHERE id='$idx'";
                          $hasil = $db->query($sql);
                          if ($hasil) {
                            echo "<script>window.location='./?p=detail_sppg&id=$sppg_id';</script>";
                          }
                        }
                        ?>
                        
                        <form action="#" method="post" enctype="multipart/form-data">
                          <table class='table table-striped table-hover'>
                            <tr>
                              <td>Hari</td>
                              <td>
                                <select name='hari' class="form-control">
                                  <option value='1' <?= $sen ?>>Senin</option>
                                  <option value='2' <?= $sel ?>>Selasa</option>
                                  <option value='3' <?= $rab ?>>Rabu</option>
                                  <option value='4' <?= $kam ?>>Kamis</option>
                                  <option value='5' <?= $jum ?>>Jumat</option>
                                </select>
                              </td>
                            <tr>
                              <td>Nama Menu</td>
                              <td><input type='text' name='nama_menu' class="form-control" value='<?= $d['nama_menu'] ?>'></td>
                            </tr>
                            <tr>
                              <td>Deskripsi Menu</td>
                              <td><textarea type='text' name='deskripsi_menu' class="form-control" value='<?= $d['deskripsi_menu'] ?>'></textarea></td>
                            </tr>
                            <tr>
                              <td>Foto Menu</td>
                              <td><input type="file" name="image"class="form-control" ></td>
                            </tr>
                            <tr>
                              <td></td>
                              <td><input type='submit' name='simpanEdit' class="form-control" value='Simpan Perubahan' class='btn btn-primary'></td>
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