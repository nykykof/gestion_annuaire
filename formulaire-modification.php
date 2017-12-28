<?php 
	$query = "SELECT * FROM categorie;";
	$categories = mysql_query($query,$db) or die("Impossible d'effectuer la selection sur la table persone");

	if(isset($_GET["id"])){
		$id = htmlspecialchars($_GET["id"]);
		$query_perso = "SELECT * FROM personne where id=$id";
		$result = mysql_query($query_perso);
		$personne = mysql_fetch_array($result);		

 ?>

<div style="padding-left: 15%;padding-right: 15%;">
	<form action="traitement_formulaire.php" method="POST" enctype="multipart/form-data">

		<fieldset>
			<legend>Identification</legend>
			<?php echo "<input type=\"hidden\" name=\"personne_id\" value=\"".$personne["id"]."\" >"; ?>
			<div class="form-group">
				<div><label for="nom"> Nom: </label></div>
				<?php echo "<div><input type=\"text\" class=\"form-control\" name=\"nom\" value=\"".$personne["nom"]."\" required></div>"; ?>
			</div>
			<div class="form-group">
				<div><label for="prenom">Prénom: </label></div>
				<?php echo "<div><input type=\"text\" class=\"form-control\" name=\"prenom\" value=\"".$personne["prenom"]."\" required></div>"; ?>
			</div>
			<div class="form-group">
				<div><label for="age">Age :</label></div>
				<?php echo "<div><input type=\"number\" class=\"form-control\" name=\"age\" value=\"".$personne["age"]."\"></div>"; ?>
			</div>
			<div class="form-group">
				<div><label for="sexe">Sexe: </label></div>
				<div><label for="sexe">M</label>
				<input type="radio" name="sexe" value="Masculin" <?php if(strcasecmp(htmlspecialchars($personne["sexe"]), "Masculin") == 0){echo "checked=\"checked\"";}?> />
				<label for="sexe">F</label>
				<input type="radio" name="sexe" value="Féminin" <?php if(strcasecmp(htmlspecialchars($personne["sexe"]), "Féminin") == 0){echo "checked=\"checked\"";}?> />
			</div>
			<div class="form-group">
				<div><label for="categorie">Catégorie: </label></div>
				<div>
					<select name="categorie" class="form-control">
						<option>--Selectionner--</option>
						<?php 
							while ($categorie = mysql_fetch_array($categories)) {
								echo "<option value=\"".$categorie["id"]."\""; if($personne["categorie_id"]==$categorie["id"]){echo "selected='selected'";} echo ">".$categorie["designation"]."</option>";
							}
						 ?>
					</select>
				</div>
			</div>
			<!-- <div class="form-group">
				<label for="photo"> Photo</label>
				<input type="file"  name="photo"/>
			</div> -->
		</fieldset>
		<fieldset>
			<legend>Pages personnelles</legend>
			<div class="form-group">
				<div><label for="url_facebook">facebook: </label></div>
				<?php echo "<div><input type=\"url\" class=\"form-control\" name=\"url_facebook\" value=\"".$personne["url_facebook"]."\"></div>"; ?>
			</div>
			<div class="form-group">
				<div><label for="url_twiter">Twiter: </label></div>
				<?php echo "<div><input type=\"url\" class=\"form-control\" name=\"url_twiter\" value=\"".$personne["url_twitter"]."\"></div>"; ?>
			</div>
			<div class="form-group">
				<div><label for="url_linkedin">Linkedin: </label></div>
				<?php echo "<div><input type=\"url\" class=\"form-control\" name=\"url_linkedin\" value=\"".$personne["url_linkedin"]."\"></div>"; ?>
			</div>

		</fieldset>
		<div>
			<a href="index.php?page=adminList"><input type="button" name="return" value="Annuler" class="btn btn-warning"></a>
			<input type="submit" value="Envoyer" name="modification" class="btn btn-success">
		</div>
	</form>
</div>
<?php 
}
 ?>