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

// PENAPIS KETAT: Hanya baca data milik ID sebenar ini
$user_filter = "(user_id = '$user_id')";
$user_filter_i = "(i.user_id = '$user_id')";
$user_filter_b = "(b.user_id = '$user_id')";

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

$date_filter_sql = " AND income_date >= '$start_date' AND income_date < '$end_date' ";
$date_filter_sql_i = " AND i.income_date >= '$start_date' AND i.income_date < '$end_date' ";

$nama_bulan_penuh = $bulan_melayu[$sel_month];
$banner_subtitle = "Rekod Aliran Masuk Bulan " . $nama_bulan_penuh . " " . $sel_year;
$current_month = $filter_month; // Set variable for queries below

// Ambil senarai Tahun dari DB untuk Dropdown
$years_list = [];
$rsYears = DB::Query("SELECT DISTINCT DATE_FORMAT(income_date, '%Y') as y_val FROM tbl_income WHERE $user_filter ORDER BY y_val DESC");
if($rsYears) { while($rowY = $rsYears->fetchAssoc()){ $years_list[] = $rowY['y_val']; } }
if(empty($years_list)) { $years_list[] = date('Y'); }
if(!in_array(date('Y'), $years_list)) { $years_list[] = date('Y'); rsort($years_list); }

// ========================================================================
// 2. PENGURUSAN TAMBAH PERBELANJAAN (WANG KELUAR)
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
        $is_lhdn = isset($_POST['is_lhdn'][$i]) ? 1 : 0; // LHDN
        
        if (isset($_FILES['receipt']['name'][$i]) && $_FILES['receipt']['error'][$i] == UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/receipts/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true); 
            $source = $_FILES['receipt']['tmp_name'][$i];
            $ext = strtolower(pathinfo($_FILES['receipt']['name'][$i], PATHINFO_EXTENSION));
            $allowed_ext = ['jpg', 'jpeg', 'png', 'pdf'];
            
            if (in_array($ext, $allowed_ext)) {
                $target_path = $upload_dir . uniqid('doc_') . '.' . ($ext === 'pdf' ? 'pdf' : 'jpg');
                if ($ext === 'pdf') { move_uploaded_file($source, $target_path); $receipt_path = $target_path; } 
                else {
                    $info = getimagesize($source);
                    if ($info['mime'] == 'image/jpeg' || $ext == 'jpg' || $ext == 'jpeg') { $image = imagecreatefromjpeg($source); imagejpeg($image, $target_path, 60); imagedestroy($image); $receipt_path = $target_path; } 
                    elseif ($info['mime'] == 'image/png' || $ext == 'png') { $image = imagecreatefrompng($source); $bg = imagecreatetruecolor(imagesx($image), imagesy($image)); imagefill($bg, 0, 0, imagecolorallocate($bg, 255, 255, 255)); imagecopy($bg, $image, 0, 0, 0, 0, imagesx($image), imagesy($image)); imagejpeg($bg, $target_path, 60); imagedestroy($image); imagedestroy($bg); $receipt_path = $target_path; }
                }
            }
        }
        
        if ($amount > 0 && $category_id > 0) {
            $db_receipt = $receipt_path !== NULL ? "'" . $receipt_path . "'" : "NULL";
            DB::Exec("INSERT INTO tbl_expenses (user_id, category_id, expense_date, amount, description, receipt_path, created_at, is_lhdn) VALUES ('$user_id', $category_id, " . db_prepare_string($expense_date) . ", $amount, " . db_prepare_string($description) . ", $db_receipt, '$created_at', $is_lhdn)");
        }
    }
    header("Location: menu.php?msg=success"); exit();
}

// ========================================================================
// 3. PENGURUSAN TAMBAH PENDAPATAN
// ========================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add_income') {
    $dates = $_POST['income_date']; 
    $amounts = $_POST['amount'];    
    $categories = $_POST['category_id']; 
    $descriptions = $_POST['description']; 
    $created_at = date('Y-m-d H:i:s');
    
    for ($i = 0; $i < count($amounts); $i++) {
        $income_date = $dates[$i];
        $amount = floatval($amounts[$i]);
        $category_id = intval($categories[$i]);
        $description = $descriptions[$i];
        $receipt_path = NULL;
        
        if (isset($_FILES['receipt']['name'][$i]) && $_FILES['receipt']['error'][$i] == UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/receipts/';
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true); 
            $source = $_FILES['receipt']['tmp_name'][$i];
            $ext = strtolower(pathinfo($_FILES['receipt']['name'][$i], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'pdf'])) {
                $target_path = $upload_dir . uniqid('doc_') . '.' . ($ext === 'pdf' ? 'pdf' : 'jpg');
                if ($ext === 'pdf') { move_uploaded_file($source, $target_path); $receipt_path = $target_path; } 
                else { $img = ($ext == 'png') ? imagecreatefrompng($source) : imagecreatefromjpeg($source); imagejpeg($img, $target_path, 60); imagedestroy($img); $receipt_path = $target_path; }
            }
        }
        
        if ($amount > 0 && $category_id > 0) {
            $db_receipt = $receipt_path !== NULL ? "'" . $receipt_path . "'" : "NULL";
            DB::Exec("INSERT INTO tbl_income (user_id, category_id, income_date, amount, description, receipt_path, created_at) VALUES ('$user_id', $category_id, " . db_prepare_string($income_date) . ", $amount, " . db_prepare_string($description) . ", $db_receipt, '$created_at')");
        }
    }
    header("Location: menu.php?msg=income_success"); exit();
}

