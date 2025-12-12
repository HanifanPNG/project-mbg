<?php

/*******************************************************
 * MBG Sistem — User Portal (AdminLTE)
 * File: pages/user.php
 * Requirements:
 * - Session keys: $_SESSION['isLogin'] (true/false), $_SESSION['level'] ('admin'|'user'), $_SESSION['user_id'], $_SESSION['username']
 * - DB config: require_once "../config.php"; exposes $db (mysqli)
 * - Tables:
 * users(id, username, password, level)
 * sppg(id, nama_sppg, alamat, kota, jam_buka, jam_tutup, waktu)
 * sekolah(id, sppg_id, nama_sekolah, jenjang, alamat)
 * menu_sppg(id, sppg_id, hari, nama_menu, image)
 * sppg_rating(id, sppg_id, nama, komentar, rating, tanggal DEFAULT CURRENT_TIMESTAMP)
 *******************************************************/
session_start();
if (!isset($_SESSION['isLogin']) || $_SESSION['isLogin'] == false || !in_array($_SESSION['level'], ['admin', 'user'])) {
    header("Location: ../logout.php");
    exit;
}
$currentLevel = $_SESSION['level'] ?? 'user';
$currentUserId = $_SESSION['user_id'] ?? null;
$currentUsername = $_SESSION['username'] ?? 'User';

require_once "../config.php"; // mysqli $db

// Utilities
function h($s)
{
    return htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
}
function jsonResponse($data)
{
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data);
    exit;
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
function isMd5Hex($hash)
{
    return (bool)preg_match('/^[a-f0-9]{32}$/i', $hash);
}

