<?php
require_once "../config.php";
require_once "../lib/db_helper.php";
require_once "../lib/validation.php";

$keyword = v_string($_POST['keyword'] ?? '', 255);

$sql = "SELECT sppg.*, u.username as sppg_username 
        FROM sppg 
        LEFT JOIN users u ON u.sppg_id = sppg.id AND u.level = 'sppg'";
$params = [];
$types = "";

if (isset($_POST["tombol-cari"]) && !empty($keyword)) {
    $sql .= " WHERE sppg.nama_sppg LIKE ?";
    $params[] = "%$keyword%";
    $types .= "s";
}

$stmt = $db->prepare($sql);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$data = $stmt->get_result();
$jumlah_data = $data->num_rows;

$pesan = "";
if (isset($_POST["tombol-cari"]) && !empty($keyword)) {
    if ($jumlah_data > 0) {
        $pesan = "<p style='color:green;margin-top:8px;'>✅ Data dengan kata kunci <b>" . e($keyword) . "</b> </p>";
    } else {
        $pesan = "<p style='color:red;margin-top:8px;'>❌ Data dengan kata kunci <b>" . e($keyword) . "</b>.</p>";
    }
}
?>
<main class="app-main">
  <div class="app-content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-sm-6">
          <h3 class="mb-0">Daftar Satuan Program Pelayanan Gizi</h3>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-end">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Daftar SPPG</li>
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
                            <a href="./?p=tambah_sppg">
                              <div class="bg-primary d-inline-block p-1 rounded-2 text-white cursor-pointer">
                                Tambah SPPG
                              </div>
                            </a>
                          </td>
                          <td width="8"></td>
                          <td><input type="text" placeholder="Masukan kata kunci..." class="form-control w-100" name="keyword" style="width: 200px;" value="<?= e($keyword) ?>"></td>
                          <td><input type="submit" value="cari" name="tombol-cari"></td>
                        </tr>
                      </table>

                      <!-- pesan hasil pencarian -->
                      <?= $pesan ?>

                      <table class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th>NO</th>
                            <th>Nama SPPG</th>
                            <th>Alamat</th>
                            <th>Lihat Lokasi</th>
                            <th>Kabupaten</th>
                            <th>Jam Buka</th>
                            <th>Jam Tutup</th>
                            <th>Akun Login</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $nomor = 0;
                          if ($jumlah_data > 0) {
                            foreach ($data as $d) {
                              $nomor++;
                              $sppg_username = $d['sppg_username'] ?? '';
                              if ($sppg_username) {
                                  $akun_info = "<span class='badge bg-success'>" . e($sppg_username) . "</span>
                                  <a href='./?p=edit_sppg&id=" . $d['id'] . "' class='btn btn-xs btn-warning mt-1' title='Reset Password'>
                                    <i class='bi bi-key'></i> Reset Password
                                  </a>";
                              } else {
                                  $akun_info = "<span class='badge bg-warning text-dark'>Belum ada akun</span>
                                  <a href='./?p=edit_sppg&id=" . $d['id'] . "' class='btn btn-xs btn-success mt-1' title='Buat Akun SPPG'>
                                    <i class='bi bi-person-plus'></i> Buat Akun
                                  </a>";
                              }
                              echo "<tr>
                                      <td>$nomor</td>
                                      <td>" . e($d['nama_sppg']) . "</td>
                                      <td>" . e($d['alamat']) . "</td>
                                      <td>
                                        <a href='" . e($d['gmaps']) . "' target='_blank' class='btn btn-sm btn-primary'>
                                          Lihat Lokasi
                                        </a>
                                      </td>
                                      <td>" . e($d['kota']) . "</td>
                                      <td>" . e($d['jam_buka']) . "</td>
                                      <td>" . e($d['jam_tutup']) . "</td>
                                      <td>$akun_info</td>
                                      <td>
                                        <a href='./?p=detail_sppg&id=" . $d['id'] . "' class='btn btn-xs btn-info'><i class='bi bi-eye'></i></a>
                                        <a href='./?p=edit_sppg&id=" . $d['id'] . "' class='btn btn-xs btn-warning'><i class='bi bi-pencil'></i></a>
                                        <a href='./?p=hapus_sppg&id=" . $d['id'] . "' class='btn btn-xs btn-danger' onclick=\"return confirm('apakah data akan dihapus?')\"><i class='bi bi-trash3'></i></a>
                                      </td>
                                    </tr>";
                            }
                          } else {
                            echo "<tr><td colspan='8' style='text-align:center;color:gray;'>Tidak ada data yang sesuai</td></tr>";
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