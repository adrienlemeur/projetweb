<!DOCTYPE html>
	<link rel="stylesheet" type="text/css" href="./css_page_de_garde.css">
<?php
	include_once('functions/connection.php');
	page_init(); #Session start / kill si l'utilisateur n'est pas connecté

	if($_SESSION['role'] != 'Validateur' and $_SESSION['role'] != 'Admin'){
		echo "Vous ne pouvez pas accéder à cette page.";
		die;
	}
?>

<html>
	<body>
		<head>
			Espace Validateur
		</head>

			<! Menu horizontal pour sélectionner l'interface (Utilisateur / Annotateur / Validateur)
			Affichage en fonction des permissions + vérifier dans chaque page que l'utilisateur en cours a les droits pour accéder à cette fonctionnalité
			>
		<?php #On affiche les pages accessibles en fonction des droits de l'utilisateur ?>
		<ul class = "menu_horizontal" style="float:right;">
			<li> <a href="main_utilisateur.php">Espace Utilisateur</a> </li>
			<?php if($_SESSION['role'] == 'Annotateur' or $_SESSION['role'] == 'Admin'):?> <li> <a href="espace_annotateur.php">Espace Annotateur</a> </li> <?php endif; ?>
			<?php if($_SESSION['role'] == 'Validateur' or $_SESSION['role'] == 'Admin'):?> <li> <a href="espace_validateur.php">Espace Validateur</a> </li> <?php endif; ?>
			<?php if($_SESSION['role'] == 'Admin'):?> <li> <a href="espace_administrateur.php">Espace Admin</a> </li> <?php endif; ?>
			<li> <a href="functions/deconnection.php">Déconnexion</a> </li>
		</ul>

		<div style="height:10vh;"> </div>

	</body>
</html>
