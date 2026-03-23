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
// 1. DAPATKAN ID PENGGUNA & FULLNAME (UNIVERSAL)
// =========================================================
$login_username = isset($_SESSION["UserID"]) ? $_SESSION["UserID"] : ""; 
$user_id = 0; $user_fullname = "Pengguna";

$sqlCheckUser = "SELECT ID, fullname, fullname1 FROM tbl_users WHERE username = " . db_prepare_string($login_username) . " OR email = " . db_prepare_string($login_username) . " OR ext_security_id = " . db_prepare_string($login_username) . " LIMIT 1";
$rsUser = DB::Query($sqlCheckUser);
if ($rsUser && $rowUser = $rsUser->fetchAssoc()) {
    $user_id = $rowUser['ID']; 
    $user_fullname = !empty($rowUser['fullname1']) ? $rowUser['fullname1'] : (!empty($rowUser['fullname']) ? $rowUser['fullname'] : $login_username);
    $_SESSION["UserDbID"] = $user_id; $_SESSION["UserFullName"] = $user_fullname;
} elseif (isset($_SESSION["UserDbID"]) && $_SESSION["UserDbID"] != 0) {
    $user_id = $_SESSION["UserDbID"];
}

// PENAPIS KETAT: Baca data milik ID sebenar sahaja
$user_filter = "(user_id = '$user_id')";

$msg = "";
$msg_type = "";

// ==========================================
// KAMUS BAHASA MELAYU UNTUK BULAN
// ==========================================
$bulan_melayu = [
    '01' => 'Januari', '02' => 'Februari', '03' => 'Mac',
    '04' => 'April', '05' => 'Mei', '06' => 'Jun',
    '07' => 'Julai', '08' => 'Ogos', '09' => 'September',
    '10' => 'Oktober', '11' => 'November', '12' => 'Disember'
];

$bulan_singkat = [
    '01' => 'Jan', '02' => 'Feb', '03' => 'Mac', '04' => 'Apr',
    '05' => 'Mei', '06' => 'Jun', '07' => 'Jul', '08' => 'Ogo',
    '09' => 'Sep', '10' => 'Okt', '11' => 'Nov', '12' => 'Dis'
];

// ========================================================================
// 1. PENGURUSAN TAMBAH TRANSAKSI
// ========================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_expense') {
    $dates = $_POST['expense_date'];
    $amounts = $_POST['amount'];
    $categories = $_POST['category_id'];
    $descriptions = $_POST['description'];
    $created_at = date('Y-m-d H:i:s');
    
    for ($i = 0; $i < count($amounts); $i++) {
        $expense_date = $dates[$i];
        $amount = floatval($amounts[$i]);
        $category_id = intval($categories[$i]);
        $description = $descriptions[$i];
        $receipt_path = NULL;
        $is_lhdn = isset($_POST['is_lhdn'][$i]) ? 1 : 0; // REKOD LHDN
        
        if (isset($_FILES['receipt']['name'][$i]) && $_FILES['receipt']['error'][$i] == UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/receipts/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true); 
            
            $source = $_FILES['receipt']['tmp_name'][$i];
            $ext = strtolower(pathinfo($_FILES['receipt']['name'][$i], PATHINFO_EXTENSION));
            $allowed_ext = ['jpg', 'jpeg', 'png', 'pdf'];
            
            if (in_array($ext, $allowed_ext)) {
                $target_path = $upload_dir . uniqid('doc_') . '.' . ($ext === 'pdf' ? 'pdf' : 'jpg');
                if ($ext === 'pdf') {
                    move_uploaded_file($source, $target_path);
                    $receipt_path = $target_path;
                } else {
                    $info = getimagesize($source);
                    if ($info['mime'] == 'image/jpeg' || $ext == 'jpg' || $ext == 'jpeg') {
                        $image = imagecreatefromjpeg($source);
                        imagejpeg($image, $target_path, 60); 
                        imagedestroy($image);
                        $receipt_path = $target_path;
                    } elseif ($info['mime'] == 'image/png' || $ext == 'png') {
                        $image = imagecreatefrompng($source);
                        $bg = imagecreatetruecolor(imagesx($image), imagesy($image));
                        imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255));
                        imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image));
                        imagejpeg($bg, $target_path, 60); 
                        imagedestroy($image);
                        imagedestroy($bg);
                        $receipt_path = $target_path;
                    }
                }
            }
        }
        
        if ($amount > 0 && $category_id > 0) {
            $db_receipt = $receipt_path !== NULL ? "'" . $receipt_path . "'" : "NULL";
            $insertSQL = "INSERT INTO tbl_expenses (user_id, category_id, expense_date, amount, description, receipt_path, created_at, is_lhdn) 
                          VALUES ('$user_id', $category_id, " . db_prepare_string($expense_date) . ", $amount, " . db_prepare_string($description) . ", $db_receipt, '$created_at', $is_lhdn)";
            DB::Exec($insertSQL);
        }
    }
    header("Location: menu.php?msg=success"); exit();
}

