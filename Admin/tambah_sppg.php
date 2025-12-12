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
                    <!--begin::Row-->
                    <div class="row">
                      <!--begin::Col-->
                      <!--end::Col-->
                      <!--begin::Col-->
                      <?php
                      if ($_POST['simpan']) {
                        $nama_sppg = $_POST['nama_sppg'];
                        $alamat = $_POST['alamat'];
                        $gmaps= $_POST['gmaps'];
                        $kota = $_POST['kota'];
                        $jam_buka = $_POST['jam_buka'];
                        $jam_tutup = $_POST['jam_tutup'];

                        require_once "../config.php";
                        $waktu = date("Y-m-d H:i:s");
                        $sql = "insert into sppg set nama_sppg='$nama_sppg', alamat='$alamat', gmaps='$gmaps', kota='$kota' , waktu='$waktu', jam_buka='$jam_buka', jam_tutup='$jam_tutup'";
                        $a = $db->query($sql);
                        if ($a) {
                          echo "<div class='alert alert-success'>SPPG Berhasil Disimpan✅ <br>
                          <a href='./?p=sppg'>Lihat Data</a></div>";
                        }
                      }
                      ?>

                      <form action="#" method="post">
                        <table>
                          <tr>
                            <td>Nama SPPG</td>
                            <td><input type="text" name="nama_sppg" class="form-control" value="<?= $nama_sppg ?>"></td>
                          </tr>
                          <tr>
                            <td valign="top">Alamat</td>
                            <td><textarea name="alamat" class="form-control" style="width: 200px;"><?= $alamat ?></textarea></td>
                          </tr>
                          <tr>
                            <td>Link Google Maps</td>
                            <td>
                              <input type="text" name="gmaps" class="form-control" placeholder="Masukkan link Google Maps">
                            </td>
                          </tr>
                          <tr>
                            <td valign="top">Kabupaten</td>
                            <td><select name="kota" class="form-control">
                                <option>--- pilih kabupaten ---</option>
                                <option value="Purbalingga">Purbalingga</option>
                              </select></td>
                          </tr>
                          <tr>
                            <td>Jam Buka</td>
                            <td>
                              <input type="time" name="jam_buka" class="form-control" value="<?= $jam_buka ?>">
                            </td>
                          </tr>
                          <tr>
                            <td>Jam Tutup</td>
                            <td>
                              <input type="time" name="jam_tutup" class="form-control" value="<?= $jam_tutup ?>">
                            </td>
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