// ==========================================
// 4. PENGIRAAN STATISTIK 
// ==========================================
$sqlGaji = "SELECT i.amount FROM tbl_income i JOIN tbl_categories c ON i.category_id = c.id WHERE i.user_id = '$user_id' AND c.name = 'Gaji Bulanan' AND DATE_FORMAT(i.income_date, '%Y-%m') <= '$current_month' ORDER BY i.income_date DESC LIMIT 1";
$rsGaji = DB::Query($sqlGaji);
$gaji_tetap = ($rsGaji && $rowGaji = $rsGaji->fetchAssoc()) ? floatval($rowGaji['amount']) : 0;

$sqlOtherIncome = "SELECT SUM(i.amount) as total FROM tbl_income i JOIN tbl_categories c ON i.category_id = c.id WHERE i.user_id = '$user_id' AND c.name != 'Gaji Bulanan' AND DATE_FORMAT(i.income_date, '%Y-%m') = '$current_month'";
$rsOther = DB::Query($sqlOtherIncome);
$other_income = ($rsOther && $rowOther = $rsOther->fetchAssoc()) ? floatval($rowOther['total']) : 0;
$total_income = $gaji_tetap + $other_income;

$sqlExp = "SELECT 
    SUM(CASE WHEN c.type_id = 3 THEN e.amount ELSE 0 END) as komitmen,
    SUM(CASE WHEN c.type_id = 4 THEN e.amount ELSE 0 END) as pelaburan,
    SUM(CASE WHEN c.type_id = 1 THEN e.amount ELSE 0 END) as belanja
    FROM tbl_expenses e JOIN tbl_categories c ON e.category_id = c.id 
    WHERE e.user_id = '$user_id' AND DATE_FORMAT(e.expense_date, '%Y-%m') = '$current_month'";
$rsExp = DB::Query($sqlExp);
if($rsExp && $rowExp = $rsExp->fetchAssoc()) {
    $total_komitmen = floatval($rowExp['komitmen']); $total_pelaburan = floatval($rowExp['pelaburan']); $total_spent = floatval($rowExp['belanja']);
}

// DIBETULKAN: FILTER by c.user_id
function getTargetSafe($u_id, $m_id, $type_id) {
    $sql = "SELECT SUM(latest_budget) as total FROM (
                SELECT COALESCE((SELECT amount FROM tbl_budgets b WHERE b.category_id = c.id AND b.user_id = '$u_id' AND b.budget_month <= '$m_id' ORDER BY budget_month DESC LIMIT 1), 0) as latest_budget 
                FROM tbl_categories c 
                WHERE c.type_id = $type_id AND (c.user_id = '$u_id' OR c.user_id = 0 OR c.user_id IS NULL)
            ) as subquery";
    $rs = DB::Query($sql); return ($rs && $row = $rs->fetchAssoc()) ? floatval($row['total']) : 0;
}

$target_income    = getTargetSafe($user_id, $current_month, 2);
$target_komitmen  = getTargetSafe($user_id, $current_month, 3);
$target_pelaburan = getTargetSafe($user_id, $current_month, 4);
$total_budget     = getTargetSafe($user_id, $current_month, 1);

$baki_pendapatan = $total_income - $target_income;
$baki_bajet = $total_budget - $total_spent;
$baki_komitmen = $target_komitmen - $total_komitmen;
$baki_pelaburan = $target_pelaburan - $total_pelaburan;
$baki_keseluruhan = $total_income - $total_komitmen - $total_pelaburan - $total_spent; 

// ==========================================
// 5. PENGURUSAN DATA CARTA & DROPDOWN
// ==========================================
$line_dates = []; $line_balances = []; $daily_deltas = [];
$first_day = date('Y-m-01', strtotime($current_month . '-01'));
$daily_deltas[$first_day] = 0;

$rsGajiChart = DB::Query("SELECT i.amount FROM tbl_income i JOIN tbl_categories c ON i.category_id = c.id WHERE i.user_id = '$user_id' AND c.name = 'Gaji Bulanan' AND DATE_FORMAT(i.income_date, '%Y-%m') < '$current_month' ORDER BY i.income_date DESC LIMIT 1");
if($rsGajiChart && $rowGajiChart = $rsGajiChart->fetchAssoc()) { $daily_deltas[$first_day] += floatval($rowGajiChart['amount']); }

$rsIncChart = DB::Query("SELECT income_date, amount FROM tbl_income WHERE user_id = '$user_id' AND DATE_FORMAT(income_date, '%Y-%m') = '$current_month'");
if($rsIncChart) { while($row = $rsIncChart->fetchAssoc()) { $d = $row['income_date']; if(!isset($daily_deltas[$d])) $daily_deltas[$d] = 0; $daily_deltas[$d] += floatval($row['amount']); } }

$rsExpChart = DB::Query("SELECT expense_date, amount FROM tbl_expenses WHERE user_id = '$user_id' AND DATE_FORMAT(expense_date, '%Y-%m') = '$current_month'");
if($rsExpChart) { while($row = $rsExpChart->fetchAssoc()) { $d = $row['expense_date']; if(!isset($daily_deltas[$d])) $daily_deltas[$d] = 0; $daily_deltas[$d] -= floatval($row['amount']); } }

ksort($daily_deltas); $running_balance = 0;
foreach($daily_deltas as $date => $delta) { $running_balance += $delta; $line_dates[] = date('d M', strtotime($date)); $line_balances[] = $running_balance; }

