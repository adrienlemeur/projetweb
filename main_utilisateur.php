<!DOCTYPE html>
	<link rel="stylesheet" type="text/css" href="./css_page_de_garde.css">
<html>
	<body>
		<head>
			Main Utilisateur
		</head>


			<ul id = "menu_horizontal" style="float:right;">
				<li> <a href="./inscription.php" title="Menu déroulant ici ?"> Espace Annotateur/Validateur</a> </li>
				<li> <a href="./page_de_garde.php" title="Déconnexion"> Déconnexion</a> </li>
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
							<option value="arn">Transcrit</option>
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
								<label for="nom" id = "text_query_form">Nom Gène</label>
								<input type="text" id = "text_query_area_form" name="nom_item">
							</div>

							<div style = "margin-bottom:2%;">
								<label for="nom" id = "text_query_form">Sigle Gène</label>
								<input type="text" id = "text_query_area_form" name="sigle_item">
							</div>

							<div style = "margin-bottom:2%;">
								<label for="nom" id = "text_query_form">Nom Génome</label>
								<input type="text" id = "text_query_area_form" name="genome_name_item">
							</div>

							<div style = "margin-bottom:4%;">
								<label for="nom" id = "text_query_form">Espèce</label>
								<input type="text" id = "text_query_area_form" name="species_item">
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
				
				<?php if (isset($_POST["select_query_type"]) && ($_POST["select_query_type"] == 'arn')): ?>
				<?php endif; ?>
				
				<?php if (isset($_POST["select_query_type"]) && ($_POST["select_query_type"] == 'prot')): ?>
				<?php endif; ?>

			</div>
			<div id = "scrollable_div">
<table class="demo">
	<thead>
	<tr>
		<th>Header 1</th>
		<th>Header 2</th>
		<th>Header 3</th>
		<th>Header 4</th>
		<th>Header 5</th>
	</tr>
	</thead>
	<tbody>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tbody>
</table>
			</div>

			<div id = "scrollable_div">
			</div>
		</main>


	</body>
</html>
