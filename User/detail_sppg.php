<?php

/*******************************************************
 * MBG Sistem — Detail SPPG (AdminLTE)
 * File: pages/detail_sppg.php
 * Requirements:
 * - Session keys: $_SESSION['isLogin'] true/false (optional gating)
 * - DB config: require_once "../config.php"; exposes $db (mysqli)
 * - Tables:
 * sppg(id, nama_sppg, alamat, kota, jam_buka, jam_tutup, waktu)
 * sekolah(id, sppg_id, nama_sekolah, jenjang, alamat)
 * menu_sppg(id, sppg_id, hari, nama_menu, image)
 * sppg_rating(id, sppg_id, nama, komentar, rating, tanggal DEFAULT CURRENT_TIMESTAMP)
 *******************************************************/
session_start();

// Gate (if you want to require login; otherwise you can comment this out)
if (isset($_SESSION['isLogin']) && $_SESSION['isLogin'] === false) {
    header("Location: ../logout.php");
    exit;
}

require_once "../config.php"; // mysqli $db

function h($s)
{
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}
function csrfToken()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}
function checkCsrf($token)
{
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token ?? '');
}

// Get SPPG id
$id = (int)($_GET['id'] ?? 0);
if ($id <= 0) {
    http_response_code(400);
    die("SPPG tidak valid.");
}

