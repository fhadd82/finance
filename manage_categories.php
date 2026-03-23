<?php

// --- HALANG BROWSER DARI MENYIMPAN CACHE ---

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");

header("Cache-Control: post-check=0, pre-check=0", false);

header("Pragma: no-cache");

header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");



require_once("include/dbcommon.php");

date_default_timezone_set('Asia/Kuala_Lumpur');



if(!isLogged()){

    header("Location: login.php");

    exit();

}



$current_page = basename($_SERVER['PHP_SELF']);



// =========================================================

// 1. DAPATKAN ID PENGGUNA (SOKONG SEMUA JENIS LOGIN TERMASUK GOOGLE)

// =========================================================

$login_username = $_SESSION["UserID"];

$user_id = 0;



// CARA 1: Baca dari Session 'Auto-Merge' yang diset masa login

if(isset($_SESSION["UserDbID"]) && !empty($_SESSION["UserDbID"]) && $_SESSION["UserDbID"] != 0) {

    $user_id = $_SESSION["UserDbID"];

}

// CARA 2: Baca dari sistem asal PHPRunner

elseif(isset($_SESSION["UserData"]["ID"]) && !empty($_SESSION["UserData"]["ID"])) {

    $user_id = $_SESSION["UserData"]["ID"];

    $_SESSION["UserDbID"] = $user_id;

}

// CARA 3: Cari manual (Sokong Username, Email ATAU Token Google)

else {

    $sqlCheckUser = "SELECT ID FROM tbl_users WHERE 

                     username = " . db_prepare_string($login_username) . " OR 

                     email = " . db_prepare_string($login_username) . " OR 

                     ext_security_id = " . db_prepare_string($login_username) . " LIMIT 1";

                     

    $rsUser = DB::Query($sqlCheckUser);

    if ($rsUser && $rowUser = $rsUser->fetchAssoc()) {

        $user_id = $rowUser['ID'];

        $_SESSION["UserDbID"] = $user_id;

    }

}



// PENAPIS: Benarkan baca kategori milik sendiri DAN kategori umum/default (0/NULL)

$user_filter = "(user_id = '$user_id' OR user_id = 0 OR user_id IS NULL OR user_id = '')";

// =========================================================



$msg = "";

$msg_type = "";



// --- PENGURUSAN DATA KATEGORI (CRUD) ---

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    

    if ($_POST['action'] === 'add') {

        $name = $_POST['name'];

        $type_id = intval($_POST['type_id']); // 1=Belanja, 2=Pendapatan, 3=Komitmen, 4=Pelaburan

        

        if ($type_id == 2) { $type = 'Pendapatan'; } 

        elseif ($type_id == 3) { $type = 'Komitmen'; } 

        elseif ($type_id == 4) { $type = 'Pelaburan'; } 

        else { $type = 'Perbelanjaan'; }

        

        $color_code = $_POST['color_code'];

        // KEMASKINI: Masukkan user_id semasa simpan kategori baru

        $insertSQL = "INSERT INTO tbl_categories (user_id, name, type_id, type, color_code) VALUES ('$user_id', " . db_prepare_string($name) . ", $type_id, " . db_prepare_string($type) . ", " . db_prepare_string($color_code) . ")";

        DB::Exec($insertSQL);

        $msg = "Kategori baru berjaya ditambah."; $msg_type = "success";

    }

    

    elseif ($_POST['action'] === 'edit') {

        $cat_id = intval($_POST['cat_id']);

        $name = $_POST['name'];

        $type_id = intval($_POST['type_id']);

        

        if ($type_id == 2) { $type = 'Pendapatan'; } 

        elseif ($type_id == 3) { $type = 'Komitmen'; } 

        elseif ($type_id == 4) { $type = 'Pelaburan'; } 

        else { $type = 'Perbelanjaan'; }

        

        $color_code = $_POST['color_code'];

        $updateSQL = "UPDATE tbl_categories SET name = " . db_prepare_string($name) . ", type_id = $type_id, type = " . db_prepare_string($type) . ", color_code = " . db_prepare_string($color_code) . " WHERE id = $cat_id";

        DB::Exec($updateSQL);

        $msg = "Kategori berjaya dikemaskini."; $msg_type = "success";

    }

    

    elseif ($_POST['action'] === 'delete') {

        $cat_id = intval($_POST['cat_id']);

        // Semak rekod transaksi mengikut user_id juga

        $checkExp = DB::Query("SELECT COUNT(*) as cnt FROM tbl_expenses WHERE category_id = $cat_id AND user_id = '$user_id'")->fetchAssoc();

        $checkInc = DB::Query("SELECT COUNT(*) as cnt FROM tbl_income WHERE category_id = $cat_id AND user_id = '$user_id'")->fetchAssoc();

        $checkBud = DB::Query("SELECT COUNT(*) as cnt FROM tbl_budgets WHERE category_id = $cat_id AND user_id = '$user_id'")->fetchAssoc();

        

        if ($checkExp['cnt'] > 0 || $checkInc['cnt'] > 0 || $checkBud['cnt'] > 0) {

            $msg = "Kategori tidak boleh dipadam kerana sedang digunakan dalam rekod transaksi atau bajet anda."; $msg_type = "error";

        } else {

            DB::Exec("DELETE FROM tbl_categories WHERE id = $cat_id");

            $msg = "Kategori berjaya dipadam."; $msg_type = "success";

        }

    }

}



