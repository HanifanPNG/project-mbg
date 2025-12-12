      <main class="app-main">
        <!--begin::App Content Header-->
        <div class="app-content-header">
          <!--begin::Container-->
          <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
              <!--begin::Col-->
              <div class="col-sm-6"><h3 class="mb-0">Tambah Menu</h3></div>
              <!--end::Col-->
              <!--begin::Col-->
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-end">
                  <li class="breadcrumb-item"><a href="#">Home</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Tambah Menu</li>
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
                      <!--begin::Col-->
                     <?php
                      $sppg_id=$_GET['id'];
                      if($_POST['simpanMenu']){
                          $hari=$_POST['hari'];
                          $nama_menu=$_POST['nama_menu'];
                          $image=$_FILES['image']['name'];
                          $tmp = $_FILES['image']['tmp_name'];

                          $dir= "../uploads/";
                          move_uploaded_file($tmp, $dir.$image);

                        require_once "../config.php";
                        $sql="insert into menu_sppg set sppg_id='$sppg_id', hari='$hari', nama_menu='$nama_menu', image='$image'";                   
                        $hasil = $db->query($sql);
                        if($hasil){
                          echo "<div class='alert alert-success'>Data Berhasil Ditambahkan✅</div>";
                        }
                      }
                      ?>

                      <form action="#" method="post" enctype="multipart/form-data">
                        <table>
                          <tr><td>Nama Menu</td><td><input type="text" name="nama_menu" class="form-control" required value="<?=$nama_menu?>"></td></tr>
                          <tr><td>Hari</td><td>
                            <select name="hari" class="form-control" required>
                              <option>--- pilih hari ---</option>
                              <option value="1"<?php if($hari == "1") echo "selected"?>>Senin</option>
                              <option value="2"<?php if($hari == "2") echo "selected"?>>Selasa</option>
                              <option value="3"<?php if($hari == "3") echo "selected"?>>Rabu</option>
                              <option value="4"<?php if($hari == "4") echo "selected"?>>Kamis</option>
                              <option value="5"<?php if($hari == "5") echo "selected"?>>Jumat</option>
                            </select>
                          </td></tr>
                          <tr><td>Foto Menu</td><td><input type="file" name="image" class="form-control" required></td></tr>
                          <tr><td></td><td><button type="submit" name="simpanMenu" value="Simpan" class="btn btn-primary mt-2">Simpan</button></td></tr>
                        </table>
                      </form>
                      <a href="./?p=detail_sppg&id=<?= $sppg_id ?>">
                        <button type="submit" class="btn btn-secondary" value="Kembali">Kembali</button>
                      </a>

                      <!--end::Col-->
                      <!--begin::Col-->
                      <div class="col-md-6"><div id="sidebar-color-code" class="w-100"></div></div>
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