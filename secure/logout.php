<?php
	session_start();
	unset($_SESSION['protectedAlbums']);
	$backUrl = isset($_SERVER['HTTP_REFERER'])?$_SERVER['HTTP_REFERER']:"/";
	header("Location: ".$backUrl);
	exit;
?>