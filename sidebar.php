<?php
// Dapatkan nama fail untuk active state
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside 
    x-show="sidebarOpen" 
    x-transition:enter="transition-transform duration-300 ease-out"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition-transform duration-300 ease-in"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col h-screen lg:static lg:translate-x-0 shadow-2xl lg:shadow-none"
>
    <div class="h-20 flex items-center px-6 border-b border-slate-100 dark:border-slate-800/50">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-indigo-500 to-sky-500 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 mr-3">
            <i class="fas fa-wallet text-xl"></i>
        </div>
        <div>
            <span class="block text-xl font-black text-slate-800 dark:text-white tracking-wider leading-none">myKewangan</span>
            <span class="text-[9px] font-bold text-sky-500 uppercase tracking-widest">Pengurusan Peribadi</span>
        </div>
        <button @click="sidebarOpen = false" class="ml-auto lg:hidden text-slate-400 hover:text-rose-500 transition-colors">
            <i class="fas fa-times-circle text-xl"></i>
        </button>
    </div>

    <div class="flex-1 overflow-y-auto py-6 px-4 space-y-1.5 custom-scrollbar">
        
        <p class="px-4 text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 mt-2">Menu Utama</p>

        <a href="menu.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?php echo ($current_page == 'menu.php') ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700 dark:text-slate-400 dark:hover:bg-slate-800/50 dark:hover:text-slate-300 font-semibold'; ?>">
            <div class="flex items-center justify-center w-8 h-8 rounded-lg <?php echo ($current_page == 'menu.php') ? 'bg-indigo-100 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-400' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400'; ?>">
                <i class="fas fa-chart-pie"></i>
            </div>
            <span class="text-sm tracking-wide">Dashboard Utama</span>
        </a>

        <a href="expenses_list.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?php echo ($current_page == 'expenses_list.php') ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700 dark:text-slate-400 dark:hover:bg-slate-800/50 dark:hover:text-slate-300 font-semibold'; ?>">
            <div class="flex items-center justify-center w-8 h-8 rounded-lg <?php echo ($current_page == 'expenses_list.php') ? 'bg-indigo-100 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-400' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400'; ?>">
                <i class="fas fa-list-ul"></i>
            </div>
            <span class="text-sm tracking-wide">Sejarah Transaksi</span>
        </a>

        <p class="px-4 text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 mt-6">Portfolio Kewangan</p>

        <a href="income_portfolio.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?php echo ($current_page == 'income_portfolio.php') ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700 dark:text-slate-400 dark:hover:bg-slate-800/50 dark:hover:text-slate-300 font-semibold'; ?>">
            <div class="flex items-center justify-center w-8 h-8 rounded-lg <?php echo ($current_page == 'income_portfolio.php') ? 'bg-indigo-100 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-400' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400'; ?>">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <span class="text-sm tracking-wide">Pendapatan Masuk</span>
        </a>

        <a href="expenses_portfolio.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?php echo ($current_page == 'expenses_portfolio.php') ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700 dark:text-slate-400 dark:hover:bg-slate-800/50 dark:hover:text-slate-300 font-semibold'; ?>">
            <div class="flex items-center justify-center w-8 h-8 rounded-lg <?php echo ($current_page == 'expenses_portfolio.php') ? 'bg-indigo-100 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-400' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400'; ?>">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <span class="text-sm tracking-wide">Perbelanjaan Harian</span>
        </a>

        <a href="commitments_portfolio.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?php echo ($current_page == 'commitments_portfolio.php') ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700 dark:text-slate-400 dark:hover:bg-slate-800/50 dark:hover:text-slate-300 font-semibold'; ?>">
            <div class="flex items-center justify-center w-8 h-8 rounded-lg <?php echo ($current_page == 'commitments_portfolio.php') ? 'bg-indigo-100 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-400' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400'; ?>">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <span class="text-sm tracking-wide">Komitmen Bulanan</span>
        </a>

        <a href="investments.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?php echo ($current_page == 'investments.php') ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700 dark:text-slate-400 dark:hover:bg-slate-800/50 dark:hover:text-slate-300 font-semibold'; ?>">
            <div class="flex items-center justify-center w-8 h-8 rounded-lg <?php echo ($current_page == 'investments.php') ? 'bg-indigo-100 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-400' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400'; ?>">
                <i class="fas fa-seedling"></i>
            </div>
            <span class="text-sm tracking-wide">Simpanan / Pelaburan</span>
        </a>

        <p class="px-4 text-[9px] font-black text-slate-400 uppercase tracking-widest mb-2 mt-6">Tetapan & Pengurusan</p>

        <a href="manage_budget.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?php echo ($current_page == 'manage_budget.php') ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700 dark:text-slate-400 dark:hover:bg-slate-800/50 dark:hover:text-slate-300 font-semibold'; ?>">
            <div class="flex items-center justify-center w-8 h-8 rounded-lg <?php echo ($current_page == 'manage_budget.php') ? 'bg-indigo-100 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-400' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400'; ?>">
                <i class="fas fa-bullseye"></i>
            </div>
            <span class="text-sm tracking-wide">Urus Bajet / Sasaran</span>
        </a>

        <a href="manage_categories.php" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 <?php echo ($current_page == 'manage_categories.php') ? 'bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-400 font-bold' : 'text-slate-500 hover:bg-slate-50 hover:text-slate-700 dark:text-slate-400 dark:hover:bg-slate-800/50 dark:hover:text-slate-300 font-semibold'; ?>">
            <div class="flex items-center justify-center w-8 h-8 rounded-lg <?php echo ($current_page == 'manage_categories.php') ? 'bg-indigo-100 text-indigo-600 dark:bg-indigo-500/20 dark:text-indigo-400' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400'; ?>">
                <i class="fas fa-tags"></i>
            </div>
            <span class="text-sm tracking-wide">Urus Kategori</span>
        </a>

    </div>

    <div class="p-4 border-t border-slate-100 dark:border-slate-800/50 space-y-2">
        
        <button @click="darkMode = !darkMode" class="w-full flex items-center justify-between px-4 py-3 rounded-xl text-slate-500 hover:bg-slate-50 hover:text-slate-700 dark:text-slate-400 dark:hover:bg-slate-800/50 dark:hover:text-slate-300 font-semibold transition-colors">
            <div class="flex items-center gap-3">
                <i class="fas" :class="darkMode ? 'fa-moon text-indigo-400' : 'fa-sun text-amber-500'"></i>
                <span class="text-sm tracking-wide" x-text="darkMode ? 'Mod Gelap' : 'Mod Terang'"></span>
            </div>
            <div class="w-8 h-4 bg-slate-200 dark:bg-slate-700 rounded-full relative transition-colors">
                <div class="absolute w-3 h-3 bg-white rounded-full top-0.5 transition-all" :class="darkMode ? 'right-0.5' : 'left-0.5'"></div>
            </div>
        </button>

        <a href="logout.php" onclick="return confirm('Anda pasti mahu log keluar?');" class="flex items-center gap-3 px-4 py-3 rounded-xl text-rose-500 hover:bg-rose-50 hover:text-rose-700 dark:hover:bg-rose-500/10 dark:hover:text-rose-400 font-semibold transition-colors">
            <div class="flex items-center justify-center w-8 h-8 rounded-lg bg-rose-100 text-rose-500 dark:bg-rose-500/20 dark:text-rose-400">
                <i class="fas fa-sign-out-alt"></i>
            </div>
            <span class="text-sm tracking-wide">Log Keluar</span>
        </a>

    </div>
</aside>