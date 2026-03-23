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

// Ambil senarai Tahun dari DB untuk Dropdown
$years_list = [];
$rsYears = DB::Query("SELECT DISTINCT DATE_FORMAT(income_date, '%Y') as y_val FROM tbl_income WHERE $user_filter ORDER BY y_val DESC");
if($rsYears) { while($rowY = $rsYears->fetchAssoc()){ $years_list[] = $rowY['y_val']; } }
if(empty($years_list)) { $years_list[] = date('Y'); }
if(!in_array(date('Y'), $years_list)) { $years_list[] = date('Y'); rsort($years_list); }

// ==========================================
// PENGIRAAN DATA PENDAPATAN (type_id = 2)
// ==========================================

// 1. JUMLAH KESELURUHAN BULANAN
$grand_total = 0;
$sqlTotal = "
    SELECT SUM(i.amount) as val 
    FROM tbl_income i 
    JOIN tbl_categories c ON i.category_id = c.id 
    WHERE $user_filter_i AND c.type_id = 2 $date_filter_sql_i
";
$rsTotal = DB::Query($sqlTotal);
if($rsTotal && $row = $rsTotal->fetchAssoc()) { 
    $grand_total = floatval($row['val']); 
}

// 2. PECAHAN MENGIKUT SUMBER & BAJET (DIBETULKAN UNTUK FILTER USER)
$cat_breakdown = [];
$pie_labels = []; $pie_data = []; $pie_colors = [];
$total_budget_pie = 0;

$sqlBreakdown = "
    SELECT c.id, c.name, c.color_code, 
           COALESCE(SUM(i.amount), 0) as total,
           COALESCE((SELECT amount FROM tbl_budgets b WHERE b.category_id = c.id AND $user_filter_b AND b.budget_month <= '$filter_month' ORDER BY budget_month DESC LIMIT 1), 0) as budget_amount
    FROM tbl_categories c 
    LEFT JOIN tbl_income i ON c.id = i.category_id AND $user_filter_i $date_filter_sql_i
    WHERE c.type_id = 2 AND (c.user_id = '$user_id' OR c.user_id = 0 OR c.user_id IS NULL)
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
            $pie_colors[] = $row['color_code'] ? $row['color_code'] : '#0ea5e9';
            $total_budget_pie += floatval($row['budget_amount']);
        }
    }
}

// 3. SEJARAH TRANSAKSI
$history_list = [];
$sqlHistory = "
    SELECT i.income_date, i.amount, i.description, c.name as cat_name, c.color_code 
    FROM tbl_income i 
    JOIN tbl_categories c ON i.category_id = c.id 
    WHERE $user_filter_i AND c.type_id = 2 $date_filter_sql_i
    ORDER BY i.income_date DESC, i.id DESC
";
$rsHistory = DB::Query($sqlHistory);
if($rsHistory) {
    while($row = $rsHistory->fetchAssoc()) { $history_list[] = $row; }
}

$json_pie_labels = json_encode($pie_labels);
$json_pie_data = json_encode($pie_data);
$json_pie_colors = json_encode($pie_colors);
?>

