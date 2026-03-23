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

// ==========================================
// LOGIK FILTER BULANAN (PELABURAN / SIMPANAN)
// ==========================================
$filter_month = isset($_GET['filter_month']) ? $_GET['filter_month'] : '';
$date_filter_sql_e = ""; // Untuk alias 'e' pada tbl_expenses
$banner_subtitle = "Aset Bersih Terkumpul Anda Sepanjang Zaman";

if (!empty($filter_month)) {
    // Bersihkan format (Pastikan YYYY-MM)
    $clean_month = preg_replace('/[^0-9\-]/', '', $filter_month);
    $start_date = $clean_month . '-01';
    $end_date = date('Y-m-d', strtotime("$start_date +1 month"));
    
    // Klausa tambahan untuk query (menggunakan lajur expense_date)
    $date_filter_sql_e = " AND e.expense_date >= '$start_date' AND e.expense_date < '$end_date' ";
    
    // Ubah teks banner supaya logik dengan bulan dipapar
    $banner_subtitle = "Simpanan & Pelaburan Untuk Bulan " . date('M Y', strtotime($start_date));
}

// Nilai untuk butang Bulan Semasa
$current_month_value = date('Y-m');

// ==========================================
// PENGIRAAN DATA PELABURAN / SIMPANAN (type_id = 4)
// ==========================================

// 1. JUMLAH KESELURUHAN
$grand_total = 0;
$sqlTotal = "
    SELECT SUM(e.amount) as val 
    FROM tbl_expenses e 
    JOIN tbl_categories c ON e.category_id = c.id 
    WHERE e.user_id = '$user_id' AND c.type_id = 4 $date_filter_sql_e
";
$rsTotal = DB::Query($sqlTotal);
if($rsTotal && $row = $rsTotal->fetchAssoc()) { 
    $grand_total = floatval($row['val']); 
}

// 2. PECAHAN MENGIKUT KATEGORI / TABUNG (DIBETULKAN UNTUK FILTER USER)
$cat_breakdown = [];
$pie_labels = []; $pie_data = []; $pie_colors = [];

$sqlBreakdown = "
    SELECT c.id, c.name, c.color_code, 
           COALESCE(SUM(e.amount), 0) as total
    FROM tbl_categories c 
    LEFT JOIN tbl_expenses e ON c.id = e.category_id AND e.user_id = '$user_id' $date_filter_sql_e
    WHERE c.type_id = 4 AND (c.user_id = '$user_id' OR c.user_id = 0 OR c.user_id IS NULL)
    GROUP BY c.id 
    ORDER BY total DESC, c.name ASC
";
$rsBreakdown = DB::Query($sqlBreakdown);
if($rsBreakdown) {
    while($row = $rsBreakdown->fetchAssoc()) {
        $cat_breakdown[] = $row;
        
        // CARTA PAI: Menggunakan nilai simpanan sebenar
        if (floatval($row['total']) > 0) {
            $pie_labels[] = $row['name'];
            $pie_data[] = floatval($row['total']); 
            $pie_colors[] = $row['color_code'] ? $row['color_code'] : '#10b981';
        }
    }
}

// 3. SEJARAH TRANSAKSI
$history_list = [];
$sqlHistory = "
    SELECT e.expense_date, e.amount, e.description, c.name as cat_name, c.color_code 
    FROM tbl_expenses e 
    JOIN tbl_categories c ON e.category_id = c.id 
    WHERE e.user_id = '$user_id' AND c.type_id = 4 $date_filter_sql_e
    ORDER BY e.expense_date DESC, e.id DESC
";
$rsHistory = DB::Query($sqlHistory);
if($rsHistory) {
    while($row = $rsHistory->fetchAssoc()) {
        $history_list[] = $row;
    }
}

// Encode Data Carta
$json_pie_labels = json_encode($pie_labels);
$json_pie_data = json_encode($pie_data);
$json_pie_colors = json_encode($pie_colors);
?>

