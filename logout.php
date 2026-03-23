<?php
require_once("include/dbcommon.php");

// --- SEMAKAN SESI ---
// Jika pengguna sudah tidak log masuk, jangan benarkan akses halaman ini.
// Terus hantar ke login.php
if(!isLogged()){
    header("Location: login.php");
    exit();
}

// --- PROSES LOG KELUAR (CONFIRMATION) ---
if(isset($_POST['confirm_logout'])) {
    // 1. Kosongkan array sesi
    $_SESSION = array();

    // 2. Padam cookie sesi jika ada
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // 3. Musnahkan sesi sepenuhnya
    session_destroy();

    // 4. Redirect ke login dengan status berjaya
    header("Location: login.php?status=loggedout");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ms" x-data="{ darkMode: $persist(false) }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Keluar - Sistem Kewangan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script> tailwind.config = { darkMode: 'class' } </script>
    <style> body { font-family: 'Plus Jakarta Sans', sans-serif; } </style>
</head>

<body class="min-h-screen flex items-center justify-center transition-colors duration-300" :class="darkMode ? 'bg-slate-900 text-slate-200' : 'bg-slate-50 text-slate-800'">

    <div class="max-w-md w-full p-8 animate-in fade-in zoom-in duration-300">
        <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-xl border border-slate-200 dark:border-slate-700 p-8 text-center relative overflow-hidden">
            
            <i class="fas fa-sign-out-alt absolute -right-4 -bottom-4 text-8xl opacity-5 text-slate-400"></i>

            <div class="w-20 h-20 bg-rose-100 dark:bg-rose-900/30 text-rose-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner">
                <i class="fas fa-power-off text-3xl"></i>
            </div>

            <h2 class="text-2xl font-black text-slate-800 dark:text-white mb-2 uppercase tracking-tighter">Log Keluar?</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400 mb-8 font-medium">
                Adakah anda pasti mahu menamatkan sesi dan keluar dari sistem kewangan?
            </p>

            <form method="POST" class="space-y-3 relative z-10">
                <button type="submit" name="confirm_logout" class="w-full py-3.5 bg-rose-500 hover:bg-rose-600 text-white rounded-2xl font-black uppercase text-xs tracking-widest shadow-lg shadow-rose-500/30 transition-all transform hover:-translate-y-1 active:scale-95">
                    Ya, Log Keluar Sekarang
                </button>
                
                <a href="menu.php" class="block w-full py-3.5 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-200 rounded-2xl font-black uppercase text-xs tracking-widest hover:bg-slate-200 dark:hover:bg-slate-600 transition-all">
                    Batal
                </a>
            </form>

            <p class="mt-8 text-[10px] text-slate-400 font-bold uppercase tracking-widest opacity-60">
                Sesi Aktif: <span class="text-slate-500 dark:text-slate-300"><?php echo htmlspecialchars($_SESSION["UserID"]); ?></span>
            </p>
        </div>
    </div>

</body>
</html>