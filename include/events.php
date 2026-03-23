<?php
class eventsBase
{
	var $events = array();
	var $maps = array();
	function exists($event, $table = "")
	{
		if($table == "")
			return (array_key_exists($event,$this->events)!==FALSE);
		else
			return isset($this->events[$event]) && isset($this->events[$event][$table]);
	}

	function existsMap($page)
	{
		return (array_key_exists($page,$this->maps)!==FALSE);
	}
}

class class_GlobalEvents extends eventsBase
{
	function __construct()
	{
	// fill list of events
		$this->events["AfterSuccessfulLogin"]=true;


//	onscreen events



		}

//	handlers

		
		
		
		
		
		
				// After successful login
function AfterSuccessfulLogin($username, $password, &$data, $pageObject)
{

		// =====================================================================
// AUTO-MERGE: GABUNGKAN AKAUN GOOGLE BARU DENGAN AKAUN MANUAL LAMA
// =====================================================================

// 1. Semak jika pengguna login menggunakan Google (ada ext_security_id)
if (!empty($data["ext_security_id"]) && !empty($data["email"])) {
    
    $email = $data["email"];
    $current_new_id = $data["ID"]; // ID baru yang PHPRunner baru cipta
    $google_ext_id = $data["ext_security_id"];

    // 2. Cari adakah wujud akaun LAMA yang menggunakan emel yang sama
    // Kita cari ID yang lebih kecil (lebih awal didaftarkan)
    $sqlCheckOld = "SELECT ID, username FROM tbl_users WHERE email = " . db_prepare_string($email) . " AND ID != " . $current_new_id . " ORDER BY ID ASC LIMIT 1";
    $rsOld = DB::Query($sqlCheckOld);

    if ($rsOld && $rowOld = $rsOld->fetchAssoc()) {
        $old_id = $rowOld["ID"];
        $old_username = $rowOld["username"];

        // 3. Gabungkan! Masukkan ID Google ke dalam akaun lama
        $sqlUpdate = "UPDATE tbl_users SET ext_security_id = " . db_prepare_string($google_ext_id) . " WHERE ID = " . $old_id;
        DB::Exec($sqlUpdate);

        // 4. Padam akaun 'pendua' (baru) yang dicipta oleh PHPRunner tadi
        $sqlDelete = "DELETE FROM tbl_users WHERE ID = " . $current_new_id;
        DB::Exec($sqlDelete);

        // 5. Setkan sesi login sistem kepada AKAUN LAMA supaya data tak lari
        $_SESSION["UserDbID"] = $old_id;
        $_SESSION["UserID"] = $old_username; // Guna username lama
        
    } else {
        // Jika emel tak wujud langsung, ini memang user baru 100%
        $_SESSION["UserDbID"] = $current_new_id;
    }

} else {
    // =====================================================================
    // LOGIN MANUAL BIASA (USERNAME & PASSWORD)
    // =====================================================================
    $_SESSION["UserDbID"] = $data["ID"];
}
;		
} // function AfterSuccessfulLogin

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

//	onscreen events




}
?>
