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
              <div class="card-tools float-end">
                <button onclick="cetakInformasiSaja()" class="btn btn-success">
                  <i class="bi bi-printer"></i> Cetak Informasi SPPG
                </button>
              </div>
              <h4>Informasi SPPG</h4>
            </div>
            <!--end::Card Header-->
            <!--begin::Card Body-->
            <div class="card-body" id="areaCetak">
              <!--begin::Row-->
              <div class="row">
                <!--begin::Col-->
                <!--end::Col-->
                <!--begin::Col-->
                <?php
                $idx = $_GET['id'];
                require_once "../config.php";
                $sql = "select * from sppg where id='$idx'"; // informasi sppg
                $sqlMenu = "select * from menu_sppg where sppg_id = '$idx' order by tanggal ASC, hari ASC"; // menu sppg
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
                             <div class='d-flex justify-content-between align-items-center my-2'>
              <h4>Menu Harian</h4>
              <button onclick='cetakMenuHarian()' class='btn btn-info text-white'>
                  <i class='bi bi-calendar-event'></i> Cetak Menu Harian
              </button>
          </div> 
                              ";
                }
                ?>
                <!-- Menu -->
                <table class="table table-bordered table-hover">
                  <tr>
                    <th>Hari</th>
                    <th>Nama Menu</th>
                    <th>Deskripsi Menu</th>
                    <th>Foto</th>
                  </tr>

                  <?php
                  $lasttanggal = null;
                  if ($dataMenu->num_rows > 0) {
                    foreach ($dataMenu as $m) {
                      if ($lasttanggal !== $m['tanggal']) {
                        $hariIndo = [
                          'Monday'    => 'Senin',
                          'Tuesday'   => 'Selasa',
                          'Wednesday' => 'Rabu',
                          'Thursday'  => 'Kamis',
                          'Friday'    => 'Jumat',
                        ];
                        $h = $hariIndo[date('l', strtotime($m['tanggal']))];
                        echo "
                        <tr class='bg-green-100'>
                            <td colspan='4' class='px-6 py-3 font-bold text-green-800'>
                               Dibuat :  📅 $h, " . date('d M Y', strtotime($m['tanggal'])) . "
                            </td>
                        </tr>
                        ";
                        $lasttanggal = $m['tanggal'];
                      }
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
                      </tr>
                    <?php }
                  } else { ?>
                    <tr>
                      <td colspan="5" style="text-align:center;">Belum ada menu</td>
                    </tr>
                  <?php } ?>
                </table>
                <!-- sekolah -->
                <div class='d-flex justify-content-between align-items-center '>
                  <h4>Daftar Penerima MBG</h4>
                  <button onclick='cetakDaftarPenerima()' class='btn btn-success'>
                    <i class='bi bi-printer'></i> Cetak Daftar Penerima
                  </button>
                </div>
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
                <div class='d-flex justify-content-between align-items-center my-2  '>
                  <h4>Komentar & Rating</h4>
                  <button onclick='cetakKomentar()' class='btn btn-secondary'>
                    <i class='bi bi-printer'></i> Cetak Komentar
                  </button>
                </div>
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

<script>
  function cetakInformasiSaja() {
    // Mengambil area cetak
    var areaCetak = document.getElementById('areaCetak');

    // Mencari tabel pertama saja (Informasi SPPG)
    var tabelInfo = areaCetak.getElementsByTagName('table')[0].outerHTML;
    var judulInfo = "<h4>Informasi SPPG</h4>";

    var jendelaCetak = window.open('', '_blank', 'height=600,width=800');

    jendelaCetak.document.write('<html><head><title>Cetak Informasi SPPG</title>');
    jendelaCetak.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
    jendelaCetak.document.write('<style>');
    // Paksa browser menampilkan gambar dan warna latar belakang
    jendelaCetak.document.write('body { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; padding: 30px; }');
    jendelaCetak.document.write('table { width: 100%; margin-top: 20px; border: 1px solid #000; }');
    // Sembunyikan tombol "Lihat Lokasi" agar lebih rapi di kertas
    jendelaCetak.document.write('.btn, .no-print { display: none !important; }');
    jendelaCetak.document.write('</style></head><body>');
    jendelaCetak.document.write('<h2 class="text-center">LAPORAN SPPG</h2><hr>');
    jendelaCetak.document.write(judulInfo);
    jendelaCetak.document.write(tabelInfo); // Hanya memasukkan tabel informasi
    jendelaCetak.document.write('</body></html>');

    jendelaCetak.document.close();

    setTimeout(function() {
      jendelaCetak.print();
      jendelaCetak.close();
    }, 750);
  }
