<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="css_page_de_garde.css">

<html>
	<body>
		<head>
			Espace Utilisateur
		</head>

		<?php
			include_once('functions/connection.php');
			page_init(); #Session start / kill si l'utilisateur n'est pas connecté					
		?>

		<?php #On affiche les pages accessibles en fonction des droits de l'utilisateur ?>
		<ul class = "menu_horizontal" style="float:right;">
			<li> <a href="main_utilisateur.php">Espace Utilisateur</a> </li>
			<?php if($_SESSION['role'] == 'Annotateur' or $_SESSION['role'] == 'Admin'):?> <li> <a href="espace_annotateur.php">Espace Annotateur</a> </li> <?php endif; ?>
			<?php if($_SESSION['role'] == 'Validateur' or $_SESSION['role'] == 'Admin'):?> <li> <a href="espace_validateur.php">Espace Validateur</a> </li> <?php endif; ?>
			<?php if($_SESSION['role'] == 'Admin'):?> <li> <a href="espace_administrateur.php">Espace Admin</a> </li><?php endif;?>
			<li> <a href="deconnection.php">Déconnexion</a> </li>
		</ul>


		<div style="height:10vh;"> </div>

		<main>

			<?php #Query menu : permet de sélectionner le type de formulaire proposé à gauche ?>
			<div class = "query_menu">
				<label class = "text_inscription_form" style="font-weight: bold;">Recherche</label>
				<div style="height:5%;"></div>
				<form method = "post" class = "text_query_form">
					<div style="margin-bottom:4%;">
						<label class = "text_query_form">Type de recherche</label>
						<select name= "select_query_type" class = "text_query_area_form" size = "1" onchange="this.form.submit();">
							<option disabled selected value><?php echo $_SESSION['last_query'] ?></option>
							<option value="genome">Génome</option>
							<option value="gene">Gène</option>
							<option value="prot">Protéine</option>
						</select>
					</div>
				</form>

				<?php
					if(isset($_POST["select_query_type"]) and $_POST["select_query_type"] != $_SESSION['last_query']){
						$_SESSION['last_query'] = $_POST["select_query_type"];
					}
				?>
		

				<?php #AFFICHAGE FORMULAIRE GENOME ?>
				<?php if($_SESSION['last_query'] == "genome"):?>

					<form method = "post" action="<?php echo $_SERVER['PHP_SELF']?>">
						<div style = "margin-bottom:2%;">
							<label class = "text_query_form">Nom Génome</label>
							<input class = "text_query_area_form" type = "text" name="q_genome_name">
						</div>

						<div style = "margin-bottom:4%;">
							<label class = "text_query_form">Espèce</label>
							<input class = "text_query_area_form" type = "text" name="q_species">
						</div>
						<div>
							<label class = "text_query_form">Séquence</label>
							<textarea class = "text_query_area_form" name="q_sequence" rows="10"></textarea>
						</div>


						<div style="height:6vw;"></div>
						<button name = "query_genome" type="submit" class="button_foreign_DB" style = "font-size: 1em;float:right;margin-right:7%;"> Recherche</button>
					</form>

				<?php endif;

				#Si le bouton submit du formulaire de recherche de génome est soumis, construit la requête SQL à partir des informations fournies par l'utilisateur
				if(isset($_POST['query_genome'])){

						$_SESSION['query'] = "SELECT nom_genome, espece FROM db_genome.genome";

						#on ajoute WHERE 1=1 (qui est toujours vrai) pour ne pas avoir à gérer la présence ou l'absence de AND avant chaque condition dans la query

						if(!empty($_POST['q_genome_name']) or !empty($_POST['q_species']) or !empty($_POST['q_sequence'])){
							$_SESSION['query'] = $_SESSION['query'] . " WHERE 1=1";

							if(isset($_POST['q_genome_name'])){
								$_SESSION['query'] = $_SESSION['query'] . " AND nom_genome LIKE '%" . $_POST['q_genome_name'] . "%'";
							}
							
							if(isset($_POST['q_species'])){
								$_SESSION['query'] = $_SESSION['query'] . " AND espece LIKE '%" . $_POST['q_species'] . "%'";
							}
							
							if(isset($_POST['q_sequence'])){
								$_SESSION['query'] = $_SESSION['query'] . " AND seq LIKE '%" . $_POST['q_sequence']. "%'";
							}
						}

						$_SESSION['query'] = $_SESSION['query'] . ";";
					}
				?>
				<?php #AFFICHAGE FORMULAIRE GENE ?>

				<?php if($_SESSION['last_query'] == "gene"): ?>

					<div class = "query_menu">
						<form method = "post" action="<?php echo $_SERVER['PHP_SELF']?>">
							<div style = "margin-bottom:2%;">
								<label class = "text_query_form">Nom Gène</label>
								<input class = "text_query_area_form" type = "text" name="q_gene_name">
							</div>

							<div style = "margin-bottom:2%;">
								<label class = "text_query_form">Nom CDS</label>
								<input class = "text_query_area_form" type = "text" name="q_cds_name">
							</div>
							
							<div style = "margin-bottom:2%;">
								<label class = "text_query_form">Espèce</label>
								<input class = "text_query_area_form" type = "text" name="q_species">
							</div>

							<div style = "margin-bottom:2%;">
								<label class = "text_query_form">Sigle</label>
								<input class = "text_query_area_form" type = "text" name="q_symbol">
							</div>

							<div style = "margin-bottom:2%;">
								<label class = "text_query_form">Biotype</label>
								<input class = "text_query_area_form" type = "text" name="q_biotype">
							</div>


							<div style = "margin-bottom:2%;">
								<label class = "text_query_form">Nom Génome</label>
								<input class = "text_query_area_form" type = "text" name="q_genome_name">
							</div>

							<div style = "margin-bottom:2%;">
								<label class = "text_query_form">Description</label>
								<input class = "text_query_area_form" type = "text" name="q_description">
							</div>

							<div style = "margin-bottom:4%;margin-left:32%;">
								<label class = "text_query_form">Début</label>
								<input type = "text" style = "width:22%;" name="q_start">

								<label class = "text_query_form">Fin</label>
								<input type = "text" style = "width:22%;" name="q_stop">
							</div>

							<div>
								<label class = "text_query_form">Séquence</label>
								<textarea class = "text_query_area_form" name="q_sequence" rows="10"></textarea>
							</div>

							<div style="height:6vw;"></div>
							<button name = "query_gene" type="submit" class="button_foreign_DB" style = "font-size:1em;float:left;margin-left:7%;">Recherche</button>
						</form>
					</div>
				<?php endif;

				#Si le bouton submit du formulaire de recherche de gène est soumis, construit la requête SQL à partir des informations fournies par l'utilisateur
				if(isset($_POST['query_gene'])){

						$_SESSION['query'] = "SELECT cds.nom_cds, gene, gene_symbol, genome.nom_genome FROM db_genome.cds as cds, db_genome.genome as genome WHERE cds.nom_genome = genome.nom_genome AND cds.annoteValide = 1";

						if(!empty($_POST['q_gene_name'])){
							$_SESSION['query'] = $_SESSION['query'] . " AND gene LIKE '%" . $_POST['q_gene_name'] . "%'";
						}

						if(!empty($_POST['q_cds_name'])){
							$_SESSION['query'] = $_SESSION['query'] . " AND nom_cds LIKE '%" . $_POST['q_cds_name'] . "%'";
						}
						
						if(!empty($_POST['q_species'])){
							$_SESSION['query'] = $_SESSION['query'] . " AND genome.espece LIKE '%" . $_POST['q_species'] . "%'";
						}

						if(!empty($_POST['q_symbol'])){
							$_SESSION['query'] = $_SESSION['query'] . " AND cds.gene_symbol LIKE '%" . $_POST['q_symbol'] . "%'";
						}

						if(!empty($_POST['q_biotype'])){
							$_SESSION['query'] = $_SESSION['query'] . " AND gene_biotype LIKE '%" . $_POST['q_biotype'] . "%'";
						}

						if(!empty($_POST['q_genome_name'])){
							$_SESSION['query'] = $_SESSION['query'] . " AND cds.nom_genome LIKE '%" . $_POST['q_genome_name'] . "%'";
						}

						if(!empty($_POST['q_description'])){
							$_SESSION['query'] = $_SESSION['query'] . " AND description LIKE '%" . $_POST['q_description'] . "%'";
						}

						if(!empty($_POST['q_start']) && !empty($_POST['q_stop'])){
							$_SESSION['query'] = $_SESSION['query'] . " AND seq_start > '" . $_POST['q_start'] . "' AND seq_end < '" . $_POST['q_stop'] . "'";
						}

						if(!empty($_POST['q_sequence'])){
							$_SESSION['query'] = $_SESSION['query'] . " AND cds_sequence LIKE '%" . $_POST['q_sequence'] . "%'";
						}
						$_SESSION['query'] = $_SESSION['query'] . ";";
					}
				?>

				<?php #AFFICHAGE FORMULAIRE PEPTIDE ?>

				<?php if($_SESSION['last_query'] == "prot"):?>
					<div id = "query_menu">
						<form method = "post" action="<?php echo $_SERVER['PHP_SELF']?>">
							<div style = "margin-bottom:2%;">
								<label class = "text_query_form">Nom CDS</label>
								<input class = "text_query_area_form" type="text" name="q_cds_name">
							</div>

							<div style = "margin-bottom:2%;">
								<label class = "text_query_form">Nom Gène</label>
								<input class = "text_query_area_form" type = "text" name="q_gene_name">
							</div>

							<div style = "margin-bottom:2%;">
								<label class = "text_query_form">Biotype</label>
								<input class = "text_query_area_form" type = "text" name="q_biotype">
							</div>

							<div style = "margin-bottom:2%;">
								<label class = "text_query_form">Nom Génome</label>
								<input class = "text_query_area_form" type = "text" name="q_genome_name">
							</div>

							<div style = "margin-bottom:2%;">
								<label class = "text_query_form">Description</label>
								<input class = "text_query_area_form" type = "text" name="q_description">
							</div>

							<div>
								<label class = "text_query_form">Séquence</label>
								<textarea class = "text_query_area_form" name="q_sequence" rows="10"></textarea>
							</div>

							<div style="height:6vw;"></div>
							<button name = "query_prot" type="submit" class="button_foreign_DB" style = "font-size:1em;float:right;margin-right:7%;">Recherche</button>
						</form>
					</div>
					<?php endif;

						#Si le bouton submit du formulaire de recherche de protéine est soumis, construit la requête SQL à partir des informations fournies par l'utilisateur
						if(isset($_POST["query_prot"])){
							
							$_SESSION['query'] = "SELECT pep.nom_cds, genome.nom_genome, genome.espece FROM db_genome.genome as genome, db_genome.cds as cds, db_genome.pep as pep WHERE cds.nom_genome = genome.nom_genome AND pep.nom_cds  = cds.nom_cds";

							if(!empty($_POST['q_cds_name'])){
								$_SESSION['query'] = $_SESSION['query'] . " AND pep.nom_cds LIKE '%" . $_POST['q_cds_name'] . "%'";
							}
							if(!empty($_POST['q_gene_name'])){
								$_SESSION['query'] = $_SESSION['query'] . " AND gene LIKE '%" . $_POST['q_gene_name'] . "%'";
							}
							
							if(!empty($_POST['q_biotype'])){
								$_SESSION['query'] = $_SESSION['query'] . " AND gene_biotype LIKE '%" . $_POST['q_biotype'] . "%'";
							}
							
							if(!empty($_POST['q_genome_name'])){
								$_SESSION['query'] = $_SESSION['query'] . " AND genome.nom_genome LIKE '%" . $_POST['q_genome_name'] . "%'";
							}
							
							if(!empty($_POST['q_description'])){
								$_SESSION['query'] = $_SESSION['query'] . " AND cds.description LIKE '%" . $_POST['q_description'] . "%'";
							}

							if(!empty($_POST['q_sequence'])){
								$_SESSION['query'] = $_SESSION['query'] . " AND seq_pep LIKE '%" . $_POST['q_sequence'] . "%'";
							}

							$_SESSION['query'] = $_SESSION['query'] . ";";
						}
					?>
			</div>

			<?php 	#Permet de conserver la forme de l'affichage entre deux rafraichissement ?>
			<?php	if(isset($_POST["query_genome"])){
						$_SESSION['last_query'] = "genome";
						$_SESSION['last_query_for_output'] = "genome";
						}
					if(isset($_POST["query_gene"])){
						$_SESSION['last_query'] = "gene";
						$_SESSION['last_query_for_output'] = "gene";
						}
					if(isset($_POST["query_prot"])){
						$_SESSION['last_query'] = "prot";
						$_SESSION['last_query_for_output'] = "prot";
					}
						
					?>

			<div class = "answer_menu">
					<table>
						<?php
							#Si une query a été entrée (si un des trois formulaire de recherche - gène, génome, prot - a été soumis, affiche les résultats
							if(isset($_SESSION['query'])){

								echo "<tr>";
									#Noms de colonnes (Génome)
									if($_SESSION['last_query_for_output'] == "genome"){
											echo "<td class = \"query_head\">Génome</td>";
											echo "<td class = \"query_head\">Espèce</td>";
									}

									#Noms de colonnes (Gène)
									if($_SESSION['last_query_for_output'] == "gene"){
										echo "<td class = \"query_head\">CDS</td>";
										echo "<td class = \"query_head\">Gène</td>";
										echo "<td class = \"query_head\">Sigle</td>";
										echo "<td class = \"query_head\">Génome</td>";
									}
									
									#Noms de colonnes (Prot)
									if($_SESSION['last_query_for_output'] == "prot"){
										echo "<td class = \"query_head\">CDS</td>";
										echo "<td class = \"query_head\">Génome</td>";
										echo "<td class = \"query_head\">Espèce</td>";
									}
								echo "</tr>";

								connect_db();

								$query_results = pg_query($GLOBALS['db_conn'], $_SESSION['query']) or die ("ERROR");
								echo $query;
								while ($line = pg_fetch_array($query_results, null, PGSQL_ASSOC)) {

									#Affichage des résultats de la query sous la forme d'un tableau à 2, 4 ou 3 colonnes
									echo "<tr>";
									foreach ($line as $col_value) {
										echo "<td class = \"query_line\">$col_value</td>";
									}
										?>
										<td>

											<?php #A côté de chaque ligne, affiche un bouton qui renvoie la clef primaire du tuple correspondant ?>
											<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
												<button class = "button_foreign_DB" type = "submit" name = "primary_key"
												value = "<?php echo array_values($line)[0];?>" type="button">Voir</button>
											</form>

										<td>
										<?php

								}

								#Si un des bouton VOIR est pressé, on conserve la valeur dans une variable de session pour conserver l'affichage
								#entre les rafraichissements
								if(isset($_POST['primary_key'])){
									$_SESSION['primary_key'] = $_POST['primary_key'];
								}
								
								#Si l'utilisateur soumet le formulaire de gauche un nouvelle fois, on ne veut pas que le panneau continue d'être affiché
								if(isset($_POST['query_genome']) or isset($_POST['query_gene']) or isset($_POST['query_prot'])){
									unset($_SESSION['primary_key']);
								}

								pg_free_result($query_results);
								close_db();
							}
						?>
					</table>
				</div>
			</div>

			<div class = "detail_menu">
				<?php
					connect_db();


					#Prépartion des urls pour rechercher les identifiants dans les bases
					$blast_base = "https://blast.ncbi.nlm.nih.gov/Blast.cgi?CMD=Put&QUERY=";
					$blast_prog = "&PROGRAM=";
					$blast_db = "&DATABASE=";
					
					$uniprotkb_query = "https://www.uniprot.org/uniprot/?query=";
					$uniprotkb_query_score = "&sort=score";

					#Si la clef primaire du tuple est attribué
					if(isset($_SESSION['primary_key'])){

						#si la dernière query est un génome (la clef primaire stockée est donc celle d'un génome)
						if($_SESSION['last_query_for_output'] == "genome"){

							#on cherche le tuple associé à la clef primaire
							$query = "SELECT * FROM db_genome.genome as genome WHERE genome.nom_genome = '" . $_SESSION['primary_key'] . "';";
							$look_it_up = pg_query($GLOBALS['db_conn'], $query) or die ("ERROR");
							$answer = pg_fetch_array($look_it_up, null, PGSQL_ASSOC);

							?>
							<br><br>

							<?php #Affichage des attributs ?>
							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Génome :</div>
								<textarea class = 'detail_query_output' disabled rows = 1><?php echo array_values($answer)[0];?></textarea>
							</div>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Espèce :</div>
								<textarea class = 'detail_query_output' disabled rows = 2><?php echo array_values($answer)[2];?></textarea>
							</div>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Séquence (100 premiers nucléotides) :</div>
								<textarea class = 'detail_query_output' disabled rows = 5><?php echo substr(array_values($answer)[1], 0, 100); ?></textarea>
							</div>

							<?php #Recherche dans les bases de données externes ?>
							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Rechercher l'ID:</div><br>
								<a class = "button_foreign_DB" target = "_blank" href = "<?php echo "https://www.ncbi.nlm.nih.gov/assembly/?term=" . array_values($answer)[0]?>">NCBI (Genome)</a>
							</div>
								
							<?php #On stock les attributs dans une variable en vu du téléchargement ?>
							<?php
								$_SESSION['download'] = "";
								foreach($answer as $ans) {$_SESSION['download'] = $_SESSION['download'] . $ans . ";";}		
								$_SESSION['file_name'] = array_values($answer)[0] . ".genome";
							?>


							<?php #Téléchargement au format texte> ?>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Télécharger :</div><br>
								<a class = "button_foreign_DB" href = "functions/download.php">Format GENOME</a>
							</div>
							
							
							<?php #Visualisation du génome> ?>
							<?php $_SESSION['visualisation_genome'] = array_values($answer)[0]; ?>

							<div class = 'detail_query'>
								<a class = "button_foreign_DB" target = "_blank" href = "genome_visualisation.php">Visualisation Génome</a>
							</div>

							<?php
						}
						
						#si la dernière query est un gène (la clef primaire stockée est donc celle d'un gène)
						if($_SESSION['last_query_for_output'] == "gene"){
							$query = "SELECT * FROM db_genome.cds as cds WHERE cds.nom_cds = '" . $_SESSION['primary_key'] . "';";
							$look_it_up = pg_query($GLOBALS['db_conn'], $query) or die ("ERROR");
							$answer = pg_fetch_array($look_it_up, null, PGSQL_ASSOC);
							
							?>
							<br>
							<?php #Affichage des attributs ?>
							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Gène</div>
								<textarea class = 'detail_query_output' disabled rows = 1><?php echo array_values($answer)[4];?></textarea>
							</div>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">CDS</div>
								<textarea class = 'detail_query_output' disabled rows = 1><?php echo array_values($answer)[0];?></textarea>
							</div>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Biotype</div>
								<textarea class = 'detail_query_output' disabled rows = 1><?php echo array_values($answer)[5];?></textarea>
							</div>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Sigle</div>
								<textarea class = 'detail_query_output' disabled rows = 1><?php echo array_values($answer)[6];?></textarea>
							</div>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Description</div>
								<textarea class = 'detail_query_output' disabled rows = 3><?php echo array_values($answer)[7];?></textarea>
							</div>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Nom du génome :</div>
								<textarea class = 'detail_query_output' disabled rows = 1><?php echo array_values($answer)[9];?></textarea>
							</div>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Chromosome :</div>
								<textarea class = 'detail_query_output' disabled rows = 1><?php echo array_values($answer)[1];?></textarea>
							</div>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Start :</div>
								<textarea class = 'detail_query_output' disabled rows = 1><?php echo array_values($answer)[2];?></textarea>
							</div>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Stop :</div>
								<textarea class = 'detail_query_output' disabled rows = 1><?php echo array_values($answer)[3];?></textarea>
							</div>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Séquence :</div>
								<textarea class = 'detail_query_output' disabled rows = 5><?php echo substr(array_values($answer)[8], 0); ?></textarea>
							</div>

							<?php #Recherche dans les bases de données externes ?>
							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Rechercher l'ID:</div><br>
								<a class = "button_foreign_DB" target = "_blank" href = "<?php echo "https://www.ncbi.nlm.nih.gov/gene/?term=" . array_values($answer)[4]?>">NCBI (Gene)</a>
								<a class = "button_foreign_DB" target = "_blank" href = "<?php echo $uniprotkb_query . array_values($answer)[0] . $uniprotkb_query_score?>">Uniprot KB (CDS)</a>
								<a class = "button_foreign_DB" target = "_blank" href = "<?php echo "https://www.ncbi.nlm.nih.gov/protein/?term=" . array_values($answer)[0]?>">NCBI (CDS)</a>
							</div>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Rechercher la séquence :</div><br>
								<a class = "button_foreign_DB" target = "_blank" href = "<?php echo $blast_base . substr(array_values($answer)[8], 0) . $blast_prog . "blastn" . $blast_db . "nr"; ?>">NCBI Protein</a>
							</div>
							<?php #Téléchargement ?>
							<?php
								$_SESSION['download'] = "";
								foreach($answer as $ans) {$_SESSION['download'] = $_SESSION['download'] . $ans . ";";}		
								$_SESSION['file_name'] = array_values($answer)[4] . ".gene";
							?>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Télécharger :</div><br>
								<?php #Ouverture d'une nouvelle page vers downloads.php qui créée un fichier et le renvoie à l'utilisateur ?>
								<a class = "button_foreign_DB" href = "functions/download.php">Format GENE</a>
							</div>


							<?php
						}
						#si la dernière query est une proteine
						if($_SESSION['last_query_for_output'] == "prot"){

							$query = "SELECT * FROM db_genome.pep as pep WHERE pep.nom_cds = '" . $_SESSION['primary_key'] . "';";
							$look_it_up = pg_query($GLOBALS['db_conn'], $query) or die ("ERROR");
							$answer = pg_fetch_array($look_it_up, null, PGSQL_ASSOC);
							?>
							<br>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Gène</div>
								<textarea class = 'detail_query_output' disabled rows = 1><?php echo array_values($answer)[1];?></textarea>
							</div>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">CDS</div>
								<textarea class = 'detail_query_output' disabled rows = 1><?php echo array_values($answer)[0];?></textarea>
							</div>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Biotype</div>
								<textarea class = 'detail_query_output' disabled rows = 1><?php echo array_values($answer)[2];?></textarea>
							</div>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Séquence :</div>
								<textarea class = 'detail_query_output' disabled rows = 5><?php echo substr(array_values($answer)[3], 0); ?></textarea>
							</div>


							<?php #Recherche dans les bases de données externes ?>
							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Rechercher l'ID:</div><br>
								<a class = "button_foreign_DB" target = "_blank" href = "<?php echo "https://www.ncbi.nlm.nih.gov/gene/?term=" . array_values($answer)[1]?>">NCBI Protein (Gene)</a>
								<a class = "button_foreign_DB" target = "_blank" href = "<?php echo $uniprotkb_query . array_values($answer)[1] . $uniprotkb_query_score?>">Uniprot KB (Gene)</a>
								<a class = "button_foreign_DB" target = "_blank" href = "<?php echo "https://www.ncbi.nlm.nih.gov/protein/?term=" . array_values($answer)[0]?>">NCBI Protein (CDS)</a>
							</div>
							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Rechercher la séquence :</div><br>
								<a class = "button_foreign_DB" target = "_blank" href = "<?php echo $blast_base . substr(array_values($answer)[3], 0) . $blast_prog . "blastp" . $blast_db . "prot"; ?>">NCBI Protein</a>
							</div>
							<?php #Téléchargement ?>
							<?php
								$_SESSION['download'] = "";
								foreach($answer as $ans) {$_SESSION['download'] = $_SESSION['download'] . $ans . ";";}		
								$_SESSION['file_name'] = array_values($answer)[1] . ".pep";
							?>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Télécharger :</div><br>
								<a class = "button_foreign_DB" href = "functions/download.php">Format PEP</a>
							</div>

							<?php
						}

					}

					pg_free_result($look_it_up);
					close_db();
				?>
			</div>

		</main>

	</body>
</html>
