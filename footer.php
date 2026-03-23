<footer class="mt-auto py-5 px-6 border-t border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800/50 transition-colors">
    <div class="flex flex-col sm:flex-row justify-between items-center gap-3 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">
        <p>&copy; <?php echo date('Y'); ?> MyKewangan. Hak Cipta Terpelihara.</p>
        <p class="flex items-center">
            Sistem Pemantauan Perbelanjaan
        </p>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Tetapan masa: 15 minit (15 * 60 * 1000 = 900,000 milisaat)
        var timeoutLimit = 900000; 
        var logoutTimer;

        // Fungsi untuk mengira semula masa (reset) dari 0
        function resetTimer() {
            clearTimeout(logoutTimer);
            logoutTimer = setTimeout(forceLogout, timeoutLimit);
        }

        // Fungsi yang akan dicetuskan tepat pada minit ke-15
        function forceLogout() {
            alert("Maaf, sesi anda telah tamat kerana tiada aktiviti selama 15 minit. Sila log masuk semula demi keselamatan akaun anda.");
            
            // Bawa pengguna keluar menggunakan URL logout rasmi PHPRunner
            window.location.href = 'login.php?a=logout';
        }

        // Pantau sebarang pergerakan pengguna di skrin untuk reset masa
        window.onload = resetTimer;
        document.onmousemove = resetTimer; // Kesan pergerakan mouse
        document.onkeypress = resetTimer;  // Kesan taipan keyboard
        document.onclick = resetTimer;     // Kesan klikan
        document.onscroll = resetTimer;    // Kesan scroll page
        
        // Mula kiraan sebaik sahaja footer dimuatkan di skrin
        resetTimer();
    });
</script>