<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: window.innerWidth > 1024, darkMode: $persist(false) }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio Simpanan & Pelaburan</title>
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
        <?php $page_title = "Portfolio Pelaburan"; include('header.php'); ?>

        <div class="p-6 max-w-7xl mx-auto w-full">
            
            <div class="mb-6 bg-white dark:bg-slate-800 p-4 rounded-2xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col sm:flex-row items-center justify-between gap-4">
                <h3 class="text-sm font-black text-slate-700 dark:text-slate-300 uppercase tracking-widest flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-emerald-500"></i> Penapis Bulanan
                </h3>
                <form method="GET" action="" class="flex flex-wrap items-center gap-3 w-full sm:w-auto">
                    
                    <input type="month" name="filter_month" 
                           value="<?php echo htmlspecialchars($filter_month); ?>" 
                           onchange="this.form.submit()"
                           class="bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 text-sm rounded-lg focus:ring-emerald-500 focus:border-emerald-500 block p-2.5 font-bold outline-none cursor-pointer flex-1 sm:flex-none">
                    
                    <a href="?filter_month=<?php echo $current_month_value; ?>" class="bg-emerald-100 hover:bg-emerald-200 text-emerald-700 dark:bg-emerald-900/40 dark:hover:bg-emerald-800 dark:text-emerald-300 font-bold py-2.5 px-4 rounded-lg transition-colors text-sm whitespace-nowrap flex items-center gap-2 border border-emerald-200 dark:border-emerald-800">
                        <i class="fas fa-clock"></i> Bulan Semasa
                    </a>
                    
                    <?php if(!empty($filter_month)): ?>
                    <a href="<?php echo basename($_SERVER['PHP_SELF']); ?>" class="bg-slate-200 hover:bg-slate-300 dark:bg-slate-700 dark:hover:bg-slate-600 text-slate-700 dark:text-slate-200 font-bold py-2.5 px-4 rounded-lg transition-colors text-sm whitespace-nowrap">
                        Reset Keseluruhan
                    </a>
                    <?php endif; ?>
                </form>
            </div>
            
            <div class="bg-emerald-500 p-5 md:p-6 rounded-3xl shadow-lg relative overflow-hidden mb-6 text-white flex flex-col items-center justify-center text-center">
                <i class="fas fa-seedling absolute -right-4 -bottom-4 text-7xl md:text-8xl opacity-10"></i>
                <p class="text-emerald-100 text-[9px] md:text-[10px] font-black uppercase tracking-widest mb-0.5 relative z-10">Total Keseluruhan Simpanan & Pelaburan</p>
                <h2 class="text-3xl md:text-4xl font-black relative z-10 my-1">RM <?php echo number_format($grand_total, 2); ?></h2>
                <p class="text-emerald-200 text-[8px] md:text-[9px] mt-1.5 relative z-10 uppercase tracking-widest"><?php echo $banner_subtitle; ?></p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                
                <div class="bg-white dark:bg-slate-800 p-5 md:p-6 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 flex flex-col items-center justify-start">
                    <h4 class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest mb-4 w-full text-center">Pecahan Kategori Simpanan</h4>
                    
                    <?php if($grand_total > 0): ?>
                    <div class="w-full max-w-[300px] h-[280px] relative flex justify-center mt-2">
                        <canvas id="portfolioPieChart"></canvas>
                    </div>
                    <?php else: ?>
                    <div class="w-full h-[250px] flex flex-col items-center justify-center text-slate-400 mt-2">
                        <i class="fas fa-chart-pie text-4xl mb-3 opacity-20"></i>
                        <p class="text-[10px] font-bold uppercase tracking-widest">Tiada Simpanan Direkodkan</p>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden flex flex-col">
                    <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50">
                        <h4 class="text-[10px] font-black text-slate-500 dark:text-slate-400 uppercase tracking-widest">Ringkasan Mengikut Tabung</h4>
                    </div>
                    <div class="p-5 flex-1">
                        <div class="space-y-3.5 max-h-[300px] overflow-y-auto custom-scrollbar pr-2">
                            <?php if(count($cat_breakdown) > 0): ?>
                                <?php foreach($cat_breakdown as $cat): ?>
                                    <?php 
                                        $spent = floatval($cat['total']);
                                        
                                        $percentage = ($grand_total > 0) ? ($spent / $grand_total) * 100 : 0; 
                                        
                                        $bar_color = $cat['color_code'] ? $cat['color_code'] : '#10b981';
                                    ?>
                                    <div>
                                        <div class="flex justify-between items-center mb-1">
                                            <div class="flex items-center gap-2">
                                                <div class="w-2.5 h-2.5 rounded-full" style="background-color: <?php echo htmlspecialchars($cat['color_code']); ?>;"></div>
                                                <span class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase"><?php echo htmlspecialchars($cat['name']); ?></span>
                                            </div>
                                            <div class="text-right">
                                                <span class="text-xs font-black text-slate-700 dark:text-slate-300">
                                                    RM <?php echo number_format($spent, 2); ?>
                                                </span>
                                                <span class="text-[9px] font-bold text-slate-400 ml-1.5">
                                                    (<?php echo number_format($percentage, 1); ?>%)
                                                </span>
                                            </div>
                                        </div>
                                        <div class="w-full bg-slate-100 dark:bg-slate-700 rounded-full h-1.5 mt-0.5">
                                            <div class="h-1.5 rounded-full" style="width: <?php echo $percentage; ?>%; background-color: <?php echo $bar_color; ?>;"></div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p class="text-center text-xs text-slate-400 font-bold py-6">Kategori pangkalan data kosong.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden mb-6">
                <div class="px-5 py-4 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 flex justify-between items-center">
                    <h3 class="text-sm font-black text-slate-800 dark:text-white uppercase tracking-widest"><i class="fas fa-list-ul mr-2 text-emerald-500"></i> Sejarah Transaksi Pelaburan</h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-800/80 text-[9px] font-black uppercase tracking-widest text-slate-400 dark:text-slate-500 border-b border-slate-200 dark:border-slate-700">
                                <th class="px-5 py-3 w-28">Tarikh</th>
                                <th class="px-5 py-3">Tabung / Kategori</th>
                                <th class="px-5 py-3">Keterangan</th>
                                <th class="px-5 py-3 text-right">Jumlah (RM)</th>
                            </tr>
                        </thead>
                        <tbody class="text-xs">
                            <?php if(count($history_list) > 0): ?>
                                <?php foreach($history_list as $t): ?>
                                <tr class="border-b border-slate-50 dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-colors">
                                    <td class="px-5 py-3 text-slate-500 dark:text-slate-400 font-bold">
                                        <?php echo date('d M Y', strtotime($t['expense_date'])); ?>
                                    </td>
                                    
                                    <td class="px-5 py-3">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2.5 h-2.5 rounded-full" style="background-color: <?php echo htmlspecialchars($t['color_code']); ?>;"></div>
                                            <span class="text-slate-700 dark:text-slate-300 font-bold"><?php echo htmlspecialchars($t['cat_name']); ?></span>
                                        </div>
                                    </td>
                                    
                                    <td class="px-5 py-3 text-slate-600 dark:text-slate-400">
                                        <?php echo htmlspecialchars($t['description']); ?>
                                    </td>
                                    
                                    <td class="px-5 py-3 text-right font-black text-emerald-600 dark:text-emerald-400">
                                        + <?php echo number_format($t['amount'], 2); ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="px-5 py-12 text-center text-slate-400 dark:text-slate-500">
                                        <i class="fas fa-piggy-bank text-4xl mb-3 opacity-20 block"></i>
                                        <p class="text-xs font-bold uppercase tracking-widest">Tiada Sejarah Rekod</p>
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

    <script>
        Chart.register(ChartDataLabels);

        document.addEventListener('DOMContentLoaded', function() {
            if(document.getElementById('portfolioPieChart')) {
                Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
                Chart.defaults.color = '#94a3b8';
                
                const pieCtx = document.getElementById('portfolioPieChart').getContext('2d');
                new Chart(pieCtx, {
                    type: 'doughnut',
                    data: {
                        labels: <?php echo $json_pie_labels; ?>,
                        datasets: [{
                            data: <?php echo $json_pie_data; ?>,
                            backgroundColor: <?php echo $json_pie_colors; ?>, 
                            borderWidth: 0,
                            hoverOffset: 6
                        }]
                    },
                    options: { 
                        responsive: true, 
                        maintainAspectRatio: false, 
                        layout: {
                            padding: 10
                        },
                        plugins: { 
                            legend: { 
                                position: 'bottom', 
                                labels: { 
                                    font: {size: 10, weight: 'bold'},
                                    usePointStyle: true,
                                    pointStyle: 'circle',
                                    padding: 15
                                } 
                            },
                            datalabels: {
                                color: '#ffffff', 
                                font: { weight: 'bold', size: 11 },
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
                                    
                                    for (let i = 0; i < diff; i++) {
                                        flooredPct[remainders[i].idx] += 0.01;
                                    }
                                    
                                    return flooredPct[ctx.dataIndex].toFixed(2) + "%";
                                }
                            }
                        }, 
                        cutout: '65%' 
                    }
                });
            }
        });
    </script>
</body>
</html>