// AJAX router (same file)
if (isset($_GET['ajax'])) {
    $action = $_GET['ajax'];

    // SPPG list with filters: q, kota, open_now (optional), limit
    if ($action === 'sppg_list') {
        $q = trim($_GET['q'] ?? '');
        $kota = trim($_GET['kota'] ?? '');
        $limit = (int)($_GET['limit'] ?? 50);
        $limit = max(1, min($limit, 200));
        $openNow = ($_GET['open_now'] ?? '') === '1';

        $where = "1=1";
        $params = [];
        $types = "";

        if ($q !== "") {
            $where .= " AND (nama_sppg LIKE ? OR alamat LIKE ?)";
            $like = "%$q%";
            $params[] = $like;
            $params[] = $like;
            $types .= "ss";
        }
        if ($kota !== "") {
            $where .= " AND kota = ?";
            $params[] = $kota;
            $types .= "s";
        }
        if ($openNow) {
            // Simple open_now check using server time (assumes same timezone)
            // jam_buka <= NOW_TIME <= jam_tutup
            // For MySQL: compare TIME(NOW())
            $where .= " AND (jam_buka IS NOT NULL AND jam_tutup IS NOT NULL AND jam_buka <= TIME(NOW()) AND TIME(NOW()) <= jam_tutup)";
        }

        $sql = "SELECT id, nama_sppg, alamat, kota, jam_buka, jam_tutup, waktu FROM sppg WHERE $where ORDER BY waktu DESC, id DESC LIMIT $limit";
        $stmt = $db->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $res = $stmt->get_result();
        $rows = [];
        while ($r = $res->fetch_assoc()) {
            $rows[] = $r;
        }
        $stmt->close();

        // Extra: counts for badges
        $totalCount = 0;
        $res2 = $db->query("SELECT COUNT(*) AS c FROM sppg");
        if ($res2) {
            $totalCount = (int)($res2->fetch_assoc()['c'] ?? 0);
            $res2->close();
        }
        jsonResponse(['rows' => $rows, 'total' => $totalCount]);
    }

    // Ratings recent by sppg_id (optional), limit
    if ($action === 'ratings_recent') {
        $sppg_id = (int)($_GET['sppg_id'] ?? 0);
        $limit = (int)($_GET['limit'] ?? 10);
        $limit = max(1, min($limit, 50));
        $params = [];
        $types = "";
        $where = "1=1";
        if ($sppg_id > 0) {
            $where .= " AND sppg_id = ?";
            $params[] = $sppg_id;
            $types .= "i";
        }

        $sql = "SELECT id, sppg_id, nama, komentar, rating, tanggal FROM sppg_rating WHERE $where ORDER BY tanggal DESC, id DESC LIMIT $limit";
        $stmt = $db->prepare($sql);
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
        $stmt->execute();
        $res = $stmt->get_result();
        $rows = [];
        while ($r = $res->fetch_assoc()) {
            $rows[] = $r;
        }
        $stmt->close();

        jsonResponse(['rows' => $rows]);
    }

    // Chart data: average rating per kota + sppg count per kota
    if ($action === 'chart_data') {
        // Average ratings per kota (join sppg_rating with sppg)
        $avgRatings = [];
        $sql = "SELECT s.kota AS kota, AVG(r.rating) AS avg_rating, COUNT(r.id) AS cnt
FROM sppg_rating r
INNER JOIN sppg s ON s.id = r.sppg_id
GROUP BY s.kota
ORDER BY s.kota ASC";
        $res = $db->query($sql);
        if ($res) {
            while ($row = $res->fetch_assoc()) {
                $avgRatings[] = ['kota' => $row['kota'], 'avg' => round((float)$row['avg_rating'], 2), 'cnt' => (int)$row['cnt']];
            }
            $res->close();
        }

        // SPPG count per kota
        $sppgCnt = [];
        $sql2 = "SELECT kota, COUNT(*) AS cnt FROM sppg GROUP BY kota ORDER BY kota ASC";
        $res2 = $db->query($sql2);
        if ($res2) {
            while ($row = $res2->fetch_assoc()) {
                $sppgCnt[] = ['kota' => $row['kota'], 'cnt' => (int)$row['cnt']];
            }
            $res2->close();
        }

        jsonResponse(['avgRatings' => $avgRatings, 'sppgCount' => $sppgCnt]);
    }

    // SPPG summary card: totals + open_now count
    if ($action === 'sppg_summary') {
        $total = 0;
        $openNow = 0;
        $todayMenus = 0;
        $schools = 0;
        $resT = $db->query("SELECT COUNT(*) AS c FROM sppg");
        if ($resT) {
            $total = (int)($resT->fetch_assoc()['c'] ?? 0);
            $resT->close();
        }
        $sqlOpen = "SELECT COUNT(*) AS c FROM sppg WHERE jam_buka IS NOT NULL AND jam_tutup IS NOT NULL AND jam_buka <= TIME(NOW()) AND TIME(NOW()) <= jam_tutup";
        $resO = $db->query($sqlOpen);
        if ($resO) {
            $openNow = (int)($resO->fetch_assoc()['c'] ?? 0);
            $resO->close();
        }
        // Approx today's menus: assuming hari 1..7 mapping (Mon..Sun), use DAYOFWEEK(NOW()) => 1 Sunday .. 7 Saturday
        // We'll map: 2..6 for Mon..Fri; simple count all menus
        $resM = $db->query("SELECT COUNT(*) AS c FROM menu_sppg");
        if ($resM) {
            $todayMenus = (int)($resM->fetch_assoc()['c'] ?? 0);
            $resM->close();
        }
        $resS = $db->query("SELECT COUNT(*) AS c FROM sekolah");
        if ($resS) {
            $schools = (int)($resS->fetch_assoc()['c'] ?? 0);
            $resS->close();
        }

        jsonResponse(['total' => $total, 'open_now' => $openNow, 'menus' => $todayMenus, 'schools' => $schools]);
    }

    // Search distinct kota list
    if ($action === 'kota_list') {
        $rows = [];
        $res = $db->query("SELECT DISTINCT kota FROM sppg WHERE kota IS NOT NULL AND kota <> '' ORDER BY kota ASC");
        if ($res) {
            while ($r = $res->fetch_assoc()) {
                $rows[] = $r['kota'];
            }
            $res->close();
        }
        jsonResponse(['kota' => $rows]);
    }

    // Fallback
    jsonResponse(['error' => 'unknown_action']);
}

// Handle POST actions (non-AJAX): add rating, update profile
$errors = [];
$success = "";

