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
// 1. DAPATKAN ID PENGGUNA & FULLNAME
// =========================================================
$login_username = isset($_SESSION["UserID"]) ? $_SESSION["UserID"] : ""; 
$user_id = 0; $user_fullname = "Pengguna";

$sqlCheckUser = "SELECT ID, fullname FROM tbl_users WHERE username = " . db_prepare_string($login_username) . " OR email = " . db_prepare_string($login_username) . " OR ext_security_id = " . db_prepare_string($login_username) . " LIMIT 1";
$rsUser = DB::Query($sqlCheckUser);
if ($rsUser && $rowUser = $rsUser->fetchAssoc()) {
    $user_id = $rowUser['ID']; 
    $user_fullname = !empty($rowUser['fullname']) ? $rowUser['fullname'] : $login_username;
    $_SESSION["UserDbID"] = $user_id; $_SESSION["UserFullName"] = $user_fullname;
} elseif (isset($_SESSION["UserDbID"]) && $_SESSION["UserDbID"] != 0) {
    $user_id = $_SESSION["UserDbID"];
}

$msg = ""; $msg_type = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'add_transaction') {
        $t_type = $_POST['t_type']; $date = $_POST['t_date']; $input_amount = floatval($_POST['amount']); $cat_id = intval($_POST['category_id']); $desc = $_POST['description']; $created_at = date('Y-m-d H:i:s');
        $receipt_path = NULL;
        
        if (isset($_FILES['receipt']) && $_FILES['receipt']['error'] == UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/receipts/'; if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true); 
            $source = $_FILES['receipt']['tmp_name']; $ext = strtolower(pathinfo($_FILES['receipt']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'pdf'])) { 
                $target_path = $upload_dir . uniqid('doc_') . '.' . $ext; 
                if(move_uploaded_file($source, $target_path)) { $receipt_path = $target_path; } 
            }
        }
        
        if ($input_amount > 0 && $cat_id > 0) {
            $db_receipt = $receipt_path ? db_prepare_string($receipt_path) : "NULL";
            
            if ($t_type == 'in') {
                $sqlInsert = "INSERT INTO tbl_income (user_id, category_id, income_date, amount, description, receipt_path, created_at) 
                              VALUES ('$user_id', $cat_id, '$date', $input_amount, " . db_prepare_string($desc) . ", $db_receipt, '$created_at')";
            } else {
                $is_lhdn = isset($_POST['is_lhdn']) ? 1 : 0;
                $sqlInsert = "INSERT INTO tbl_expenses (user_id, category_id, expense_date, amount, description, receipt_path, created_at, is_lhdn) 
                              VALUES ('$user_id', $cat_id, '$date', $input_amount, " . db_prepare_string($desc) . ", $db_receipt, '$created_at', $is_lhdn)";
            }
            
            DB::Exec($sqlInsert);
            $msg = "Transaksi direkodkan.";
        }
    } elseif (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $t_id = intval($_POST['t_id']); $t_type = $_POST['t_type'];
        $table = ($t_type == 'in') ? 'tbl_income' : 'tbl_expenses';
        DB::Exec("DELETE FROM $table WHERE id = $t_id AND user_id = '$user_id'");
        $msg = "Rekod berjaya dipadam.";
    } elseif (isset($_POST['action']) && $_POST['action'] === 'edit_transaction') {
        // --- PROSES KEMASKINI (EDIT) REKOD ---
        $t_id = intval($_POST['edit_id']);
        $t_type = $_POST['edit_t_type'];
        $date = $_POST['edit_t_date']; 
        $input_amount = floatval($_POST['edit_amount']); 
        $cat_id = intval($_POST['edit_category_id']); 
        $desc = $_POST['edit_description'];
        
        // Cek jika ada upload resit baru
        $receipt_update_sql = "";
        if (isset($_FILES['edit_receipt']) && $_FILES['edit_receipt']['error'] == UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/receipts/'; if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true); 
            $source = $_FILES['edit_receipt']['tmp_name']; $ext = strtolower(pathinfo($_FILES['edit_receipt']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'pdf'])) { 
                $target_path = $upload_dir . uniqid('doc_') . '.' . $ext; 
                if(move_uploaded_file($source, $target_path)) { 
                    $receipt_update_sql = ", receipt_path = " . db_prepare_string($target_path); 
                } 
            }
        }
        
        if ($input_amount > 0 && $cat_id > 0 && $t_id > 0) {
            if ($t_type == 'in') {
                $sqlUpdate = "UPDATE tbl_income SET 
                                category_id = $cat_id, 
                                income_date = '$date', 
                                amount = $input_amount, 
                                description = " . db_prepare_string($desc) . " 
                                $receipt_update_sql
                              WHERE id = $t_id AND user_id = '$user_id'";
            } else {
                $is_lhdn = isset($_POST['edit_is_lhdn']) ? 1 : 0;
                $sqlUpdate = "UPDATE tbl_expenses SET 
                                category_id = $cat_id, 
                                expense_date = '$date', 
                                amount = $input_amount, 
                                description = " . db_prepare_string($desc) . ",
                                is_lhdn = $is_lhdn
                                $receipt_update_sql
                              WHERE id = $t_id AND user_id = '$user_id'";
            }
            DB::Exec($sqlUpdate);
            $msg = "Rekod berjaya dikemaskini.";
        }
    }
}

