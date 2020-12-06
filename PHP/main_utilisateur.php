<!DOCTYPE html>

<link rel="stylesheet" type="text/css" href="css_page_de_garde.css">

<html>
	<body>
		<head>
			Espace Utilisateur
		</head>
		<div>
		<?php
			include_once('functions/connection.php');
			page_init();
			/*
			Variable session :
			last_query -> conserver l'affichage du dernier formulaire de recherche utilisé (gène, génome ou prot)
			*/
			
		?>

		</div>

			<ul class = "menu_horizontal" style="float:right;">
				<li> <a href="main_utilisateur.php">Espace Utilisateur</a> </li>
				<?php if($_SESSION['role'] == 'annotateur'):?> <li> <a href="espace_annotateur.php">Espace Annotateur</a> </li> <?php endif; ?>
				<?php if($_SESSION['role'] == 'validateur'):?> <li> <a href="espace_validateur.php">Espace Validateur</a> </li> <?php endif; ?>
				<li> <a href="deconnection.php">Déconnexion</a> </li>
			</ul>

		<div style="height:10vh;"> </div>

		<main>
			<!--
				
			-->
			<div class = "query_menu">
				<label class = "text_inscription_form" style="font-weight: bold;">Recherche</label>
				<div style="height:5%;"></div>
				<form method = "post" class = "text_query_form">
					<div style="margin-bottom:4%;">
						<label class = "text_query_form">Type de recherche</label>
						<select name= "select_query_type" class = "text_query_area_form" size = "1" onchange="this.form.submit();">
							<option disabled selected value><?php echo $_POST["select_query_type"] ?></option>
							<option value="genome">Génome</option>
							<option value="gene">Gène</option>
							<option value="prot">Protéine</option>
						</select>
					</div>
				</form>

				<?php if($_POST["select_query_type"] == "genome"):?>

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


						<div style="height:15vw;"></div>
						<button name = "query_genome" type="submit" class="btn btn-default" style = "font-size: 1em;float:right;margin-right:5%;"> Recherche</button>
					</form>

				<?php endif;
				
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
				
				<?php if($_POST["select_query_type"] == "gene"): ?>

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

							<div style="height:7.5vw;"></div>
							<button name = "query_gene" type="submit" class="btn btn-default" style = "font-size:1em;float:right;margin-right:5%;">Recherche</button>
						</form>
					</div>
				<?php endif;

				if(isset($_POST['query_gene'])){

						$_SESSION['query'] = "SELECT nom_cds, gene, gene_symbol, genome.nom_genome FROM db_genome.cds as cds, db_genome.genome as genome WHERE cds.nom_genome = genome.nom_genome";

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
				
				<?php if($_POST["select_query_type"] == "prot"):?>
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

							<div style="height:7.5vw;"></div>
							<button name = "query_prot" type="submit" class="btn btn-default" style = "font-size:1em;float:right;margin-right:5%;">Recherche</button>
						</form>
					</div>
					<?php endif;

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

			<?php	if(isset($_POST["query_genome"])){$_SESSION['last_query'] = "genome";}
					if(isset($_POST["query_gene"])){$_SESSION['last_query'] = "gene";}
					if(isset($_POST["query_prot"])){$_SESSION['last_query'] = "prot";}	?>

			<div class = "answer_menu">
					<table>
						<?php
							if(isset($_SESSION['query'])){

								echo "<tr>";
									if($_SESSION['last_query'] == "genome"){
											echo "<td class = \"query_head\">Génome</td>";
											echo "<td class = \"query_head\">Espèce</td>";
									}

									if($_SESSION['last_query'] == "gene"){
										echo "<td class = \"query_head\">CDS</td>";
										echo "<td class = \"query_head\">Gène</td>";
										echo "<td class = \"query_head\">Sigle</td>";
										echo "<td class = \"query_head\">Génome</td>";
									}

									if($_SESSION['last_query'] == "prot"){
										echo "<td class = \"query_head\">CDS</td>";
										echo "<td class = \"query_head\">Génome</td>";
										echo "<td class = \"query_head\">Espèce</td>";
									}
								echo "</tr>";

								connect_db();

								$query_results = pg_query($GLOBALS['db_conn'], $_SESSION['query']) or die ("ERROR");

								echo $query;
								while ($line = pg_fetch_array($query_results, null, PGSQL_ASSOC)) {

									echo "<tr>";
									foreach ($line as $col_value) {
										echo "<td class = \"query_line\">$col_value</td>";
									}
										?>
										<td>

											<form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
												<button class = "button_foreign_DB" type = "submit" name = "primary_key"
												value = "<?php echo array_values($line)[0];?>" type="button">Voir</button>
											</form>

										<td>
										<?php

								}
								if(isset($_POST['primary_key'])){
									$_SESSION['primary_key'] = $_POST['primary_key'];
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

					$blast_base = "https://blast.ncbi.nlm.nih.gov/Blast.cgi?CMD=Put&QUERY=";
					$blast_prog = "&PROGRAM=";
					$blast_db = "&DATABASE=";
					
					$uniprotkb_query = "https://www.uniprot.org/uniprot/?query=";
					$uniprotkb_query_score = "&sort=score";

					if(isset($_SESSION['primary_key'])){

						if($_SESSION['last_query'] == "genome"){

							$query = "SELECT * FROM db_genome.genome as genome WHERE genome.nom_genome = '" . $_SESSION['primary_key'] . "';";
							$look_it_up = pg_query($GLOBALS['db_conn'], $query) or die ("ERROR");
							$answer = pg_fetch_array($look_it_up, null, PGSQL_ASSOC);

							?>
							<br><br>

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

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Rechercher l'ID:</div><br>
								<a class = "button_foreign_DB" target = "_blank" href = "<?php echo "https://www.ncbi.nlm.nih.gov/assembly/?term=" . array_values($answer)[0]?>">NCBI (Genome)</a>
							</div>
								
							<?php
								$_SESSION['download'] = "";
								foreach($answer as $ans) {$_SESSION['download'] = $_SESSION['download'] . $ans . ";";}		
								$_SESSION['file_name'] = array_values($answer)[0] . ".genome";
							?>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Télécharger :</div><br>
								<a class = "button_foreign_DB" href = "functions/download.php">Format GENOME</a>
							</div>

							<?php
						}

						if($_SESSION['last_query'] == "gene"){
							$query = "SELECT * FROM db_genome.cds as cds WHERE cds.nom_cds = '" . $_SESSION['primary_key'] . "';";
							$look_it_up = pg_query($GLOBALS['db_conn'], $query) or die ("ERROR");
							$answer = pg_fetch_array($look_it_up, null, PGSQL_ASSOC);
							
							?>
							<br>

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

							<?php
								$_SESSION['download'] = "";
								foreach($answer as $ans) {$_SESSION['download'] = $_SESSION['download'] . $ans . ";";}		
								$_SESSION['file_name'] = array_values($answer)[4] . ".gene";
							?>

							<div class = 'detail_query'>
								<div class = "detail_query_attributes">Télécharger :</div><br>
								<a class = "button_foreign_DB" href = "functions/download.php">Format GENE</a>
							</div>


							<?php
						}
						if($_SESSION['last_query'] == "prot"){

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
