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

$msg = "";
$msg_type = "";

// Set Bulan Pilihan (Default: Bulan Semasa)
$selected_month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
if (!preg_match('/^\d{4}-\d{2}$/', $selected_month)) {
    $selected_month = date('Y-m');
}

// --- PENGURUSAN SIMPAN/KEMASKINI BAJET ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'save_budget') {
    $cat_id = intval($_POST['category_id']);
    $amount = floatval($_POST['amount']);
    $b_month = $_POST['budget_month'];
    
    // Semak jika rekod bajet untuk bulan tersebut sudah wujud
    $sqlCheck = "SELECT id FROM tbl_budgets WHERE category_id = $cat_id AND budget_month = " . db_prepare_string($b_month) . " AND user_id = " . db_prepare_string($user_id);
    $rsCheck = DB::Query($sqlCheck);
    
    if ($rsCheck && $row = $rsCheck->fetchAssoc()) {
        // Kemas kini jika wujud
        DB::Exec("UPDATE tbl_budgets SET amount = $amount WHERE id = " . $row['id']);
    } else {
        // Tambah baru jika belum wujud pada bulan tersebut
        DB::Exec("INSERT INTO tbl_budgets (user_id, category_id, amount, budget_month) VALUES (" . db_prepare_string($user_id) . ", $cat_id, $amount, " . db_prepare_string($b_month) . ")");
    }
    
    $msg = "Sasaran/Bajet kategori berjaya dikemaskini.";
    $msg_type = "success";
}

// --- AMBIL SENARAI KATEGORI, BAJET & JUMLAH DIGUNAKAN ---
$cat_expense = [];
$cat_commit = [];
$cat_invest = [];
$cat_income = [];

$total_budget = 0; 
$total_income_target = 0; $total_income_used = 0;
$total_expense_budget = 0; $total_expense_used = 0;
$total_commit_budget = 0; $total_commit_used = 0;
$total_invest_budget = 0; $total_invest_used = 0;

$sqlCats = "
    SELECT c.id, c.name, c.type_id, c.color_code, 
    COALESCE((SELECT amount FROM tbl_budgets b WHERE b.category_id = c.id AND b.user_id = '$user_id' AND b.budget_month <= '$selected_month' ORDER BY budget_month DESC LIMIT 1), 0) as budget_amt,
    COALESCE((SELECT SUM(amount) FROM tbl_expenses e WHERE e.category_id = c.id AND e.user_id = '$user_id' AND DATE_FORMAT(e.expense_date, '%Y-%m') = '$selected_month'), 0) as expense_used,
    COALESCE((SELECT SUM(amount) FROM tbl_income i WHERE i.category_id = c.id AND i.user_id = '$user_id' AND DATE_FORMAT(i.income_date, '%Y-%m') = '$selected_month'), 0) as income_used
    FROM tbl_categories c 
    WHERE c.type_id IN (1, 2, 3, 4) AND (c.user_id = '$user_id' OR c.user_id = 0 OR c.user_id IS NULL)
    ORDER BY c.name ASC
";
$rsCats = DB::Query($sqlCats);

if($rsCats) {
    while($row = $rsCats->fetchAssoc()) {
        $amt = floatval($row['budget_amt']);
        $used = ($row['type_id'] == 2) ? floatval($row['income_used']) : floatval($row['expense_used']);
        
        // Pengiraan baki: 
        // Untuk Pendapatan: Baki = Dicapai - Sasaran (Positif = Bagus/Lebih)
        // Untuk Perbelanjaan: Baki = Bajet - Digunakan (Positif = Bagus/Ada Baki, Negatif = Overbudget)
        if($row['type_id'] == 2) {
            $bal = $used - $amt; 
        } else {
            $bal = $amt - $used; 
        }

        $row['used_amt'] = $used;
        $row['balance_amt'] = $bal;
        
        if($row['type_id'] == 1) {
            $cat_expense[] = $row;
            $total_expense_budget += $amt;
            $total_expense_used += $used;
            $total_budget += $amt;
        } elseif($row['type_id'] == 2) {
            $cat_income[] = $row;
            $total_income_target += $amt;
            $total_income_used += $used;
        } elseif($row['type_id'] == 3) {
            $cat_commit[] = $row;
            $total_commit_budget += $amt;
            $total_commit_used += $used;
            $total_budget += $amt;
        } elseif($row['type_id'] == 4) {
            $cat_invest[] = $row;
            $total_invest_budget += $amt;
            $total_invest_used += $used;
            $total_budget += $amt;
        }
    }
}

