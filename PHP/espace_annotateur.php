<!DOCTYPE html>


<link rel="stylesheet" type="text/css" href="global_style.css">

<?php
	include_once('functions/connection.php');
	page_init(); #Session start / kill si l'utilisateur n'est pas connecté

	if($_SESSION['role'] != 'Annotateur' and $_SESSION['role'] != 'Admin'){
		echo "Vous ne pouvez pas accéder à cette page.";
		die;
	}
				
?>

<html>
	<body>

		<?php #On affiche les pages accessibles en fonction des droits de l'utilisateur ?>
		<ul class = "menu_horizontal" style="float:right;">
			<li> <a href="main_utilisateur.php">Espace Utilisateur</a> </li>
			<?php if($_SESSION['role'] == 'Annotateur' or $_SESSION['role'] == 'Admin'):?> <li> <a href="espace_annotateur.php">Espace Annotateur</a> </li> <?php endif; ?>
			<?php if($_SESSION['role'] == 'Validateur' or $_SESSION['role'] == 'Admin'):?> <li> <a href="espace_validateur.php">Espace Validateur</a> </li> <?php endif; ?>
			<?php if($_SESSION['role'] == 'Admin'):?> <li> <a href="espace_administrateur.php">Espace Admin</a> </li> <?php endif; ?>
			<li> <a href="functions/deconnection.php">Déconnexion</a> </li>
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
	
		<?php #Choix de la séquence à annoter ?>
		<div class = "administrator_panel">
			<div class = "menu_name_admin">Vos séquences à annoter</div>
				<br>
				<form method = "post" class = "text_query_form" action="<?php echo $_SERVER['PHP_SELF']?>">
						<?php #si l'annotateur n'a pas de séquence attribuée
							if ($query == NULL) :
								echo "<div class = 'text_admin'>Vous n'avez pas de séquence à annoter</div><br><br>";
						endif;

						#si l'annotateur n'a qu'une séquence attribuée
							if ($query!=NULL and !$next==1) :
								echo "<div class = 'text_admin'>Vous n'avez qu'une séquence à annoter :</div>";
								echo $query;
							else : #plus d'une séquence attribuée ?>

							<div class = "text_admin" style = "float:left;">Choisir une séquence :</div>
							<select name="seq" class = "admin_form" onchange="this.form.submit();">
								<option disabled selected value><?php echo $_POST["seq"] ?></option>

								<?php
									$i=1;
									$row = pg_fetch_result($connection_result,0,0);

									while (!$row==0) {
										echo '<option value="'. $row .'">'.$row.'</option>';
										$row = pg_fetch_result($connection_result,$i,0);
										$i=$i+1;
									}
								?>
							</select>
							<?php $query = $_POST['seq']; #on modifie la valeur de $query en fonction du choix de l'utilisateur
							endif; ?>
				</form>
				
				<br><div class = "menu_name_admin">Vos annotations</div>

					<?php
						connect_db();
						$user_annotation = "SELECT nom_genome, nom_cds, valide FROM db_genome.attribution_annotateur as anot WHERE anot.mail_annot ='" . $_SESSION['email'] . "';";
						$answer = pg_query($GLOBALS['db_conn'], $user_annotation);

						echo "<div style = 'height:50%;overflow-x:auto;'>";
						echo "<table style = 'margin-right:10%;margin-left:10%;table-layout:fixed;width:75%;overflow-x: auto;'>";

						#affichage des noms colonnes
						echo "<tr class = 'admin_user_table' style = 'font-weight: bolder;'>";
						echo "<td>"; echo "Genome";echo "</td>";
						echo "<td>"; echo "CDS";echo "</td>";
						echo "<td>"; echo "Validé?";echo "</td>";
						echo "</tr>";

						while ($line = pg_fetch_array($answer, null, PGSQL_ASSOC)) {
							echo "<tr>";
							#Affiche tout les attributs, sauf le hash du mot de passe
							foreach($line as $key => $val){
								echo "<td class = 'admin_user_table'>";
								if($key == "valide"){
									if($val == 0){
										echo "NON";
									} else if($val == 1){
										echo "OUI";
									}
								} else {
									echo $val;
								}

								echo "</td>";
							}
						}
						echo "</tr>";
						echo "</table>";
						echo "</div>";

						close_db();
					?>
			</div>


		<div class = "administrator_panel">

				<div class = "text_admin">
				<?php if($query != NULL):
					echo "<div class = 'menu_name_admin'>Annoter ";echo $query; echo "</div>";
				?>
				</div>
				<div class = "text_admin">
					<div style = "text-align: justify;margin-left:5%;margin-right:10%;">
					<div class = "text_admin">Remplissez les différents champs afin d'annoter la séquence.
											Une fois tous les champs remplis vous pouvez soumettre vos annotations.</div>
					<br>
					<div class = "text_admin">NB : Vous pouvez récupérer la séquence du gène dans l'onglet utilisateur en reportant le code de la séquence.</div>
				</div>
				<br>
				
				<?php $_SESSION['annoteEnCours']=$query;?>
				
				<form method="post" class = "text_admin" action="<?php echo $_SERVER['PHP_SELF']?>">
					
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
							<option value='plasmid'>plasmid</option>
						</select><br><br>

						<div class = "bloc_admin">
							<label class = "text_admin">Description</label>
							<textarea class = "admin_form" name="description" rows="5"></textarea>
						</div>
						<br><br><br><br><br>
						<button name="annotation" type="submit" style = "font-size:1em;margin-left:76%;">Annoter</button>
					</form>
				</div>
				<?php endif;?>

				<?php if(isset($_POST['annotation'])): #Si le bouton submit du formulaire de recherche de gène est soumis, construit la requête SQL à partir des informations fournies par l'utilisateur ?>
				<br> Le formulaire a bien été envoyé pour la séquence :
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
		</div>
	</body>
</html>
