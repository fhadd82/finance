<?php
// --- HALANG BROWSER DARI MENYIMPAN CACHE ---
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 

require_once("include/dbcommon.php");
date_default_timezone_set('Asia/Kuala_Lumpur');

if(!isLogged()){ header("Location: login.php"); exit(); }
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
    // Di sini kita utamakan fullname1 untuk paparan Header. Jika tiada, baru ambil fullname.
    $user_fullname = !empty($rowUser['fullname1']) ? $rowUser['fullname1'] : (!empty($rowUser['fullname']) ? $rowUser['fullname'] : $login_username);
    $_SESSION["UserDbID"] = $user_id; $_SESSION["UserFullName"] = $user_fullname;
} elseif (isset($_SESSION["UserDbID"]) && $_SESSION["UserDbID"] != 0) {
    $user_id = $_SESSION["UserDbID"];
}

$msg = ""; $msg_type = "";

// ========================================================================
// 2. KEMASKINI PROFIL & KATA LALUAN
// ========================================================================
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_profile') {
    // Tangkap data dari borang yang dipos
    $new_fullname1 = $_POST['fullname1'];
    $new_username = $_POST['username'];
    $new_password = $_POST['new_password'];
    
    // Semak sama ada Username telah wujud pada akaun lain (selain dari ID sendiri)
    $checkUsername = DB::Query("SELECT ID FROM tbl_users WHERE username = " . db_prepare_string($new_username) . " AND ID != '$user_id'");
    
    if ($checkUsername && $rowCheck = $checkUsername->fetchAssoc()) {
        // Ralat: Username telah digunakan
        $msg = "Maaf, Nama Pengguna (Username) '$new_username' telah wujud. Sila pilih yang lain.";
        $msg_type = "error";
    } else {
        // --- KUNCI AES-128 ANDA ---
        $aes_key = "ygBL0KO31VezhaTWuFPHx9v4CjUw26cy"; 
        
        // Kemaskini fullname1 & Username (fullname dan email JANGAN DIUSIK)
        $updateQuery = "UPDATE tbl_users SET fullname1 = " . db_prepare_string($new_fullname1) . ", username = " . db_prepare_string($new_username);
        
        // Semak jika pengguna memasukkan kata laluan baharu
        if (!empty($new_password)) {
            if (!empty($aes_key)) {
                $updateQuery .= ", password = HEX(AES_ENCRYPT(" . db_prepare_string($new_password) . ", '$aes_key'))";
            } else {
                $updateQuery .= ", password = " . db_prepare_string($new_password);
            }
        }
        
        $updateQuery .= " WHERE ID = '$user_id'";
        DB::Exec($updateQuery);
        
        // Kemaskini Session supaya nama di menu atas (Header) terus bertukar kepada fullname1
        // Jika fullname1 dibiarkan kosong semasa kemaskini, kembalikan paparan kepada username/fullname asal
        $display_name = !empty($new_fullname1) ? $new_fullname1 : (isset($_SESSION["UserFullName"]) ? $_SESSION["UserFullName"] : $new_username);
        $_SESSION["UserFullName"] = $display_name;
        
        if($login_username == $_SESSION["UserID"]) {
            $_SESSION["UserID"] = $new_username; 
        }
        
        $msg = "Maklumat profil anda berjaya dikemaskini.";
        $msg_type = "success";
    }
}

// ========================================================================
// 3. DAPATKAN MAKLUMAT SEMASA PENGGUNA
// ========================================================================
$user_data = [];
$sqlData = "SELECT * FROM tbl_users WHERE ID = '$user_id' LIMIT 1";
$rsData = DB::Query($sqlData);
if ($rsData) {
    $user_data = $rsData->fetchAssoc();
}
?>

<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: window.innerWidth > 1024, darkMode: $persist(false) }" :class="darkMode ? 'dark' : ''">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tetapan Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/@alpinejs/persist@3.x.x/dist/cdn.min.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <script> tailwind.config = { darkMode: 'class' } </script>
    <style> 
        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: background-color 0.3s ease; } 
        [x-cloak]{display:none !important;}
    </style>
</head>