// --- AMBIL SENARAI KATEGORI KEPADA 4 ARRAY BERBEZA ---

$categories_expense = [];

$categories_income = [];

$categories_commitment = [];

$categories_investment = [];



// KEMASKINI: Hanya tarik kategori milik user_id ini (atau 0)

$sqlCat = "SELECT id, name, type_id, type, color_code FROM tbl_categories WHERE $user_filter ORDER BY name ASC";

$rsCat = DB::Query($sqlCat);



if($rsCat) {

    while($row = $rsCat->fetchAssoc()){

        if($row['type_id'] == 1) { $categories_expense[] = $row; } 

        elseif($row['type_id'] == 2) { $categories_income[] = $row; } 

        elseif($row['type_id'] == 3) { $categories_commitment[] = $row; }

        elseif($row['type_id'] == 4) { $categories_investment[] = $row; }

    }

}

?>



<!DOCTYPE html>

<html lang="en" x-data="{ 

    sidebarOpen: window.innerWidth > 1024, 

    darkMode: $persist(false),

    catPopup: false,

    editMode: false,

    activeTab: 1, 

    formData: { id: '', name: '', type_id: '1', color_code: '#8b5cf6' },

    

    openAddModal() {

        this.editMode = false;

        this.formData = { id: '', name: '', type_id: this.activeTab.toString(), color_code: '#8b5cf6' };

        this.catPopup = true;

    },

    

    openEditModal(id, name, type_id, color) {

        this.editMode = true;

        this.formData = { id: id, name: name, type_id: type_id.toString(), color_code: color };

        this.catPopup = true;

    }

}" :class="darkMode ? 'dark' : ''">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pengurusan Kategori</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://unpkg.com/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">

    <script> tailwind.config = { darkMode: 'class', } </script>

    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; transition: background-color 0.3s ease; } [x-cloak] { display: none !important; } </style>

</head>



