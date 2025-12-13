<main class="app-main">
    <!--begin::App Content Header-->
    <div class="app-content-header">
        <!--begin::Container-->
        <div class="container-fluid">
            <!--begin::Row-->
            <div class="row">
                <!--begin::Col-->
                <div class="col-sm-6">
                    <h3 class="mb-0">Tambah Ibu hamil</h3>
                </div>
                <!--end::Col-->
                <!--begin::Col-->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-end">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Tambah Ibu hamil</li>
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
                                $sppg_id = $_GET['id'];
                                if ($_POST['simpan']) {
                                    $nama_ibu = $_POST['nama_ibu'];
                                    $klaster = $_POST['klaster'];
                                    $alamat = $_POST['alamat'];

                                    require_once "../config.php";
                                    $sql = "insert into ibu_hamil set sppg_id='$sppg_id', nama_ibu='$nama_ibu', klaster='$klaster' ,alamat='$alamat'";
                                    $a = $db->query($sql);
                                    if ($a) {
                                        echo "<div class='alert alert-success'>Berhasil Ditambahkan✅ <br></div>";
                                    }
                                }
                                ?>

                                <form action="#" method="post">
                                    <table>
                                        <tr>
                                            <td>Nama</td>
                                            <td><input type="text" name="nama_ibu" class="form-control" value="<?= $nama_ibu ?>"></td>
                                        </tr>
                                        <tr>
                                            <td>Klaster</td>
                                            <td><select name="klaster" class="form-control">
                                                    <option></option>
                                                    <option value="1"<?php if($klaster == "1") echo "selected"?>>Ibu Hamil</option>
                                                    <option value="2"<?php if($klaster == "2") echo "selected"?>>Ibu Menyusui</option>
                                                    <option value="3"<?php if($klaster == "3") echo "selected"?>>Balita Non PAUD</option>
                                                </select></td>
                                        </tr>
                                        <tr>
                                            <td valign="top">Alamat</td>
                                            <td><textarea name="alamat" class="form-control" style="width: 200px;"><?= $alamat ?></textarea></td>
                                        </tr>
                                        <tr>
                                            <td></td>
                                            <td><button type="submit" name="simpan" value="Simpan" class="btn btn-primary mt-2">Simpan</button></td>
                                        </tr>
                                    </table>
                                </form>
                                <a href="./?p=detail_sppg&id=<?= $sppg_id ?>">
                                    <button type="submit" class="btn btn-secondary" value="Kembali">Kembali</button>
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