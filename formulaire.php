<?php 

	$query = "SELECT * FROM categorie;";
	$categories = mysql_query($query,$db) or die("Impossible d'effectuer la selection sur la table persone");

 ?>

<div style="padding-left: 15%;padding-right: 15%;">
	<form action="traitement_formulaire.php" method="POST" enctype="multipart/form-data">

		<fieldset>
			<legend>Identification</legend>
			<div class="form-group">
				<div><label for="nom"> Nom: </label></div>
				<div><input type="text" class="form-control" name="nom" required></div>
			</div>
			<div class="form-group">
				<div><label for="prenom">Prénom: </label></div>
				<div><input type="text" class="form-control" name="prenom" required></div>
			</div>
			<div class="form-group">
				<div><label for="age">Age :</label></div>
				<div><input type="number" class="form-control" name="age"></div>
			</div>
			<div class="form-group">
				<div><label for="sexe">Sexe: </label></div>
				<div><label for="sexe">M</label>
				<input type="radio" name="sexe" value="Masculin" />
				<label for="sexe">F</label>
				<input type="radio"  name="sexe" value="Féminin"></div>
			</div>
			<div class="form-group">
				<div><label for="categorie">Catégorie: </label></div>
				<div>
					<select name="categorie" class="form-control">
						<option>--Selectionner--</option>
						<?php 
							while ($categorie = mysql_fetch_array($categories)) {
								echo "<option value=\"".$categorie["id"]."\">".$categorie["designation"]."</option>";
							}
						 ?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<label for="photo"> Photo</label>
				<input type="file"  name="photo"/>
			</div>
		</fieldset>
		<fieldset>
			<legend>Pages personnelles</legend>
			<div class="form-group">
				<div><label for="url_facebook">facebook: </label></div>
				<div><input type="url" class="form-control" name="url_facebook" ></div>
			</div>
			<div class="form-group">
				<div><label for="url_twitter">Twiter: </label></div>
				<div><input type="url" class="form-control" name="url_ttwiter" ></div>
			</div>
			<div class="form-group">
				<div><label for="url_linkedin">Linkedin: </label></div>
				<div><input type="url" class="form-control" name="url_linkedin" ></div>
			</div>

		</fieldset>
		<div>
			<a href="index.php?page=adminList"><input type="button" name="return" value="Annuler" class="btn btn-warning"></a>
			<input type="submit" value="Envoyer" name="enreg_personne" class="btn btn-success">
		</div>
	</form>
</div>