<?php

	function page_init()
	{
		session_start();

		if(!isset($_SESSION['CONNECTION'])){
			session_destroy();

			echo "<script type='text/javascript'>
					window.alert('Accès refusé. Connectez vous pour accéder à cette page');
					document.location.replace('page_de_garde.php');
				</script>";
			exit();
		} else {
		
		echo "Bienvenue " . $_SESSION['prenom'] . " " . $_SESSION['nom'] . " !";
		
		}
	}

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