// ==========================================
// LOGIK FILTER BULANAN (DEFAULT: BULAN SEMASA)
// ==========================================
$filter_month = isset($_GET['filter_month']) ? $_GET['filter_month'] : date('Y-m'); 

$parts = explode('-', $filter_month);
if(count($parts) != 2) {
    $sel_year = date('Y');
    $sel_month = date('m');
    $filter_month = date('Y-m');
} else {
    $sel_year = $parts[0];
    $sel_month = $parts[1];
}

$start_date = $filter_month . '-01';
$end_date = date('Y-m-d', strtotime("$start_date +1 month"));

$date_filter_sql_e = " AND e.expense_date >= '$start_date' AND e.expense_date < '$end_date' ";

$nama_bulan_penuh = $bulan_melayu[$sel_month];
$banner_subtitle = "Rekod Perbelanjaan Bulan " . $nama_bulan_penuh . " " . $sel_year;

// Ambil senarai Tahun dari DB untuk Dropdown
$years_list = [];
$rsYears = DB::Query("SELECT DISTINCT DATE_FORMAT(expense_date, '%Y') as y_val FROM tbl_expenses WHERE user_id = '$user_id' ORDER BY y_val DESC");
if($rsYears) { while($rowY = $rsYears->fetchAssoc()){ $years_list[] = $rowY['y_val']; } }
if(empty($years_list)) { $years_list[] = date('Y'); }
if(!in_array(date('Y'), $years_list)) { $years_list[] = date('Y'); rsort($years_list); }

// ==========================================
// PENGIRAAN DATA PERBELANJAAN (type_id = 1)
// ==========================================

// 1. JUMLAH KESELURUHAN
$grand_total = 0;
$sqlTotal = "
    SELECT SUM(e.amount) as val 
    FROM tbl_expenses e 
    JOIN tbl_categories c ON e.category_id = c.id 
    WHERE e.user_id = '$user_id' AND c.type_id = 1 $date_filter_sql_e
";
$rsTotal = DB::Query($sqlTotal);
if($rsTotal && $row = $rsTotal->fetchAssoc()) { 
    $grand_total = floatval($row['val']); 
}

// 2. PECAHAN MENGIKUT KATEGORI & BAJET (DIBETULKAN UNTUK USER SAHAJA)
$cat_breakdown = [];
$pie_labels = []; $pie_data = []; $pie_colors = [];
$total_budget_pie = 0;

$sqlBreakdown = "
    SELECT c.id, c.name, c.color_code, 
           COALESCE(SUM(e.amount), 0) as total,
           COALESCE((SELECT amount FROM tbl_budgets b WHERE b.category_id = c.id AND b.user_id = '$user_id' AND b.budget_month <= '$filter_month' ORDER BY budget_month DESC LIMIT 1), 0) as budget_amount
    FROM tbl_categories c 
    LEFT JOIN tbl_expenses e ON c.id = e.category_id AND e.user_id = '$user_id' $date_filter_sql_e
    WHERE c.type_id = 1 AND (c.user_id = '$user_id' OR c.user_id = 0 OR c.user_id IS NULL)
    GROUP BY c.id 
    ORDER BY total DESC, c.name ASC
