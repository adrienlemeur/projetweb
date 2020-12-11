<!DOCTYPE html>
	<link rel="stylesheet" type="text/css" href="./css_page_de_garde.css">
<?php
	include_once('functions/connection.php');
	page_init(); #Session start / kill si l'utilisateur n'est pas connecté					
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
			<li> <a href="deconnection.php">Déconnexion</a> </li>
		</ul>

		<div style="height:10vh;"> </div>
	</body>
	
	<?php
		#Interrogation de la base de donnée
		connect_db();
		#on cherche les séquences que doit reviewer le validateur
		$aValider = "SELECT nom_cds FROM db_genome.attribution_annotateur WHERE annote=1 AND valide=0;";
		#on cherche les séquences que doit attribuer le validateur
		$aAttribuer = "SELECT nom_cds FROM db_genome.cds WHERE annoteValide=0;";
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
		$annotateursNext=pg_fetch_result($eAnnot_result,0,0);

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
					
						<?php #Liste des séquences à attribuer
							if ($A==NULL) : ?>
								<span style = "float:left;">Vous n'avez pas de séquence à attribuer</span><br><br>
						<?php elseif ($A!=NULL and !$Anext==1) : ?>
								Il n'y plus qu'une séquence à attribuer dans la base ! <br>
								<?php $_SESSION['cds']=$A;?>
							
						<?php	else : #plus d'une séquence à attribuer ?>
							<label class = "text_query_form"> Choix d'une séquence : </label>
							<select name="cds" class = "text_query_area_form" size = "1" onchange="this.form.submit();">
								<option disabled selected value><?php echo $_POST["cds"] ?></option>
								<optgroup>
								<?php
								$i=1;
								$row = pg_fetch_result($aAttribuer_result,0,0);
								while (!$row==0) {
									echo '<option value="'.$row.'">'.$row.'</option>';
									$row = pg_fetch_result($aAttribuer_result,$i,0);
									$i=$i+1;
								}
								?>
								</optgroup>
							</select>
							<?php $_SESSION['cds']=$_POST['cds']; #la séquence du choix est sauvegardée dans $A
							echo $_SESSION['cds'] ?>
						<?php endif; ?>
						
						<?php #Liste des annotateurs disponibles
							if ($annotateurs==NULL) : ?>
								<span style = "float:left;">Il n'y a pas d'annotateurs dans la base !!</span><br><br>
						<?php elseif ($annotateurs!=NULL and !$annnotateursNext==1) : ?>
								<br><br<br><br><br<br>Il n'y a qu'un annotateur dans la base ! Il est choisi d'office :
								<?php echo $annotateurs?>
							
						<?php	else : #plus d'une séquence à attribuer ?>
							<label class = "text_query_form"> Choix d'un annotateur : </label>
							<select name="annot" class = "text_query_area_form" size = "1" onchange="this.form.submit();">
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
							<?php $annotateurs=$_POST['annot']; #l'annotateur du choix est sauvegardé dans $annotateurs ?>
						<?php endif; ?>
					</div>
					<br><br><br><br><br>
					<button name="attribAnnot" type="submit" style = "font-size:1em;margin-left:76%;">Attribuer</button>
				</form>
				
				<?php if(isset($_POST['attribAnnot'])): #Si le bouton submit est pressé, construit la requête SQL à partir des informations fournies par l'utilisateur ?>
				<br><br><br><br><br><br><br><br>
				<label class = "text_inscription_form" style="font-weight: bold;"> Verification de l'envoi </label>
					<br> Les informations ont bien été saisies pour l'attribution. <br>
					<?php
					
						#recuperation du nom de genome :
						$nom_genome="SELECT nom_genome FROM db_genome.cds WHERE nom_cds='".$_SESSION['cds']."';";
						echo $nom_genome;
						$ng_result=pg_query($GLOBALS['db_conn'], $nom_genome) or die("Connexion impossible à établir") ;
						$ng=pg_fetch_result($ng_result,0,0);
						
						
						$peutAnnoter = "UPDATE db_genome.attribution_annotateur SET nom_genome='".$ng."', nom_cds='".$_SESSION['cds']."', mail_annot='".$annotateurs."', valide=0, annote=0;";
						echo $peutAnnoter;

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
								<span style = "float:left;">Vous n'avez pas de séquence à attribuer</span><br><br>
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
					$Vselect_result = pg_query($GLOBALS['db_conn'],$Vselect) or die("Données de la séquence impossible à récupérer");
					close_db();
					$chromosome = pg_fetch_result($Vselect_result,0,1);
					$gene_biotype = pg_fetch_result($Vselect_result,0,5);
					$gene_symbol = pg_fetch_result($Vselect_result,0,6);
					$description = pg_fetch_result($Vselect_result,0,7);
					$_SESSION=$V;
					?>
					
					<table>
						<tr>
							<td> nom CDS </td>
							<td> <?php echo $V; ?> </td>
						</tr>
						<tr>
							<td> type ADN </td>
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
						
						$estValide="UPDATE db_genome.cds SET annoteValide=1 WHERE nom_cds='".$V."';";
						$estValide2="UPDATE db_genome.attribution_annotateur SET valide=1 WHERE nom_cds='".$V."';";
						echo $estValide;
						
						connect_db();
						$res1=pg_query($GLOBALS['db_conn'],$estValide) or die("Impossible de valider dans la table cds");
						$res2=pg_query($GLOBALS['db_conn'],$estValide2) or die("Impossible de valider dans la table attribution_annotateur");
						close_db();	
					}
					elseif(isset($_POST["Refuser"])){
						#suppression des annotations
						$estRefuse="UPDATE db_genome.attribution_annotateur SET annote=0 WHERE nom_cds='".$V."';";
						#reinitialisation des annotations
						$estRefuse2="UPDATE db_genome.cds SET gene_biotype='', gene_symbol='', description='' WHERE nom_cds='".$V."';"; #pas obligé de réinitialiser, cela dit...
						echo $estRefuse;
						
						connect_db();
						$res1=pg_query($GLOBALS['db_conn'],$estRefuse) or die("Impossible de refuser dans la table attribution_annotateur");
						$res2=pg_query($GLOBALS['db_conn'],$estRefuse2) or die("Impossible de supprimer les annotations dans la table cds");
						close_db();
						
					}
					else #rien à faire
					{}
					
					?>
					
					
					
			</div>
			
		
	</main>
</html>
