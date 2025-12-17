<?php
require_once "../config.php";

$keyword = $_POST['keyword'] ?? '';
$pesan = "";
$sql = "SELECT 
        users.id, users.username, users.level, 
        sppg.nama_sppg 
    FROM 
        users
    INNER JOIN 
        sppg ON users.sppg_id = sppg.id
    WHERE 
        users.level = 'user'";

if ($_POST["tombol-cari"]) {
      $sql = "SELECT 
            users.id,
            users.username, 
            sppg.nama_sppg 
        FROM 
            users
        INNER JOIN 
            sppg ON users.sppg_id = sppg.id
        WHERE users.level = 'user' and
            (
                users.username LIKE '%$keyword%' OR 
                sppg.nama_sppg LIKE '%$keyword%'
            )";
    }

$data = $db->query($sql);
$jumlah_data = $data->num_rows;

if (($_POST["tombol-cari"])  && !empty($keyword)) {
  if ($jumlah_data > 0) {
    $pesan = "<p style='color:green;margin-top:8px;'>✅ Data dengan kata kunci <b>$keyword</b> ";
  } else {
    $pesan = "<p style='color:red;margin-top:8px;'>❌ Data dengan kata kunci <b>$keyword</b>.</p>";
  }
}
?> 

<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h3 class="mb-0">Daftar User Login</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Daftar User Login</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <div class="app-content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-lte-toggle="card-collapse">
                  <i data-lte-icon="expand" class="bi bi-plus-lg"></i>
                  <i data-lte-icon="collapse" class="bi bi-dash-lg"></i>
                </button>
              </div>
            </div>

            <div class="card-body">
              <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12">
                  <div class="table-responsive">
                    <form action="#" method="post">
                      <table>
                        <tr>
                          <td>
                          </td>
                          <td width="8"></td>
                          <td><input type="text" placeholder="Masukan kata kunci..." class="form-control w-100" name="keyword" style="width: 200px;" value="<?= $keyword ?>"></td>
                          <td><input type="submit" value="cari" name="tombol-cari"></td>
                        </tr>
                      </table>

                      <!-- pesan hasil pencarian -->
                      <?= $pesan ?>

                      <table class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th>NO</th>
                            <th>Nama User</th>
                            <th>SPPG</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $nomor = 0;
                          if ($jumlah_data > 0) {
                            foreach ($data as $d) {
                              $nomor++;
                              echo "<tr>
                                      <td>$nomor</td>
                                      <td>$d[username]</td>
                                      <td>$d[nama_sppg]</td>
                                      <td>
                                        <a href='./?p=hapus_user&id=$d[id]' class='btn btn-xs btn-danger' onclick=\"return confirm('apakah data akan dihapus?')\"><i class='bi bi-trash3'></i></a>
                                      </td>
                                    </tr>";
                            }
                          } else {
                            echo "<tr><td colspan='6' style='text-align:center;color:gray;'>Tidak ada data yang sesuai</td></tr>";
                          }


                          ?>
                        </tbody>
                      </table>

                    </form>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</main>
