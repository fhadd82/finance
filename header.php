<?php
$display_id = isset($_SESSION["UserDbID"]) ? $_SESSION["UserDbID"] : '0';
$display_name = isset($_SESSION["UserID"]) ? $_SESSION["UserID"] : 'Pengguna';

// Semak pangkalan data untuk fullname1 atau fullname
if ($display_id != '0') {
    $rsHdrUser = DB::Query("SELECT fullname, fullname1 FROM tbl_users WHERE ID = '$display_id' LIMIT 1");
    if ($rsHdrUser && $rowHdrUser = $rsHdrUser->fetchAssoc()) {
        // Jika fullname1 wujud dan tidak kosong, guna fullname1
        if (!empty($rowHdrUser['fullname1'])) {
            $display_name = $rowHdrUser['fullname1'];
        } 
        // Jika fullname1 kosong, semak fullname pula
        elseif (!empty($rowHdrUser['fullname'])) {
            $display_name = $rowHdrUser['fullname'];
        }
    }
}

$initial = strtoupper(substr(trim($display_name), 0, 1));
$page_title_display = isset($page_title) ? $page_title : 'Sistem Kewangan';
?>

<header class="bg-white dark:bg-slate-800 shadow-sm border-b border-slate-200 dark:border-slate-700 sticky top-0 z-30">
    <div class="flex justify-between items-center px-6 py-4">
        <div class="flex items-center gap-4">
            <button @click="sidebarOpen = !sidebarOpen" class="lg:hidden text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <h2 class="text-lg font-black text-slate-800 dark:text-white hidden sm:block uppercase tracking-tight">
                <?php echo $page_title_display; ?>
            </h2>
        </div>
        <div class="flex items-center gap-5">
            <button @click="darkMode = !darkMode" class="w-9 h-9 rounded-full flex items-center justify-center bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
                <i class="fas" :class="darkMode ? 'fa-sun' : 'fa-moon'"></i>
            </button>
            <div class="w-px h-8 bg-slate-200 dark:bg-slate-700 hidden sm:block"></div>
            
            <div x-data="{ profileOpen: false }" class="relative">
                <button @click="profileOpen = !profileOpen" class="flex items-center gap-3 focus:outline-none group">
                    <div class="text-right hidden sm:block">
                        <p class="text-xs font-black text-slate-800 dark:text-white uppercase"><?php echo htmlspecialchars($display_name); ?></p>
                        <p class="text-[9px] font-bold text-emerald-500 uppercase tracking-widest transition-colors"><i class="fas fa-circle text-[6px] align-middle mr-1"></i>Akaun Aktif</p>
                    </div>
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-500 to-sky-500 flex items-center justify-center text-white font-black text-lg shadow-md shadow-sky-500/30 group-hover:scale-105 transition-transform">
                        <?php echo $initial; ?>
                    </div>
                </button>
                <div x-show="profileOpen" @click.away="profileOpen = false" x-transition class="absolute right-0 mt-3 w-56 bg-white dark:bg-slate-800 rounded-2xl shadow-xl border border-slate-100 dark:border-slate-700 py-2 overflow-hidden" x-cloak>
                    <div class="px-4 py-3 border-b border-slate-100 dark:border-slate-700 sm:hidden">
                        <p class="text-xs font-black text-slate-800 dark:text-white uppercase"><?php echo htmlspecialchars($display_name); ?></p>
                        <p class="text-[9px] font-bold text-emerald-500 uppercase tracking-widest"><i class="fas fa-circle text-[6px] align-middle mr-1"></i>Akaun Aktif</p>
                    </div>
                    <a href="profile.php" class="flex items-center gap-3 px-4 py-2.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-indigo-600 dark:hover:text-indigo-400">
                        <i class="fas fa-user-circle text-sm opacity-70"></i> Tetapan Profil
                    </a>
                    <a href="login.php?a=logout" class="flex items-center gap-3 px-4 py-2.5 text-xs font-bold text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/20">
                        <i class="fas fa-sign-out-alt text-sm opacity-70"></i> Log Keluar
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>