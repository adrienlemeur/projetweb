<!DOCTYPE html>
	<link rel="stylesheet" type="text/css" href="./css_page_de_garde.css">
<html>
	<body>

		<head>
			Inscription
		</head>

		<div style="height:20vh;"> </div>

		<form method="post" action="./page_de_garde.php" class = "form-group">

			<div id = "deux_blocs">
				<div>
					<label for="email" id = "text_inscription_form">Email : </label>
					<input type="email" id="input_inscription_form" name="email">
					
				</div>
				<div>
					<label for="pwd" id = "text_inscription_form">Mot de Passe : </label>
					<input type="password" id="input_inscription_form" name="pwd">
				</div>

				<div>
					<br><br>
					<label for="nom" id = "text_inscription_form">Nom : </label>
					<input type="text" id="input_inscription_form" name="nom">
				</div>

				<div>
					<label for="prenom" id = "text_inscription_form">Prénom : </label>
					<input type="text" id="input_inscription_form" name="prenom">
				</div>


				<div>
					<br>
					<label for="telephone" id = "text_inscription_form"> Numéro de Téléphone : </label>
					<input type="text" id="input_inscription_form" name="telephone">
				</div>

				<div>
					<label for="adresse" id = "text_inscription_form"> Adresse : </label>
					<input type="text" id="input_inscription_form" name="adresse">
				</div>

			</div>

			<div id = "deux_blocs">
				<label for="role" id = "text_inscription_form"> Rôle souhaité : </label>
				<div style="color:white;margin-left:20%;">
					<div>
						<input type="radio" id="role_choix1" name="role" value="user">
						<label for="role_choix1">Simple Utilisateur</label>
					</div>


					<div>
						<input type="radio" id="role_choix2" name="role" value="annotateur">
						<label for="role_choix2">Annotateur</label>
					</div>

					<div>
						<input type="radio" id="role_choix3" name="role" value="validateur">
						<label for="role_choix3">Validateur</label>
					</div>
				</div>

				<br><br>
				<label for="motivation" id = "text_inscription_form"> Motivation : </label>
				<textarea id="input_inscription_form" name="motivations" rows="5"> </textarea>

			</div>


			<div style="height:50vh;"></div>
			<button type="submit" class="btn btn-default" style = "font-size: 1em;float:right;"> Inscription </button>
		</form>

	</body>
</html>