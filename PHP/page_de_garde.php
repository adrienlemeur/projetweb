<?php include_once('functions/connection.php');?>

<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href= "global_style.css">

<html>
	<body>

			<head>
				Page de garde
			</head>
			<br><br><br>			

			<?php
				if(isset($_POST["submit_connexion_button"])) {
					#connection à la base de donnée
					connect_db();
					
					#interrogation de la base de donnée à la recherche du mail entré par l'utilisateur
					$connection_query = "SELECT mdp,statut, prenom, nom FROM db_genome.utilisateurs WHERE email = $1;";
					$connection_result = pg_query_params($GLOBALS['db_conn'], $connection_query, array($_POST['email'])) or die("Connection impossible") ;
					$query_pwd = pg_fetch_result($connection_result, 0, 0);

					#Si aucun email ne correspond dans la base de donnée (query vide)
					if(empty($query_pwd)){
						echo "Email invalide";
					#Si le mail est trouvé dans la base
					} else {
						#le mot de passe entré correspond à celui associé à l'email dans la base =
						# Connexion de l'utilisateur
						if(password_verify ($_POST['pwd'] , $query_pwd)){
							
							#lancement de la session
							session_start();
							$_SESSION['role'] = pg_fetch_result($connection_result, 0, 1);

							$_SESSION['prenom'] = pg_fetch_result($connection_result, 0, 2);
							$_SESSION['nom'] = pg_fetch_result($connection_result, 0, 3);

							#Variables conservées tant que la session est ouverte

							#Vérification de la connexion
							$_SESSION['CONNECTION'] = 'YES';
							
							#mail de l'utilisateur en cours
							$_SESSION['email'] = $_POST['email'];

							#fuseau horaire Paris - Berlin
							date_default_timezone_set('UTC+1');
							$date = date("Y") . "-" .date("m") . "-" . date("d");

							#On change la date de dernière connexion dans la table utilisateur
							$query_last_connection = "UPDATE db_genome.utilisateurs as usr SET dateConnexion = '". $date . "' WHERE usr.email ='" . $_SESSION['email'] . "';";

							pg_query($GLOBALS['db_conn'], $query_last_connection) or die("TIME CONNEXION ERROR");

							#redirection vers la page utilisateur
							header("location:main_utilisateur.php");
						} else {

							#le mail est trouvé mais le mot de passe associé ne correspond pas
							echo "Mot de passe invalide";
						}
					}

					pg_free_result($connection_result); #libère les résultats
					close_db(); #fermeture de la base
				}
			?>

			<?php #Formulaire de connexion ?>
			<div style="float:right;">
				<form class="menu_horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" style="float:right;">
					<label for="email" class = "really_not_a_link">Email</label>
					<input type="email" placeholder="Entrez votre email" name="email">

					<label for="pwd" class = "really_not_a_link">Mot de Passe</label>
					<input type="password" placeholder="Entrez un mot de passe" name="pwd">

					<button type="submit" name = "submit_connexion_button" class = "probably_not_a_button">Connexion</button>
				</form>

					<div>
				<ul class = "menu_horizontal" style="float:right;">
					<li><a href="inscription.php">Inscription</a></li>
					</div>
				</ul>
			</div>

		<div>

			<div class = "main_text" style = "margin: 2% 20% 2% 20%">
				Bienvenue sur la banque de donnée en ligne d'Adrien Le Meur & Ombeline Lamer !
			</div>

			<div class = "plain_text" style = "float:left; margin: 2% 10% 2% 10%; text-align:justify;">
			Ce site est dédié à l'annotation des différentes souches d'Escherichia coli. Vous y trouverez les annotations validés par nos reviewers. Vous pourrez trouver et retrouver une séquence selon ses annotations et les comparer aux banques de données du NCBI et Uniprot. Vous pouvez également directement visualiser les séquences référencées sur ce site.<br><br>
			Annotateurs, nous avons besoin de vous ! Des dizaines de séquences attendent votre expertise ! N'hésitez pas à vous inscrire pour pouvoir bénéficiez de toutes nos fonctionnalités. Les reviewer vous attribueront des séquences à annoter. Vous pourrez soumettre immédiatement vos suggestions qui seront ensuite révisées pour approbation.<br>
			Validateurs, vous pouvez attribuer et reviewer les annotations proposées.<br><br>
			Nous vous souhaitons une bonne expérience sur ce site !
			</div>
		</div>
	</body>
</html>
