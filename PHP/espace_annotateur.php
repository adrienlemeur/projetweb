<!DOCTYPE html>


<link rel="stylesheet" type="text/css" href="./css_page_de_garde.css">

<?php
	include_once('functions/connection.php');
	page_init(); #Session start / kill si l'utilisateur n'est pas connecté					
?>

<html>
	<body>
		<head>
			Espace Annotateur
		</head>
		<div>
		<?php
			include_once('functions/connection.php');
			page_init(); #Session start / kill si l'utilisateur n'est pas connecté			
		?>
		</div>
		
			<?php
				#Interrogation de la base de donnée : on cherche les séquences que doit annoter l'utilisateur
				connect_db();
				$connection_query = "SELECT nom_cds FROM db_genome.attribution_annotateur WHERE mail_annot ='".$_SESSION['email']."';";
				
				$connection_result = pg_query($GLOBALS['db_conn'], $connection_query) or die("Connection impossible") ;
				$query = pg_fetch_result($connection_result,0,0);
				$next = pg_fetch_result($connection_result,1,0);
				
				close_db();
			?>
			
			
			<?php #On affiche les pages accessibles en fonction des droits de l'utilisateur ?>
		<ul class = "menu_horizontal" style="float:right;">
			<li> <a href="main_utilisateur.php">Espace Utilisateur</a> </li>
			<?php if($_SESSION['role'] == 'Annotateur' or $_SESSION['role'] == 'Admin'):?> <li> <a href="espace_annotateur.php">Espace Annotateur</a> </li> <?php endif; ?>
			<?php if($_SESSION['role'] == 'Validateur' or $_SESSION['role'] == 'Admin'):?> <li> <a href="espace_validateur.php">Espace Validateur</a> </li> <?php endif; ?>
			<?php if($_SESSION['role'] == 'Admin'):?> <li> <a href="espace_administrateur.php">Espace Administrateur</a> </li> <?php endif; ?>
			<li> <a href="deconnection.php">Déconnexion</a> </li>
		</ul>
		
		<div style="height:10vh;"> </div>
		
		<main>
			
			<?php #Choix de la séquence à annoter ?>
			<div class = "query_menu">
				<label class = "text_inscription_form" style="font-weight: bold;">Vos séquences à annoter</label>
				<div style="height:5%;"></div>
				<form method = "post" class = "text_query_form">
					<div style="margin-bottom:4%;">
						
						<?php #si l'annotateur n'a pas de séquence attribuée
							if ($query==NULL) : ?>
								"Vous n'avez pas de séquence à annoter"
						<?php endif ?>
						<?php #si l'annotateur n'a qu'une séquence attribuée
							if ($query!=NULL and !$next==1) : ?>
								"Vous n'avez qu'une séquence à annoter"
							
						<?php	else : #plus d'une séquence attribuée ?>
							<label class = "text_query_form"> Choix d'une séquence : </label>
							<select name="seq" id="seq-select">
								<option value=""> </option>
								<?php
								$i=1;
								$row = pg_fetch_result($connection_result,0,0);
								while (!$row==0) {
									echo '<option value="'.$row.'">'.$row.'</option>';
									$row = pg_fetch_result($connection_result,$i,0);
									$i=$i+1;
								}
								?>
							</select>
						<?php endif ?>
					</div>
				</form>
			</div>
			
			<div class = "query_menu">
				<label class = "text_inscription_form" style="font-weight: bold;"> Vos annotations </label>
				
			</div>
		</main>

	</body>
</html>
