<!DOCTYPE html>
	<link rel="stylesheet" type="text/css" href="./css_page_de_garde.css">
<html>
	<body>
		<head>
			Main Utilisateur
		</head>


			<ul id = "menu_horizontal" style="float:right;">
				<li> <a href="inscription.php" title="Menu déroulant ici ?"> Espace Annotateur</a> </li>
				<li> <a href="inscription.php" title="Menu déroulant ici ?"> Espace Validateur</a> </li>
				<li> <a href="page_de_garde.php" title="Déconnexion"> Déconnexion</a> </li>
			</ul>

		<div style="height:10vh;"> </div>

		<main>
			<div id = "query_menu">
				<label for="query_menu" id = "text_inscription_form" style="font-weight: bold;">Recherche</label>
				<div style="height:5%;"></div>

				<form method = "post" action="<?php echo $_SERVER['PHP_SELF'];?>">
					<div style="margin-bottom:4%;">
						<label for="query_type" id = "text_query_form">Type de recherche</label>
						<select name="select_query_type" id = "text_query_area_form" size = "1" onchange="this.form.submit();">
							<option disabled selected value><?php echo $_POST["select_query_type"]?></option>
							<option value="genome">Génome</option>
							<option value="gene">Gène</option>
							<option value="prot">Protéine</option>
						</select>
					</div>
				</form>

				<?php if (isset($_POST["select_query_type"]) && ($_POST["select_query_type"] == 'genome')): ?>
					<form>
						<div style = "margin-bottom:2%;">
							<label for="nom" id = "text_query_form">Nom Génome</label>
							<input type="text" id = "text_query_area_form" name="nom_item">
						</div>

						<div style = "margin-bottom:4%;">
							<label for="nom" id = "text_query_form">Espèce</label>
							<input type="text" id = "text_query_area_form" name="species_item">
						</div>

						<div style="height:15vw;"></div>
						<div><button type="submit" class="btn btn-default" style = "font-size: 1em;float:right;margin-right:5%;"> Recherche</button></div>
					</form>
				<?php endif; ?>
				

				<?php if (isset($_POST["select_query_type"]) && ($_POST["select_query_type"] == 'gene')): ?>

					<div id = "query_menu">
						<form>
							<div style = "margin-bottom:2%;">
								<label for="nom_gene" id = "text_query_form">Nom</label>
								<input type="text" id = "text_query_area_form" name="nom_item">
							</div>

							<div style = "margin-bottom:2%;">
								<label for="sigle" id = "text_query_form">Sigle</label>
								<input type="text" id = "text_query_area_form" name="sigle_item">
							</div>

							<div style = "margin-bottom:2%;">
								<label for="sigle" id = "text_query_form">Biotype</label>
								<input type="text" id = "text_query_area_form" name="biotype">
							</div>


							<div style = "margin-bottom:2%;">
								<label for="nom" id = "text_query_form">Nom Génome</label>
								<input type="text" id = "text_query_area_form" name="genome_name_item">
							</div>

							<div style = "margin-bottom:2%;">
								<label for="nom" id = "text_query_form">Description</label>
								<input type="text" id = "text_query_area_form" name="description">
							</div>

							<div style = "margin-bottom:4%;margin-left:32%;">
								<label for="nom" id = "text_query_form">Début</label>
								<input type="text" style = "width:22%;" name="start">

								<label for="nom" id = "text_query_form">Fin</label>
								<input type="text" style = "width:22%;" name="stop">
							</div>

							<div>
								<label for="sequence" id = "text_query_form">Séquence</label>
								<textarea id="text_query_area_form" name="sequence" rows="10"> </textarea>
							</div>

							<div style="height:11vw;"></div>
							<div><button type="submit" class="btn btn-default" style = "font-size:1em;float:right;margin-right:5%;">Recherche</button></div>
						</form>
					</div>
				<?php endif; ?>
				
				<?php if (isset($_POST["select_query_type"]) && ($_POST["select_query_type"] == 'prot')): ?>
					<div id = "query_menu">
						<form>
							<div style = "margin-bottom:2%;">
								<label for="nom_gene" id = "text_query_form">Nom</label>
								<input type="text" id = "text_query_area_form" name="nom_item">
							</div>

							<div style = "margin-bottom:2%;">
								<label for="sigle" id = "text_query_form">Biotype</label>
								<input type="text" id = "text_query_area_form" name="biotype">
							</div>

							<div style = "margin-bottom:2%;">
								<label for="nom" id = "text_query_form">Nom Gène</label>
								<input type="text" id = "text_query_area_form" name="gene_name">
							</div>

							<div style = "margin-bottom:2%;">
								<label for="nom" id = "text_query_form">Nom Génome</label>
								<input type="text" id = "text_query_area_form" name="genome_name_item">
							</div>

							<div style = "margin-bottom:2%;">
								<label for="nom" id = "text_query_form">Description</label>
								<input type="text" id = "text_query_area_form" name="description">
							</div>
							
							<div>
								<label for="sequence" id = "text_query_form">Séquence</label>
								<textarea id="text_query_area_form" name="sequence" rows="10"> </textarea>
							</div>

							<div style="height:11vw;"></div>
							<div><button type="submit" class="btn btn-default" style = "font-size:1em;float:right;margin-right:5%;">Recherche</button></div>
						</form>
					</div>
				<?php endif; ?>

			</div>
			<div id = "scrollable_div">
				<table class="demo">
				</table>

			</div>

			<div id = "scrollable_div">
			</div>
		</main>


	</body>
</html>
