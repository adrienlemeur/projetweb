<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="global_style.css">

<html>
	<body>

		<?php
			include_once('functions/connection.php');
			page_init(); #Session start / kill si l'utilisateur n'est pas connecté

			if($_SESSION['role'] != 'Admin'){
				echo "Vous ne pouvez pas accéder à cette page.";
				die;
			}

		?>


		<?php #On affiche les pages accessibles en fonction des droits de l'utilisateur ?>
		<ul class = "menu_horizontal" style="float:right;">
			<li> <a href="main_utilisateur.php">Espace Utilisateur</a> </li>
			<?php if($_SESSION['role'] == 'Annotateur' or $_SESSION['role'] == 'Admin'):?> <li> <a href="espace_annotateur.php">Espace Annotateur</a> </li> <?php endif; ?>
			<?php if($_SESSION['role'] == 'Validateur' or $_SESSION['role'] == 'Admin'):?> <li> <a href="espace_validateur.php">Espace Validateur</a> </li> <?php endif; ?>
			<?php if($_SESSION['role'] == 'Admin'):?> <li> <a href="espace_administrateur.php">Espace Admin</a> </li> <?php endif; ?>
			<li> <a href="functions/deconnection.php">Déconnexion</a> </li>
		</ul>

		<div style="height:10vh;"> </div>
		<main>
			<?php #Formulaire de création d'un nouvel utilisateur ?>
			<div class = "administrator_panel">
				<div class = "menu_name_admin">Créer</div>

				<form action = "<?php echo $_SERVER['PHP_SELF']?>" method = "POST">
					<div class = "bloc_admin">
						<label for = "email" class = "text_admin">Email</label>
						<input class = "admin_form" name="email">
					</div><br>

					<div class = "bloc_admin">
						<label class = "text_admin">Mot de Passe</label>
						<input type = "password" class = "admin_form" name="pwd">
					</div><br>

					<div class = "bloc_admin">
						<label class = "text_admin">Nom</label>
						<input class ="admin_form" name="nom">
					</div><br>

					<div class = "bloc_admin">
						<label class = "text_admin">Prénom</label>
						<input class ="admin_form" name="prenom">
					</div><br>
					
					<div class = "bloc_admin">
						<label class = "text_admin">N° Téléphone</label>
						<input class ="admin_form" name="telephone">
					</div><br>

					<div class = "bloc_admin">
						<label class = "text_admin">Adresse</label>
						<input class ="admin_form" name="adresse">
					</div><br>
					
					<div class = "bloc_admin">
						<label class = "text_admin">Rôle</label>

						<br><input type="radio" name="role" class = "text_admin" value="Lecteur" style = "margin-left:40%;">	Simple Utilisateur</input>
						<br><br><input type="radio" name="role" class = "text_admin" value="Annotateur" style = "margin-left:40%;">	Annotateur</input>
						<br><br><input type="radio" name="role" class = "text_admin" value="Validateur" style = "margin-left:40%;">	Validateur</input>
					</div><br>

					<button type="submit" name = "create_user_admin" class="button_foreign_DB" style = "font-size:1em;margin-left:60%; margin-top:4%;">Créer un utilisateur</button>
				</form>

				<?php
					if(isset($_POST["create_user_admin"])) {
						#on vérifie que les principaux attributs sont correctement rentrés
						if(empty($_POST['email'])){echo "Entrez une adresse mail";} else
						if(empty($_POST['pwd'])){echo "Entrez mot de passe";} else
						if(empty($_POST['role'])){echo "Choisissez un rôle !";} else {

							#Stockage du hash du mot de passe
							$pwd_hashed = password_hash($_POST['pwd'], PASSWORD_DEFAULT);

							connect_db();
							#Requête de création de l'utilisateur
							$inscription = "INSERT INTO db_genome.utilisateurs(email, prenom, nom, tel, adphysique, statut, mdp)
								VALUES($1, $2, $3, $4, $5, $6, $7);";

							pg_query_params($GLOBALS['db_conn'], $inscription, array($_POST['email'], $_POST['prenom'], $_POST['nom'], $_POST['telephone'], $_POST['adresse'], $_POST['role'], $pwd_hashed)) or die ("Erreur, veuillez réessayer<br>" . pg_last_error());

							close_db();
							#Confirme à l'administrateur que l'utilisateur a bien été créé
							?> <script> window.alert('L\'utilisateur a été créé avec succès'); </script> <?php
						}
					} ?>
			</div>

			<div class = "administrator_panel">
				<div style = "height:80%;overflow-x:auto;">
					<div class = "menu_name_admin">Surveiller</div>
					<?php
						connect_db();
						$query = "SELECT * FROM db_genome.utilisateurs;";
						$answer = pg_query($GLOBALS['db_conn'], $query);

						#table des utilisateurs
						echo "<table>";

						#affichage des noms colonnes
						echo "<tr class = 'admin_user_table' style = 'font-weight: bolder;'>";
						echo "<td>"; echo "E-mail";echo "</td>";
						echo "<td>"; echo "Prénom";echo "</td>";
						echo "<td>"; echo "Nom";echo "</td>";
						echo "<td>"; echo "N° Tel";echo "</td>";
						echo "<td>"; echo "Adresse";echo "</td>";
						echo "<td>"; echo "Dernière connection";echo "</td>";
						echo "<td>"; echo "Rôle";echo "</td>";
						echo "</tr>";
						
						#affichage des lignes
						while ($line = pg_fetch_array($answer, null, PGSQL_ASSOC)) {
							echo "<tr>";
							#Affiche tout les attributs, sauf le hash du mot de passe
							foreach($line as $key => $val){
								if($key == "mdp"){break;}

								echo "<td class = 'admin_user_table'>";
								echo $val;
								echo "</td>";
								echo $line[0];
							}
						}
						echo "</table>";
						close_db();
					?>
					</div>
						<div class = "bloc_admin">
							<?php #Formulaire pour supprimer un utilisateur ?>
							<div for = "email" class = "text_admin" style = "float:left;">Révoquer un utilisateur:</div>

							<form action = "<?php echo $_SERVER['PHP_SELF']?>" method = "POST">
								<input class = "admin_form" style = "width:40%;color:grey;text-align:center;" name="email_to_delete" onfocus="this.value=''" value = "Mail de l'utilisateur à supprimer"><br><br>
								<input class = "admin_form" style = "width:40%;color:grey;text-align:center;" name="email_to_delete_2" onfocus="this.value=''" value = "Confirmer">
								<button type="submit" name = "kill_it" class="button_foreign_DB" style = "margin-left:4%; font-size:1em;">Supprimer un utilisateur</button>
							</form>

							<?php
								#on vérifie qu'un mail a été entré et qu'il a été confirmé
								if(isset($_POST['email_to_delete'])){
									if($_POST['email_to_delete'] == $_POST['email_to_delete_2']){
										connect_db();
										#Supprime l'utilisateur des tables utilisateurs et attribution_annotateur;
										$exterminate_1 = "DELETE FROM db_genome.utilisateurs as usr WHERE usr.statut != 'Admin' AND usr.email = '" . $_POST['email_to_delete'] . "';";
										$exterminate_2 = "DELETE FROM db_genome.attribution_annotateur as att WHERE att.mail_annot = '" . $_POST['email_to_delete'] . "';";
										pg_query($GLOBALS['db_conn'], $exterminate_1) or die("Erreur");
										pg_query($GLOBALS['db_conn'], $exterminate_2) or die("Erreur");
										close_db();
									} else {
										echo "Les deux adresses ne correspondent pas / Champ(s) vide(s)";
									}
								}
							?>
							

					</div>
				</div>
		</main>
	<body>
</html>
