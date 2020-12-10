<?php
	include_once('functions/connection.php');
	page_init();

	header("Content-type: text/plain");
	header('Content-Disposition: attachment; filename="default-filename.txt"');

	echo $_SESSION['download'];
	exit();
?>
