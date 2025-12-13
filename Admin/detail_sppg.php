<main class="app-main">
  <!--begin::App Content Header-->
  <div class="app-content-header">
    <!--begin::Container-->
    <div class="container-fluid">
      <!--begin::Row-->
      <div class="row">
        <!--begin::Col-->
        <div class="col-sm-6">
          <h3 class="mb-0">Detail SPPG</h3>
        </div>
        <!--end::Col-->
        <!--begin::Col-->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Detail SPPG</li>
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
              <h4>Informasi SPPG</h4>
              <!--end::Card Title-->
              <!--begin::Card Toolbar-->
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
                $idx = $_GET['id'];
                require_once "../config.php";
                $sql = "select * from sppg where id='$idx'"; // informasi sppg
                $sqlMenu = "select * from menu_sppg where sppg_id = '$idx' order by hari ASC"; // menu sppg
                $sqlSek = "select * from sekolah where sppg_id = '$idx'"; // sekolah penerima
                $sqlIbu = "select * from ibu_hamil where sppg_id = '$idx'";
                $sqlBalita = "select * from balita where sppg_id = '$idx'";
                $sqlRating = "
SELECT 
  sr.id,
  sr.komentar,
  sr.rating,
  sr.tanggal,
  u.username AS nama
FROM sppg_rating sr
LEFT JOIN users u ON sr.user_id = u.id
WHERE sr.sppg_id = '$idx'
ORDER BY sr.tanggal DESC
"; //komentar & rating

                $dataMenu = $db->query($sqlMenu);
                $dataSekolah = $db->query($sqlSek);
                $dataIbu = $db->query($sqlIbu);
                $dataBalita = $db->query($sqlBalita);
                $dataRating = $db->query($sqlRating);
                $data = $db->query($sql);
                foreach ($data as $d) {
                  echo "<table border=1 class='table table-striped table-bordered table-hover'>
                              <tr><td>Nama SPPG</td><td> $d[nama_sppg]</td></tr>
                              <tr><td>Alamat</td><td> $d[alamat]</td></tr>
                              <tr><td>Lihat Lokasi</td>                                      <td>
                                        <a href='$d[gmaps]' target='_blank' class='btn btn-sm btn-primary'>
                                          Lihat Lokasi
                                        </a>
                                      </td></tr>
                              <tr><td>Kota</td><td> $d[kota]</td></tr>
                              <tr><td>Jam Buka</td><td> $d[jam_buka]</td></tr>
                              <tr><td>Jam Tutup</td><td> $d[jam_tutup]</td></tr>  
                             </table>
                             <h4>Menu Harian</h4> 
                              <a href='./?p=tambah_menu&id=$d[id]'>
                              <button type='submit' class='btn btn-primary my-1'><i class='bi bi-plus-circle'></i> Tambah Menu</button>
                            </a>";
                }
                ?>
                <!-- Menu -->
                <table class="table table-bordered table-hover">
                  <tr>
                    <th>Hari</th>
                    <th>Nama Menu</th>
                    <th>Deskripsi Menu</th>
                    <th>Foto</th>
                    <th>Aksi</th>
                  </tr>

                  <?php
                  if ($dataMenu->num_rows > 0) {
                    foreach ($dataMenu as $m) {
                      if ($m['hari'] == 1) {
                        $hari = "Senin";
                      } elseif ($m['hari'] == 2) {
                        $hari = "Selasa";
                      } elseif ($m['hari'] == 3) {
                        $hari = "Rabu";
                      } elseif ($m['hari'] == 4) {
                        $hari = "Kamis";
                      } elseif ($m['hari'] == 5) {
                        $hari = "Jumat";
                      }
                  ?>
                      <tr>
                        <td><?= $hari ?></td>
                        <td><?= $m['nama_menu'] ?></td>
                        <td><?= $m['deskripsi_menu'] ?></td>
                        <td>
                          <?php if ($m['image']) { ?>
                            <img src="../uploads/<?= $m['image'] ?>" width="100">
                          <?php } else {
                            echo "-";
                          } ?>
                        </td>
                        <td>
                          <a href="./?p=edit_menu&id=<?= $m['id'] ?>&sppg_id=<?= $d['id'] ?>"><i class="bi bi-pencil btn btn-warning"></i></a>
                          <a href="./?p=hapus_menu&id=<?= $m['id'] ?>&sppg_id=<?= $d['id'] ?>"><i class="bi bi-trash3 btn btn-danger"></i></a>
                        </td>
                      </tr>
                    <?php }
                  } else { ?>
                    <tr>
                      <td colspan="5" style="text-align:center;">Belum ada menu</td>
                    </tr>
                  <?php } ?>
                </table>
                <!-- sekolah -->
                <h4>Daftar Penerima MBG</h4>
                <div class="d-flex gap-2">
                  <a href='./?p=tambah_sekolah&id=<?= $idx ?>'>
                    <button type='submit' class='btn btn-primary my-1'><i class='bi bi-plus-circle'></i> Tambah Sekolah</button>
                  </a>
                  <a href='./?p=tambah_klaster&id=<?= $idx ?>'>
                    <button type='submit' class='btn btn-primary my-1'><i class='bi bi-plus-circle'></i> Tambah Kelompok 3B</button>
                  </a>
                </div>
                <table class="table table-striped table-bordered table-hover">
                  <tr>
                    <th>No</th>
                    <th>Nama Sekolah</th>
                    <th>Jenjang Pendidikan</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                  </tr>
                  <?php
                  $no = 0;
                  if ($dataSekolah->num_rows > 0) {
                    foreach ($dataSekolah as $ds) {
                      $no++;
                      echo "<tr>
                                <td>$no</td>
                                <td>{$ds['nama_sekolah']}</td>
                                <td>{$ds['jenjang']}</td>
                                <td>{$ds['alamat']}</td>
                                <td>
                                  <a href='./?p=edit_sekolah&id=$ds[id]&sppg_id=$d[id]'><i class='bi bi-pencil btn btn-warning'></i></a>
                                  <a href='./?p=hapus_sekolah&id=$ds[id]&sppg_id=$d[id]'><i class='bi bi-trash3 btn btn-danger'></i></a>
                                </td>
                              </tr>";
                    }
                  } else {
                    echo "<p>Tidak ada sekolah pada SPPG ini.</p>";
                  }
                  ?>
                </table>

                <!-- Klaster 3B -->
                <table class="table table-striped table-bordered table-hover">
                  <tr>
                    <th>No</th>
                    <th>Nama </th>
                    <th>Klaster</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                  </tr>
                  <?php
                  $no = 0;
                  if ($dataIbu->num_rows > 0) {
                    foreach ($dataIbu as $di) {
                      $no++;
                        if ($di['klaster'] == 1) {
                          $klaster = "Ibu Hamil";
                        } elseif ($di['klaster'] == 2) {
                          $klaster = "Ibu Menyusui";
                        } elseif ($di['klaster'] == 3) {
                          $klaster = "Balita Non PAUD";
                        } else {
                          $klaster = "klaster Tidak Diketahui";
                        }
                      echo "<tr>
                                <td>$no</td>
                                <td>{$di['nama_ibu']}</td>
                                <td>$klaster</td>
                                <td>{$di['alamat']}</td>
                                <td>
                                  <a href='./?p=edit_ibu_hamil&id=$di[id]&sppg_id=$d[id]'><i class='bi bi-pencil btn btn-warning'></i></a>
                                  <a href='./?p=hapus_ibu_hamil&id=$di[id]&sppg_id=$d[id]'><i class='bi bi-trash3 btn btn-danger'></i></a>
                                </td>
                              </tr>";
                    }
                  } else {
                    echo "<p>Tidak ada ibu hamil pada SPPG ini.</p>";
                  }
                  ?>
                </table>

                <!-- Komentar -->
                <h4>Komentar</h4>
                <table class="table table-striped table-bordered">
                  <tr>
                    <th>Nama</th>
                    <th>Komentar</th>
                    <th>Rating</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                  </tr>
                  <?php
                  if ($dataRating->num_rows > 0) {
                    foreach ($dataRating as $dr) {
                      echo "
                                <tr>
                                    <td>$dr[nama]</td>
                                    <td>$dr[komentar]</td>
                                    <td>$dr[rating] / 5</td>
                                    <td>$dr[tanggal]</td>
                                    <td>
                                      <a href='./?p=hapus_komentar&id=$dr[id]&sppg_id=$d[id]'>
                                        <button class='btn btn-danger'><i class='bi bi-trash3'></i></button>
                                      </a>
                                </tr>";
                    }
                  } else {
                    echo "<p>Tidak ada komentar pada SPPG ini.</p>";
                  }
                  ?>
                </table>
                <!-- back -->
                <a href="./?p=sppg">
                  <input type="submit" class="btn btn-primary" value="kembali">
                </a>
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