<body class="flex min-h-screen" :class="darkMode ? 'bg-slate-900 text-white' : 'bg-slate-50 text-slate-800'">
    
    <?php include('sidebar.php'); ?>
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false" class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden"></div>
    
    <main class="flex-1 overflow-y-auto custom-scrollbar">
        <?php $page_title = "Tetapan Profil"; include('header.php'); ?>
        
        <div class="p-6 max-w-3xl mx-auto w-full mt-6">
            
            <?php if($msg): ?>
                <div class="<?php echo $msg_type === 'error' ? 'bg-rose-100 border-rose-400 text-rose-700' : 'bg-emerald-100 border-emerald-400 text-emerald-700'; ?> border px-4 py-3 rounded-xl mb-6 shadow-sm flex items-center">
                    <i class="fas <?php echo $msg_type === 'error' ? 'fa-exclamation-circle text-rose-600' : 'fa-check-circle text-emerald-600'; ?> mr-3 text-lg"></i> 
                    <span class="text-sm font-bold"><?php echo $msg; ?></span>
                </div>
            <?php endif; ?>

            <div class="bg-white dark:bg-slate-800 rounded-3xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
                <div class="px-8 py-6 border-b border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800/50 flex items-center gap-4">
                    <div class="w-14 h-14 rounded-full bg-gradient-to-br from-indigo-500 to-sky-500 flex items-center justify-center text-white font-black text-2xl shadow-md">
                        <?php echo strtoupper(substr(!empty($user_data['fullname1']) ? $user_data['fullname1'] : ($user_data['fullname'] ?: 'P'), 0, 1)); ?>
                    </div>
                    <div>
                        <h2 class="text-xl font-black text-slate-800 dark:text-white uppercase tracking-tight">Maklumat Peribadi</h2>
                        <p class="text-xs font-bold text-slate-500 uppercase tracking-widest mt-1">Urus maklumat dan kata laluan anda</p>
                    </div>
                </div>

                <form method="POST" action="profile.php" class="p-8" 
                      x-data="{ 
                          pwd: '', 
                          confirmPwd: '', 
                          showPwd: false,
                          validate() {
                              if(this.pwd !== '' && this.pwd !== this.confirmPwd) {
                                  alert('Ralat: Kata laluan baharu tidak sepadan!');
                                  return false;
                              }
                              return true;
                          }
                      }" 
                      @submit="if(!validate()) $event.preventDefault()">
                    
                    <input type="hidden" name="action" value="update_profile">
                    
                    <div class="space-y-6">
                        
                        <div>
                            <h4 class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-4 border-b border-slate-100 dark:border-slate-700 pb-2">Maklumat Tetap (Tidak Boleh Diubah)</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="bg-slate-50 dark:bg-slate-900/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-700">
                                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Nama Penuh Daftar</label>
                                    <div class="relative">
                                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                        <input type="text" value="<?php echo htmlspecialchars($user_data['fullname']); ?>" readonly disabled class="w-full bg-slate-200/50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 pl-10 pr-4 text-sm font-bold text-slate-500 dark:text-slate-400 cursor-not-allowed select-none">
                                    </div>
                                </div>
                                <div class="bg-slate-50 dark:bg-slate-900/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-700">
                                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Alamat Emel</label>
                                    <div class="relative">
                                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                                        <input type="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" readonly disabled class="w-full bg-slate-200/50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl py-3 pl-10 pr-4 text-sm font-bold text-slate-500 dark:text-slate-400 cursor-not-allowed select-none">
                                    </div>
                                </div>
                            </div>
                            <?php if(!empty($user_data['ext_security_id'])): ?>
                                <p class="text-[9px] font-bold text-emerald-500 mt-3 ml-2 uppercase tracking-widest"><i class="fab fa-google mr-1"></i> Akaun dipautkan dengan Google Log Masuk</p>
                            <?php endif; ?>
                        </div>

                        <div>
                            <h4 class="text-[10px] font-black text-indigo-500 uppercase tracking-widest mb-4 border-b border-slate-100 dark:border-slate-700 pb-2 mt-8">Maklumat Paparan</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Nama Panggilan / Komersial</label>
                                    <input type="text" name="fullname1" placeholder="Cth: Fuad Hasan" value="<?php echo htmlspecialchars($user_data['fullname1'] ?? ''); ?>" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl p-3 text-sm font-semibold text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                                </div>
                                <div>
                                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Nama Pengguna (Username) <span class="text-rose-500">*</span></label>
                                    <input type="text" name="username" required value="<?php echo htmlspecialchars($user_data['username']); ?>" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl p-3 text-sm font-semibold text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-indigo-500 outline-none transition-all">
                                </div>
                            </div>
                        </div>

                        <div>
                            <h4 class="text-[10px] font-black text-rose-500 uppercase tracking-widest mb-4 border-b border-slate-100 dark:border-slate-700 pb-2 mt-8">Tukar Kata Laluan <span class="text-slate-400 font-medium ml-2">(Biarkan kosong jika tidak mahu menukar)</span></h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="relative">
                                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Kata Laluan Baharu</label>
                                    <input :type="showPwd ? 'text' : 'password'" name="new_password" x-model="pwd" placeholder="********" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl p-3 pr-10 text-sm font-semibold text-slate-800 dark:text-slate-200 focus:ring-2 focus:ring-rose-500 outline-none transition-all">
                                    <button type="button" @click="showPwd = !showPwd" class="absolute right-3 top-[34px] text-slate-400 hover:text-slate-600 dark:hover:text-slate-200">
                                        <i class="fas" :class="showPwd ? 'fa-eye-slash' : 'fa-eye'"></i>
                                    </button>
                                </div>
                                <div class="relative">
                                    <label class="block text-[10px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wide mb-1.5">Sahkan Kata Laluan Baharu</label>
                                    <input :type="showPwd ? 'text' : 'password'" x-model="confirmPwd" placeholder="********" class="w-full bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl p-3 pr-10 text-sm font-semibold text-slate-800 dark:text-slate-200 outline-none transition-all" :class="(pwd !== '' && pwd !== confirmPwd) ? 'border-rose-500 focus:ring-2 focus:ring-rose-500' : 'focus:ring-2 focus:ring-indigo-500'">
                                    <p x-show="pwd !== '' && pwd !== confirmPwd" class="text-[9px] font-bold text-rose-500 mt-1 absolute -bottom-5" x-cloak>Kata laluan tidak sepadan!</p>
                                </div>
                            </div>
                        </div>

                    </div>
                    
                    <div class="mt-12 flex justify-end gap-4 border-t border-slate-100 dark:border-slate-700 pt-6">
                        <button type="reset" class="px-6 py-3 bg-slate-200 dark:bg-slate-700 text-slate-700 dark:text-slate-200 rounded-xl font-bold uppercase tracking-widest text-[10px] hover:bg-slate-300 dark:hover:bg-slate-600 transition-colors">Batal</button>
                        <button type="submit" class="px-8 py-3 bg-indigo-600 text-white rounded-xl font-black uppercase tracking-widest text-[10px] hover:bg-indigo-700 shadow-lg shadow-indigo-200 dark:shadow-none transition-colors flex items-center gap-2">
                            <i class="fas fa-save"></i> Simpan Profil
                        </button>
                    </div>
                </form>
            </div>
            
        </div>
        
        <?php include('footer.php'); ?>
    </main>
    
</body>
</html>