// Handle add rating (POST to same page)
$errors = [];
$success = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'add_rating') {
    $token = $_POST['csrf_token'] ?? '';
    $nama = trim($_POST['nama'] ?? ($_SESSION['username'] ?? 'Pengguna'));
    $komentar = trim($_POST['komentar'] ?? '');
    $rating = (int)($_POST['rating'] ?? 0);
    $sppg_id = (int)($_POST['sppg_id'] ?? 0);

    if (!checkCsrf($token)) {
        $errors[] = "CSRF token tidak valid. Muat ulang halaman dan coba lagi.";
    }
    if ($sppg_id !== $id) {
        $errors[] = "SPPG tidak sesuai.";
    }
    if ($nama === "" || strlen($nama) < 2) {
        $errors[] = "Nama minimal 2 karakter.";
    }
    if ($komentar === "" || strlen($komentar) < 3) {
        $errors[] = "Komentar minimal 3 karakter.";
    }
    if ($rating < 1 || $rating > 5) {
        $errors[] = "Rating harus antara 1-5.";
    }

    if (empty($errors)) {
        $stmt = $db->prepare("INSERT INTO sppg_rating (sppg_id, nama, komentar, rating) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("issi", $sppg_id, $nama, $komentar, $rating);
        if ($stmt->execute()) {
            $success = "Terima kasih! Rating Anda telah disimpan.";
        } else {
            $errors[] = "Gagal menyimpan rating.";
        }
        $stmt->close();
    }
}

// Fetch SPPG
$sppg = null;
$stmt = $db->prepare("SELECT id, nama_sppg, alamat, kota, jam_buka, jam_tutup, waktu FROM sppg WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
$sppg = $res ? $res->fetch_assoc() : null;
$stmt->close();
if (!$sppg) {
    http_response_code(404);
    die("SPPG tidak ditemukan.");
}

// Fetch sekolah
$schools = [];
$stmt = $db->prepare("SELECT nama_sekolah, jenjang, alamat FROM sekolah WHERE sppg_id = ? ORDER BY id ASC");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
while ($r = $res->fetch_assoc()) {
    $schools[] = $r;
}
$stmt->close();

// Fetch menu
$menus = [];
$stmt = $db->prepare("SELECT hari, nama_menu, image FROM menu_sppg WHERE sppg_id = ? ORDER BY hari ASC, id ASC");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
while ($r = $res->fetch_assoc()) {
    $menus[] = $r;
}
$stmt->close();

// Fetch ratings
$ratings = [];
$stmt = $db->prepare("SELECT nama, komentar, rating, tanggal FROM sppg_rating WHERE sppg_id = ? ORDER BY tanggal DESC, id DESC");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
while ($r = $res->fetch_assoc()) {
    $ratings[] = $r;
}
$stmt->close();

// Average rating
$avg = 0.0;
$cnt = count($ratings);
if ($cnt > 0) {
    $sum = 0;
    foreach ($ratings as $rt) {
        $sum += (int)$rt['rating'];
    }
    $avg = round($sum / $cnt, 2);
}

// CSRF for forms
$csrf = csrfToken();

// Map hari (int) to label
function hariLabel($h)
{
    // Assuming 1..7 mapping; customize if your data uses a different convention
    $map = [
        1 => 'Senin',
        2 => 'Selasa',
        3 => 'Rabu',
        4 => 'Kamis',
        5 => 'Jumat',
        6 => 'Sabtu',
        7 => 'Minggu'
    ];
    return $map[$h] ?? (string)$h;
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Detail SPPG — <?= h($sppg['nama_sppg']) ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- AdminLTE & dependencies via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        .table td,
        .table th {
            vertical-align: middle;
        }

        .small-text {
            font-size: .9rem;
            color: #6c757d;
        }

        .rating-stars .fa-star {
            color: #ffc107;
        }

        .menu-img {
            height: 56px;
            border-radius: 6px;
        }

        .badge-open {
            background: #28a745;
        }

        .badge-closed {
            background: #dc3545;
        }
    </style>
</head>

<body class="hold-transition layout-top-nav">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a></li>
                <li class="nav-item d-none d-sm-inline-block"><a href="../User/index.php" class="nav-link">Beranda</a></li>
                <li class="nav-item d-none d-sm-inline-block"><a href="#" class="nav-link active">Detail</a></li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a href="../logout.php" class="btn btn-outline-secondary btn-sm"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </nav>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Header -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Detail SPPG</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="../pages/user.php">Home</a></li>
                                <li class="breadcrumb-item active"><?= h($sppg['nama_sppg']) ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Alerts -->
            <section class="content">
                <div class="container-fluid">
                    <?php if (!empty($errors)): ?>
                        <div class="alert alert-danger alert-dismissible">
                            <h5><i class="icon fas fa-ban"></i> Error!</h5>
                            <?= nl2br(h(implode("\n", $errors))) ?>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    <?php endif; ?>
                    <?php if ($success !== ""): ?>
                        <div class="alert alert-success alert-dismissible">
                            <h5><i class="icon fas fa-check"></i> Sukses!</h5>
                            <?= h($success) ?>
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                        </div>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <!-- SPPG info -->
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h3 class="card-title"><i class="fas fa-store"></i> <?= h($sppg['nama_sppg']) ?></h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <p><strong>Alamat:</strong> <?= h($sppg['alamat']) ?></p>
                                    <p><strong>Kota:</strong> <?= h($sppg['kota']) ?></p>
                                    <p><strong>Jam Operasional:</strong> <?= h($sppg['jam_buka']) ?> — <?= h($sppg['jam_tutup']) ?></p>
                                    <p><strong>Waktu Input:</strong> <?= h($sppg['waktu']) ?></p>
                                    <?php
                                    // Open now badge (server-side check)
                                    $openBadge = '';
                                    if (!empty($sppg['jam_buka']) && !empty($sppg['jam_tutup'])) {
                                        // Compare using MySQL TIME: we’ll do quick PHP comparison
                                        $now = date('H:i:s');
                                        if ($sppg['jam_buka'] <= $now && $now <= $sppg['jam_tutup']) {
                                            $openBadge = '<span class="badge badge-open">Buka sekarang</span>';
                                        } else {
                                            $openBadge = '<span class="badge badge-closed">Tutup</span>';
                                        }
                                    }
                                    echo $openBadge ? "<p><strong>Status:</strong> $openBadge</p>" : "";
                                    ?>

                                </div>
                                <div class="col-lg-4">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center">
                                                <div><strong>Rata-rata Rating</strong></div>
                                                <div class="badge badge-warning"><?= $avg ?>/5</div>
                                            </div>
                                            <canvas id="ratingAvgChart" style="max-height:160px;"></canvas>
                                            <p class="small-text mb-0 mt-2">Jumlah ulasan: <?= (int)$cnt ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Schools -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-school"></i> Sekolah Terkait</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nama Sekolah</th>
                                            <th>Jenjang</th>
                                            <th>Alamat</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($schools as $sc): ?>
                                            <tr>
                                                <td><?= h($sc['nama_sekolah']) ?></td>
                                                <td><?= h($sc['jenjang']) ?></td>
                                                <td><?= h($sc['alamat']) ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if (empty($schools)): ?>
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">Tidak ada data sekolah.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <p class="small-text mb-0">Data sekolah ditautkan dengan SPPG ini.</p>
                        </div>
                    </div>

                    <!-- Menus -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title"><i class="fas fa-utensils"></i> Menu Harian</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>Hari</th>
                                            <th>Nama Menu</th>
                                            <th>Gambar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($menus as $mn): ?>
                                            <tr>
                                                <td><?= h(hariLabel((int)$mn['hari'])) ?></td>
                                                <td><?= h($mn['nama_menu']) ?></td>
                                                <td>
                                                    <?php if (!empty($mn['image'])): ?>
                                                        <img src="../uploads/<?= h($mn['image']) ?>" alt="menu" class="menu-img">
                                                    <?php else: ?>
                                                        <span class="text-muted">—</span>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                        <?php if (empty($menus)): ?>
                                            <tr>
                                                <td colspan="3" class="text-center text-muted">Tidak ada menu.</td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                            <p class="small-text mb-0">Menu ditampilkan berdasarkan hari.</p>
                        </div>
                    </div>

                    <!-- Ratings & new rating form -->
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h3 class="card-title"><i class="fas fa-star"></i> Ratings & Komentar</h3>
                            <a href="#rating-form" class="btn btn-sm btn-outline-primary"><i class="fas fa-plus"></i> Tambah Rating</a>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($ratings)): ?>
                                <ul class="list-unstyled">
                                    <?php foreach ($ratings as $rt): ?>
                                        <li class="mb-3">
                                            <div class="d-flex align-items-center">
                                                <strong class="mr-2"><?= h($rt['nama']) ?></strong>
                                                <span class="badge badge-warning"><?= (int)$rt['rating'] ?>/5</span>
                                                <span class="small-text ml-2"><?= h($rt['tanggal']) ?></span>
                                            </div>
                                            <div><?= nl2br(h($rt['komentar'])) ?></div>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php else: ?>
                                <p class="text-muted">Belum ada rating untuk SPPG ini.</p>
                            <?php endif; ?>
                            <hr>
                            <div id="rating-form"></div>
                            <form method="post" class="mt-2">
                                <input type="hidden" name="csrf_token" value="<?= h($csrf) ?>">
                                <input type="hidden" name="action" value="add_rating">
                                <input type="hidden" name="sppg_id" value="<?= (int)$id ?>">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label>Nama</label>
                                        <input type="text" name="nama" class="form-control" value="<?= h($_SESSION['username'] ?? '') ?>" required minlength="2" placeholder="Nama Anda">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label>Rating</label>
                                        <select name="rating" class="form-control" required>
                                            <option value="">-- Pilih --</option>
                                            <option value="5">5 - Sangat Baik</option>
                                            <option value="4">4 - Baik</option>
                                            <option value="3">3 - Cukup</option>
                                            <option value="2">2 - Kurang</option>
                                            <option value="1">1 - Buruk</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Komentar</label>
                                        <textarea name="komentar" rows="3" class="form-control" required minlength="3" placeholder="Tulis pengalaman Anda..."></textarea>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button class="btn btn-success" type="submit"><i class="fas fa-paper-plane"></i> Kirim</button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Back button -->
                    <div class="card">
                        <div class="card-body d-flex justify-content-between">
                            <a href="../User/index.php" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
                            <span class="small-text">Detail dimuat langsung dari basis data.</span>
                        </div>
                    </div>

                </div>
            </section>
        </div>

        <!-- Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-inline">MBG Sistem — Transparan dan Tepat Sasaran</div>
            <strong>&copy; <?= date('Y') ?> MBG Sistem.</strong> All rights reserved.
        </footer>
    </div>

    <!-- Charts init -->
    <script>
        // Average rating chart (simple doughnut)
        (function() {
            const ctx = document.getElementById('ratingAvgChart');
            if (!ctx) return;
            const avg = <?= json_encode($avg) ?>;
            const cnt = <?= json_encode($cnt) ?>;
            const filled = Math.max(0, Math.min(5, avg));
            const data = [filled, Math.max(0, 5 - filled)];
            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Skor', 'Sisa dari 5'],
                    datasets: [{
                        data,
                        backgroundColor: ['#ffc107', '#e9ecef']
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    },
                    responsive: true
                }
            });
        })();
    </script>
</body>

</html>