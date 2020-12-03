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
						<div><button name = "query_genome" type="submit" class="btn btn-default" style = "font-size: 1em;float:right;margin-right:5%;"> Recherche</button></div>
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
						echo $query;
					}
				?>
				
				<?php if (isset($_POST["select_query_type"]) && ($_POST["select_query_type"] == 'gene')): ?>

					<div class = "query_menu">
						<form method = "post" action="<?php echo $_SERVER['PHP_SELF']?>">
							<div style = "margin-bottom:2%;">
								<label class = "text_query_form">Nom</label>
								<input class = "text_query_area_form" type = "text" name="q_gene_name">
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
								<textarea class = "text_query_area_form" name="q_sequence" rows="10"> </textarea>
							</div>

							<div style="height:11vw;"></div>
							<div><button name = "query_gene" type="submit" class="btn btn-default" style = "font-size:1em;float:right;margin-right:5%;">Recherche</button></div>
						</form>
					</div>
				<?php endif;

				if(isset($_POST['query_gene'])){

						$query = "SELECT nom_cds, gene_symbole, genome FROM db_genome.cds as cds, db_genome.genome as genome WHERE cds.nom_genome == genome.nom_genome";

						if(isset($_POST['q_gene_name'])){
							$query = $query . " AND nom_cds LIKE '%" . $_POST['q_gene_name'] . "%'";
						}
						
						if(isset($_POST['q_symbol'])){
							$query = $query . " AND gene_symbol LIKE '%" . $_POST['q_symbol'] . "%'";
						}

						if(isset($_POST['q_biotype'])){
							$query = $query . " AND gene_biotype LIKE '%" . $_POST['q_biotype'] . "%'";
						}

						if(isset($_POST['q_genome_name'])){
							$query = $query . " AND nom_genome LIKE '%" . $_POST['q_genome_name'] . "%'";
						}

						
						if(isset($_POST['q_description'])){
							$query = $query . " AND description LIKE '%" . $_POST['q_description'] . "%'";
						}
						
						#if(isset($_POST['q_start']) && isset($_POST['q_stop'])){
						#	$query = $query . " AND start > '" . $_POST['q_start'] . "' AND start < '" . $_POST['q_stop'] . . "'";
						#}


						$query = $query . ";";
						echo $query;
					}

				?>
				
				<?php if (isset($_POST["select_query_type"]) && ($_POST["select_query_type"] == 'prot')): ?>
					<div id = "query_menu">
						<form method = "post" action="<?php echo $_SERVER['PHP_SELF']?>">
							<div style = "margin-bottom:2%;">
								<label class = "text_query_form">Nom</label>
								<input class = "text_query_area_form" type="text" name="q_rna_name">
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

							<div style="height:11vw;"></div>
							<div><button name = "query_prot" type="submit" class="btn btn-default" style = "font-size:1em;float:right;margin-right:5%;">Recherche</button></div>
						</form>
					</div>
				<?php endif; ?>
			</div>
			

			<! Résultat de la query sous forme de tableau>
			<div class = "scrollable_div">
				<table class="demo">
				</table>
			</div>

			<! Détail sur le résultat de la query sélectionné>
			<div class = "scrollable_div">
			</div>

		</main>


	</body>
</html>

<?php
	$_POST = array();
?>