// Add rating
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_rating') {
    $token = $_POST['csrf_token'] ?? '';
    $sppg_id = (int)($_POST['sppg_id'] ?? 0);
    $nama = trim($_POST['nama'] ?? $currentUsername);
    $komentar = trim($_POST['komentar'] ?? '');
    $rating = (int)($_POST['rating'] ?? 0);

    if (!checkCsrf($token)) {
        $errors[] = "CSRF token tidak valid. Silakan muat ulang halaman.";
    }
    if ($sppg_id <= 0) {
        $errors[] = "Silakan pilih SPPG.";
    }
    if ($nama === "") {
        $errors[] = "Nama tidak boleh kosong.";
    }
    if ($rating < 1 || $rating > 5) {
        $errors[] = "Rating harus antara 1 sampai 5.";
    }
    if ($komentar === "") {
        $errors[] = "Komentar tidak boleh kosong.";
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

// Update profile (user can edit self; admin can edit self too)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_profile') {
    $token = $_POST['csrf_token'] ?? '';
    $newUser = trim($_POST['username'] ?? '');
    $newPass = trim($_POST['password'] ?? '');
    $confirm = trim($_POST['confirm'] ?? '');
    $uid = (int)$currentUserId;

    if (!checkCsrf($token)) {
        $errors[] = "CSRF token tidak valid.";
    }
    if ($uid <= 0) {
        $errors[] = "User tidak valid.";
    }
    if ($newUser === "" || strlen($newUser) < 3) {
        $errors[] = "Username minimal 3 karakter.";
    }
    if ($newPass !== "" && strlen($newPass) < 4) {
        $errors[] = "Password minimal 4 karakter.";
    }
    if ($newPass !== "" && $newPass !== $confirm) {
        $errors[] = "Konfirmasi password tidak cocok.";
    }

    if (empty($errors)) {
        // uniqueness check
        $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE username = ? AND id <> ?");
        $stmt->bind_param("si", $newUser, $uid);
        $stmt->execute();
        $stmt->bind_result($cnt);
        $stmt->fetch();
        $stmt->close();
        if ($cnt > 0) {
            $errors[] = "Username sudah dipakai.";
        } else {
            if ($newPass !== "") {
                $md5 = md5($newPass); // keep MD5 for compatibility
                $stmt = $db->prepare("UPDATE users SET username = ?, password = ? WHERE id = ?");
                $stmt->bind_param("ssi", $newUser, $md5, $uid);
            } else {
                $stmt = $db->prepare("UPDATE users SET username = ? WHERE id = ?");
                $stmt->bind_param("si", $newUser, $uid);
            }
            if ($stmt->execute()) {
                $success = "Profil berhasil diperbarui.";
                $_SESSION['username'] = $newUser;
            } else {
                $errors[] = "Gagal memperbarui profil.";
            }
            $stmt->close();
        }
    }
}

// Initial data for page (server-side render fallback)
$csrf = csrfToken();

// Distinct kota for filter dropdown
$kotaOptions = [];
$resK = $db->query("SELECT DISTINCT kota FROM sppg WHERE kota IS NOT NULL AND kota <> '' ORDER BY kota ASC");
if ($resK) {
    while ($r = $resK->fetch_assoc()) {
        $kotaOptions[] = $r['kota'];
    }
    $resK->close();
}

// Initial sppg list (limited)
$initSppg = [];
$resS = $db->query("SELECT id, nama_sppg, alamat, kota, jam_buka, jam_tutup, waktu FROM sppg ORDER BY waktu DESC, id DESC LIMIT 20");
if ($resS) {
    while ($r = $resS->fetch_assoc()) {
        $initSppg[] = $r;
    }
    $resS->close();
}