// --- JANA SENARAI BULAN UNTUK DROPDOWN (12 BULAN KE BELAKANG & 1 BULAN KE DEPAN) ---
$months_dropdown = [];
for ($i = -1; $i <= 12; $i++) {
    $m_val = date('Y-m', strtotime("-$i months"));
    $m_label = date('F Y', strtotime("-$i months"));
    $months_dropdown[$m_val] = $m_label;
}
?>

<!DOCTYPE html>
<html lang="en" x-data="{ 
    sidebarOpen: window.innerWidth > 1024, 
    darkMode: $persist(false),
    budgetPopup: false,
    activeTab: 1, /* 1: Perbelanjaan, 2: Pendapatan, 3: Komitmen, 4: Pelaburan */
    formData: { category_id: '', category_name: '', amount: '0.00', color_code: '#000' },
    
    openBudgetModal(id, name, amount, color) {
        this.formData.category_id = id;
        this.formData.category_name = name;
        this.formData.amount = amount;
        this.formData.color_code = color;
        this.budgetPopup = true;
    }
}" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengurusan Bajet</title>
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
        <?php $page_title = "Tetapan Bajet"; include('header.php'); ?>

        <div class="p-6 max-w-6xl mx-auto w-full">
            
            <?php if(!empty($msg)): ?>
            <div class="<?php echo $msg_type === 'success' ? 'bg-emerald-100 border-emerald-400 text-emerald-700' : 'bg-rose-100 border-rose-400 text-rose-700'; ?> border px-4 py-3 rounded-xl mb-6 flex items-center shadow-sm" role="alert">
                <i class="fas <?php echo $msg_type === 'success' ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?> mr-2 text-xl"></i>
                <span class="block sm:inline text-sm font-bold"><?php echo $msg; ?></span>
            </div>
            <?php endif; ?>

            <div class="bg-indigo-600 rounded-3xl shadow-lg border border-indigo-700 p-6 md:p-8 mb-6 flex flex-col md:flex-row justify-between items-center gap-6 relative overflow-hidden">
                <i class="fas fa-bullseye absolute -right-4 -bottom-4 text-8xl text-white opacity-10"></i>
                
                <div class="flex flex-col sm:flex-row gap-8 relative z-10 w-full">
                    <div class="text-center sm:text-left border-b sm:border-b-0 sm:border-r border-indigo-400/50 pb-4 sm:pb-0 sm:pr-8">
                        <p class="text-indigo-200 text-[10px] font-black uppercase tracking-widest mb-1">Sasaran Pendapatan</p>
                        <h2 class="text-3xl md:text-4xl font-black text-sky-300">RM <?php echo number_format($total_income_target, 2); ?></h2>
                    </div>

                    <div class="text-center sm:text-left">
                        <p class="text-indigo-200 text-[10px] font-black uppercase tracking-widest mb-1">Jumlah Peruntukan Keluar</p>
                        <h2 class="text-3xl md:text-4xl font-black text-white">RM <?php echo number_format($total_budget, 2); ?></h2>
                    </div>
                </div>

                <form method="GET" action="manage_budget.php" class="relative z-10 flex flex-col w-full md:w-64 gap-2">
                    <label class="text-[10px] font-black text-indigo-200 uppercase tracking-widest">Pilih Bulan Bajet:</label>
                    <div class="relative">
                        <select name="month" onchange="this.form.submit()" class="w-full bg-white/10 border border-white/20 text-white rounded-xl p-3 text-sm font-bold focus:ring-2 focus:ring-white outline-none cursor-pointer appearance-none">
                            <?php foreach($months_dropdown as $val => $label): ?>
                                <option value="<?php echo $val; ?>" <?php if($selected_month == $val) echo 'selected'; ?> class="text-slate-800">
                                    <?php echo $label; ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <i class="fas fa-chevron-down absolute right-4 top-3.5 text-white/70 pointer-events-none"></i>
                    </div>
                </form>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden mb-6">
                
                <div class="p-6 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                    <h2 class="text-xl font-black text-slate-800 dark:text-white">Peruntukan & Prestasi Kategori</h2>
                    <p class="text-xs font-bold text-slate-500 mt-1">Kawal bajet dan pantau baki peruntukan yang tinggal bagi bulan ini.</p>
                </div>

                <div class="flex overflow-x-auto border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 px-6 pt-2 gap-6 custom-scrollbar">
                    <button @click="activeTab = 1" class="pb-3 text-sm font-bold border-b-2 transition-colors flex items-center gap-2 whitespace-nowrap" :class="activeTab === 1 ? 'border-rose-500 text-rose-600 dark:text-rose-400' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'">
                        <i class="fas fa-shopping-cart"></i> Perbelanjaan Harian
                    </button>
                    <button @click="activeTab = 3" class="pb-3 text-sm font-bold border-b-2 transition-colors flex items-center gap-2 whitespace-nowrap" :class="activeTab === 3 ? 'border-amber-500 text-amber-600 dark:text-amber-400' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'">
                        <i class="fas fa-file-invoice-dollar"></i> Komitmen Bulanan
                    </button>
                    <button @click="activeTab = 4" class="pb-3 text-sm font-bold border-b-2 transition-colors flex items-center gap-2 whitespace-nowrap" :class="activeTab === 4 ? 'border-emerald-500 text-emerald-600 dark:text-emerald-400' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'">
                        <i class="fas fa-seedling"></i> Pelaburan / Simpanan
                    </button>
                    <button @click="activeTab = 2" class="pb-3 text-sm font-bold border-b-2 transition-colors flex items-center gap-2 whitespace-nowrap" :class="activeTab === 2 ? 'border-sky-500 text-sky-600 dark:text-sky-400' : 'border-transparent text-slate-500 hover:text-slate-700 dark:hover:text-slate-300'">
                        <i class="fas fa-hand-holding-usd"></i> Pendapatan (Sasaran)
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-white dark:bg-slate-800/80 text-[10px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 border-b border-slate-100 dark:border-slate-700">
                                <th class="px-6 py-4 w-12 text-center">Warna</th>
                                <th class="px-6 py-4">Kategori</th>
                                <th class="px-6 py-4 text-right">Sasaran / Had (RM)</th>
                                <th class="px-6 py-4 text-right">Telah Diguna (RM)</th>
                                <th class="px-6 py-4 text-right">Baki (RM)</th>
                                <th class="px-6 py-4 text-center w-28">Tindakan</th>
                            </tr>
                        </thead>

                        <tbody class="text-sm" x-show="activeTab === 1">
                            <?php if(count($cat_expense) > 0): ?>
                                <?php foreach($cat_expense as $cat): ?>
                                <tr class="border-b border-slate-50 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-colors">
                                    <td class="px-6 py-4 text-center"><div class="w-4 h-4 rounded-full mx-auto shadow-sm" style="background-color: <?php echo $cat['color_code']; ?>;"></div></td>
                                    <td class="px-6 py-4 text-slate-700 dark:text-slate-300 font-bold"><?php echo htmlspecialchars($cat['name']); ?></td>
                                    
                                    <td class="px-6 py-4 text-right font-black text-rose-600 dark:text-rose-400 text-base">
                                        <?php echo number_format($cat['budget_amt'], 2); ?>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-slate-500 dark:text-slate-400">
                                        <?php echo number_format($cat['used_amt'], 2); ?>
                                    </td>
                                    <td class="px-6 py-4 text-right font-black <?php echo $cat['balance_amt'] >= 0 ? 'text-emerald-500' : 'text-red-500'; ?> text-base">
                                        <?php echo number_format($cat['balance_amt'], 2); ?>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <button @click="openBudgetModal(<?php echo $cat['id']; ?>, '<?php echo addslashes($cat['name']); ?>', '<?php echo $cat['budget_amt']; ?>', '<?php echo addslashes($cat['color_code']); ?>')" class="px-3 py-1.5 bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-200 hover:bg-rose-500 hover:text-white rounded-lg text-[10px] font-bold uppercase tracking-wider transition-colors">
                                            Kemaskini
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <tr class="bg-rose-50/50 dark:bg-rose-900/10 border-t-2 border-rose-100 dark:border-rose-800/30">
                                    <td colspan="2" class="px-6 py-4 text-right font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest text-[10px]">Jumlah Sub-Bajet Perbelanjaan:</td>
                                    <td class="px-6 py-4 text-right font-black text-rose-600 dark:text-rose-400 text-lg">RM <?php echo number_format($total_expense_budget, 2); ?></td>
                                    <td class="px-6 py-4 text-right font-bold text-slate-600 dark:text-slate-300 text-base">RM <?php echo number_format($total_expense_used, 2); ?></td>
                                    <td class="px-6 py-4 text-right font-black <?php echo ($total_expense_budget - $total_expense_used) >= 0 ? 'text-emerald-500' : 'text-red-500'; ?> text-lg">
                                        RM <?php echo number_format($total_expense_budget - $total_expense_used, 2); ?>
                                    </td>
                                    <td></td>
                                </tr>
                            <?php else: ?>
                                <tr><td colspan="6" class="px-6 py-10 text-center text-slate-400">Tiada kategori direkodkan.</td></tr>
                            <?php endif; ?>
                        </tbody>

                        <tbody class="text-sm" x-show="activeTab === 3" x-cloak>
                            <?php if(count($cat_commit) > 0): ?>
                                <?php foreach($cat_commit as $cat): ?>
                                <tr class="border-b border-slate-50 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-colors">
                                    <td class="px-6 py-4 text-center"><div class="w-4 h-4 rounded-full mx-auto shadow-sm" style="background-color: <?php echo $cat['color_code']; ?>;"></div></td>
                                    <td class="px-6 py-4 text-slate-700 dark:text-slate-300 font-bold"><?php echo htmlspecialchars($cat['name']); ?></td>
                                    
                                    <td class="px-6 py-4 text-right font-black text-amber-600 dark:text-amber-400 text-base">
                                        <?php echo number_format($cat['budget_amt'], 2); ?>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-slate-500 dark:text-slate-400">
                                        <?php echo number_format($cat['used_amt'], 2); ?>
                                    </td>
                                    <td class="px-6 py-4 text-right font-black <?php echo $cat['balance_amt'] >= 0 ? 'text-emerald-500' : 'text-red-500'; ?> text-base">
                                        <?php echo number_format($cat['balance_amt'], 2); ?>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <button @click="openBudgetModal(<?php echo $cat['id']; ?>, '<?php echo addslashes($cat['name']); ?>', '<?php echo $cat['budget_amt']; ?>', '<?php echo addslashes($cat['color_code']); ?>')" class="px-3 py-1.5 bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-200 hover:bg-amber-500 hover:text-white rounded-lg text-[10px] font-bold uppercase tracking-wider transition-colors">
                                            Kemaskini
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <tr class="bg-amber-50/50 dark:bg-amber-900/10 border-t-2 border-amber-100 dark:border-amber-800/30">
                                    <td colspan="2" class="px-6 py-4 text-right font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest text-[10px]">Jumlah Sub-Bajet Komitmen:</td>
                                    <td class="px-6 py-4 text-right font-black text-amber-600 dark:text-amber-400 text-lg">RM <?php echo number_format($total_commit_budget, 2); ?></td>
                                    <td class="px-6 py-4 text-right font-bold text-slate-600 dark:text-slate-300 text-base">RM <?php echo number_format($total_commit_used, 2); ?></td>
                                    <td class="px-6 py-4 text-right font-black <?php echo ($total_commit_budget - $total_commit_used) >= 0 ? 'text-emerald-500' : 'text-red-500'; ?> text-lg">
                                        RM <?php echo number_format($total_commit_budget - $total_commit_used, 2); ?>
                                    </td>
                                    <td></td>
                                </tr>
                            <?php else: ?>
                                <tr><td colspan="6" class="px-6 py-10 text-center text-slate-400">Tiada kategori komitmen direkodkan.</td></tr>
                            <?php endif; ?>
                        </tbody>

                        <tbody class="text-sm" x-show="activeTab === 4" x-cloak>
                            <?php if(count($cat_invest) > 0): ?>
                                <?php foreach($cat_invest as $cat): ?>
                                <tr class="border-b border-slate-50 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-colors">
                                    <td class="px-6 py-4 text-center"><div class="w-4 h-4 rounded-full mx-auto shadow-sm" style="background-color: <?php echo $cat['color_code']; ?>;"></div></td>
                                    <td class="px-6 py-4 text-slate-700 dark:text-slate-300 font-bold"><?php echo htmlspecialchars($cat['name']); ?></td>
                                    
                                    <td class="px-6 py-4 text-right font-black text-emerald-600 dark:text-emerald-400 text-base">
                                        <?php echo number_format($cat['budget_amt'], 2); ?>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-slate-500 dark:text-slate-400">
                                        <?php echo number_format($cat['used_amt'], 2); ?>
                                    </td>
                                    <td class="px-6 py-4 text-right font-black <?php echo $cat['balance_amt'] >= 0 ? 'text-emerald-500' : 'text-red-500'; ?> text-base">
                                        <?php echo number_format($cat['balance_amt'], 2); ?>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <button @click="openBudgetModal(<?php echo $cat['id']; ?>, '<?php echo addslashes($cat['name']); ?>', '<?php echo $cat['budget_amt']; ?>', '<?php echo addslashes($cat['color_code']); ?>')" class="px-3 py-1.5 bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-200 hover:bg-emerald-500 hover:text-white rounded-lg text-[10px] font-bold uppercase tracking-wider transition-colors">
                                            Kemaskini
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <tr class="bg-emerald-50/50 dark:bg-emerald-900/10 border-t-2 border-emerald-100 dark:border-emerald-800/30">
                                    <td colspan="2" class="px-6 py-4 text-right font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest text-[10px]">Jumlah Sub-Bajet Pelaburan:</td>
                                    <td class="px-6 py-4 text-right font-black text-emerald-600 dark:text-emerald-400 text-lg">RM <?php echo number_format($total_invest_budget, 2); ?></td>
                                    <td class="px-6 py-4 text-right font-bold text-slate-600 dark:text-slate-300 text-base">RM <?php echo number_format($total_invest_used, 2); ?></td>
                                    <td class="px-6 py-4 text-right font-black <?php echo ($total_invest_budget - $total_invest_used) >= 0 ? 'text-emerald-500' : 'text-red-500'; ?> text-lg">
                                        RM <?php echo number_format($total_invest_budget - $total_invest_used, 2); ?>
                                    </td>
                                    <td></td>
                                </tr>
                            <?php else: ?>
                                <tr><td colspan="6" class="px-6 py-10 text-center text-slate-400">Tiada kategori pelaburan direkodkan.</td></tr>
                            <?php endif; ?>
                        </tbody>

                        <tbody class="text-sm" x-show="activeTab === 2" x-cloak>
                            <?php if(count($cat_income) > 0): ?>
                                <?php foreach($cat_income as $cat): ?>
                                <tr class="border-b border-slate-50 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-colors">
                                    <td class="px-6 py-4 text-center"><div class="w-4 h-4 rounded-full mx-auto shadow-sm" style="background-color: <?php echo $cat['color_code']; ?>;"></div></td>
                                    <td class="px-6 py-4 text-slate-700 dark:text-slate-300 font-bold"><?php echo htmlspecialchars($cat['name']); ?></td>
                                    
                                    <td class="px-6 py-4 text-right font-black text-sky-600 dark:text-sky-400 text-base">
                                        <?php echo number_format($cat['budget_amt'], 2); ?>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-slate-500 dark:text-slate-400">
                                        <?php echo number_format($cat['used_amt'], 2); ?>
                                    </td>
                                    <td class="px-6 py-4 text-right font-black <?php echo $cat['balance_amt'] >= 0 ? 'text-emerald-500' : 'text-orange-500'; ?> text-base">
                                        <?php echo $cat['balance_amt'] >= 0 ? '+' : ''; ?><?php echo number_format($cat['balance_amt'], 2); ?>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <button @click="openBudgetModal(<?php echo $cat['id']; ?>, '<?php echo addslashes($cat['name']); ?>', '<?php echo $cat['budget_amt']; ?>', '<?php echo addslashes($cat['color_code']); ?>')" class="px-3 py-1.5 bg-slate-200 text-slate-700 dark:bg-slate-700 dark:text-slate-200 hover:bg-sky-500 hover:text-white rounded-lg text-[10px] font-bold uppercase tracking-wider transition-colors">
                                            Kemaskini
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <tr class="bg-sky-50/50 dark:bg-sky-900/10 border-t-2 border-sky-100 dark:border-sky-800/30">
                                    <td colspan="2" class="px-6 py-4 text-right font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest text-[10px]">Jumlah Sasaran Pendapatan:</td>
                                    <td class="px-6 py-4 text-right font-black text-sky-600 dark:text-sky-400 text-lg">RM <?php echo number_format($total_income_target, 2); ?></td>
                                    <td class="px-6 py-4 text-right font-bold text-slate-600 dark:text-slate-300 text-base">RM <?php echo number_format($total_income_used, 2); ?></td>
                                    <td class="px-6 py-4 text-right font-black <?php echo ($total_income_used - $total_income_target) >= 0 ? 'text-emerald-500' : 'text-orange-500'; ?> text-lg">
                                        <?php echo ($total_income_used - $total_income_target) >= 0 ? '+' : ''; ?><?php echo number_format($total_income_used - $total_income_target, 2); ?>
                                    </td>
                                    <td></td>
                                </tr>
                            <?php else: ?>
                                <tr><td colspan="6" class="px-6 py-10 text-center text-slate-400">Tiada kategori pendapatan direkodkan.</td></tr>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>

        </div>
        <?php include('footer.php'); ?>
    </main>

    <div x-show="budgetPopup" x-cloak class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm transition-all">
        <div @click.away="budgetPopup = false" class="bg-white dark:bg-slate-800 w-full max-w-sm rounded-3xl p-6 shadow-2xl animate-in zoom-in duration-200 border dark:border-slate-700">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <p class="text-[9px] font-black text-indigo-500 uppercase tracking-widest mb-1">Bulan: <?php echo date('M Y', strtotime($selected_month . '-01')); ?></p>
                    <h3 class="text-xl font-black text-slate-800 dark:text-white" x-text="formData.category_name"></h3>
                </div>
                <div class="w-8 h-8 rounded-full border-2 border-white shadow-sm" :style="'background-color: ' + formData.color_code"></div>
            </div>
            
            <form method="POST" action="manage_budget.php?month=<?php echo urlencode($selected_month); ?>">
                <input type="hidden" name="action" value="save_budget">
                <input type="hidden" name="category_id" :value="formData.category_id">
                <input type="hidden" name="budget_month" value="<?php echo htmlspecialchars($selected_month); ?>">
                
                <div class="space-y-5">
                    <div>
                        <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Jumlah Peruntukan / Sasaran (RM)</label>
                        <input type="number" step="0.01" name="amount" x-model="formData.amount" required class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl p-4 text-2xl font-black text-center text-slate-800 dark:text-white focus:ring-2 focus:ring-indigo-500 outline-none">
                    </div>
                </div>
                
                <div class="mt-8 flex gap-3">
                    <button type="button" @click="budgetPopup = false" class="w-1/3 py-3 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-xl font-bold uppercase tracking-wide text-[10px] hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">Batal</button>
                    <button type="submit" class="w-2/3 py-3 bg-indigo-600 text-white rounded-xl font-bold uppercase tracking-wide text-[10px] hover:bg-indigo-700 shadow-md shadow-indigo-200 dark:shadow-none transition-colors">Simpan Rekod</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>