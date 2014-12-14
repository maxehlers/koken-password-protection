<?php
	session_start();
	include("../../../configuration/database.php");

	$db = mysqli_connect($KOKEN_DATABASE['hostname'],$KOKEN_DATABASE['username'],$KOKEN_DATABASE['password'],$KOKEN_DATABASE['database']) or die("Error " . mysqli_error($db)); 
	$table = $KOKEN_DATABASE['prefix']."passwordsByMax";

	// Erstmal gucken ob das Ding überhaupt schonmal lief
	$setup = $db->query("
			CREATE TABLE IF NOT EXISTS `".$table."` (
			`id` int(80) NOT NULL,
			  `pw` varchar(255) NOT NULL,
			  `albumId` int(255) NOT NULL,
			  `description` varchar(255) NOT NULL
			) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Max is an awesome dude';


			ALTER TABLE `".$table."`
			 ADD PRIMARY KEY (`id`);


			ALTER TABLE `".$table."`
			MODIFY `id` int(80) NOT NULL AUTO_INCREMENT;");

	// Jetzt haben wir ein Amt :-)
	$backUrl = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"/";
?>