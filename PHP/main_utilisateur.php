<!DOCTYPE html>
	<link rel="stylesheet" type="text/css" href="css_page_de_garde.css">
<html>
	<body>
		<head>
			Espace Utilisateur
			
			<?php echo $_POST["select_query_type"]?>
		</head>

			<! Menu horizontal pour sélectionner l'interface (Utilisateur / Annotateur / Validateur)
			Affichage en fonction des permissions + vérifier dans chaque page que l'utilisateur en cours a les droits pour accéder à cette fonctionnalité
			>
			<ul class = "menu_horizontal" style="float:right;">
				<li> <a href="main_utilisateur.php">Espace Utilisateur</a> </li>
				<li> <a href="espace_annotateur.php">Espace Annotateur</a> </li>
				<li> <a href="espace_validateur.php">Espace Validateur</a> </li>
				<li> <a href="page_de_garde.php" title = "Déconnexion"> Déconnexion</a> </li>
			</ul>

		<div style="height:10vh;"> </div>
		
		<main>

				<!_____________________________________________________________________________________________________>
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

				<!_____________________________________________________________________________________________________>

				<?php if(isset($_POST["select_query_type"]) && ($_POST["select_query_type"] == 'genome')): ?>
					<form method = "post">
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
							<textarea class = "text_query_area_form" name="q_sequence" rows="10"> </textarea>
						</div>


						<div style="height:15vw;"></div>
						<div><button name = "query_genome" type="submit" class="btn btn-default" style = "font-size: 1em;float:right;margin-right:5%;"> Recherche</button></div>
					</form>
				<?php endif; ?>
				
				<!_____________________________________________________________________________________________________>

				<?php if (isset($_POST["select_query_type"]) && ($_POST["select_query_type"] == 'gene')): ?>

					<div class = "query_menu">
						<form method = "post">
							<div style = "margin-bottom:2%;">
								<label class = "text_query_form">Nom</label>
								<input class = "text_query_area_form" type = "text" name="q_gene_name">
							</div>

							<div style = "margin-bottom:2%;">
								<label class = "text_query_form">Sigle</label>
								<input class = "text_query_area_form" type = "text" name="q_sigle">
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
				<?php endif; ?>
				
				<!_____________________________________________________________________________________________________>
				
				<?php if (isset($_POST["select_query_type"]) && ($_POST["select_query_type"] == 'prot')): ?>
					<div id = "query_menu">
						<form method = "post">
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
				<!_____________________________________________________________________________________________________>
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
