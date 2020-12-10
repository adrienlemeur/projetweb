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

		<?php #On affiche les pages accessibles en fonction des droits de l'utilisateur ?>
		<ul class = "menu_horizontal" style="float:right;">
			<li> <a href="main_utilisateur.php">Espace Utilisateur</a> </li>
			<?php if($_SESSION['role'] == 'Annotateur' or $_SESSION['role'] == 'Admin'):?> <li> <a href="espace_annotateur.php">Espace Annotateur</a> </li> <?php endif; ?>
			<?php if($_SESSION['role'] == 'Validateur' or $_SESSION['role'] == 'Admin'):?> <li> <a href="espace_validateur.php">Espace Validateur</a> </li> <?php endif; ?>
			<?php if($_SESSION['role'] == 'Admin'):?> <li> <a href="espace_administrateur.php">Espace Admin</a> </li> <?php endif; ?>
			<li> <a href="deconnection.php">Déconnexion</a> </li>
		</ul>

		<?php
			#Interrogation de la base de donnée : on cherche les séquences que doit annoter l'utilisateur
			connect_db();
			$connection_query = "SELECT nom_cds FROM db_genome.attribution_annotateur WHERE mail_annot ='".$_SESSION['email']."'AND annote=0;";

			$connection_result = pg_query($GLOBALS['db_conn'], $connection_query) or die("Connection impossible") ;
			$query = pg_fetch_result($connection_result,0,0);
			$next = pg_fetch_result($connection_result,1,0);

			close_db();
		?>
		
		<div style="height:10vh;"> </div>
		
		<main>
			
			<?php #Choix de la séquence à annoter ?>
			<div class = "administrator_panel">
				<br>
				<label class = "menu_name_admin" style = "margin-left:10%;">Vos séquences à annoter</label>
				<div style="height:5%;"></div>
				
				<form method = "post" class = "text_query_form" action="<?php echo $_SERVER['PHP_SELF']?>">
					<div style="margin-bottom:4%;">
					
						<?php #si l'annotateur n'a pas de séquence attribuée
							if ($query==NULL) : ?>
								Vous n'avez pas de séquence à annoter
						<?php endif; ?>

						<?php #si l'annotateur n'a qu'une séquence attribuée
							if ($query!=NULL and !$next==1) : ?>
								Vous n'avez qu'une séquence à annoter :<br>
								<?php echo $query?>
							
						<?php	else : #plus d'une séquence attribuée ?>
							<label class = "text_query_form"> Choix d'une séquence : </label>
							<select name="seq" class = "text_query_area_form" size = "1" onchange="this.form.submit();">
								<option disabled selected value><?php echo $_POST["seq"] ?></option>
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
							<?php
								$query=$_POST['seq'];
								#on modifie la valeur de $query suivant le choix de l'utilisateur dans la liste
							?>
						<?php endif; ?>
					</div>
				</form>
			</div>
			
			<div class = "administrator_panel">
				<br>
				<label class = "menu_name_admin" style = "margin-left:10%;"> Vos annotations </label>
				<?php if($query!=NULL):?>
					 sur <?php echo $query; ?>
					<div>
					<br>
					<div class = "main_text">Remplissez les différents champs afin d'annoter la séquence. Une fois tous les champs remplis vous pouvez soumettre vos annotations.
					<br><br>
					NB : Vous pouvez récupérer la séquence du gène dans l'onglet utilisateur en reportant le code de la séquence.
					<br><br>
					</div>
					
					
					<?php $_SESSION['annoteEnCours']=$query;?>
					
					<form method="post">
						
						<div class = "bloc_admin">

							<div class = "bloc_admin">
								<label class = "text_admin">Nom du gène</label>
								<input class = "admin_form" type = "text" name="gene"></textarea>
							</div><br>

							<div class = "bloc_admin">
								<label class = "text_admin">Biotype du gène</label>
								<input class = "admin_form" type = "text" name="gene_biotype"></textarea>
							</div>

							<br>
							<div class = "bloc_admin">
								<label class = "text_admin">Symbole du gène</label>
								<input class = "admin_form" type="text" name="gene_symbol"></textarea>
							</div>
							<br>
							
							<label class = "text_admin">Type d'ADN</label>
							<select name = "chromosome" class = "admin_form">
								<option disabled selected value></option>
								<option value='chromosome'>chromosome</option>
								<option value='plasmide'>plasmid</option>
							</select><br><br>

							<div class = "bloc_admin">
								<label class = "text_admin">Description</label>
								<textarea class = "admin_form" name="description" rows="5"></textarea>
							</div>
							<br><br><br><br><br>
							<button name="annotation" type="submit" style = "font-size:1em;margin-left:76%;">Annoter</button>
						</form>
					<?php endif;?>
				</div>

			<?php if(isset($_POST['annotation'])): #Si le bouton submit du formulaire de recherche de gène est soumis, construit la requête SQL à partir des informations fournies par l'utilisateur ?>
			<div class = "query_menu">
				<label class = "text_inscription_form" style="font-weight: bold;"> Verification de l'envoi </label>
					<br> Le formulaire a bien été envoyé pour la séquence : <br>
					<?php  #chromosome gene_biotype gene_symbol description
						$_SESSION['annote'] = "UPDATE db_genome.cds SET chromosome='".$_POST['chromosome']."', gene_biotype='".$_POST['gene_biotype']."', gene_symbol='".$_POST['gene_symbol']."', description='".$_POST['description']."' WHERE nom_cds='".$_SESSION['annoteEnCours']."';";
						$chgEtat = "UPDATE db_genome.attribution_annotateur SET annote=1 WHERE nom_cds='".$_SESSION['annoteEnCours']."';";
						echo $_SESSION['annoteEnCours'];

						#connexion à la BD pour ajout de modification
						connect_db();
						#ajout des annotations dans la base de données
						$connection_result = pg_query($GLOBALS['db_conn'], $_SESSION['annote']) or die("\n\tInsertion impossible") ;
						#changement du statut de l'annotation
						$connection_result = pg_query($GLOBALS['db_conn'],$chgEtat) or die("\n\tChangement d'etat de annote impossible") ;

						close_db();
					endif; ?>
		</main>
	</body>
</html>
