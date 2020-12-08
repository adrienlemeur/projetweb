<?php

	function page_init()
	{
		session_start();
		if($_SESSION['CONNECTION'] != 'YES'){
			echo "Connectez vous pour vous pour pouvoir accéder à cette page";
			die;
		}
	}

	function connect_db()
	{

		$db_info = parse_ini_file("start.ini");
		#on se connecte à la base avant chaque requête, et on ferme la base
		# > Conseillé par rapport à une ouverture persistante
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

	#Retourne OK si la page est connectée à la base
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