$search_text = isset($_GET['search']) ? $_GET['search'] : ""; $filter_month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
if ($filter_month === 'all') { $sel_year = date('Y'); $sel_month = date('m'); } else { $parts = explode('-', $filter_month); $sel_year = $parts[0]??date('Y'); $sel_month = $parts[1]??date('m'); }

$sql_trans = "SELECT * FROM (
    SELECT e.id, e.expense_date AS t_date, e.amount, e.description, e.category_id, e.receipt_path, 'out' AS t_type, c.name as cat_name, c.color_code, e.is_lhdn 
    FROM tbl_expenses e LEFT JOIN tbl_categories c ON e.category_id=c.id WHERE e.user_id='$user_id' 
    UNION ALL 
    SELECT i.id, i.income_date AS t_date, i.amount, i.description, i.category_id, i.receipt_path, 'in' AS t_type, c.name as cat_name, c.color_code, 0 as is_lhdn 
    FROM tbl_income i LEFT JOIN tbl_categories c ON i.category_id=c.id WHERE i.user_id='$user_id'
) AS t WHERE 1=1 ";
if ($filter_month != 'all') { $sql_trans .= " AND DATE_FORMAT(t_date, '%Y-%m') = '$filter_month' "; }
if (!empty($search_text)) { $search_sql = db_prepare_string("%".$search_text."%"); $sql_trans .= " AND (description LIKE $search_sql OR cat_name LIKE $search_sql) "; }
$sql_trans .= " ORDER BY t_date DESC, id DESC";

$rsT = DB::Query($sql_trans); $trans_list = []; $total_in=0; $total_out=0;
if($rsT) { while($row = $rsT->fetchAssoc()){ $trans_list[]=$row; if($row['t_type']=='in') $total_in+=floatval($row['amount']); else $total_out+=floatval($row['amount']); } }

$cat_in=[]; $cat_out=[]; $rsC = DB::Query("SELECT id, name, type_id, color_code FROM tbl_categories WHERE user_id='$user_id' OR user_id=0 OR user_id IS NULL ORDER BY name ASC");
if($rsC){while($r=$rsC->fetchAssoc()){if($r['type_id']==2)$cat_in[]=$r;else $cat_out[]=$r;}}

