<?php
  error_reporting(0);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://cdn.tailwindcss.com"></script>
  <title>edit menu</title>
</head>
<body>
  <main class="min-h-screen bg-gray-100 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 border-b-4 border-green-500 pb-1">
                <i class="bi bi-pencil-square mr-2 text-green-600"></i> Edit Menu
            </h1>
            <nav class="mt-3 sm:mt-0">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li><a href="#" class="hover:text-green-600">Home</a></li>
                    <li class="text-gray-400">/</li>
                    <li class="font-medium text-gray-700" aria-current="page">Edit Menu</li>
                </ol>
            </nav>
        </div>
        <div class="bg-white shadow-xl rounded-xl overflow-hidden">
            <div class="p-6 sm:p-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="lg:col-span-1">
                        <?php
                        $idx = $_GET['id'];
                        $sppg_id = $_GET['sppg_id'];
                        require_once "../config.php";

                        $sql = "select * from menu_sppg WHERE id='$idx'";
                        $data = $db->query($sql);
                        
                        // $sen = $sel = $rab = $kam = $jum = ""; 
                        
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
                                move_uploaded_file($_FILES['image']['tmp_name'], "../uploads/" . $image);
                            } else {
                                $image = $d['image'];
                            } 

                            $sql = "update menu_sppg set hari='$hari', nama_menu='$nama_menu', deskripsi_menu='$deskripsi_menu', image='$image' WHERE id='$idx'";
                            $hasil = $db->query($sql);
                            if ($hasil) {
                                echo "<script>window.location='index.php?id=$idx';</script>";
                            }
                        }
                        ?>
                        
                        <form action="#" method="post" enctype="multipart/form-data" class="space-y-6">
                            
                            <div>
                                <label for="hari" class="block text-sm font-medium text-gray-700 mb-1">Hari</label>
                                <select id="hari" name='hari' class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-3 transition duration-150">
                                    <option value='1' <?= $sen ?>>Senin</option>
                                    <option value='2' <?= $sel ?>>Selasa</option>
                                    <option value='3' <?= $rab ?>>Rabu</option>
                                    <option value='4' <?= $kam ?>>Kamis</option>
                                    <option value='5' <?= $jum ?>>Jumat</option>
                                </select>
                            </div>

                            <div>
                                <label for="nama_menu" class="block text-sm font-medium text-gray-700 mb-1">Nama Menu</label>
                                <input type='text' id="nama_menu" name='nama_menu' class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-3" value='<?= $d['nama_menu'] ?>' required>
                            </div>
                            
                            <div>
                                <label for="deskripsi_menu" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Menu</label>
                                <textarea id="deskripsi_menu" name='deskripsi_menu' rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500 p-3"><?= htmlspecialchars($d['deskripsi_menu']) ?></textarea>
                            </div>

                            <div>
                                <label for="image" class="block text-sm font-medium text-gray-700 mb-1">Foto Menu</label>
                                <input type="file" id="image" name="image" class="w-full block text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 p-3">
                                <p class="mt-2 text-xs text-gray-500">Biarkan kosong jika tidak ingin mengubah gambar.</p>
                            </div>

                            <div class="pt-4">
                                <input type='submit' name='simpanEdit' value='Simpan Perubahan'
                                    class='w-full inline-flex justify-center items-center rounded-lg bg-green-600
                                    px-5 py-3 text-lg text-white font-semibold shadow-md cursor-pointer
                                    hover:bg-green-700 hover:shadow-lg transition duration-300'>
                            </div>
                        </form>

                    </div>
                    
                    <div class="lg:col-span-1 border-l border-gray-200 lg:pl-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Pratinjau Menu Saat Ini</h3>
                        <div class="bg-gray-50 p-4 rounded-lg shadow-inner">
                            <p class="text-sm font-medium text-gray-600 mb-2">Gambar Saat Ini:</p>
                            <?php if (!empty($d['image'])): ?>
                                <img src="../uploads/<?= htmlspecialchars($d['image']) ?>" 
                                     alt="Foto Menu Saat Ini" 
                                     class="w-full h-64 object-cover rounded-lg shadow-md border-2 border-gray-200" />
                            <?php else: ?>
                                <div class="w-full h-64 flex items-center justify-center border border-dashed border-gray-300 rounded-lg text-gray-500">
                                    Tidak ada gambar yang tersedia.
                                </div>
                            <?php endif; ?>

                            <div class="mt-4 p-3 bg-white rounded-lg border border-gray-100">
                                <p class="text-xs font-semibold text-gray-700">Hari Terpilih:</p>
                                <p class="text-base text-gray-900 font-medium"><?= $hari ?></p>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
            </div>
        </div>
</main>
</body>
</html>