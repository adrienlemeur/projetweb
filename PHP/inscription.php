<?php
	include_once('functions/connection.php');
	session_start();
?>

<!DOCTYPE html>
<link rel="stylesheet" type="text/css" href="./css_page_de_garde.css">
	
<html>
	<body>

		<head>
			Inscription
		</head>

		<div style="height:20vh;"> </div>

		<form method="post" action="<?php echo $_SERVER['PHP_SELF']?>" class = "form-group">

			<div class = "deux_blocs">
				<div>
					<label for="email" class = "text_inscription_form">Email : </label>
					<input type="email" class = "input_inscription_form" name="email">
				</div>
				<div>
					<label for="pwd" class = "text_inscription_form">Mot de Passe : </label>
					<input type="password" class = "input_inscription_form" name="pwd">
				</div>
				<div>
					<label for="pwd" class = "text_inscription_form">Confirmation : </label>
					<input type="password" class = "input_inscription_form" name="pwd_2">
				</div>

				<div>
					<br><br>
					<label for="nom" class = "text_inscription_form">Nom : </label>
					<input type="text" class ="input_inscription_form" name="nom">
				</div>

				<div>
					<label for="prenom" class = "text_inscription_form">Prénom : </label>
					<input type="text" class ="input_inscription_form" name="prenom">
				</div>

				<div>
					<br>
					<label for="telephone" class = "text_inscription_form"> Numéro de Téléphone : </label>
					<input type="text" class = "input_inscription_form" name="telephone">
				</div>

				<div>
					<label for="adresse" class = "text_inscription_form"> Adresse : </label>
					<input type="text" class = "input_inscription_form" name="adresse">
				</div>

			</div>

			<div class = "deux_blocs">
				<label for="role" class = "text_inscription_form"> Rôle souhaité : </label>
				<div style="color:white;margin-left:20%;">
					<div>
						<input type="radio" name="role" value="Lecteur">
						<label for="role_choix1">Simple Utilisateur</label>
					</div>

					<div>
						<input type="radio" name="role" value="Annotateur">
						<label for="role_choix2">Annotateur</label>
					</div>

					<div>
						<input type="radio" name="role" value="Validateur">
						<label for="role_choix3">Validateur</label>
					</div>
				</div>
			</div>

			<button type="submit" name = "submit_inscription_button" class="btn btn-default" style = "font-size:1em;margin-left:60%"> Inscription </button>

		</form>
			<?php

				if(isset($_POST["submit_inscription_button"])) {

					if(empty($_POST['pwd'])){
						echo "Vous devez entrer un mot de passe";
						die;
					}

					if(empty($_POST['pwd_2']) or ($_POST['pwd_2'] != $_POST['pwd'])){
						echo "Veuillez confirmer votre mot de passe";
						die;
					}
					
					if(empty($_POST['role'])){
						echo "Vous devez choisir un rôle !";
						die;
					}

					$pwd_hashed = password_hash($_POST['pwd'], PASSWORD_DEFAULT);

					connect_db();

					$inscription = "INSERT INTO
						db_genome.utilisateurs(email, prenom, nom, tel, adphysique, statut, mdp)
						VALUES($1, $2, $3, $4, $5, $6, $7);";

					pg_query_params($GLOBALS['db_conn'], $inscription, array($_POST[email], $_POST[prenom], $_POST[nom], $_POST[telephone], $_POST[adresse], $_POST[role], $pwd_hashed)) or die ("Le processus d'inscription n'a pas fonctionné, veuillez réessayer");

					close_db();
					header("location:page_de_garde.php");
				}

				$_POST = array();
			?>

	</body>
</html>
