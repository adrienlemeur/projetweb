<?php

	function page_init()
	{
		session_start();

	}



	// Variable globale de connexion base de données pour simplifier
	//$db_conn = null;

	// Fonction de connexion à la base de données postgres
	function connect_db()
	{

		$db_info = parse_ini_file("start.ini");

		global $db_conn;

		$db_conn = pg_connect("host=" . $db_info['host']
							. " user=" . $db_info['user']
							. " dbname=". $db_info['dbname']
							. " port=" . $db_info['port']
							. " password=" . $db_info['password']);
	}
	

	function close_db()
	{
		global $db_conn;
		pg_close($db_conn);
	}


	function is_conn_okay($current_connection)
	{

		$stat = pg_connection_status($current_connection);
		if ($stat === PGSQL_CONNECTION_OK) {
			echo 'OK';
		} else {
			echo 'ERREUR';
		}
	}

?>