// Initial recent ratings (global)
$initRatings = [];
$resR = $db->query("SELECT id, sppg_id, nama, komentar, rating, tanggal FROM sppg_rating ORDER BY tanggal DESC, id DESC LIMIT 10");
if ($resR) {
    while ($r = $resR->fetch_assoc()) {
        $initRatings[] = $r;
    }
    $resR->close();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>MBG Sistem — User Portal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- AdminLTE & dependencies via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/datatables.net-bs4@1.13.8/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.4/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net@1.13.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/datatables.net-bs4@1.13.8/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        .brand-link .brand-text {
            font-weight: 600;
        }

        .table td,
        .table th {
            vertical-align: middle;
        }

        .rating-stars .fa-star {
            color: #ffc107;
        }

        .small-text {
            font-size: .9rem;
            color: #6c757d;
        }

        .dataTables_wrapper .dataTables_filter input {
            border-radius: 4px;
        }

        .card-kpi h2 {
            font-weight: 700;
            margin: 0;
        }

        .kpi-icon {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            margin-right: 8px;
        }

        .kpi-icon.bg-green {
            background: #28a745;
        }

        .kpi-icon.bg-blue {
            background: #007bff;
        }

        .kpi-icon.bg-orange {
            background: #fd7e14;
        }

        .chart-card canvas {
            max-height: 280px;
        }

        .timeline {
            list-style: none;
            padding-left: 0;
        }

        .timeline-item {
            position: relative;
            padding-left: 26px;
            margin-bottom: 14px;
        }

        .timeline-item::before {
            content: "";
            position: absolute;
            left: 8px;
            top: 6px;
            width: 10px;
            height: 10px;
            background: #007bff;
            border-radius: 50%;
        }

        .footer-note {
            color: #6c757d;
            font-size: .9rem;
        }

        .modal .form-control.is-invalid {
            border-color: #dc3545;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a></li>
                <li class="nav-item d-none d-sm-inline-block"><a href="#" class="nav-link">Beranda</a></li>
                <li class="nav-item d-none d-sm-inline-block"><a href="#sppg-section" class="nav-link">SPPG</a></li>
                <li class="nav-item d-none d-sm-inline-block"><a href="#ratings-section" class="nav-link">Ratings</a></li>
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <span class="nav-link">Masuk sebagai: <strong><?= h($currentUsername) ?></strong> (<?= h($currentLevel) ?>)</span>
                </li>
                <li class="nav-item">
                    <a href="../logout.php" class="btn btn-outline-secondary btn-sm ml-2"><i class="fas fa-sign-out-alt"></i> Logout</a>
                </li>
            </ul>
        </nav>

        <!-- Sidebar -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="#" class="brand-link">
                <span class="brand-text font-weight-light">MBG Sistem</span>
            </a>
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column">
                        <li class="nav-item"><a href="#" class="nav-link active"><i class="nav-icon fas fa-home"></i>
                                <p>Beranda</p>
                            </a></li>
                        <li class="nav-item"><a href="#sppg-section" class="nav-link"><i class="nav-icon fas fa-store"></i>
                                <p>Daftar SPPG</p>
                            </a></li>
                        <li class="nav-item"><a href="#ratings-section" class="nav-link"><i class="nav-icon fas fa-star"></i>
                                <p>Ratings</p>
                            </a></li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Header -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Portal Pengguna</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">User</li>
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

            <!-- Hero + KPIs -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <!-- Hero card -->
                        <div class="col-lg-7">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="kpi-icon bg-blue"><i class="fas fa-heartbeat"></i></div>
                                        <div>
                                            <h4 class="mb-1">Sistem Pelayanan Makanan Bergizi Gratis</h4>
                                            <p class="mb-0 small-text">Transparan, tepat sasaran, dan mudah diakses oleh masyarakat.</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <p class="mb-2">Selamat datang, <strong><?= h($currentUsername) ?></strong>. Jelajahi daftar SPPG, beri rating, dan kelola profil Anda.</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <img src="../assets/img/hihi.png" alt="Makanan bergizi" class="img-fluid rounded">
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="timeline" id="heroTimeline">
                                                <!-- <?php foreach ($initRatings as $rt): ?>
<li class="timeline-item">
<strong><?= h($rt['nama']) ?></strong> memberi rating
<span class="badge badge-warning"><?= (int)$rt['rating'] ?>/5</span>
<div class="small-text"><?= h($rt['komentar']) ?> — <em><?= h($rt['tanggal']) ?></em></div>
</li>
<?php endforeach; ?>
<?php if (empty($initRatings)): ?>
<li class="timeline-item text-muted">Belum ada aktivitas terbaru.</li>
<?php endif; ?> -->
                                            </ul>
                                            <!-- <p class="small-text mb-0">Aktivitas di atas dimuat awal dan akan diperbarui otomatis dari server.</p> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- KPI cards -->
                        <div class="col-lg-5">
                            <div class="card card-kpi">
                                <div class="card-body">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="kpi-icon bg-green"><i class="fas fa-store"></i></div>
                                        <div>
                                            <h5 class="mb-0">Ringkasan SPPG</h5>
                                            <span class="small-text">Jumlah, buka sekarang, menu, sekolah</span>
                                        </div>
                                    </div>
                                    <div class="row text-center">
                                        <div class="col-6 mb-3">
                                            <h2 id="kpiTotal">0</h2>
                                            <div class="small-text">Total SPPG</div>
                                        </div>
                                        <div class="col-6 mb-3">
                                            <h2 id="kpiOpen">0</h2>
                                            <div class="small-text">Buka sekarang</div>
                                        </div>
                                        <div class="col-6">
                                            <h2 id="kpiMenus">0</h2>
                                            <div class="small-text">Jumlah menu</div>
                                        </div>
                                        <div class="col-6">
                                            <h2 id="kpiSchools">0</h2>
                                            <div class="small-text">Jumlah sekolah</div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="chart-card">
                                        <canvas id="chartOverview"></canvas>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="mb-2"><i class="fas fa-chart-pie"></i> Rata-rata Rating per Kota</h5>
                                    <div class="chart-card">
                                        <canvas id="chartAvgRatings"></canvas>
                                    </div>
                                    <p class="small-text mb-0">Grafik menampilkan rata-rata rating dan jumlah kontribusi per kota.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- SPPG Section -->
                    <div id="sppg-section" class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h3 class="card-title"><i class="fas fa-store"></i> Daftar SPPG</h3>
                                    <div>
                                        <a href="#ratings-section" class="btn btn-outline-primary btn-sm"><i class="fas fa-star"></i> Beri Rating</a>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <form id="sppgFilter" class="mb-3">
                                        <div class="form-row">
                                            <div class="col-md-3 mb-2">
                                                <label class="mb-0">Kata Kunci</label>
                                                <input type="text" class="form-control" id="filterQ" placeholder="Nama SPPG / Alamat">
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="mb-0">Kota</label>
                                                <select id="filterKota" class="form-control">
                                                    <option value="">Semua</option>
                                                    <?php foreach ($kotaOptions as $ko): ?>
                                                        <option value="<?= h($ko) ?>"><?= h($ko) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-2">
                                                <label class="mb-0">Buka sekarang</label>
                                                <select id="filterOpen" class="form-control">
                                                    <option value="">Semua</option>
                                                    <option value="1">Ya</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 mb-2 d-flex align-items-end">
                                                <button type="button" id="applyFilters" class="btn btn-primary mr-2"><i class="fas fa-search"></i> Cari</button>
                                                <button type="button" id="resetFilters" class="btn btn-secondary"><i class="fas fa-redo"></i> Reset</button>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="table-responsive">
                                        <table id="sppgTable" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th style="width:60px;">ID</th>
                                                    <th>Nama</th>
                                                    <th>Kota</th>
                                                    <th>Jam Buka</th>
                                                    <th>Jam Tutup</th>
                                                    <th>Alamat</th>
                                                    <th style="width:150px;">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="sppgBody">
                                                <?php foreach ($initSppg as $sp): ?>
                                                    <tr>
                                                        <td><?= (int)$sp['id'] ?></td>
                                                        <td><?= h($sp['nama_sppg']) ?></td>
                                                        <td><?= h($sp['kota']) ?></td>
                                                        <td><?= h($sp['jam_buka']) ?></td>
                                                        <td><?= h($sp['jam_tutup']) ?></td>
                                                        <td><?= h($sp['alamat']) ?></td>
                                                        <td>
                                                            <a href="detail_sppg.php?id=<?= (int)$sp['id'] ?>" class="btn btn-sm btn-primary">
                                                                <i class="fas fa-info-circle"></i> Detail
                                                            </a>
                                                            <button class="btn btn-sm btn-warning btn-rate" data-sppg="<?= (int)$sp['id'] ?>" data-name="<?= h($currentUsername) ?>">
                                                                <i class="fas fa-star"></i> Rate
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                                <?php if (empty($initSppg)): ?>
                                                    <tr>
                                                        <td colspan="7" class="text-center text-muted">Tidak ada data SPPG.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <p class="small-text mb-0">Gunakan filter untuk mempersempit hasil. Tabel akan memuat data secara langsung dari server.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Ratings Section -->
                    <div id="ratings-section" class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-star"></i> Beri Rating SPPG</h3>
                                </div>
                                <div class="card-body">
                                    <form method="post" id="ratingForm">
                                        <input type="hidden" name="csrf_token" value="<?= h($csrf) ?>">
                                        <input type="hidden" name="action" value="add_rating">
                                        <div class="form-group">
                                            <label>Pilih SPPG</label>
                                            <select class="form-control" name="sppg_id" id="ratingSppg" required>
                                                <option value="">-- Pilih --</option>
                                                <?php foreach ($initSppg as $sp): ?>
                                                    <option value="<?= (int)$sp['id'] ?>"><?= h($sp['nama_sppg']) ?> (<?= h($sp['kota']) ?>)</option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Nama Anda</label>
                                            <input type="text" class="form-control" name="nama" value="<?= h($currentUsername) ?>" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Komentar</label>
                                            <textarea class="form-control" name="komentar" rows="3" placeholder="Tulis pengalaman Anda..." required></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Rating</label>
                                            <div class="rating-stars">
                                                <select class="form-control" name="rating" required>
                                                    <option value="">-- Pilih --</option>
                                                    <option value="5">5 - Sangat Baik</option>
                                                    <option value="4">4 - Baik</option>
                                                    <option value="3">3 - Cukup</option>
                                                    <option value="2">2 - Kurang</option>
                                                    <option value="1">1 - Buruk</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <button class="btn btn-success" type="submit"><i class="fas fa-paper-plane"></i> Kirim</button>
                                        </div>
                                    </form>
                                    <p class="small-text mt-2 mb-0">Rating disimpan langsung ke database dan muncul di aktivitas terbaru.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title"><i class="fas fa-stream"></i> Aktivitas Rating Terbaru</h3>
                                </div>
                                <div class="card-body">
                                    <ul class="timeline" id="ratingsTimeline">
                                        <?php foreach ($initRatings as $rt): ?>
                                            <li class="timeline-item">
                                                <strong><?= h($rt['nama']) ?></strong> memberi rating
                                                <span class="badge badge-warning"><?= (int)$rt['rating'] ?>/5</span>
                                                <div class="small-text"><?= h($rt['komentar']) ?> — <em><?= h($rt['tanggal']) ?></em></div>
                                            </li>
                                        <?php endforeach; ?>
                                        <?php if (empty($initRatings)): ?>
                                            <li class="timeline-item text-muted">Belum ada rating.</li>
                                        <?php endif; ?>
                                    </ul>
                                    <div class="d-flex justify-content-end">
                                        <button id="refreshRatings" class="btn btn-outline-primary btn-sm"><i class="fas fa-sync"></i> Muat ulang</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Section -->
                    <!-- <div id="profile-section" class="row">
<div class="col-lg-6">
<div class="card">
<div class="card-header"><h3 class="card-title"><i class="fas fa-user"></i> Profil Saya</h3></div>
<div class="card-body">
<form method="post" id="profileForm">
<input type="hidden" name="csrf_token" value="<?= h($csrf) ?>">
<input type="hidden" name="action" value="update_profile">
<div class="form-group">
<label>Username</label>
<input type="text" class="form-control" name="username" value="<?= h($currentUsername) ?>" required minlength="3">
</div>
<div class="form-group">
<label>Password Baru (opsional)</label>
<input type="password" class="form-control" name="password" minlength="4" placeholder="Kosongkan jika tidak diganti">
<small class="small-text">Password saat ini disimpan sebagai MD5 untuk kompatibilitas.</small>
</div>
<div class="form-group">
<label>Konfirmasi Password</label>
<input type="password" class="form-control" name="confirm" minlength="4" placeholder="Sama seperti password baru">
</div>
<div class="text-right">
<button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Simpan</button>
</div>
</form>
</div>
</div>
</div>

<div class="col-lg-6">
<div class="card">
<div class="card-header"><h3 class="card-title"><i class="fas fa-info-circle"></i> Info Akun</h3></div>
<div class="card-body"> -->
                    <!-- <?php
                            $hashLabel = "";
                            if ($currentUserId) {
                                $stmt = $db->prepare("SELECT password, level FROM users WHERE id = ?");
                                $stmt->bind_param("i", $currentUserId);
                                $stmt->execute();
                                $resU = $stmt->get_result();
                                if ($resU && $row = $resU->fetch_assoc()) {
                                    $hash = $row['password'];
                                    $hashLabel = isMd5Hex($hash) ? 'MD5' : 'custom';
                                    echo '<p><strong>Peran:</strong> ' . h($row['level']) . '</p>';
                                    echo '<p><strong>Hash Password:</strong> <code>' . h($hash) . '</code> <span class="small-text">(' . $hashLabel . ')</span></p>';
                                }
                                $stmt->close();
                            } else {
                                echo '<p class="text-muted">User tidak ditemukan.</p>';
                            }
                            ?>
<p class="small-text mb-0">Keamanan: kami menyarankan migrasi ke bcrypt ke depannya. Saat ini kompatibel dengan sistem yang ada.</p>
</div>
</div>
</div>
</div> -->

                    <!-- Footer note -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body text-center footer-note">
                                    &copy; <?= date('Y') ?> MBG Sistem — Portal pengguna dibuat dengan AdminLTE. Data dimuat langsung dari server (AJAX) dan terhubung dengan basis data Anda.
                                </div>
                            </div>
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

    <script>
        // DataTable init
        $(function() {
            $('#sppgTable').DataTable({
                paging: true,
                pageLength: 10,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
            });
        });

        // Helper escape (client-side)
        function esc(s) {
            if (s === null || s === undefined) return '';
            return String(s)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", "&#039;");
        }

        // Load summary KPIs
        function loadSummary() {
            fetch('?ajax=sppg_summary').then(r => r.json()).then(d => {
                $('#kpiTotal').text(d.total || 0);
                $('#kpiOpen').text(d.open_now || 0);
                $('#kpiMenus').text(d.menus || 0);
                $('#kpiSchools').text(d.schools || 0);
                // Update Overview chart
                if (window.chartOverview) {
                    chartOverview.data.labels = ['Total SPPG', 'Buka sekarang', 'Menu', 'Sekolah'];
                    chartOverview.data.datasets[0].data = [d.total || 0, d.open_now || 0, d.menus || 0, d.schools || 0];
                    chartOverview.update();
                }
            }).catch(() => {});
        }

        // Load charts data
        function loadCharts() {
            fetch('?ajax=chart_data').then(r => r.json()).then(d => {
                const ctx1 = document.getElementById('chartOverview');
                const ctx2 = document.getElementById('chartAvgRatings');

                // Overview chart
                window.chartOverview = new Chart(ctx1, {
                    type: 'bar',
                    data: {
                        labels: ['Total SPPG', 'Buka sekarang', 'Menu', 'Sekolah'],
                        datasets: [{
                            label: 'Jumlah',
                            data: [0, 0, 0, 0],
                            backgroundColor: ['#007bff', '#28a745', '#fd7e14', '#6c757d']
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                // Avg ratings per kota (bar + count overlay)
                const labels = (d.avgRatings || []).map(x => x.kota);
                const avgs = (d.avgRatings || []).map(x => x.avg);
                const counts = (d.avgRatings || []).map(x => x.cnt);

                window.chartAvg = new Chart(ctx2, {
                    type: 'bar',
                    data: {
                        labels,
                        datasets: [{
                                label: 'Rata-rata rating',
                                data: avgs,
                                backgroundColor: '#ffc107'
                            },
                            {
                                label: 'Jumlah rating',
                                data: counts,
                                backgroundColor: '#6c757d'
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });

                loadSummary();
            }).catch(() => {});
        }

        // Apply filters for SPPG list
        function applyFilters() {
            const q = $('#filterQ').val().trim();
            const kota = $('#filterKota').val();
            const open_now = $('#filterOpen').val() === '1' ? '1' : '';
            const params = new URLSearchParams({
                ajax: 'sppg_list',
                q,
                kota,
                open_now,
                limit: '100'
            });

            fetch('?' + params.toString()).then(r => r.json()).then(d => {
                const tb = $('#sppgBody');
                tb.empty();
                const rows = d.rows || [];
                if (rows.length === 0) {
                    tb.append('<tr><td colspan="7" class="text-center text-muted">Tidak ada data untuk filter saat ini.</td></tr>');
                } else {
                    rows.forEach(sp => {
                        tb.append(`
<tr>
<td>${sp.id}</td>
<td>${esc(sp.nama_sppg)}</td>
<td>${esc(sp.kota)}</td>
<td>${esc(sp.jam_buka||'')}</td>
<td>${esc(sp.jam_tutup||'')}</td>
<td>${esc(sp.alamat)}</td>
<td>
<a href="detail_sppg.php?id=${sp.id}" class="btn btn-sm btn-primary">
<i class="fas fa-info-circle"></i> Detail
</a>
<button class="btn btn-sm btn-warning btn-rate" data-sppg="${sp.id}" data-name="<?= h($currentUsername) ?>">
<i class="fas fa-star"></i> Rate
</button>
</td>
</tr>
`);
                    });
                }
                // Rebind rate buttons
                bindRateButtons();
            }).catch(() => {});
        }

        // Bind filter buttons
        $('#applyFilters').on('click', applyFilters);
        $('#resetFilters').on('click', function() {
            $('#filterQ').val('');
            $('#filterKota').val('');
            $('#filterOpen').val('');
            applyFilters();
        });

        // Ratings timeline refresh
        function refreshRatingsTimeline() {
            const sppg_id = $('#ratingSppg').val() || '';
            const params = new URLSearchParams({
                ajax: 'ratings_recent',
                sppg_id,
                limit: '10'
            });
            fetch('?' + params.toString()).then(r => r.json()).then(d => {
                const ul = $('#ratingsTimeline');
                ul.empty();
                const rows = d.rows || [];
                if (rows.length === 0) {
                    ul.append('<li class="timeline-item text-muted">Belum ada rating.</li>');
                } else {
                    rows.forEach(rt => {
                        ul.append(`
<li class="timeline-item">
<strong>${esc(rt.nama)}</strong> memberi rating
<span class="badge badge-warning">${rt.rating}/5</span>
<div class="small-text">${esc(rt.komentar)} — <em>${esc(rt.tanggal)}</em></div>
</li>
`);
                    });
                }
            }).catch(() => {});
        }
        $('#refreshRatings').on('click', refreshRatingsTimeline);

        // Submit rating form with simple validation feedback
        $('#ratingForm').on('submit', function(e) {
            // Let server handle; after submit the page will reload with success or error alert
            // Optionally, you can AJAX-submit; but you requested everything live and working; this standard POST is safest.
        });

        // Profile form
        $('#profileForm').on('submit', function(e) {
            // Standard POST submit; server returns alerts.
        });

        // Quick rate from SPPG table
        function bindRateButtons() {
            $('.btn-rate').off('click').on('click', function() {
                const id = $(this).data('sppg');
                const name = $(this).data('name');
                // Pre-fill rating form
                $('#ratingSppg').val(String(id)).trigger('change');
                $('input[name="nama"]').val(String(name));
                $('html,body').animate({
                    scrollTop: $('#ratings-section').offset().top - 60
                }, 400);
            });
        }
        bindRateButtons();

        // Initial charts and data load
        $(document).ready(function() {
            loadCharts();
            applyFilters();
            refreshRatingsTimeline();
        });
    </script>
</body>

</html>