<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: window.innerWidth > 1024, darkMode: $persist(false) }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Pendapatan</title>
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
        <?php $page_title = "Portfolio Pendapatan"; include('header.php'); ?>

        <div class="p-6 max-w-7xl mx-auto w-full">
            
            <div class="mb-6 bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-sky-50 dark:bg-sky-900/30 text-sky-500 rounded-xl flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest">Penapis Masa</h3>
                        <p class="text-[10px] font-bold text-slate-400">Pilih bulan dan tahun rekod</p>
                    </div>
                </div>
                
                <form method="GET" action="" class="flex items-center gap-2" x-data="{ y: '<?php echo $sel_year; ?>', m: '<?php echo $sel_month; ?>' }">
                    <input type="hidden" name="filter_month" :value="y + '-' + m">
                    
                    <select x-model="m" @change="$el.form.submit()" class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 p-2.5 font-bold outline-none cursor-pointer">
                        <?php foreach($bulan_melayu as $num => $nama): ?>
                            <option value="<?php echo $num; ?>" <?php if($sel_month == $num) echo 'selected'; ?>><?php echo $nama; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <select x-model="y" @change="$el.form.submit()" class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-sm rounded-lg focus:ring-sky-500 focus:border-sky-500 p-2.5 font-bold outline-none cursor-pointer">
                        <?php foreach($years_list as $y): ?>
                            <option value="<?php echo $y; ?>" <?php if($sel_year == $y) echo 'selected'; ?>><?php echo $y; ?></option>
                        <?php endforeach; ?>
                    </select>

                    <a href="?filter_month=<?php echo date('Y-m'); ?>" class="ml-2 p-2.5 bg-slate-100 hover:bg-slate-200 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-600 dark:text-slate-300 rounded-lg transition-colors shadow-sm" title="Bulan Semasa">
                        <i class="fas fa-redo-alt text-xs"></i>
                    </a>
                </form>
            </div>
            
            <div class="bg-sky-500 p-5 md:p-6 rounded-3xl shadow-lg relative overflow-hidden mb-6 text-white flex flex-col items-center justify-center text-center">
                <i class="fas fa-hand-holding-usd absolute -right-4 -bottom-4 text-7xl md:text-8xl opacity-10"></i>
                <p class="text-sky-100 text-[9px] md:text-[10px] font-black uppercase tracking-widest mb-0.5 relative z-10">Total Pendapatan Bulan Ini</p>
                <h2 class="text-3xl md:text-4xl font-black relative z-10 my-1">RM <?php echo number_format($grand_total, 2); ?></h2>
                <p class="text-sky-200 text-[8px] md:text-[9px] mt-1.5 relative z-10 uppercase tracking-widest"><?php echo $banner_subtitle; ?></p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                
                <div class="bg-white dark:bg-slate-800 p-5 md:p-6 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col items-center justify-start">
                    <h4 class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-4 w-full text-center">Pecahan Sasaran Pendapatan</h4>
                    <?php if($total_budget_pie > 0): ?>
                    <div class="w-full max-w-[300px] h-[280px] relative flex justify-center mt-2">
                        <canvas id="incomePieChart"></canvas>
                    </div>
                    <?php else: ?>
                    <div class="w-full h-[250px] flex flex-col items-center justify-center text-slate-400 mt-2">
                        <i class="fas fa-chart-pie text-4xl mb-3 opacity-20"></i>
                        <p class="text-[10px] font-bold uppercase tracking-widest">Tiada Sasaran Ditetapkan</p>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden flex flex-col">
                    <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                        <h4 class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Ringkasan Prestasi vs Sasaran</h4>
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
                                        $bar_color = ($percentage >= 100 && $budget > 0) ? '#10b981' : ($cat['color_code'] ?: '#0ea5e9'); 
                                    ?>
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <div class="flex items-center gap-2">
                                                <div class="w-2.5 h-2.5 rounded-full" style="background-color: <?php echo htmlspecialchars($cat['color_code']); ?>;"></div>
                                                <span class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase"><?php echo htmlspecialchars($cat['name']); ?></span>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-xs font-black <?php echo ($percentage >= 100 && $budget > 0) ? 'text-emerald-600 bg-emerald-100 px-1 rounded dark:bg-rose-900/30' : 'text-sky-600 dark:text-sky-400'; ?>">
                                                    RM <?php echo number_format($spent, 2); ?>
                                                </span>
                                                <span class="text-[9px] font-bold text-slate-400 ml-1.5">(<?php echo number_format($percentage, 1); ?>%)</span>
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
                <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                    <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest"><i class="fas fa-list-ul mr-2 text-sky-500"></i> Sejarah Transaksi Bulan Ini</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-800/80 text-[9px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 border-b border-slate-200 dark:border-slate-700">
                                <th class="px-5 py-3 w-28">Tarikh</th>
                                <th class="px-5 py-3">Sumber</th>
                                <th class="px-5 py-3">Keterangan</th>
                                <th class="px-5 py-3 text-right">Jumlah (RM)</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($history_list) > 0): ?>
                                <?php foreach($history_list as $t): ?>
                                <tr class="border-b border-slate-50 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-colors">
                                    <td class="px-5 py-3 text-slate-500 dark:text-slate-400 font-bold">
                                        <?php $ti = strtotime($t['income_date']); echo date('d', $ti) . ' ' . $bulan_singkat[date('m', $ti)] . ' ' . date('Y', $ti); ?>
                                    </td>
                                    <td class="px-5 py-3"><span class="text-slate-700 dark:text-slate-300 font-bold"><?php echo htmlspecialchars($t['cat_name']); ?></span></td>
                                    <td class="px-5 py-3 text-slate-600 dark:text-slate-400"><?php echo htmlspecialchars($t['description']); ?></td>
                                    <td class="px-5 py-3 text-right font-black text-sky-600 dark:text-sky-400">+ <?php echo number_format($t['amount'], 2); ?></td>
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

    <script>
        Chart.register(ChartDataLabels);
        document.addEventListener('DOMContentLoaded', function() {
            if(document.getElementById('incomePieChart')) {
                Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
                Chart.defaults.color = '#94a3b8';
                
                const pieCtx = document.getElementById('incomePieChart').getContext('2d');
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
                                    
                                    // PENGIRAAN "LARGEST REMAINDER METHOD" (Tepat 100.00%)
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