<?php
include("basics.php");

if(isset($_SESSION['protectedAlbums']) && is_array($_SESSION['protectedAlbums'])){
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

	$displayAlbums = array();
	foreach($_SESSION['protectedAlbums'] as $pw){
		$query = $db->query("SELECT `albumId` FROM `".$table."` WHERE `pw` = '".$pw."'");
		if(mysqli_num_rows($query) >= 1){
			while($row = mysqli_fetch_array($query)){
				if(!in_array($row['albumId'],$displayAlbums)) $displayAlbums[] = $row['albumId'];
			}
		}
	}


	// Let's start the output
	echo '<ul class="maxPasswords">';
	foreach($displayAlbums as $item){
		echo '<li><a href="/albums/'.$albums[$item]["internal_id"].'/" title="'.$albums[$item]['title'].'">'.$albums[$item]['title'].'</a></li>';
	}
	echo '<li class="maxPasswordsLogout"><a href="/storage/plugins/pw-secured-albums/secure/logout.php" titlte="Logout if you are on a public computer.">Logout</a></li>';
	echo '</ul>';
}

?>