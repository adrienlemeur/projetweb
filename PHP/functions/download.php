<?php
	session_start();

	header("Content-type: text/plain");
	header('Content-Disposition: attachment; filename=' . $_SESSION["file_name"]);

	echo $_SESSION['download'];
	exit();
?>

