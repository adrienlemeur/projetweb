<?php


	// Variable globale de connexion base de données pour simplifier
	//$db_conn = null;

	// Fonction de connexion à la base de données postgres
	function connect_db()
	{
		global $db_conn;
		$db_info = parse_ini_file("start.ini");

		$db_conn = pg_connect("host=" . $db_info['host']
							. " user=" . $db_info['user']
							. " dbname=". $db_info['dbname']
							. " port=" . $db_info['port']
							. " password=" . $db_info['password']);
	}

	function is_conn_okay($db_conn)
	{
		$stat = pg_connection_status($db_conn);
		if ($stat === PGSQL_CONNECTION_OK) {
			echo 'OK';
		} else {
			echo 'ERREUR';
		}
	}

	function disconnect_db ()
	{
		global $db_conn;
		pg_close($db_conn);
	}

?>
