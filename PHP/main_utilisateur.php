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
		?>

		</div>

			<ul class = "menu_horizontal" style="float:right;">
				<li> <a href="main_utilisateur.php">Espace Utilisateur</a> </li>
				<li> <a href="espace_annotateur.php">Espace Annotateur</a> </li>
				<li> <a href="espace_validateur.php">Espace Validateur</a> </li>
				<li> <a href="deconnection.php">Déconnexion</a> </li>
			</ul>

		<div style="height:10vh;"> </div>

		<main>

			<div class = "query_menu">
				<label class = "text_inscription_form" style="font-weight: bold;">Recherche</label>
				<div style="height:5%;"></div>

				<form method = "post" class = "text_query_form">
					<div style="margin-bottom:4%;">
						<label class = "text_query_form">Type de recherche</label>
						<select name= "select_query_type" class = "text_query_area_form" size = "1" onchange="this.form.submit();">
							<option disabled selected value><?php echo $_POST["select_query_type"]?></option>
							<option value="genome">Génome</option>
							<option value="gene">Gène</option>
							<option value="prot">Protéine</option>
						</select>
					</div>
				</form>

				<?php if(isset($_POST["select_query_type"]) && ($_POST["select_query_type"] == 'genome')): ?>
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

						$query = "SELECT nom_genome, espece FROM db_genome.genome";
						
						if(!empty($_POST['q_genome_name']) or !empty($_POST['q_species']) or !empty($_POST['q_sequence'])){
							$query = $query . " WHERE 1=1";

							if(isset($_POST['q_genome_name'])){
								$query = $query . " AND nom_genome LIKE '%" . $_POST['q_genome_name'] . "%'";
							}
							
							if(isset($_POST['q_species'])){
								$query = $query . " AND espece LIKE '%" . $_POST['q_species'] . "%'";
							}
							
							if(isset($_POST['q_sequence'])){
								$query = $query . " AND seq LIKE '%" . $_POST['q_sequence']. "%'";
							}
						}

						$query = $query . ";";
					}
				?>
				
				<?php if (isset($_POST["select_query_type"]) && ($_POST["select_query_type"] == 'gene')): ?>

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

						$query = "SELECT nom_cds, gene_symbol, genome.nom_genome FROM db_genome.cds as cds, db_genome.genome as genome WHERE cds.nom_genome = genome.nom_genome";

						if(!empty($_POST['q_gene_name'])){
							$query = $query . " AND gene LIKE '%" . $_POST['q_gene_name'] . "%'";
						}

						if(!empty($_POST['q_cds_name'])){
							$query = $query . " AND nom_cds LIKE '%" . $_POST['q_cds_name'] . "%'";
						}
						
						if(!empty($_POST['q_species'])){
							$query = $query . " AND genome.espece LIKE '%" . $_POST['q_species'] . "%'";
						}

						if(!empty($_POST['q_symbol'])){
							$query = $query . " AND cds.gene_symbol LIKE '%" . $_POST['q_symbol'] . "%'";
						}

						if(!empty($_POST['q_biotype'])){
							$query = $query . " AND gene_biotype LIKE '%" . $_POST['q_biotype'] . "%'";
						}

						if(!empty($_POST['q_genome_name'])){
							$query = $query . " AND cds.nom_genome LIKE '%" . $_POST['q_genome_name'] . "%'";
						}

						if(!empty($_POST['q_description'])){
							$query = $query . " AND description LIKE '%" . $_POST['q_description'] . "%'";
						}

						if(!empty($_POST['q_start']) && !empty($_POST['q_stop'])){
							$query = $query . " AND seq_start > '" . $_POST['q_start'] . "' AND seq_end < '" . $_POST['q_stop'] . "'";
						}

						if(!empty($_POST['q_sequence'])){
							$query = $query . " AND cds_sequence LIKE '%" . $_POST['q_sequence'] . "%'";
						}
						$query = $query . ";";
					}

				?>
				
				<?php if (isset($_POST["select_query_type"]) && ($_POST["select_query_type"] == 'prot')): ?>
					<div id = "query_menu">
						<form method = "post" action="<?php echo $_SERVER['PHP_SELF']?>">
							<div style = "margin-bottom:2%;">
								<label class = "text_query_form">Nom CDS</label>
								<input class = "text_query_area_form" type="text" name="q_cds_name">
							</div>

							<div style = "margin-bottom:2%;">
								<label class = "text_query_form">Biotype</label>
								<input class = "text_query_area_form" type = "text" name="q_biotype">
							</div>

							<div style = "margin-bottom:2%;">
								<label class = "text_query_form">Nom Gène</label>
								<input class = "text_query_area_form" type="text" name="q_prot_name">
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
								<textarea class = "text_query_area_form" name="q_sequence" rows="10"> </textarea>
							</div>

							<div style="height:7.5vw;"></div>
							<button name = "query_prot" type="submit" class="btn btn-default" style = "font-size:1em;float:right;margin-right:5%;">Recherche</button>
						</form>
					</div>
					<?php endif;
						if(isset($_POST['query_prot'])){
					
							$query = "SELECT cds.nom_cds, cds.gene, genome.nom_genome, genome.espece FROM db_genome.genome as genome, db_genome.cds as cds, db_genome.pep as pep WHERE cds.nom_genome = genome.nom_genome AND pep.nom_cds  = cds.nom_cds";

							if(!empty($_POST['q_cds_name'])){
								$query = $query . " AND pep.nom_cds LIKE '%" . $_POST['q_cds_name'] . "%'";
							}
							
							if(!empty($_POST['q_biotype'])){
								$query = $query . " AND gene_biotype LIKE '%" . $_POST['q_biotype'] . "%'";
							}
							
							if(!empty($_POST['q_prot_name'])){
								$query = $query . " AND gene_biotype LIKE '%" . $_POST['q_prot_name'] . "%'";
							}
							
							if(!empty($_POST['q_genome_name'])){
								$query = $query . " AND genome.nom_genome LIKE '%" . $_POST['q_genome_name'] . "%'";
							}
							
							if(!empty($_POST['q_description'])){
								$query = $query . " AND cds.description LIKE '%" . $_POST['q_description'] . "%'";
							}

							$query = $query . ";";
						}
					?>
			</div>


			<div class = "scrollable_div">
				<table class="demo", style = "font-size = 0.5;">

					<?php
	
							if(isset($_POST['query_gene']) or isset($_POST['query_gene']) or isset($_POST['query_genome'])){
							connect_db();
							$query_results = pg_query($GLOBALS['db_conn'], $query) or die ("ERROR");
	
							while ($line = pg_fetch_array($query_results, null, PGSQL_ASSOC)) {
								echo "\t<tr>\n";
								foreach ($line as $col_value) {
									echo "\t<td>$col_value</td>\n";
								}
								echo "\t</tr>\n";
							}
							pg_free_result($query_results);
							close_db();
						}
					?>

				</table>
			</div>

			<! Détail sur le résultat de la query sélectionné>
			<div class = "scrollable_div">
			</div>

		</main>
		<?php
			$_POST = array();
		?>

	</body>
</html>