</script>
<script>
  function cetakMenuHarian() {
    var areaCetak = document.getElementById('areaCetak');

    // Berdasarkan kode Anda, tabel Menu Harian adalah tabel kedua (indeks 1)
    var daftarTabel = areaCetak.getElementsByTagName('table');

    if (daftarTabel.length < 2) {
      alert("Data menu tidak ditemukan!");
      return;
    }

    var tabelMenu = daftarTabel[1].outerHTML;
    var judul = "<h3>LAPORAN MENU HARIAN SPPG</h3>";

    var jendelaCetak = window.open('', '_blank', 'height=700,width=900');

    jendelaCetak.document.write('<html><head><title>Cetak Menu Harian</title>');
    jendelaCetak.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
    jendelaCetak.document.write('<style>');
    // CSS agar gambar muncul dan layout rapi
    jendelaCetak.document.write(`
        body { 
            -webkit-print-color-adjust: exact !important; 
            print-color-adjust: exact !important; 
            padding: 40px; 
            font-family: sans-serif; 
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999 !important; padding: 12px; text-align: left; }
        th { background-color: #f8f9fa !important; }
        .bg-green-100 { background-color: #d1e7dd !important; } /* Warna baris tanggal */
        img { max-width: 150px; height: auto; border-radius: 5px; }
    `);
    jendelaCetak.document.write('</style></head><body>');
    jendelaCetak.document.write('<div class="text-center">' + judul + '</div><hr>');
    jendelaCetak.document.write(tabelMenu);
    jendelaCetak.document.write('</body></html>');

    jendelaCetak.document.close();

    // Memberikan waktu agar gambar di-load sebelum window print muncul
    setTimeout(function() {
      jendelaCetak.focus();
      jendelaCetak.print();
      jendelaCetak.close();
    }, 1000);
  }

  function cetakDaftarPenerima() {
    var areaCetak = document.getElementById('areaCetak');
    var daftarTabel = areaCetak.getElementsByTagName('table');


    if (daftarTabel.length < 4) {
      alert("Data penerima tidak lengkap!");
      return;
    }

    var tabelSekolah = daftarTabel[2].outerHTML;
    var tabelKlaster = daftarTabel[3].outerHTML;

    var jendelaCetak = window.open('', '_blank', 'height=700,width=900');

    jendelaCetak.document.write('<html><head><title>Cetak Daftar Penerima MBG</title>');
    jendelaCetak.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
    jendelaCetak.document.write('<style>');
    jendelaCetak.document.write(`
        body { 
            -webkit-print-color-adjust: exact !important; 
            print-color-adjust: exact !important; 
            padding: 40px; 
            font-family: sans-serif; 
        }
        h4 { margin-top: 30px; border-bottom: 2px solid #333; padding-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; margin-bottom: 20px; }
        th, td { border: 1px solid #999 !important; padding: 10px; text-align: left; font-size: 12px; }
        th { background-color: #f8f9fa !important; }
        .btn, .bi, td:last-child, th:last-child { display: none !important; } /* Sembunyikan kolom AKSI */
    `);
    jendelaCetak.document.write('</style></head><body>');
    jendelaCetak.document.write('<div class="text-center"><h2>DAFTAR PENERIMA MAKAN BERGIZI GRATIS (MBG)</h2></div><hr>');

    jendelaCetak.document.write('<h4>1. Daftar Sekolah</h4>');
    jendelaCetak.document.write(tabelSekolah);

    jendelaCetak.document.write('<h4>2. Daftar Kelompok 3B (Ibu Hamil, Menyusui, Balita)</h4>');
    jendelaCetak.document.write(tabelKlaster);

    jendelaCetak.document.write('</body></html>');

    jendelaCetak.document.close();

    setTimeout(function() {
      jendelaCetak.focus();
      jendelaCetak.print();
      jendelaCetak.close();
    }, 750);
  }

  function cetakKomentar() {
    var areaCetak = document.getElementById('areaCetak');
    var daftarTabel = areaCetak.getElementsByTagName('table');


    if (daftarTabel.length < 5) {
        alert("Data komentar tidak ditemukan!");
        return;
    }

    var tabelKomentar = daftarTabel[4].outerHTML;
    var judul = "<h3>LAPORAN KOMENTAR DAN RATING SPPG</h3>";

    var jendelaCetak = window.open('', '_blank', 'height=700,width=900');

    jendelaCetak.document.write('<html><head><title>Cetak Komentar</title>');
    jendelaCetak.document.write('<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">');
    jendelaCetak.document.write('<style>');
    jendelaCetak.document.write(`
        body { 
            -webkit-print-color-adjust: exact !important; 
            print-color-adjust: exact !important; 
            padding: 40px; 
            font-family: sans-serif; 
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #999 !important; padding: 12px; text-align: left; }
        th { background-color: #f8f9fa !important; }
        /* Sembunyikan kolom AKSI (tombol hapus) dan ikon sampah saat cetak */
        td:last-child, th:last-child, .btn, .bi-trash3 { display: none !important; }
    `);
    jendelaCetak.document.write('</style></head><body>');
    jendelaCetak.document.write('<div class="text-center">' + judul + '</div><hr>');
    jendelaCetak.document.write(tabelKomentar);
    jendelaCetak.document.write('</body></html>');

    jendelaCetak.document.close();

    setTimeout(function() {
        jendelaCetak.focus();
        jendelaCetak.print();
        jendelaCetak.close();
    }, 750);
}
</script>