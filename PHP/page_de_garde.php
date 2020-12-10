<?php
	include_once('functions/connection.php');
?>


<!DOCTYPE html>
	<link rel="stylesheet" type="text/css" href="css_page_de_garde.css">

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
					
					#Interrogation de la base de donnée : on cherche l'email dans la base de donnée
					$connection_query = "SELECT mdp,statut FROM db_genome.utilisateurs WHERE email = $1;";
					$connection_result = pg_query_params($GLOBALS['db_conn'], $connection_query, array($_POST['email'])) or die("Connection impossible") ;
					$query_pwd = pg_fetch_result($connection_result, 0, 0);
				
				
					#Si aucun email ne correspond dans la base de donnée (query vide)
					if(empty($query_pwd)){
						echo "Email invalide";
					} else {
						#si l'email est trouvé dans la base de donnée
						#le mot de passe entré correspond à celui associé à l'email dans la base
						if(password_verify ($_POST['pwd'] , $query_pwd)){
							#lancement de la session
							session_start();
							$_SESSION['role'] = pg_fetch_result($connection_result, 0, 1);

							#variable permettant de vérifier la connection de l'utilisateur avant d'afficher les pages
							$_SESSION['CONNECTION'] = 'YES';
							$_SESSION['email']=$_POST['email'];

							#accession à la plage utilisateur, accessible par tout les types d'utilisateur
							header("location:main_utilisateur.php");
						} else {
							#le mot de passe ne correspond pas
							echo "Mot de passe invalide";
						}
					}

					pg_free_result($connection_result); #libère les résultats
					close_db(); #fermeture de la base
					$_POST = array(); #délétion des variables POST en vue du rafraichissement de la page
				}
			?>

			<div style="float:right;">
				<form class="form-inline" method="post" action="<?php echo $_SERVER['PHP_SELF']?>" style="float:right;">
					<label for="email" class = "bouton">Email : </label>
					<input type="email" class="form-control" class ="email" placeholder="Entrez votre email" name="email">

					<label for="pwd" class = "bouton">Mot de Passe : </label>
					<input type="password" class="form-control" class = "pwd" placeholder="Entrez un mot de passe" name="pwd">

					<button type="submit" name = "submit_connexion_button" class="btn btn-default" style = "font-size: 1em;">Connexion</button>
				</form>

					<div>
				<ul class = "menu_horizontal" style="float:right;">
					<li><a href="inscription.php">Inscription</a></li>
					</div>
				</ul>
			</div>
		<br><br><br><br><br>

		<div class = "main_text">
			Bienvenue sur la banque de donnée en ligne d'Adrien Le Meur & Ombeline Lamer !
		</div>

		<div class = "plain_text">
		<br><br><br>
		Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent rutrum imperdiet mauris, porta sollicitudin dolor viverra id. Duis congue ut mauris quis aliquet. Nam at fermentum velit. Morbi quis sodales neque. Sed ut purus at diam pretium pellentesque. Maecenas suscipit lacinia massa. Donec suscipit feugiat magna. Morbi leo neque, luctus et velit nec, efficitur iaculis metus. In dictum arcu quis leo lobortis, sed fermentum orci tristique. Quisque sit amet ornare quam. Suspendisse rhoncus euismod viverra. Donec venenatis odio et eros condimentum, et suscipit orci consectetur. Nam efficitur vitae odio eu tincidunt. Aliquam id placerat odio, non elementum mauris. Pellentesque posuere finibus malesuada.<br><br>
		Cras vel turpis posuere, congue elit quis, ornare eros. Integer dignissim sapien sit amet hendrerit pellentesque. Suspendisse vel lectus eros. Aenean id nibh urna. Praesent et molestie nunc. Duis pharetra, nulla vel finibus facilisis, elit ex facilisis augue, in pellentesque ligula nisi ut ex. Integer pretium, lorem posuere commodo tincidunt, turpis nulla fermentum ex, sit amet bibendum felis est a neque. Vestibulum euismod posuere tellus, quis ornare orci congue a. Maecenas eget nibh eget mi iaculis lacinia nec nec nisi. Phasellus et interdum erat.
		</div>


		</body>
</html>
