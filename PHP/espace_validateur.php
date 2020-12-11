<!DOCTYPE html>
	<link rel="stylesheet" type="text/css" href="global_style.css">
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
	
	<?php
		#Interrogation de la base de donnée
		connect_db();
		#on cherche les séquences que doit reviewer le validateur
		$aValider = "SELECT nom_cds FROM db_genome.attribution_annotateur WHERE annote=1 AND valide=0;";
		
		#on cherche les séquences que doit attribuer le validateur (non annoté-validé et non attribué)
		$aAttribuer = "SELECT nom_cds FROM db_genome.cds WHERE annoteValide=0 EXCEPT(SELECT nom_cds FROM db_genome.attribution_annotateur);";
		#on cherche les annotateurs à qui le validateur peut attribuer les séquences
		$qAnnot = "SELECT email FROM db_genome.utilisateurs WHERE statut='Annotateur';";
		
		$aValider_result = pg_query($GLOBALS['db_conn'], $aValider) or die("Liste des annotations à valider impossible à établir") ;
		
		$aAttribuer_result = pg_query($GLOBALS['db_conn'], $aAttribuer) or die("Liste des ORF a attribuer impossible à établir") ;
		$eAnnot_result = pg_query($GLOBALS['db_conn'], $qAnnot) or die("Liste des annotateurs impossible à établir ") ;
		
		$V = pg_fetch_result($aValider_result,0,0);
		$Vnext = pg_fetch_result($aValider_result,1,0);
		
		$A = pg_fetch_result($aAttribuer_result,0,0);
		$Anext = pg_fetch_result($aAttribuer_result,1,0);
		$annotateurs=pg_fetch_result($eAnnot_result,0,0);
		$annotateursNext=pg_fetch_result($eAnnot_result,1,0);
		echo $annotateursNext;

		close_db();
	?>
	
	<main>
		
		<?php #Attribuer des sequences aux annotateurs ?>
			<div class = "administrator_panel">
				<br>
				
				<label class = "menu_name_admin" style = "margin-left:10%;">Les séquences à annoter</label>
				<div style="height:5%;"></div>
				
				<form method = "post" class = "text_query_form" action="<?php echo $_SERVER['PHP_SELF']?>">
					<div style="margin-bottom:4%;">
						
						<?php ### Liste des séquences à attribuer
						
						if ($A==NULL) :
							echo "Vous n'avez pas de séquence à attribuer</span><br><br>";
							
						elseif ($A!=NULL and !$Anext==1): ?>
								Il n'y plus qu'une séquence à attribuer dans la base ! <br>
								<?php $_SESSION['sequence']=$A;
						
						else : #plus d'une séquence à attribuer ?>
							
							<label class = "text_query_form"> Choix d'une séquence : </label>
							<select name="sequence" class = "text_query_area_form" size = "1" onchange="return $_POST['sequence'];">
							<option disabled selected value><?php echo $_POST["sequence"] ?></option>
								<?php
								
								$i=1;
								$row = pg_fetch_result($aAttribuer_result,0,0);
								while (!$row==0) {
									echo '<option value="'.$row.'">'.$row.'</option>';
									$row = pg_fetch_result($aAttribuer_result,$i,0);
									$i=$i+1;
								}
								?>
							</select>
							
							<?php $_SESSION['sequence']=$_POST['sequence']; #la séquence du choix est sauvegardée ?>
							<?php endif; ?>
						
						<?php
						### Liste des annotateurs disponibles
						
						if ($annotateurs==NULL) :
							echo "Il n'y a pas d'annotateurs dans la base !!<br><br>";
						
						elseif ($annotateurs!=NULL and !$annnotateursNext==0): ?>
								<br><br<br><br><br<br>Il n'y a qu'un annotateur dans la base ! Il est choisi d'office :
								<?php
								$_SESSION['annotateur']=$annotateurs;
								echo $_SESSION['annotateur'];
								
						else : #plus d'une séquence à attribuer ?>
							<br><br>
							<label class = "text_query_form"> Choix d'un annotateur : </label>
							<select name="annot" class = "text_query_area_form" size = "1" onchange="return $_POST['annot'];">
							<option disabled selected value><?php echo $_POST["annot"] ?></option>
								<?php
								$i=1;
								$row = pg_fetch_result($eAnnot_result,0,0);
								while (!$row==0) {
									echo '<option value="'.$row.'">'.$row.'</option>';
									$row = pg_fetch_result($eAnnot_result,$i,0);
									$i=$i+1;
								}
								?>
							</select>
							
							<?php $_SESSION['annotateur']=$_POST['annot'];?>
						<?php endif; ?>
					</div>
					<br><br><br><br><br>
					<button name="Attribuer" type="submit" style = "font-size:1em;margin-left:76%;">Attribuer</button>
				</form>
				
				<?php if(isset($_POST['Attribuer'])): #Si seq et annotateurs sont choisis et soumis ?>
					
					<br><br><br>
					<label class = "text_inscription_form" style="font-weight: bold;"> Verification de l'envoi </label>
						<?php
						echo "<br> annotateur :", $_SESSION['annotateur'];
						echo "<br> sequence :", $_SESSION['sequence'],"<br>";
						
							#recuperation du nom de genome :
							$nom_genome="SELECT nom_genome FROM db_genome.cds WHERE nom_cds='".$_SESSION['sequence']."';";							
							connect_db();
							$ng_result=pg_query($GLOBALS['db_conn'], $nom_genome) or die("Nom du génome impossible à sélectionner.") ;
							close_db();
							$ng=pg_fetch_result($ng_result,0,0);
							
							
							$peutAnnoter = "INSERT INTO db_genome.attribution_annotateur VALUES ('".$ng."','".$_SESSION['sequence']."', '".$_SESSION['annotateur']."', 0, 0);";

							#connexion à la BD pour ajout de la modification
							connect_db();
							#ajout des annotations dans la base de données
							$connection_result = pg_query($GLOBALS['db_conn'], $peutAnnoter) or die("\n\tInsertion impossible") ;
							close_db();
						?>
						<br> L'attribution a bien été intégrée à la base de données.
				<?php endif; ?>
				
			</div>
			
			<div class = "administrator_panel">
				<br>
				<label class = "menu_name_admin" style = "margin-left:10%;">Les annotations à valider sont les suivantes :</label>
				<div style="height:5%;"></div>
				
				<form method = "post" class = "text_query_form" action="<?php echo $_SERVER['PHP_SELF']?>" >
				<label class = "text_query_form"> Choisissez une séquence sur laquelle travailler : </label>
						<?php #Pas de séquence en attente de validation
							if ($V==NULL) : ?>
								<span style = "float:left;"><br><br>Vous n'avez pas de séquence à attribuer</span><br><br>
						<?php elseif($V!=NULL and !$Vnext==1) : ?>
								<br><br>>>> Il n'y plus qu'une séquence à attribuer dans la base :
								<?php echo $V;?>
							
						<?php	else : #plus d'une séquence à valider ?>
							<select name="Avalider" class = "text_query_area_form" size = "1" onchange="this.form.submit();">
								<option disabled selected value><?php echo $_POST["Avalider"] ?></option>
								<?php
								$i=1;
								$row = pg_fetch_result($aValider_result,0,0);
								while (!$row==0) {
									echo '<option value="'.$row.'">'.$row.'</option>';
									$row = pg_fetch_result($aValider_result,$i,0);
									$i=$i+1;
								}
								?>
							</select>
							<?php $V=$_POST['Avalider'];?>
						<?php endif; ?>
				</form>
						
				<?php 
				if(isset($_POST['Avalider']) or ($V!=NULL and !$Vnext==1)): ?>
				<label class = "text_query_form"> Proposition à la validation </label>
					<?php #recuperation des données d'annotation
					$Vselect = "SELECT * FROM db_genome.cds WHERE nom_cds='".$V."';";
					connect_db();
					$Vselect_result = pg_query($GLOBALS['db_conn'], $Vselect) or die("Données de la séquence impossible à récupérer");
					close_db();
					$chromosome = pg_fetch_result($Vselect_result,0,1);
					$gene_biotype = pg_fetch_result($Vselect_result,0,5);
					$gene_symbol = pg_fetch_result($Vselect_result,0,6);
					$description = pg_fetch_result($Vselect_result,0,7);
					$_SESSION['V']=$V;
					?>
					
					<table>
						<tr>
							<td> Nom CDS </td>
							<td> <?php echo $V; ?> </td>
						</tr>
						<tr>
							<td> Type ADN </td>
							<td> <?php echo $chromosome; ?> </td>
						</tr>
						<tr>
							<td> Biotype </td>
							<td> <?php echo $gene_biotype; ?> </td>
						</tr>
						<tr>
							<td> Symbole </td>
							<td> <?php echo $gene_symbol; ?> </td>
						</tr>
						<tr>
							<td> Description </td>
							<td> <?php echo $description; ?> </td>
						</tr>
					</table>
				<?php endif; ?>
					
					<form method = "post" class = "text_query_form" action="<?php echo $_SERVER['PHP_SELF']?>" >
					<br><br><br>
					<button name="Valider" type="submit" style = "font-size:1em;margin-left:76%;">Valider</button>
					<button name="Refuser" type="submit" style = "font-size:1em;margin-left:76%;">Refuser</button>
					</form>
					
				<?php #en cas de validation, on change la valeur de annoteValide et valide
					if(isset($_POST["Valider"])) {
						
						$estValide="UPDATE db_genome.cds SET annoteValide=1 WHERE nom_cds='".$_SESSION['V']."';";
						$estValide2="UPDATE db_genome.attribution_annotateur SET valide=1 WHERE nom_cds='".$_SESSION['V']."';";
						echo $estValide;
						
						connect_db();
						$res1=pg_query($GLOBALS['db_conn'],$estValide) or die("Impossible de valider dans la table cds");
						$res2=pg_query($GLOBALS['db_conn'],$estValide2) or die("Impossible de valider dans la table attribution_annotateur");
						close_db();
						echo "La validation de l'annotation a bien été prise en compte.";
						
						$aValider = "SELECT nom_cds FROM db_genome.attribution_annotateur WHERE annote=1 AND valide=0;";
						connect_db();
						$aValider_result = pg_query($GLOBALS['db_conn'], $aValider) or die("Liste des annotations à valider impossible à établir") ;
						close_db();
						$V = pg_fetch_result($aValider_result,0,0);
						$Vnext = pg_fetch_result($aValider_result,1,0);
					}
					elseif(isset($_POST["Refuser"])){
						#suppression des annotations
						$estRefuse="UPDATE db_genome.attribution_annotateur SET annote=0 WHERE nom_cds='".$_SESSION['V']."';";
						
						connect_db();

						$res1=pg_query($GLOBALS['db_conn'],$estRefuse) or die("Impossible de refuser dans la table attribution_annotateur");

						
						close_db();
						echo "Le refus de l'annotation a bien été pris en compte.";
					}
					
					?>
					
			</div>
			
		
	</main>
</html>