$chart_pie_labels = []; $chart_pie_data = []; $chart_pie_colors = [];
$rsPie = DB::Query("SELECT c.type_id, SUM(e.amount) as total FROM tbl_expenses e JOIN tbl_categories c ON e.category_id = c.id WHERE e.user_id = '$user_id' AND DATE_FORMAT(e.expense_date, '%Y-%m') = '$current_month' GROUP BY c.type_id HAVING total > 0");
if($rsPie) {
    while($rowPie = $rsPie->fetchAssoc()){
        $t_id = intval($rowPie['type_id']); $tot = floatval($rowPie['total']);
        if($t_id == 1) { $chart_pie_labels[] = 'Perbelanjaan (Bajet)'; $chart_pie_colors[] = '#f43f5e'; }
        elseif($t_id == 3) { $chart_pie_labels[] = 'Komitmen Bulanan'; $chart_pie_colors[] = '#f59e0b'; }
        elseif($t_id == 4) { $chart_pie_labels[] = 'Pelaburan / Simpanan'; $chart_pie_colors[] = '#10b981'; }
        else { continue; }
        $chart_pie_data[] = $tot;
    }
}

// DIBETULKAN: FILTER by c.user_id pada CARTA BAR
$sqlBar = "
    SELECT c.name, 
           COALESCE((SELECT amount FROM tbl_budgets b WHERE b.category_id = c.id AND b.user_id = '$user_id' AND b.budget_month <= '$current_month' ORDER BY budget_month DESC LIMIT 1), 0) as budget_amt, 
           COALESCE((SELECT SUM(amount) FROM tbl_expenses e WHERE e.category_id = c.id AND e.user_id = '$user_id' AND DATE_FORMAT(e.expense_date, '%Y-%m') = '$current_month'), 0) as spent_amt 
    FROM tbl_categories c 
    WHERE c.type_id = 1 AND (c.user_id = '$user_id' OR c.user_id = 0 OR c.user_id IS NULL) 
    HAVING budget_amt > 0 OR spent_amt > 0
";
$rsBar = DB::Query($sqlBar);
if($rsBar) { while($rowBar = $rsBar->fetchAssoc()){ $chart_bar_labels[] = $rowBar['name']; $chart_bar_budget[] = floatval($rowBar['budget_amt']); $chart_bar_spent[] = floatval($rowBar['spent_amt']); } }

// DIBETULKAN: SELECT e.is_lhdn UNTUK LENCANA
$recent_transactions = [];
$sqlRecent = "
    (SELECT e.expense_date as t_date, e.amount, e.description, c.name as cat_name, 'out' as t_type, e.is_lhdn 
     FROM tbl_expenses e JOIN tbl_categories c ON e.category_id = c.id WHERE e.user_id = '$user_id') 
    UNION ALL 
    (SELECT i.income_date as t_date, i.amount, i.description, c.name as cat_name, 'in' as t_type, 0 as is_lhdn 
     FROM tbl_income i JOIN tbl_categories c ON i.category_id = c.id WHERE i.user_id = '$user_id') 
    ORDER BY t_date DESC LIMIT 5
";
$rsRecent = DB::Query($sqlRecent);
if($rsRecent) { while($r = $rsRecent->fetchAssoc()){ $recent_transactions[] = $r; } }

// DIBETULKAN: FILTER by user_id PADA DROPDOWN MODAL dan TAMBAH color_code
$category_list_income = []; $category_list_expense = [];
$rsCat = DB::Query("SELECT id, name, type_id, color_code FROM tbl_categories WHERE (user_id = '$user_id' OR user_id = 0 OR user_id IS NULL) ORDER BY type_id DESC, name ASC");
if($rsCat) { while($rowC = $rsCat->fetchAssoc()){ if($rowC['type_id'] == 2) { $category_list_income[] = $rowC; } else { $category_list_expense[] = $rowC; } } }