$bulan_melayu = [ '01'=>'Januari', '02'=>'Februari', '03'=>'Mac', '04'=>'April', '05'=>'Mei', '06'=>'Jun', '07'=>'Julai', '08'=>'Ogos', '09'=>'September', '10'=>'Oktober', '11'=>'November', '12'=>'Disember' ];
$years_list = []; $rsYears = DB::Query("SELECT DISTINCT DATE_FORMAT(t_date, '%Y') as y_val FROM (SELECT expense_date AS t_date FROM tbl_expenses WHERE user_id='$user_id' UNION SELECT income_date AS t_date FROM tbl_income WHERE user_id='$user_id') as t ORDER BY y_val DESC");
if($rsYears) { while($r = $rsYears->fetchAssoc()) $years_list[]=$r['y_val']; } if(empty($years_list)) $years_list[]=date('Y');
?>
<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: window.innerWidth>1024, darkMode: $persist(false), formPopup:false, previewModal:false, previewSrc:'', previewType:'', delModal:false, editModal:false, editData: {} }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <title>Sejarah Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script> tailwind.config = { darkMode: 'class' } </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: background-color 0.3s ease; } 
        [x-cloak]{display:none !important;}
        .custom-scrollbar::-webkit-scrollbar { width: 4px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
        .dark .custom-scrollbar::-webkit-scrollbar-thumb { background: #475569; }
    </style>
</head>
<body class="flex min-h-screen" :class="darkMode ? 'bg-slate-900 text-white' : 'bg-slate-50 text-slate-800'">
    <?php include('sidebar.php'); ?>
    <main class="flex-1 overflow-y-auto"><?php $page_title="Sejarah Transaksi"; include('header.php'); ?>
        <div class="p-6 max-w-7xl mx-auto">
            <?php if($msg): ?><div class="bg-emerald-100 border border-emerald-400 text-emerald-700 px-4 py-3 rounded-xl mb-6 shadow-sm flex items-center"><i class="fas fa-check-circle mr-2"></i><?php echo $msg; ?></div><?php endif; ?>
            <div class="bg-white dark:bg-slate-800 p-6 rounded-3xl shadow-sm mb-6 flex flex-col xl:flex-row justify-between items-center gap-6 border dark:border-slate-700">
                <div class="flex gap-6 w-full xl:w-auto items-center">
                    <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Masuk</p><h3 class="text-xl font-black text-sky-500">RM <?php echo number_format($total_in,2); ?></h3></div><div class="w-px h-10 bg-slate-200 dark:bg-slate-700"></div>
                    <div><p class="text-[10px] font-black text-slate-400 uppercase tracking-widest">Keluar</p><h3 class="text-xl font-black text-rose-500">RM <?php echo number_format($total_out,2); ?></h3></div>
                </div>
                <form id="searchForm" method="GET" class="flex flex-col md:flex-row items-center gap-2 w-full xl:w-auto" x-data="{ y: '<?php echo $sel_year; ?>', m: '<?php echo $sel_month; ?>' }">
                    <div class="relative w-full md:w-56"><i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i><input type="text" name="search" value="<?php echo htmlspecialchars($search_text); ?>" placeholder="Cari nota..." oninput="debounceSearch()" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl py-2 pl-9 pr-4 text-sm outline-none focus:ring-2 focus:ring-indigo-500"></div>
                    <input type="hidden" name="month" :value="y+'-'+m">
                    <div class="flex gap-1.5 w-full md:w-auto">
                        <select x-model="m" @change="document.getElementById('searchForm').submit()" class="flex-1 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm rounded-lg p-2 outline-none"><?php foreach($bulan_melayu as $n=>$l) echo "<option value='$n'>$l</option>"; ?></select>
                        <select x-model="y" @change="document.getElementById('searchForm').submit()" class="flex-1 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-sm rounded-lg p-2 outline-none"><?php foreach($years_list as $yr) echo "<option value='$yr'>$yr</option>"; ?></select>
                    </div>
                    <button type="button" @click="formPopup=true" class="w-full md:w-auto px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-xs uppercase shadow-md flex items-center justify-center gap-2"><i class="fas fa-plus"></i> Baru</button>
                </form>
            </div>
            
            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-800/80 text-[9px] font-black uppercase tracking-widest text-slate-400 border-b dark:border-slate-700"><th class="px-6 py-4 text-center">Aliran</th><th>Tarikh</th><th>Kategori</th><th>Nota</th><th class="text-center">Resit</th><th class="text-right">Jumlah (RM)</th><th class="text-center">Tindakan</th></tr>
                    </thead>
                    <tbody>
                    <?php if(count($trans_list)>0): foreach($trans_list as $t): ?>
                    <tr class="border-b dark:border-slate-700/50 hover:bg-slate-50 dark:hover:bg-slate-800/80 transition-colors">
                        <td class="px-6 py-4 text-center"><i class="fas <?php echo $t['t_type']=='in'?'fa-arrow-down text-sky-500 bg-sky-100 dark:bg-sky-900/40':'fa-arrow-up text-rose-500 bg-rose-100 dark:bg-rose-900/40'; ?> p-2 rounded-full text-xs"></i></td>
                        <td class="px-6 py-4 font-bold text-xs text-slate-500 dark:text-slate-400"><?php echo date('d M Y', strtotime($t['t_date'])); ?></td>
                        <td class="px-6 py-4 font-bold text-slate-700 dark:text-slate-300"><div class="flex items-center gap-2"><div class="w-2.5 h-2.5 rounded-full" style="background:<?php echo $t['color_code']?:'#94a3b8'; ?>"></div><?php echo $t['cat_name']; ?></div></td>
                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                            <?php echo htmlspecialchars($t['description']); ?>
                            <?php if(isset($t['is_lhdn']) && $t['is_lhdn'] == 1): ?>
                                <span class="ml-2 inline-block px-2 py-0.5 bg-emerald-100 text-emerald-600 dark:bg-emerald-900/30 dark:text-emerald-400 text-[8px] font-black rounded-md uppercase tracking-widest border border-emerald-200 dark:border-emerald-800" title="Pelepasan Cukai LHDN">LHDN</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-center"><?php if($t['receipt_path'] && file_exists($t['receipt_path'])): ?><button @click="previewSrc='<?php echo $t['receipt_path']; ?>'; previewType='<?php echo strtolower(pathinfo($t['receipt_path'], PATHINFO_EXTENSION)); ?>'; previewModal=true" class="w-8 h-8 flex items-center justify-center rounded-lg bg-indigo-50 text-indigo-500 mx-auto dark:bg-indigo-900/30 dark:text-indigo-400 hover:bg-indigo-100 transition-colors"><i class="fas <?php echo (pathinfo($t['receipt_path'],PATHINFO_EXTENSION)=='pdf')?'fa-file-pdf':'fa-image'; ?>"></i></button><?php else: ?><span class="text-slate-300">-</span><?php endif; ?></td>
                        <td class="px-6 py-4 text-right font-black <?php echo $t['t_type']=='in'?'text-sky-600 dark:text-sky-400':'text-rose-600 dark:text-rose-400'; ?>"><?php echo $t['t_type']=='in'?'+':'-'; ?> <?php echo number_format($t['amount'],2); ?></td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <button @click="editData = {
                                id: '<?php echo $t['id']; ?>',
                                type: '<?php echo $t['t_type']; ?>',
                                date: '<?php echo $t['t_date']; ?>',
                                amount: '<?php echo $t['amount']; ?>',
                                category_id: '<?php echo $t['category_id']; ?>',
                                cat_name: '<?php echo htmlspecialchars(addslashes($t['cat_name'])); ?>',
                                color_code: '<?php echo $t['color_code']; ?>',
                                description: '<?php echo htmlspecialchars(addslashes($t['description'])); ?>',
                                is_lhdn: <?php echo isset($t['is_lhdn']) ? $t['is_lhdn'] : 0; ?>
                            }; editModal=true" class="text-slate-400 hover:text-indigo-500 transition-colors" title="Kemaskini Rekod"><i class="fas fa-edit"></i></button>
                            
                            <button @click="document.getElementById('del_t_id').value='<?php echo $t['id']; ?>'; document.getElementById('del_t_type').value='<?php echo $t['t_type']; ?>'; delModal=true" class="text-slate-400 hover:text-rose-500 transition-colors" title="Padam Rekod"><i class="fas fa-trash-alt"></i></button>
                        </td>
                    </tr>
                    <?php endforeach; else: ?><tr><td colspan="7" class="px-6 py-20 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">Tiada rekod dijumpai</td></tr><?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
    
    <div x-show="formPopup" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm text-left" x-cloak>
        <div @click.away="formPopup=false" class="bg-white dark:bg-slate-800 w-full max-w-lg rounded-3xl p-6 shadow-2xl border dark:border-slate-700" x-data="{ type: 'out' }">
            <div class="flex justify-between items-start mb-5"><h3 class="text-xl font-black uppercase tracking-tight">Transaksi Baru</h3><button @click="formPopup=false" class="text-slate-300 hover:text-rose-500 transition-colors"><i class="fas fa-times-circle text-xl"></i></button></div>
            <form method="POST" action="expenses_list.php" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add_transaction">
                <div class="space-y-4">
                    <div class="flex p-1 bg-slate-100 dark:bg-slate-900 rounded-xl">
                        <label class="flex-1 cursor-pointer"><input type="radio" name="t_type" value="out" x-model="type" class="hidden"><div class="text-center py-2 rounded-lg text-xs font-bold uppercase transition-colors" :class="type==='out'?'bg-white dark:bg-slate-800 text-rose-500 shadow-sm':'text-slate-500'">Wang Keluar</div></label>
                        <label class="flex-1 cursor-pointer"><input type="radio" name="t_type" value="in" x-model="type" class="hidden"><div class="text-center py-2 rounded-lg text-xs font-bold uppercase transition-colors" :class="type==='in'?'bg-white dark:bg-slate-800 text-sky-500 shadow-sm':'text-slate-500'">Pendapatan</div></label>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Tarikh</label><input type="date" name="t_date" required value="<?php echo date('Y-m-d'); ?>" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-2.5 text-sm outline-none focus:ring-2 focus:ring-indigo-500"></div>
                        <div><label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Jumlah (RM)</label><input type="number" step="0.01" name="amount" required placeholder="0.00" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-2.5 text-sm outline-none focus:ring-2 focus:ring-indigo-500"></div>
                    </div>
                    <div x-data="{ open: false, search: '', selected: '', selectedText: '-- Pilih Kategori --', selectedColor: '' }">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kategori</label>
                        <div class="relative">
                            <button type="button" @click="open=!open" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-2.5 text-sm text-left flex justify-between items-center outline-none focus:ring-2 focus:ring-indigo-500 transition-colors"><div class="flex items-center gap-2"><div x-show="selectedColor" class="w-2.5 h-2.5 rounded-full" :style="'background-color: '+selectedColor" x-cloak></div><span x-text="selectedText" :class="selected===''?'text-slate-400':''"></span></div><i class="fas fa-chevron-down text-[10px] text-slate-400" :class="open?'rotate-180':''"></i></button>
                            <input type="hidden" name="category_id" x-model="selected" required>
                            <div x-show="open" @click.away="open=false" class="absolute z-10 w-full mt-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-xl overflow-hidden" x-cloak x-transition>
                                <div class="p-2 border-b dark:border-slate-700 bg-slate-50 dark:bg-slate-900"><input type="text" x-model="search" placeholder="Cari..." class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md py-1.5 px-3 text-xs outline-none"></div>
                                <ul class="max-h-48 overflow-y-auto p-1 custom-scrollbar">
                                    <div x-show="type === 'out'">
                                        <?php foreach($cat_out as $cat): 
                                            $prefix = ($cat['type_id'] == 3) ? '[KOMITMEN]' : (($cat['type_id'] == 4) ? '[PELABURAN]' : '[BELANJA]');
                                            $fullName = $prefix . " " . $cat['name'];
                                            $color = $cat['color_code'] ?: '#94a3b8';
                                        ?>
                                            <li x-show="'<?php echo strtolower(addslashes($fullName)); ?>'.includes(search.toLowerCase())" @click="selected='<?php echo $cat['id']; ?>'; selectedText='<?php echo addslashes($fullName); ?>'; selectedColor='<?php echo $color; ?>'; open=false; search=''" class="px-3 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 cursor-pointer rounded-md flex items-center gap-2">
                                                <div class="w-2.5 h-2.5 rounded-full" style="background-color: <?php echo $color; ?>;"></div>
                                                <?php echo htmlspecialchars($fullName); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </div>
                                    <div x-show="type === 'in'">
                                        <?php foreach($cat_in as $cat): 
                                            $color = $cat['color_code'] ?: '#94a3b8';
                                        ?>
                                            <li x-show="'<?php echo strtolower(addslashes($cat['name'])); ?>'.includes(search.toLowerCase())" @click="selected='<?php echo $cat['id']; ?>'; selectedText='<?php echo addslashes($cat['name']); ?>'; selectedColor='<?php echo $color; ?>'; open=false; search=''" class="px-3 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 cursor-pointer rounded-md flex items-center gap-2">
                                                <div class="w-2.5 h-2.5 rounded-full" style="background-color: <?php echo $color; ?>;"></div>
                                                <?php echo htmlspecialchars($cat['name']); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div><label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nota</label><input type="text" name="description" placeholder="Contoh: Bayar bil..." class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-2.5 text-sm outline-none focus:ring-2 focus:ring-indigo-500"></div>
                    <div><label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Muat Naik Resit (Pilihan)</label><input type="file" name="receipt" accept=".jpg,.jpeg,.png,.pdf" class="w-full text-xs file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400 cursor-pointer text-slate-500"></div>
                    
                    <div x-show="type === 'out'" class="flex items-center gap-2 mt-2 p-3 bg-rose-50 dark:bg-rose-900/10 border border-rose-100 dark:border-rose-800/30 rounded-xl" x-cloak x-transition>
                        <input type="checkbox" id="is_lhdn" name="is_lhdn" value="1" class="w-4 h-4 text-rose-500 bg-white border-slate-300 rounded focus:ring-rose-500 cursor-pointer dark:bg-slate-900 dark:border-slate-700 accent-rose-500">
                        <label for="is_lhdn" class="text-[10px] font-bold text-rose-600 dark:text-rose-400 uppercase tracking-wide cursor-pointer select-none">Tandakan untuk Pelepasan Cukai (LHDN)</label>
                    </div>

                </div>
                <button type="submit" class="w-full mt-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-black uppercase text-xs tracking-widest shadow-lg transition-all">Simpan Rekod</button>
            </form>
        </div>
    </div>
    
    <div x-show="editModal" class="fixed inset-0 z-[60] flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm text-left" x-cloak>
        <div @click.away="editModal=false" class="bg-white dark:bg-slate-800 w-full max-w-lg rounded-3xl p-6 shadow-2xl border dark:border-slate-700">
            <div class="flex justify-between items-start mb-5"><h3 class="text-xl font-black uppercase tracking-tight text-indigo-600 dark:text-indigo-400"><i class="fas fa-edit mr-2"></i> Kemaskini Rekod</h3><button @click="editModal=false" class="text-slate-300 hover:text-rose-500 transition-colors"><i class="fas fa-times-circle text-xl"></i></button></div>
            <form method="POST" action="expenses_list.php" enctype="multipart/form-data">
                <input type="hidden" name="action" value="edit_transaction">
                <input type="hidden" name="edit_id" :value="editData.id">
                <input type="hidden" name="edit_t_type" :value="editData.type">
                
                <div class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div><label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Tarikh</label><input type="date" name="edit_t_date" required x-model="editData.date" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-2.5 text-sm outline-none focus:ring-2 focus:ring-indigo-500"></div>
                        <div><label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Jumlah (RM)</label><input type="number" step="0.01" name="edit_amount" required x-model="editData.amount" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-2.5 text-sm outline-none focus:ring-2 focus:ring-indigo-500"></div>
                    </div>
                    
                    <div x-data="{ openEdit: false, searchEdit: '' }">
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Kategori</label>
                        <div class="relative">
                            <button type="button" @click="openEdit=!openEdit" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-2.5 text-sm text-left flex justify-between items-center outline-none focus:ring-2 focus:ring-indigo-500 transition-colors">
                                <div class="flex items-center gap-2">
                                    <div x-show="editData.color_code" class="w-2.5 h-2.5 rounded-full" :style="'background-color: '+editData.color_code" x-cloak></div>
                                    <span x-text="editData.cat_name"></span>
                                </div>
                                <i class="fas fa-chevron-down text-[10px] text-slate-400" :class="openEdit?'rotate-180':''"></i>
                            </button>
                            <input type="hidden" name="edit_category_id" x-model="editData.category_id" required>
                            <div x-show="openEdit" @click.away="openEdit=false" class="absolute z-10 w-full mt-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg shadow-xl overflow-hidden" x-cloak x-transition>
                                <div class="p-2 border-b dark:border-slate-700 bg-slate-50 dark:bg-slate-900"><input type="text" x-model="searchEdit" placeholder="Cari..." class="w-full bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-md py-1.5 px-3 text-xs outline-none"></div>
                                <ul class="max-h-48 overflow-y-auto p-1 custom-scrollbar">
                                    <div x-show="editData.type === 'out'">
                                        <?php foreach($cat_out as $cat): 
                                            $prefix = ($cat['type_id'] == 3) ? '[KOMITMEN]' : (($cat['type_id'] == 4) ? '[PELABURAN]' : '[BELANJA]');
                                            $fullName = $prefix . " " . $cat['name'];
                                            $color = $cat['color_code'] ?: '#94a3b8';
                                        ?>
                                            <li x-show="'<?php echo strtolower(addslashes($fullName)); ?>'.includes(searchEdit.toLowerCase())" @click="editData.category_id='<?php echo $cat['id']; ?>'; editData.cat_name='<?php echo addslashes($fullName); ?>'; editData.color_code='<?php echo $color; ?>'; openEdit=false; searchEdit=''" class="px-3 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 cursor-pointer rounded-md flex items-center gap-2">
                                                <div class="w-2.5 h-2.5 rounded-full" style="background-color: <?php echo $color; ?>;"></div>
                                                <?php echo htmlspecialchars($fullName); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </div>
                                    <div x-show="editData.type === 'in'">
                                        <?php foreach($cat_in as $cat): 
                                            $color = $cat['color_code'] ?: '#94a3b8';
                                        ?>
                                            <li x-show="'<?php echo strtolower(addslashes($cat['name'])); ?>'.includes(searchEdit.toLowerCase())" @click="editData.category_id='<?php echo $cat['id']; ?>'; editData.cat_name='<?php echo addslashes($cat['name']); ?>'; editData.color_code='<?php echo $color; ?>'; openEdit=false; searchEdit=''" class="px-3 py-2 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 cursor-pointer rounded-md flex items-center gap-2">
                                                <div class="w-2.5 h-2.5 rounded-full" style="background-color: <?php echo $color; ?>;"></div>
                                                <?php echo htmlspecialchars($cat['name']); ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                    
                    <div><label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Nota</label><input type="text" name="edit_description" x-model="editData.description" placeholder="Contoh: Bayar bil..." class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-lg p-2.5 text-sm outline-none focus:ring-2 focus:ring-indigo-500"></div>
                    
                    <div>
                        <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Ganti Resit (Biar kosong jika tiada perubahan)</label>
                        <input type="file" name="edit_receipt" accept=".jpg,.jpeg,.png,.pdf" class="w-full text-xs file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-indigo-900/30 dark:file:text-indigo-400 cursor-pointer text-slate-500">
                    </div>
                    
                    <div x-show="editData.type === 'out'" class="flex items-center gap-2 mt-2 p-3 bg-indigo-50 dark:bg-indigo-900/10 border border-indigo-100 dark:border-indigo-800/30 rounded-xl" x-cloak>
                        <input type="checkbox" id="edit_is_lhdn" name="edit_is_lhdn" value="1" x-model="editData.is_lhdn" class="w-4 h-4 text-indigo-600 bg-white border-slate-300 rounded focus:ring-indigo-500 cursor-pointer dark:bg-slate-900 dark:border-slate-700 accent-indigo-600">
                        <label for="edit_is_lhdn" class="text-[10px] font-bold text-indigo-700 dark:text-indigo-400 uppercase tracking-wide cursor-pointer select-none">Pelepasan Cukai (LHDN)</label>
                    </div>

                </div>
                <div class="flex gap-3 mt-6">
                    <button type="button" @click="editModal = false" class="flex-1 py-3 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-xl font-bold uppercase text-xs transition-colors hover:bg-slate-200 dark:hover:bg-slate-600">Batal</button>
                    <button type="submit" class="flex-1 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-black uppercase text-xs tracking-widest shadow-lg transition-all">Kemaskini</button>
                </div>
            </form>
        </div>
    </div>

    <div x-show="previewModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/80 backdrop-blur-sm p-4 transition-all" x-cloak>
        <div @click.away="previewModal=false" class="bg-white dark:bg-slate-800 p-4 rounded-3xl w-full max-w-4xl flex flex-col shadow-2xl relative max-h-[90vh]">
            <div class="flex justify-between items-center mb-4 px-2"><h3 class="text-sm font-black uppercase tracking-widest"><i class="fas fa-eye mr-2 text-indigo-500"></i> Pratonton Fail</h3><button @click="previewModal=false" class="text-slate-400 hover:text-rose-500 w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-700 flex items-center justify-center transition-colors"><i class="fas fa-times"></i></button></div>
            <div class="w-full flex-1 overflow-auto bg-slate-100 dark:bg-slate-900 flex justify-center items-center rounded-2xl p-2 min-h-[50vh]"><template x-if="previewType!=='pdf'"><img :src="previewSrc" class="max-w-full max-h-[70vh] object-contain rounded-xl shadow-lg"></template><template x-if="previewType==='pdf'"><iframe :src="previewSrc" class="w-full h-[70vh] border-0 rounded-xl bg-white"></iframe></template></div>
            <div class="mt-4 flex justify-end px-2"><a :href="previewSrc" download class="px-5 py-2.5 bg-indigo-600 text-white rounded-xl font-bold text-xs uppercase tracking-widest shadow-md hover:bg-indigo-700 flex items-center gap-2"><i class="fas fa-download"></i> Simpan Fail</a></div>
        </div>
    </div>

    <div x-show="delModal" x-cloak class="fixed inset-0 z-[100] flex items-center justify-center p-4 bg-slate-900/80 backdrop-blur-sm text-center">
        <div @click.away="delModal = false" class="bg-white dark:bg-slate-800 w-full max-w-sm rounded-3xl p-6 shadow-2xl relative">
            <i class="fas fa-exclamation-triangle text-rose-500 text-4xl mb-4"></i>
            <h3 class="text-lg font-black dark:text-white mb-2 uppercase tracking-tight">Padam Rekod?</h3>
            <form method="POST" action="expenses_list.php">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="t_id" id="del_t_id" value="">
                <input type="hidden" name="t_type" id="del_t_type" value="">
                <div class="flex gap-3 mt-6">
                    <button type="button" @click="delModal = false" class="flex-1 py-3 bg-slate-100 dark:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-xl font-bold uppercase text-xs hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">Batal</button>
                    <button type="submit" class="flex-1 py-3 bg-rose-500 hover:bg-rose-600 text-white rounded-xl font-bold uppercase text-xs shadow-lg transition-colors">Ya, Padam</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        let timer;
        function debounceSearch() {
            clearTimeout(timer);
            timer = setTimeout(() => { document.getElementById('searchForm').submit(); }, 500);
        }
    </script>
</body>
</html>