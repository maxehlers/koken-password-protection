<?php
/* Das passiert hier:

1. MySQL-Verbindung (nehmen wir von Koken)
2. Prozess: Wenn ein User /secure öffnet, wird er nach einem Passwort gefragt. Hierbei unterscheiden wir dann zwischen drei Varianten
2.1 Passwort wurde nicht gefunden
2.2 Ein richtiges Passwort (muss unique sein)
2.4 Der Admin
3.1 User 2.1 wird zurückgeschickt
3.2 User 2.2 wird automatisch zur richtigen Gallerie weitergeleitet
3.3 User 2.3 werden die Gallerien angezeigt und er kann Passwörter definieren

######## Als erstes die MySQL-Daten von KOKEN */
include("basics.php");
if(isset($_POST['maxPw'])){
	// At first we look if it is the Admin-Password
	include("admin_password.php");
	if(isset($adminPw) && $adminPw == $_POST['maxPw']){

		// Alle Alben in ein Array schreiben
		$albums = array();
		$sql = "SELECT `title`, `listed`, `id`, `internal_id` FROM `".$KOKEN_DATABASE['prefix']."albums` ORDER BY `title`";
		$query = $db->query($sql) OR DIE ($sql);
		while($row = mysqli_fetch_array($query)){
			$albums[$row['id']] = array(
					"id" =>	$row['id'],
					"listed" => $row['listed'],
					"title" => $row['title'],
					"internal_id" => $row['internal_id']);
		}

		include("templates/header.php");	// Einbindung des Headers

		// Aktionen
		if(isset($_POST['action']) && $_POST['action'] != ""){
			$skipActions = false;

			if(isset($_POST['pw']) && $_POSt['pw'] == $adminPw){
				$message = "Please chose another Password than your admin-password.";
				$skipActions = true;
			}

			if($skipActions === false){
				// Neues Passwort hinzufügen
				if($_POST['action'] == "addPassword" && isset($_POST['albumId']) && isset($_POST['pw']) && $_POST['pw'] != ""){
					$pw = sha1($_POST['pw']);
					$count = $db->query("SELECT `id` FROM `".$table."` WHERE `pw` = '".$pw."' AND `albumId` = '".$_POST['album']."'");
					if(mysqli_num_rows($count) == 0) $query = $db->query("INSERT INTO `".$table."` SET `albumId` = '".$_POST['albumId']."', `pw` = '".$pw."', `description` = '".$_POST['description']."'");
					else $message = "You have already set that password to this album";
				}
				
				// Passwort bearbeiten
				if($_POST['action'] == "editPassword" && isset($_POST['id'])){
					if(isset($_POST['pw']) && $_POST['pw'] != ""){
						$pw = sha1($_POST['pw']);
						$pwsql = "`pw` = '".$pw."', ";
					} else {
						$pw = "";
						$pwsql = "";
					}
					$count = $db->query("SELECT `id` FROM `".$table."` WHERE `pw` = '".$pw."' AND `albumId` = '".$_POST['albumId']."' AND `id` <> `'".$_POST['id']."'");
					if(mysqli_num_rows($countResult) == 0) $query = $db->query("UPDATE `".$table."` SET ".$pwsql."`description` = '".$_POST['description']."', `albumId` = '".$_POST['albumId']."' WHERE `id` = '".$_POST['id.']."'");
					else $message = "This password is already taken. Please use another one";
				}
				
				// Passwort löschen
				if($_POST['action'] == "deletePassword" && isset($_POST['id'])){
					$thisSql = "DELETE FROM `".$table."` WHERE `id` = '".$_POST['id']."'";
					$query = $db->query($thisSql);
					$message = "The password was deleted";
				}
			}
		}
		
		if(isset($message)) include("templates/message.php");

		$sql = "SELECT * FROM `".$table."` ORDER BY `description`";
		$passwordsResult = $db->query($sql) OR die("Geht nicht!!! ".$sql);
		if(mysqli_num_rows($passwordsResult) > 0){
			// Jetzt zeigen wir die eingegebenen Passwörter an und ermöglichen eine Änderung
			include("templates/mainbody.php");				
		}

		include("templates/footer.php");	// Einbindung des Footers
	}
	// Jetzt geht es um die User
	else{
		$hashedPw = sha1($_POST['maxPw']);
		$result = $db->query("SELECT `albumId` FROM `".$table."` WHERE `pw` = '".$hashedPw."'");
		if(mysqli_num_rows($result) > 0){
			$hashedPw = sha1($_POST['maxPw']);
			if(!isset($_SESSION['protectedAlbums'])){
				$_SESSION['protectedAlbums'] = array($hashedPw);
			} else {
				if(!in_array($_SESSION['protectedAlbums'], $hashedPw)) $_SESSION['protectedAlbums'][] = $hashedPw;
			}
		}
		
		header("Location: ".$backUrl."#goodPw");
		exit;
	}
} else{
	header("Location: ".$backUrl."#wrongPw");
	exit;
}