$json_pie_labels = json_encode($chart_pie_labels); $json_pie_data = json_encode($chart_pie_data); $json_pie_colors = json_encode($chart_pie_colors);
$json_bar_labels = json_encode($chart_bar_labels); $json_bar_budget = json_encode($chart_bar_budget); $json_bar_spent = json_encode($chart_bar_spent);
$json_line_dates = json_encode($line_dates); $json_line_balances = json_encode($line_balances);
?>
<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: window.innerWidth > 1024, darkMode: $persist(false), expensePopup: false, incomePopup: false }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Kewangan Peribadi</title>
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
        <?php $page_title = "Aliran Tunai: " . $display_month; include('header.php'); ?>

        <div class="p-6 max-w-7xl mx-auto w-full">
            
            <?php if(!empty($msg)): ?>
            <div class="<?php echo $msg_type === 'success' ? 'bg-emerald-100 border-emerald-400 text-emerald-700' : 'bg-rose-100 border-rose-400 text-rose-700'; ?> border px-4 py-3 rounded-xl mb-6 flex items-center shadow-sm" role="alert">
                <i class="fas <?php echo $msg_type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?> mr-2 text-xl"></i>
                <span class="block sm:inline text-sm font-bold"><?php echo $msg; ?></span>
            </div>
            <?php endif; ?>

            <div class="flex justify-between items-center mb-6 border-b border-slate-200 dark:border-slate-700 pb-4">
                <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest"><i class="fas fa-chart-line mr-2 text-indigo-500"></i> Prestasi Kewangan</h3>
                <div class="flex gap-2">
                    <button @click="incomePopup = true" class="px-4 py-2 bg-sky-500 text-white font-bold text-[10px] uppercase tracking-wider rounded-lg shadow-sm hover:bg-sky-600 transition-colors"><i class="fas fa-plus mr-1"></i> Pendapatan</button>
                    <button @click="expensePopup = true" class="px-4 py-2 bg-rose-500 text-white font-bold text-[10px] uppercase tracking-wider rounded-lg shadow-sm hover:bg-rose-600 transition-colors"><i class="fas fa-minus mr-1"></i> Wang Keluar</button>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                
                <div class="bg-sky-500 p-5 rounded-2xl shadow-md dark:shadow-none relative overflow-hidden flex flex-col justify-between group text-white font-bold hover:-translate-y-1 transition-transform">
                    <div class="relative z-10">
                        <p class="text-sky-100 text-[9px] uppercase tracking-widest">Total Pendapatan</p>
                        <div class="mt-1"><h3 class="text-3xl font-black leading-none"><span class="text-lg">RM</span> <?php echo number_format($total_income, 2); ?></h3></div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-sky-400/50 flex justify-between items-center text-[9px] font-bold text-sky-100 relative z-10">
                        <div>SASARAN: <span class="text-white">RM <?php echo number_format($target_income, 2); ?></span></div>
                        <div class="text-right">BAKI: <span class="text-white">RM <?php echo number_format($baki_pendapatan, 2); ?></span></div>
                    </div>
                    <i class="fas fa-hand-holding-usd absolute -left-2 -bottom-2 text-6xl opacity-10"></i>
                </div>

                <div class="bg-amber-500 p-5 rounded-2xl shadow-md dark:shadow-none relative overflow-hidden flex flex-col justify-between group text-white font-bold hover:-translate-y-1 transition-transform">
                    <div class="relative z-10">
                        <p class="text-amber-100 text-[9px] uppercase tracking-widest">Komitmen Bulanan</p>
                        <div class="mt-1"><h3 class="text-3xl font-black leading-none"><span class="text-lg">RM</span> <?php echo number_format($total_komitmen, 2); ?></h3></div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-amber-400/50 flex justify-between items-center text-[9px] font-bold text-amber-100 relative z-10">
                        <div>SASARAN: <span class="text-white">RM <?php echo number_format($target_komitmen, 2); ?></span></div>
                        <div class="text-right">BAKI: <span class="text-white">RM <?php echo number_format($baki_komitmen, 2); ?></span></div>
                    </div>
                    <i class="fas fa-file-invoice-dollar absolute -left-2 -bottom-2 text-6xl opacity-10"></i>
                </div>

                <div class="bg-emerald-500 p-5 rounded-2xl shadow-md dark:shadow-none relative overflow-hidden flex flex-col justify-between group text-white font-bold hover:-translate-y-1 transition-transform">
                    <div class="relative z-10">
                        <p class="text-emerald-100 text-[9px] uppercase tracking-widest">Simpanan / Pelaburan</p>
                        <div class="mt-1"><h3 class="text-3xl font-black leading-none"><span class="text-lg">RM</span> <?php echo number_format($total_pelaburan, 2); ?></h3></div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-emerald-400/50 flex justify-between items-center text-[9px] font-bold text-emerald-100 relative z-10">
                        <div>SASARAN: <span class="text-white">RM <?php echo number_format($target_pelaburan, 2); ?></span></div>
                        <div class="text-right">BAKI: <span class="text-white">RM <?php echo number_format($baki_pelaburan, 2); ?></span></div>
                    </div>
                    <i class="fas fa-seedling absolute -left-2 -bottom-2 text-6xl opacity-10"></i>
                </div>

                <div class="bg-indigo-400 p-5 rounded-2xl shadow-md dark:shadow-none relative overflow-hidden flex flex-col justify-between group text-white font-bold hover:-translate-y-1 transition-transform">
                    <div class="relative z-10">
                        <p class="text-indigo-100 text-[9px] uppercase tracking-widest">Bajet (Diasingkan)</p>
                        <div class="mt-1"><h3 class="text-3xl font-black leading-none"><span class="text-lg">RM</span> <?php echo number_format($total_spent, 2); ?></h3></div>
                    </div>
                    <div class="mt-4 pt-3 border-t border-indigo-300/50 flex justify-between items-center text-[9px] font-bold text-indigo-100 relative z-10">
                        <div>SASARAN: <span class="text-white">RM <?php echo number_format($total_budget, 2); ?></span></div>
                        <div class="text-right">BAKI: <span class="text-white">RM <?php echo number_format($baki_bajet, 2); ?></span></div>
                    </div>
                    <i class="fas fa-bullseye absolute -left-2 -bottom-2 text-6xl opacity-10"></i>
                </div>
            </div>
            
            <div class="<?php echo $baki_keseluruhan >= 0 ? 'bg-emerald-500' : 'bg-red-600'; ?> p-6 md:p-8 rounded-3xl shadow-lg relative overflow-hidden mb-8 flex flex-col items-center justify-center text-center text-white transition-colors">
                <i class="fas fa-wallet absolute -right-4 -bottom-4 text-8xl md:text-9xl opacity-10"></i>
                <p class="text-white/80 text-[10px] md:text-xs font-black uppercase tracking-widest mb-1 relative z-10">Baki Keseluruhan (Cash On Hand)</p>
                <h2 class="text-4xl md:text-6xl font-black relative z-10 my-2">RM <?php echo number_format($baki_keseluruhan, 2); ?></h2>
                <p class="text-white/60 text-[9px] md:text-[10px] uppercase tracking-wider relative z-10">Wang sebenar yang tinggal selepas ditolak komitmen, pelaburan dan perbelanjaan sebenar</p>
            </div>

            <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 mb-8">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest"><i class="fas fa-file-invoice-dollar mr-2 text-indigo-500"></i> Statement: Sasaran vs Sebenar</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-800/80 text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 border-b border-slate-200 dark:border-slate-700">
                                <th class="px-4 py-4 w-48">Kategori</th>
                                <th class="px-4 py-4 text-right">Sasaran (RM)</th>
                                <th class="px-4 py-4 text-right">Sebenar (RM)</th>
                                <th class="px-4 py-4 text-right">Baki (RM)</th>
                                <th class="px-4 py-4 text-center w-32">Prestasi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            
                            <tr class="border-b border-slate-50 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-colors">
                                <td class="px-4 py-4 font-bold text-slate-700 dark:text-slate-300">
                                    <div class="flex items-center gap-2"><div class="w-2.5 h-2.5 rounded-full bg-sky-500 shadow-sm shadow-sky-500/50"></div> Pendapatan Masuk</div>
                                </td>
                                <td class="px-4 py-4 text-right font-semibold text-slate-500 dark:text-slate-400"><?php echo number_format($target_income, 2); ?></td>
                                <td class="px-4 py-4 text-right font-black text-sky-600 dark:text-sky-400"><?php echo number_format($total_income, 2); ?></td>
                                <td class="px-4 py-4 text-right font-black <?php echo $baki_pendapatan >= 0 ? 'text-emerald-500' : 'text-rose-500'; ?>">
                                    <?php echo $baki_pendapatan >= 0 ? '+' : ''; ?><?php echo number_format($baki_pendapatan, 2); ?>
                                </td>
                                <td class="px-4 py-4">
                                    <?php 
                                        $pct_inc_actual = $target_income > 0 ? ($total_income / $target_income) * 100 : ($total_income > 0 ? 100 : 0); 
                                        $pct_inc_bar = min($pct_inc_actual, 100); 
                                    ?>
                                    <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-1.5 mt-1 overflow-hidden">
                                        <div class="h-1.5 rounded-full bg-sky-500" style="width: <?php echo $pct_inc_bar; ?>%;"></div>
                                    </div>
                                    <div class="text-[8.5px] text-right mt-1.5 text-slate-400 font-bold tracking-wider"><?php echo number_format($pct_inc_actual, 1); ?>% CAPAI</div>
                                </td>
                            </tr>

                            <tr class="border-b border-slate-50 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-colors">
                                <td class="px-4 py-4 font-bold text-slate-700 dark:text-slate-300">
                                    <div class="flex items-center gap-2"><div class="w-2.5 h-2.5 rounded-full bg-amber-500 shadow-sm shadow-amber-500/50"></div> Komitmen Bulanan</div>
                                </td>
                                <td class="px-4 py-4 text-right font-semibold text-slate-500 dark:text-slate-400"><?php echo number_format($target_komitmen, 2); ?></td>
                                <td class="px-4 py-4 text-right font-black text-amber-600 dark:text-amber-400"><?php echo number_format($total_komitmen, 2); ?></td>
                                <td class="px-4 py-4 text-right font-black <?php echo $baki_komitmen >= 0 ? 'text-slate-600 dark:text-slate-300' : 'text-rose-500'; ?>">
                                    <?php echo number_format($baki_komitmen, 2); ?>
                                    <span class="block text-[8px] font-bold text-slate-400 uppercase"><?php echo $baki_komitmen >= 0 ? 'Belum Bayar' : 'Terlebih Bayar'; ?></span>
                                </td>
                                <td class="px-4 py-4">
                                    <?php 
                                        $pct_kom_actual = $target_komitmen > 0 ? ($total_komitmen / $target_komitmen) * 100 : ($total_komitmen > 0 ? 100 : 0); 
                                        $pct_kom_bar = min($pct_kom_actual, 100); 
                                    ?>
                                    <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-1.5 mt-1 overflow-hidden">
                                        <div class="h-1.5 rounded-full <?php echo $total_komitmen > $target_komitmen ? 'bg-rose-500' : 'bg-amber-500'; ?>" style="width: <?php echo $pct_kom_bar; ?>%;"></div>
                                    </div>
                                    <div class="text-[8.5px] text-right mt-1.5 text-slate-400 font-bold tracking-wider"><?php echo number_format($pct_kom_actual, 1); ?>% DIBAYAR</div>
                                </td>
                            </tr>

                            <tr class="border-b border-slate-50 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-colors">
                                <td class="px-4 py-4 font-bold text-slate-700 dark:text-slate-300">
                                    <div class="flex items-center gap-2"><div class="w-2.5 h-2.5 rounded-full bg-emerald-500 shadow-sm shadow-emerald-500/50"></div> Simpanan / Pelaburan</div>
                                </td>
                                <td class="px-4 py-4 text-right font-semibold text-slate-500 dark:text-slate-400"><?php echo number_format($target_pelaburan, 2); ?></td>
                                <td class="px-4 py-4 text-right font-black text-emerald-600 dark:text-emerald-400"><?php echo number_format($total_pelaburan, 2); ?></td>
                                <td class="px-4 py-4 text-right font-black <?php echo $baki_pelaburan > 0 ? 'text-slate-600 dark:text-slate-300' : 'text-emerald-500'; ?>">
                                    <?php echo $baki_pelaburan > 0 ? number_format($baki_pelaburan, 2) : '+ ' . number_format(abs($baki_pelaburan), 2); ?>
                                    <span class="block text-[8px] font-bold text-slate-400 uppercase"><?php echo $baki_pelaburan > 0 ? 'Belum Simpan' : 'Lebihan Simpanan'; ?></span>
                                </td>
                                <td class="px-4 py-4">
                                    <?php 
                                        $pct_pel_actual = $target_pelaburan > 0 ? ($total_pelaburan / $target_pelaburan) * 100 : ($total_pelaburan > 0 ? 100 : 0); 
                                        $pct_pel_bar = min($pct_pel_actual, 100); 
                                    ?>
                                    <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-1.5 mt-1 overflow-hidden">
                                        <div class="h-1.5 rounded-full bg-emerald-500" style="width: <?php echo $pct_pel_bar; ?>%;"></div>
                                    </div>
                                    <div class="text-[8.5px] text-right mt-1.5 text-slate-400 font-bold tracking-wider"><?php echo number_format($pct_pel_actual, 1); ?>% CAPAI</div>
                                </td>
                            </tr>

                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-colors">
                                <td class="px-4 py-4 font-bold text-slate-700 dark:text-slate-300">
                                    <div class="flex items-center gap-2"><div class="w-2.5 h-2.5 rounded-full bg-indigo-500 shadow-sm shadow-indigo-500/50"></div> Perbelanjaan (Bajet)</div>
                                </td>
                                <td class="px-4 py-4 text-right font-semibold text-slate-500 dark:text-slate-400"><?php echo number_format($total_budget, 2); ?></td>
                                <td class="px-4 py-4 text-right font-black text-indigo-600 dark:text-indigo-400"><?php echo number_format($total_spent, 2); ?></td>
                                <td class="px-4 py-4 text-right font-black <?php echo $baki_bajet >= 0 ? 'text-slate-600 dark:text-slate-300' : 'text-rose-500'; ?>">
                                    <?php echo number_format($baki_bajet, 2); ?>
                                    <span class="block text-[8px] font-bold text-slate-400 uppercase"><?php echo $baki_bajet >= 0 ? 'Baki Boleh Guna' : 'Terlebih Belanja'; ?></span>
                                </td>
                                <td class="px-4 py-4">
                                    <?php 
                                        $pct_spent_actual = $total_budget > 0 ? ($total_spent / $total_budget) * 100 : ($total_spent > 0 ? 100 : 0); 
                                        $pct_spent_bar = min($pct_spent_actual, 100); 
                                    ?>
                                    <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-1.5 mt-1 overflow-hidden">
                                        <div class="h-1.5 rounded-full <?php echo $total_spent > $total_budget ? 'bg-rose-500' : 'bg-indigo-500'; ?>" style="width: <?php echo $pct_spent_bar; ?>%;"></div>
                                    </div>
                                    <div class="text-[8.5px] text-right mt-1.5 <?php echo $total_spent > $total_budget ? 'text-rose-500' : 'text-slate-400'; ?> font-bold tracking-wider"><?php echo number_format($pct_spent_actual, 1); ?>% DIGUNA</div>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 p-5 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 mb-8">
                <h4 class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-4"><i class="fas fa-chart-area mr-1 text-sky-500"></i> Trend Aliran Tunai Bulan Ini</h4>
                <div class="w-full relative h-[250px] md:h-[300px]"><canvas id="cashflowLineChart"></canvas></div>
            </div>

            <div class="md:flex md:gap-6 items-stretch mb-6">
                <div class="md:w-full flex flex-col gap-4">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col items-center col-span-1">
                            <h4 class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3 w-full text-center">Pecahan Wang Keluar</h4>
                            <div class="w-full max-w-[180px] aspect-square relative"><canvas id="expensePieChart"></canvas></div>
                        </div>

                        <div class="bg-white dark:bg-slate-800 p-5 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col flex-1 min-h-[200px] col-span-1 lg:col-span-2">
                            <h4 class="text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-3 text-center">Status Bajet Perbelanjaan Harian</h4>
                            <div class="w-full relative h-[180px]"><canvas id="budgetVsSpentChart"></canvas></div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden mb-6">
                <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 flex justify-between items-center">
                    <h3 class="text-xs font-black text-slate-700 dark:text-slate-200 uppercase tracking-widest"><i class="fas fa-exchange-alt text-indigo-500 mr-2"></i> Transaksi Terkini</h3>
                    <a href="expenses_list.php" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-800 uppercase tracking-wider">Lihat Sejarah</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white dark:bg-slate-800 text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 border-b border-slate-100 dark:border-slate-700">
                                <th class="px-6 py-4 w-10 text-center">Jenis</th>
                                <th class="px-6 py-4">Tarikh</th>
                                <th class="px-6 py-4">Kategori / Sumber</th>
                                <th class="px-6 py-4">Keterangan</th>
                                <th class="px-6 py-4 text-right">Jumlah (RM)</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            <?php if(count($recent_transactions) > 0): ?>
                                <?php foreach($recent_transactions as $rx): ?>
                                <tr class="border-b border-slate-50 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-colors">
                                    <td class="px-6 py-4 text-center">
                                        <?php if($rx['t_type'] == 'in'): ?>
                                            <i class="fas fa-arrow-down text-sky-500 bg-sky-100 dark:bg-sky-900/40 p-1.5 rounded-md"></i>
                                        <?php else: ?>
                                            <i class="fas fa-arrow-up text-rose-500 bg-rose-100 dark:bg-rose-900/40 p-1.5 rounded-md"></i>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-slate-500 dark:text-slate-400 text-xs font-bold"><?php echo date('d M Y', strtotime($rx['t_date'])); ?></td>
                                    <td class="px-6 py-4 text-slate-700 dark:text-slate-300 font-semibold"><?php echo $rx['cat_name']; ?></td>
                                    <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                        <?php echo htmlspecialchars($rx['description']); ?>
                                        <?php if(isset($rx['is_lhdn']) && $rx['is_lhdn'] == 1): ?>
                                            <span class="ml-2 inline-block px-2 py-0.5 bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 text-[8px] font-black rounded-md uppercase tracking-widest border border-emerald-200 dark:border-emerald-800" title="Pelepasan Cukai LHDN">LHDN</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-right font-black <?php echo $rx['t_type'] == 'in' ? 'text-sky-500' : 'text-rose-500'; ?>">
                                        <?php echo $rx['t_type'] == 'in' ? '+' : '-'; ?> <?php echo number_format($rx['amount'], 2); ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-slate-400 dark:text-slate-500">
                                        <i class="fas fa-receipt text-3xl mb-3 opacity-20 block"></i>
                                        <p class="text-xs font-bold uppercase tracking-widest">Tiada rekod transaksi</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
        <?php include('footer.php'); ?>
    </main>

    <div x-show="incomePopup" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all text-left">
        <div @click.away="incomePopup = false" class="bg-white dark:bg-slate-800 w-full max-w-2xl rounded-3xl p-6 shadow-2xl border dark:border-slate-700">
            <div class="flex justify-between items-start mb-5">
                <div>
                    <p class="text-[9px] font-black text-sky-500 uppercase tracking-widest mb-1">Wang Masuk</p>
                    <h3 class="text-xl font-black text-slate-800 dark:text-white">Tambah Pendapatan</h3>
                </div>
                <button @click="incomePopup = false" class="text-slate-300 hover:text-rose-500 transition-colors"><i class="fas fa-times-circle text-xl"></i></button>
            </div>
            
            <form method="POST" action="menu.php" enctype="multipart/form-data" x-data="{ rows: [{id: 1, fileReady: false, fileName: ''}] }">
                <input type="hidden" name="action" value="add_income">
                
                <div class="flex justify-between items-center mb-3">
                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Senarai Pendapatan</p>
                    <button type="button" @click="rows.push({id: Date.now(), fileReady: false, fileName: ''})" class="text-[10px] bg-sky-100 text-sky-600 dark:bg-sky-900/40 dark:text-sky-400 px-3 py-1.5 rounded-lg font-bold hover:bg-sky-200 transition-colors">
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
                                    <input type="date" name="income_date[]" required value="<?php echo date('Y-m-d'); ?>" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-2.5 text-sm text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-sky-500 outline-none">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Jumlah (RM)</label>
                                    <input type="number" step="0.01" name="amount[]" required placeholder="0.00" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-2.5 text-sm text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-sky-500 outline-none">
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Sumber</label>
                                    <div x-data="{ open: false, search: '', selected: '', selectedText: '-- Cari & Pilih --' }" class="relative w-full">
                                        <select name="category_id[]" required x-model="selected" class="absolute opacity-0 inset-0 -z-10 pointer-events-none" tabindex="-1">
                                            <option value=""></option>
                                            <?php foreach($category_list_income as $cat): ?>
                                                <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['name']); ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                        <button type="button" @click="open = !open" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-2.5 text-sm text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-sky-500 outline-none flex justify-between items-center text-left transition-colors">
                                            <span x-text="selectedText" class="truncate" :class="selected === '' ? 'text-slate-400' : ''"></span>
                                            <i class="fas fa-chevron-down text-[10px] text-slate-400 transition-transform" :class="open ? 'rotate-180' : ''"></i>
                                        </button>
                                        <div x-show="open" @click.away="open = false" x-transition class="absolute z-[70] w-full mt-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-xl overflow-hidden" x-cloak>
                                            <div class="p-2 border-b border-slate-100 dark:border-slate-700 bg-slate-50/50 dark:bg-slate-800/50">
                                                <div class="relative">
                                                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                                                    <input type="text" x-model="search" @keydown.enter.prevent="" placeholder="Taip untuk cari..." class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-md py-1.5 pl-8 pr-3 text-xs text-slate-700 dark:text-slate-300 focus:ring-1 focus:ring-sky-500 outline-none shadow-sm">
                                                </div>
                                            </div>
                                            <ul class="max-h-48 overflow-y-auto custom-scrollbar p-1">
                                                <?php foreach($category_list_income as $cat): ?>
                                                    <li x-show="search === '' || '<?php echo strtolower(addslashes($cat['name'])); ?>'.includes(search.toLowerCase())"
                                                        @click="selected = '<?php echo $cat['id']; ?>'; selectedText = '<?php echo addslashes($cat['name']); ?>'; open = false; search = ''"
                                                        class="px-3 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-sky-50 dark:hover:bg-slate-700 hover:text-sky-600 dark:hover:text-sky-400 rounded-md cursor-pointer transition-colors"
                                                        :class="selected === '<?php echo $cat['id']; ?>' ? 'bg-sky-50 dark:bg-slate-700 text-sky-600 dark:text-sky-400' : ''">
                                                        <?php echo htmlspecialchars($cat['name']); ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Keterangan / Nota</label>
                                    <input type="text" name="description[]" maxlength="100" placeholder="Pilihan..." class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-2.5 text-sm text-slate-700 dark:text-slate-300 focus:ring-2 focus:ring-sky-500 outline-none">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Muat Naik Resit (Pilihan - JPG/PNG/PDF)</label>
                                <div class="flex items-center gap-3">
                                    <label class="cursor-pointer bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-800 px-3 py-2 rounded-lg text-[10px] font-bold text-slate-600 dark:text-slate-300 transition-colors flex items-center gap-2">
                                        <i class="fas fa-upload text-sky-500"></i> Pilih Fail
                                        <input type="file" name="receipt[]" accept=".jpg,.jpeg,.png,.pdf" class="hidden" @change="row.fileReady = !!$event.target.files.length; row.fileName = $event.target.files.length ? $event.target.files[0].name : ''">
                                    </label>
                                    <span x-show="row.fileReady" class="text-[9px] font-bold text-emerald-500 flex items-center gap-1">
                                        <i class="fas fa-check-circle"></i> <span x-text="row.fileName" class="truncate max-w-[150px] inline-block"></span>
                                    </span>
                                </div>
                            </div>
                            
                        </div>
                    </template>
                </div>
                
                <div class="mt-6 flex gap-3 pt-4 border-t border-slate-100 dark:border-slate-700">
                    <button type="button" @click="incomePopup = false" class="w-1/3 py-2.5 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-lg font-bold uppercase tracking-wide text-[10px] hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">Batal</button>
                    <button type="submit" class="w-2/3 py-2.5 bg-sky-500 text-white rounded-lg font-bold uppercase tracking-wide text-[10px] hover:bg-sky-600 shadow-md transition-colors">Simpan Rekod Pendapatan</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="expensePopup" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all text-left">
        <div @click.away="expensePopup = false" class="bg-white dark:bg-slate-800 w-full max-w-2xl rounded-3xl p-6 shadow-2xl border dark:border-slate-700">
            <div class="flex justify-between items-start mb-5">
                <div>
                    <p class="text-[9px] font-black text-rose-500 uppercase tracking-widest mb-1">Wang Keluar</p>
                    <h3 class="text-xl font-black text-slate-800 dark:text-white">Tambah Komitmen / Belanja</h3>
                </div>
                <button @click="expensePopup = false" class="text-slate-300 hover:text-rose-500 transition-colors"><i class="fas fa-times-circle text-xl"></i></button>
            </div>
            
            <form method="POST" action="menu.php" enctype="multipart/form-data" x-data="{ rows: [{id: 1, fileReady: false, fileName: ''}] }">
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
            Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
            Chart.defaults.color = '#94a3b8';
            
            // CARTA GARISAN ALIRAN TUNAI
            const lineCtx = document.getElementById('cashflowLineChart').getContext('2d');
            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: <?php echo $json_line_dates; ?>,
                    datasets: [{
                        label: 'Baki Keseluruhan (RM)',
                        data: <?php echo $json_line_balances; ?>,
                        borderColor: '#0ea5e9', 
                        backgroundColor: 'rgba(14, 165, 233, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#0ea5e9',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        datalabels: { display: false },
                        tooltip: { callbacks: { label: function(context) { return 'RM ' + context.parsed.y.toFixed(2); } } }
                    },
                    scales: {
                        y: { beginAtZero: true, grid: { borderDash: [5, 5], color: 'rgba(148, 163, 184, 0.2)' } },
                        x: { grid: { display: false } }
                    },
                    interaction: { mode: 'nearest', axis: 'x', intersect: false }
                }
            });

            // CARTA PAI
            const pieCtx = document.getElementById('expensePieChart').getContext('2d');
            new Chart(pieCtx, {
                type: 'doughnut',
                data: {
                    labels: <?php echo $json_pie_labels; ?>,
                    datasets: [{
                        data: <?php echo $json_pie_data; ?>,
                        backgroundColor: <?php echo $json_pie_colors; ?>, 
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: { 
                    responsive: true, maintainAspectRatio: false, 
                    plugins: { 
                        legend: { position: 'bottom', labels: { font: {size: 10} } },
                        datalabels: {
                            color: '#ffffff', font: { weight: 'bold', size: 11 },
                            formatter: (value, ctx) => {
                                let sum = ctx.chart.data.datasets[0].data.reduce((a, b) => a + b, 0);
                                if(sum === 0) return '';
                                return (value*100 / sum).toFixed(0) + "%";
                            }
                        }
                    }, 
                    cutout: '60%' 
                }
            });

            // CARTA BAR
            const barCtx = document.getElementById('budgetVsSpentChart').getContext('2d');
            new Chart(barCtx, {
                type: 'bar',
                data: {
                    labels: <?php echo $json_bar_labels; ?>,
                    datasets: [
                        { label: 'Bajet Ditetapkan', data: <?php echo $json_bar_budget; ?>, backgroundColor: '#e2e8f0', borderRadius: 4, barPercentage: 0.95, categoryPercentage: 0.75 },
                        { label: 'Telah Dibelanjakan', data: <?php echo $json_bar_spent; ?>, backgroundColor: '#f43f5e', borderRadius: 4, barPercentage: 0.95, categoryPercentage: 0.75 }
                    ]
                },
                options: { 
                    responsive: true, maintainAspectRatio: false, 
                    plugins: { legend: { position: 'top', labels: { boxWidth: 10, font: {size: 10} } }, datalabels: { display: false } }, 
                    scales: { 
                        y: { beginAtZero: true, ticks: { precision: 0, font: {size: 10} }, grid: { borderDash: [5, 5], color: 'rgba(148, 163, 184, 0.2)' } }, 
                        x: { ticks: { font: { weight: 'bold', size: 10 } }, grid: { display: false } } 
                    } 
                }
            });
        });
    </script>
</body>
</html>