";
$rsBreakdown = DB::Query($sqlBreakdown);
if($rsBreakdown) {
    while($row = $rsBreakdown->fetchAssoc()) {
        $cat_breakdown[] = $row;
        if (floatval($row['budget_amount']) > 0) {
            $pie_labels[] = $row['name'];
            $pie_data[] = floatval($row['budget_amount']); 
            $pie_colors[] = $row['color_code'] ? $row['color_code'] : '#f43f5e';
            $total_budget_pie += floatval($row['budget_amount']);
        }
    }
}

// 3. SEJARAH TRANSAKSI (TERMASUK LHDN BADGE)
$history_list = [];
$sqlHistory = "
    SELECT e.expense_date, e.amount, e.description, c.name as cat_name, c.color_code, e.is_lhdn 
    FROM tbl_expenses e 
    JOIN tbl_categories c ON e.category_id = c.id 
    WHERE e.user_id = '$user_id' AND c.type_id = 1 $date_filter_sql_e
    ORDER BY e.expense_date DESC, e.id DESC
";
$rsHistory = DB::Query($sqlHistory);
if($rsHistory) {
    while($row = $rsHistory->fetchAssoc()) { $history_list[] = $row; }
}

$json_pie_labels = json_encode($pie_labels);
$json_pie_data = json_encode($pie_data);
$json_pie_colors = json_encode($pie_colors);

// DATA DROPDOWN UNTUK MODAL
$category_list_expense = [];
$rsCat = DB::Query("SELECT id, name, type_id FROM tbl_categories WHERE (user_id = '$user_id' OR user_id = 0 OR user_id IS NULL) AND type_id != 2 ORDER BY type_id DESC, name ASC");
if($rsCat) { 
    while($rowC = $rsCat->fetchAssoc()){ 
        $category_list_expense[] = $rowC; 
    } 
}
?>

<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: window.innerWidth > 1024, darkMode: $persist(false), expensePopup: false }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Perbelanjaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script> 
    <script> tailwind.config = { darkMode: 'class', } </script>
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; transition: background-color 0.3s ease; } [x-cloak] { display: none !important; } </style>
</head>