<body class="flex min-h-screen" :class="darkMode ? 'bg-slate-900 text-slate-200' : 'bg-slate-50 text-slate-800'">



    <?php include('sidebar.php'); ?>

    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden"></div>



    <main class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto custom-scrollbar">

        <?php $page_title = "Tetapan Kategori"; include('header.php'); ?>



        <div class="p-6 max-w-5xl mx-auto w-full">

            

            <?php if(!empty($msg)): ?>

            <div class="<?php echo $msg_type === 'success' ? 'bg-emerald-100 border-emerald-400 text-emerald-700' : 'bg-rose-100 border-rose-400 text-rose-700'; ?> border px-4 py-3 rounded-xl mb-6 flex items-center shadow-sm" role="alert">

                <i class="fas <?php echo $msg_type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?> mr-2 text-xl"></i>

                <span class="block sm:inline text-sm font-bold"><?php echo $msg; ?></span>

            </div>

            <?php endif; ?>



            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden mb-6">

                

                <div class="p-6 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                    <div>

                        <h2 class="text-xl font-black text-slate-800 dark:text-white">Senarai Kategori</h2>

                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-1">Urus semua kategori aliran tunai anda</p>

                    </div>

                    <div class="flex items-center gap-3">

                        <span class="px-3 py-1 bg-slate-200 dark:bg-slate-700 rounded-lg text-[10px] font-bold tracking-widest uppercase">ID: <?php echo $user_id; ?></span>

                        <button @click="openAddModal()" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg font-bold uppercase tracking-wider text-[10px] hover:bg-indigo-700 shadow-sm transition-colors flex items-center justify-center gap-2">

                            <i class="fas fa-plus"></i> Kategori Baru

                        </button>

                    </div>

                </div>



                <div class="flex overflow-x-auto border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 px-6 pt-4 gap-6 custom-scrollbar">

                    <button @click="activeTab = 2" class="pb-3 text-sm font-bold border-b-2 transition-colors flex items-center gap-2 whitespace-nowrap" :class="activeTab === 2 ? 'border-sky-500 text-sky-600 dark:text-sky-400' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'">

                        <i class="fas fa-hand-holding-usd"></i> Pendapatan

                    </button>

                    <button @click="activeTab = 3" class="pb-3 text-sm font-bold border-b-2 transition-colors flex items-center gap-2 whitespace-nowrap" :class="activeTab === 3 ? 'border-amber-500 text-amber-600 dark:text-amber-400' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'">

                        <i class="fas fa-file-invoice-dollar"></i> Komitmen

                    </button>

                    <button @click="activeTab = 1" class="pb-3 text-sm font-bold border-b-2 transition-colors flex items-center gap-2 whitespace-nowrap" :class="activeTab === 1 ? 'border-rose-500 text-rose-600 dark:text-rose-400' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'">

                        <i class="fas fa-shopping-cart"></i> Perbelanjaan

                    </button>

                    <button @click="activeTab = 4" class="pb-3 text-sm font-bold border-b-2 transition-colors flex items-center gap-2 whitespace-nowrap" :class="activeTab === 4 ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'">

                        <i class="fas fa-seedling"></i> Pelaburan

                    </button>

                </div>



                <div class="overflow-x-auto">

                    <table class="w-full text-left border-collapse">

                        <thead>

                            <tr class="bg-white dark:bg-slate-800 text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 border-b border-slate-100 dark:border-slate-700">

                                <th class="px-6 py-4 w-16 text-center">Warna</th>

                                <th class="px-6 py-4">Nama Kategori</th>

                                <th class="px-6 py-4 text-center w-32">Tindakan</th>

                            </tr>

                        </thead>



                        <tbody class="text-sm" x-show="activeTab === 1" x-cloak>

                            <?php foreach($categories_expense as $cat): ?>

                                <tr class="border-b border-slate-50 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-colors">

                                    <td class="px-6 py-4 text-center"><div class="w-6 h-6 rounded-full mx-auto shadow-sm border border-slate-200 dark:border-slate-600" style="background-color: <?php echo $cat['color_code']; ?>;"></div></td>

                                    <td class="px-6 py-4 text-slate-700 dark:text-slate-300 font-bold"><?php echo htmlspecialchars($cat['name']); ?></td>

                                    <td class="px-6 py-4 text-center flex justify-center gap-2">

                                        <button @click="openEditModal(<?php echo $cat['id']; ?>, '<?php echo addslashes($cat['name']); ?>', '<?php echo $cat['type_id']; ?>', '<?php echo addslashes($cat['color_code']); ?>')" class="p-2 text-indigo-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-lg"><i class="fas fa-edit"></i></button>

                                        <form method="POST" action="manage_categories.php" onsubmit="return confirm('Padam kategori ini?');" class="inline"><input type="hidden" name="action" value="delete"><input type="hidden" name="cat_id" value="<?php echo $cat['id']; ?>"><button type="submit" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-lg"><i class="fas fa-trash-alt"></i></button></form>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>



                        <tbody class="text-sm" x-show="activeTab === 2" x-cloak>

                            <?php foreach($categories_income as $cat): ?>

                                <tr class="border-b border-slate-50 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-colors">

                                    <td class="px-6 py-4 text-center"><div class="w-6 h-6 rounded-full mx-auto shadow-sm border border-slate-200 dark:border-slate-600" style="background-color: <?php echo $cat['color_code']; ?>;"></div></td>

                                    <td class="px-6 py-4 text-slate-700 dark:text-slate-300 font-bold"><?php echo htmlspecialchars($cat['name']); ?></td>

                                    <td class="px-6 py-4 text-center flex justify-center gap-2">

                                        <button @click="openEditModal(<?php echo $cat['id']; ?>, '<?php echo addslashes($cat['name']); ?>', '<?php echo $cat['type_id']; ?>', '<?php echo addslashes($cat['color_code']); ?>')" class="p-2 text-indigo-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-lg"><i class="fas fa-edit"></i></button>

                                        <form method="POST" action="manage_categories.php" onsubmit="return confirm('Padam kategori ini?');" class="inline"><input type="hidden" name="action" value="delete"><input type="hidden" name="cat_id" value="<?php echo $cat['id']; ?>"><button type="submit" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-lg"><i class="fas fa-trash-alt"></i></button></form>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>



                        <tbody class="text-sm" x-show="activeTab === 3" x-cloak>

                            <?php foreach($categories_commitment as $cat): ?>

                                <tr class="border-b border-slate-50 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-colors">

                                    <td class="px-6 py-4 text-center"><div class="w-6 h-6 rounded-full mx-auto shadow-sm border border-slate-200 dark:border-slate-600" style="background-color: <?php echo $cat['color_code']; ?>;"></div></td>

                                    <td class="px-6 py-4 text-slate-700 dark:text-slate-300 font-bold"><?php echo htmlspecialchars($cat['name']); ?></td>

                                    <td class="px-6 py-4 text-center flex justify-center gap-2">

                                        <button @click="openEditModal(<?php echo $cat['id']; ?>, '<?php echo addslashes($cat['name']); ?>', '<?php echo $cat['type_id']; ?>', '<?php echo addslashes($cat['color_code']); ?>')" class="p-2 text-indigo-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-lg"><i class="fas fa-edit"></i></button>

                                        <form method="POST" action="manage_categories.php" onsubmit="return confirm('Padam kategori ini?');" class="inline"><input type="hidden" name="action" value="delete"><input type="hidden" name="cat_id" value="<?php echo $cat['id']; ?>"><button type="submit" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-lg"><i class="fas fa-trash-alt"></i></button></form>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>



                        <tbody class="text-sm" x-show="activeTab === 4" x-cloak>

                            <?php foreach($categories_investment as $cat): ?>

                                <tr class="border-b border-slate-50 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-colors">

                                    <td class="px-6 py-4 text-center"><div class="w-6 h-6 rounded-full mx-auto shadow-sm border border-slate-200 dark:border-slate-600" style="background-color: <?php echo $cat['color_code']; ?>;"></div></td>

                                    <td class="px-6 py-4 text-slate-700 dark:text-slate-300 font-bold"><?php echo htmlspecialchars($cat['name']); ?></td>

                                    <td class="px-6 py-4 text-center flex justify-center gap-2">

                                        <button @click="openEditModal(<?php echo $cat['id']; ?>, '<?php echo addslashes($cat['name']); ?>', '<?php echo $cat['type_id']; ?>', '<?php echo addslashes($cat['color_code']); ?>')" class="p-2 text-indigo-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900/30 rounded-lg"><i class="fas fa-edit"></i></button>

                                        <form method="POST" action="manage_categories.php" onsubmit="return confirm('Padam kategori ini?');" class="inline"><input type="hidden" name="action" value="delete"><input type="hidden" name="cat_id" value="<?php echo $cat['id']; ?>"><button type="submit" class="p-2 text-slate-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/30 rounded-lg"><i class="fas fa-trash-alt"></i></button></form>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <?php include('footer.php'); ?>

    </main>



    <div x-show="catPopup" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all">

        <div @click.away="catPopup = false" class="bg-white dark:bg-slate-800 w-full max-w-sm rounded-3xl p-6 shadow-2xl">

            <div class="flex justify-between items-start mb-6">

                <div>

                    <p class="text-[9px] font-black text-indigo-500 uppercase tracking-widest mb-1" x-text="editMode ? 'Kemaskini Data' : 'Rekod Baru'"></p>

                    <h3 class="text-xl font-black text-slate-800 dark:text-white" x-text="editMode ? 'Edit Kategori' : 'Tambah Kategori'"></h3>

                </div>

                <button @click="catPopup = false" class="text-slate-300 hover:text-rose-500 transition-colors"><i class="fas fa-times-circle text-xl"></i></button>

            </div>

            

            <form method="POST" action="manage_categories.php">

                <input type="hidden" name="action" :value="editMode ? 'edit' : 'add'">

                <input type="hidden" name="cat_id" :value="formData.id">

                <div class="space-y-5">

                    <div>

                        <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Jenis Kategori</label>

                        <select name="type_id" x-model="formData.type_id" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-2.5 text-sm font-bold text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">

                            <option value="2">Pendapatan (Masuk)</option>

                            <option value="3">Komitmen Bulanan (Bil Tetap)</option>

                            <option value="4">Pelaburan / Simpanan</option>

                            <option value="1">Perbelanjaan (Harian)</option>

                        </select>

                    </div>

                    <div>

                        <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Nama Kategori</label>

                        <input type="text" name="name" x-model="formData.name" required placeholder="Cth: Gaji, Makanan..." class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-2.5 text-sm font-bold text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-indigo-500 outline-none">

                    </div>

                    <div>

                        <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Warna (Untuk Carta)</label>

                        <div class="flex items-center gap-3">

                            <input type="color" name="color_code" x-model="formData.color_code" required class="w-12 h-12 rounded cursor-pointer border-0 bg-transparent p-0">

                            <input type="text" x-model="formData.color_code" class="flex-1 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-2.5 text-sm font-bold text-slate-700 dark:text-slate-300 outline-none uppercase" readonly>

                        </div>

                    </div>

                </div>

                <div class="mt-8 flex gap-3">

                    <button type="button" @click="catPopup = false" class="w-1/3 py-2.5 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-lg font-bold uppercase tracking-wide text-[10px] hover:bg-slate-300">Batal</button>

                    <button type="submit" class="w-2/3 py-2.5 bg-indigo-600 text-white rounded-lg font-bold uppercase tracking-wide text-[10px] hover:bg-indigo-700 shadow-md" x-text="editMode ? 'Simpan' : 'Tambah'"></button>

                </div>

            </form>

        </div>

    </div>

</body>

</html>