<body class="flex min-h-screen" :class="darkMode ? 'bg-slate-900 text-slate-200' : 'bg-slate-50 text-slate-800'">

    <?php include('sidebar.php'); ?>
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden"></div>

    <main class="flex-1 flex flex-col min-w-0 h-screen overflow-y-auto custom-scrollbar">
        <?php $page_title = "Portfolio Perbelanjaan"; include('header.php'); ?>

        <div class="p-6 max-w-7xl mx-auto w-full">
            
            <div class="mb-6 bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-rose-50 dark:bg-rose-900/30 text-rose-500 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest">Penapis Masa</h3>
                        <p class="text-[10px] font-bold text-slate-400">Pilih bulan dan tahun rekod</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-4">
                    <form method="GET" action="" class="flex items-center gap-2" x-data="{ y: '<?php echo $sel_year; ?>', m: '<?php echo $sel_month; ?>' }">
                        <input type="hidden" name="filter_month" :value="y + '-' + m">
                        
                        <select x-model="m" @change="$el.form.submit()" class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-sm rounded-lg focus:ring-rose-500 focus:border-rose-500 p-2.5 font-bold outline-none cursor-pointer">
                            <?php foreach($bulan_melayu as $num => $nama): ?>
                                <option value="<?php echo $num; ?>"><?php echo $nama; ?></option>
                            <?php endforeach; ?>
                        </select>

                        <select x-model="y" @change="$el.form.submit()" class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-sm rounded-lg focus:ring-rose-500 focus:border-rose-500 p-2.5 font-bold outline-none cursor-pointer">
                            <?php foreach($years_list as $y): ?>
                                <option value="<?php echo $y; ?>"><?php echo $y; ?></option>
                            <?php endforeach; ?>
                        </select>

                        <a href="?filter_month=<?php echo date('Y-m'); ?>" class="ml-2 p-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 rounded-lg transition-colors shadow-sm" title="Bulan Semasa">
                            <i class="fas fa-redo-alt text-xs"></i>
                        </a>
                    </form>
                    <div class="w-px h-8 bg-slate-200 dark:bg-slate-700 hidden sm:block"></div>
                    <button @click="expensePopup = true" class="hidden sm:flex px-4 py-2.5 bg-rose-500 text-white rounded-lg font-bold uppercase tracking-wider text-[10px] hover:bg-rose-600 shadow-md transition-colors items-center gap-2">
                        <i class="fas fa-plus"></i> Wang Keluar
                    </button>
                </div>
            </div>
            
            <div class="bg-rose-500 p-5 md:p-6 rounded-3xl shadow-lg relative overflow-hidden mb-6 text-white flex flex-col items-center justify-center text-center">
                <i class="fas fa-shopping-bag absolute -right-4 -bottom-4 text-7xl md:text-8xl opacity-10"></i>
                <p class="text-rose-100 text-[9px] md:text-[10px] font-black uppercase tracking-widest mb-0.5 relative z-10">Total Perbelanjaan Bulan Ini</p>
                <h2 class="text-3xl md:text-4xl font-black relative z-10 my-1">RM <?php echo number_format($grand_total, 2); ?></h2>
                <p class="text-rose-200 text-[8px] md:text-[9px] mt-1.5 relative z-10 uppercase tracking-widest"><?php echo $banner_subtitle; ?></p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                
                <div class="bg-white dark:bg-slate-800 p-5 md:p-6 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col items-center justify-start">
                    <h4 class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-4 w-full text-center">Pecahan Sasaran Bajet</h4>
                    <?php if($total_budget_pie > 0): ?>
                    <div class="w-full max-w-[300px] h-[280px] relative flex justify-center mt-2">
                        <canvas id="expensePieChart"></canvas>
                    </div>
                    <?php else: ?>
                    <div class="w-full h-[250px] flex flex-col items-center justify-center text-slate-400 mt-2">
                        <i class="fas fa-chart-pie text-4xl mb-3 opacity-20"></i>
                        <p class="text-[10px] font-bold uppercase tracking-widest">Tiada Bajet Ditetapkan</p>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden flex flex-col">
                    <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                        <h4 class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Prestasi Perbelanjaan vs Bajet</h4>
                    </div>
                    <div class="p-5 flex-1">
                        <div class="space-y-3.5 max-h-[300px] overflow-y-auto custom-scrollbar pr-2">
                            <?php if(count($cat_breakdown) > 0): ?>
                                <?php foreach($cat_breakdown as $cat): ?>
                                    <?php 
                                        $spent = floatval($cat['total']);
                                        $budget = floatval($cat['budget_amount']);
                                        $percentage = ($budget > 0) ? ($spent / $budget) * 100 : ($spent > 0 ? 100 : 0);
                                        $bar_width = min($percentage, 100);
                                        $bar_color = ($percentage > 100) ? '#e11d48' : ($cat['color_code'] ?: '#f43f5e');
                                    ?>
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <div class="flex items-center gap-2">
                                                <div class="w-2.5 h-2.5 rounded-full" style="background-color: <?php echo htmlspecialchars($cat['color_code']); ?>;"></div>
                                                <span class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase"><?php echo htmlspecialchars($cat['name']); ?></span>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-xs font-black <?php echo ($percentage > 100) ? 'text-rose-600 bg-rose-100 px-1 rounded dark:bg-rose-900/30' : 'text-slate-600 dark:text-slate-300'; ?>">
                                                    RM <?php echo number_format($spent, 2); ?>
                                                </span>
                                                <span class="text-[9px] font-bold <?php echo ($percentage > 100) ? 'text-rose-500' : 'text-slate-400'; ?> ml-1.5">(<?php echo number_format($percentage, 1); ?>%)</span>
                                            </div>
                                        </div>
                                        <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-1.5 mt-0.5">
                                            <div class="h-1.5 rounded-full" style="width: <?php echo $bar_width; ?>%; background-color: <?php echo $bar_color; ?>;"></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-center text-xs text-slate-400 font-bold py-6">Tiada rekod pada bulan ini.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden mb-6">
                <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 flex justify-between items-center">
                    <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest"><i class="fas fa-list-ul mr-2 text-rose-500"></i> Sejarah Transaksi Bulan Ini</h3>
                    <a href="expenses_list.php" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-wider">Papar Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-800/80 text-[9px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 border-b border-slate-200 dark:border-slate-700">
                                <th class="px-5 py-3 w-28">Tarikh</th>
                                <th class="px-5 py-3">Kategori</th>
                                <th class="px-5 py-3">Keterangan</th>
                                <th class="px-5 py-3 text-right">Jumlah (RM)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($history_list) > 0): ?>
                                <?php foreach($history_list as $t): ?>
                                <tr class="border-b border-slate-50 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-colors">
                                    <td class="px-5 py-3 text-slate-500 dark:text-slate-400 font-bold">
                                        <?php $ti = strtotime($t['expense_date']); echo date('d', $ti) . ' ' . $bulan_singkat[date('m', $ti)] . ' ' . date('Y', $ti); ?>
                                    </td>
                                    <td class="px-5 py-3"><span class="text-slate-700 dark:text-slate-300 font-bold"><?php echo htmlspecialchars($t['cat_name']); ?></span></td>
                                    <td class="px-5 py-3 text-slate-600 dark:text-slate-400">
                                        <?php echo htmlspecialchars($t['description']); ?>
                                        <?php if(isset($t['is_lhdn']) && $t['is_lhdn'] == 1): ?>
                                            <span class="ml-2 inline-block px-2 py-0.5 bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 text-[8px] font-black rounded-md uppercase tracking-widest border border-emerald-200 dark:border-emerald-800" title="Pelepasan Cukai LHDN">LHDN</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-5 py-3 text-right font-black text-rose-600 dark:text-rose-400">- <?php echo number_format($t['amount'], 2); ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="px-5 py-12 text-center text-slate-400 font-bold uppercase tracking-widest">Tiada Rekod</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </main>

    <div x-show="expensePopup" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all text-left">
        <div @click.away="expensePopup = false" class="bg-white dark:bg-slate-800 w-full max-w-2xl rounded-3xl p-6 shadow-2xl border dark:border-slate-700">
            <div class="flex justify-between items-start mb-5">
                <div>
                    <p class="text-[9px] font-black text-rose-500 uppercase tracking-widest mb-1">Wang Keluar</p>
                    <h3 class="text-xl font-black text-slate-800 dark:text-white">Tambah Komitmen / Belanja</h3>
                </div>
                <button @click="expensePopup = false" class="text-slate-300 hover:text-rose-500 transition-colors"><i class="fas fa-times-circle text-xl"></i></button>
            </div>
            
            <form method="POST" action="expenses_portfolio.php" enctype="multipart/form-data" x-data="{ rows: [{id: 1, fileReady: false, fileName: ''}] }">
                <input type="hidden" name="action" value="add_expense">
                
                <div class="flex justify-between items-center mb-3">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Senarai Wang Keluar</p>
                    <button type="button" @click="rows.push({id: Date.now(), fileReady: false, fileName: ''})" class="text-[10px] bg-rose-100 text-rose-600 dark:bg-rose-900/40 dark:text-rose-400 px-3 py-1.5 rounded-lg font-bold hover:bg-rose-200 transition-colors">
                        <i class="fas fa-plus mr-1"></i> Tambah Baris
                    </button>
                </div>

                <div class="max-h-[50vh] overflow-y-auto space-y-4 pr-2 custom-scrollbar">
                    <template x-for="(row, index) in rows" :key="row.id">
                        <div class="p-4 border border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-900/30 rounded-2xl relative">
                            <button type="button" x-show="rows.length > 1" @click="rows.splice(index, 1)" class="absolute top-3 right-3 text-slate-300 hover:text-rose-500 transition-colors">
                                <i class="fas fa-times-circle"></i>
                            </button>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Tarikh</label>
                                    <input type="date" :name="'expense_date[' + index + ']'" required value="<?php echo date('Y-m-d'); ?>" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-2.5 text-sm text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-rose-500 outline-none">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Jumlah (RM)</label>
                                    <input type="number" step="0.01" :name="'amount[' + index + ']'" required placeholder="0.00" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-2.5 text-sm text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-rose-500 outline-none">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Kategori / Komitmen</label>
                                    <div x-data="{ open: false, search: '', selected: '', selectedText: '-- Cari & Pilih --' }" class="relative w-full">
                                        <select :name="'category_id[' + index + ']'" required x-model="selected" class="absolute opacity-0 inset-0 -z-10 pointer-events-none" tabindex="-1">
                                            <option value=""></option>
                                            <?php foreach($category_list_expense as $cat): ?>
                                                <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="button" @click="open = !open" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-2.5 text-sm text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-rose-500 outline-none flex justify-between items-center text-left transition-colors">
                                            <span x-text="selectedText" class="truncate" :class="selected === '' ? 'text-slate-400' : ''"></span>
                                            <i class="fas fa-chevron-down text-[10px] text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                                        </button>
                                        <div x-show="open" @click.away="open = false" x-transition class="absolute z-[70] w-full mt-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-xl overflow-hidden" x-cloak>
                                            <div class="p-2 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
                                                <div class="relative">
                                                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                                    <input type="text" x-model="search" @keydown.enter.prevent="" placeholder="Taip untuk cari..." class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-md py-1.5 pl-8 pr-3 text-xs text-slate-700 dark:text-slate-300 focus:ring-1 focus:ring-rose-500 outline-none shadow-sm">
                                                </div>
                                            </div>
                                            <ul class="max-h-48 overflow-y-auto custom-scrollbar p-1">
                                                <?php foreach($category_list_expense as $cat): ?>
                                                    <?php 
                                                        $prefix = '';
                                                        if($cat['type_id'] == 3) $prefix = '[KOMITMEN] ';
                                                        elseif($cat['type_id'] == 4) $prefix = '[PELABURAN] ';
                                                        else $prefix = '[BELANJA] ';
                                                        $display_name = $prefix . $cat['name'];
                                                    ?>
                                                    <li x-show="search === '' || '<?php echo strtolower(addslashes($display_name)); ?>'.includes(search.toLowerCase())"
                                                        @click="selected = '<?php echo $cat['id']; ?>'; selectedText = '<?php echo addslashes($display_name); ?>'; open = false; search = ''"
                                                        class="px-3 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-rose-50 dark:hover:bg-slate-700 hover:text-rose-600 dark:hover:text-rose-400 rounded-md cursor-pointer transition-colors"
                                                        :class="selected === '<?php echo $cat['id']; ?>' ? 'bg-rose-50 dark:bg-slate-700 text-rose-600 dark:text-rose-400' : ''">
                                                        <?php echo htmlspecialchars($display_name); ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Keterangan / Nota</label>
                                    <input type="text" :name="'description[' + index + ']'" maxlength="100" required placeholder="Contoh: Barang dapur..." class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-2.5 text-sm text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-rose-500 outline-none">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Muat Naik Resit (Pilihan - JPG/PNG/PDF)</label>
                                <div class="flex items-center gap-3">
                                    <label class="cursor-pointer bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 px-3 py-2 rounded-lg text-[10px] font-bold text-slate-600 dark:text-slate-300 transition-colors flex items-center gap-2">
                                        <i class="fas fa-upload text-rose-500"></i> Pilih Fail
                                        <input type="file" :name="'receipt[' + index + ']'" accept=".jpg,.jpeg,.png,.pdf" class="hidden" @change="row.fileReady = !!$event.target.files.length; row.fileName = $event.target.files.length ? $event.target.files[0].name : ''">
                                    </label>
                                    <span x-show="row.fileReady" class="text-[9px] font-bold text-emerald-500 flex items-center gap-1">
                                        <i class="fas fa-check-circle"></i> <span x-text="row.fileName" class="truncate max-w-[150px] inline-block"></span>
                                    </span>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex items-center gap-2 p-3 bg-rose-50 dark:bg-rose-900/10 border border-rose-100 dark:border-rose-800/30 rounded-xl">
                                <input type="checkbox" :id="'is_lhdn_' + index" :name="'is_lhdn[' + index + ']'" value="1" class="w-4 h-4 text-rose-500 bg-white border-slate-300 rounded focus:ring-rose-500 cursor-pointer dark:bg-slate-900 dark:border-slate-700 accent-rose-500">
                                <label :for="'is_lhdn_' + index" class="text-[10px] font-bold text-rose-600 dark:text-rose-400 uppercase tracking-wide cursor-pointer select-none">Tandakan untuk Pelepasan Cukai (LHDN)</label>
                            </div>
                            
                        </div>
                    </template>
                </div>
                
                <div class="mt-6 flex gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button type="button" @click="expensePopup = false" class="w-1/3 py-2.5 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-lg font-bold uppercase tracking-wide text-[10px] hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">Batal</button>
                    <button type="submit" class="w-2/3 py-2.5 bg-rose-500 text-white rounded-lg font-bold uppercase tracking-wide text-[10px] hover:bg-rose-600 shadow-md transition-colors">Simpan Rekod Wang Keluar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        Chart.register(ChartDataLabels);
        document.addEventListener('DOMContentLoaded', function() {
            if(document.getElementById('expensePieChart')) {
                Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
                Chart.defaults.color = '#94a3b8';
                
                const pieCtx = document.getElementById('expensePieChart').getContext('2d');
                new Chart(pieCtx, {
                    type: 'doughnut',
                    data: {
                        labels: <?php echo $json_pie_labels; ?>,
                        datasets: [{ data: <?php echo $json_pie_data; ?>, backgroundColor: <?php echo $json_pie_colors; ?>, borderWidth: 0, hoverOffset: 6 }]
                    },
                    options: { 
                        responsive: true, maintainAspectRatio: false, layout: { padding: 10 },
                        plugins: { 
                            legend: { position: 'bottom', labels: { font: {size: 10, weight: 'bold'}, usePointStyle: true, pointStyle: 'circle', padding: 15 } },
                            datalabels: {
                                color: '#ffffff', font: { weight: 'bold', size: 11 },
                                formatter: (value, ctx) => {
                                    let dataset = ctx.chart.data.datasets[0].data;
                                    let sum = dataset.reduce((a, b) => a + b, 0);
                                    if(sum === 0) return '';
                                    
                                    let exactPct = dataset.map(v => (v / sum) * 100);
                                    let flooredPct = exactPct.map(v => Math.floor(v * 100) / 100);
                                    let remainders = exactPct.map((v, i) => ({ idx: i, rem: v - flooredPct[i] }));
                                    
                                    let currentSum = flooredPct.reduce((a, b) => a + b, 0);
                                    let diff = Math.round((100 - currentSum) * 100);
                                    
                                    remainders.sort((a, b) => b.rem - a.rem);
                                    for (let i = 0; i < diff; i++) { flooredPct[remainders[i].idx] += 0.01; }
                                    
                                    return flooredPct[ctx.dataIndex].toFixed(2) + "%";
                                }
                            }
                        }, cutout: '65%' 
                    }
                });
            }
        });
    </script>
</body>
</html>