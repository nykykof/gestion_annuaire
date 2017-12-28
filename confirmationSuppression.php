
<?php 

	if (isset($_GET["done"]) && strcasecmp(htmlspecialchars($_GET["done"]), "ok") == 0) {
		echo "<div class=\"alert alert-success\" role=\"alert\">
				  <p style=\"text-align: center;font-size: 20px;font-style: italic;\"> Action effectuée avec suuccès !</p>
				</div>";
				if($_GET["type"] && strcasecmp(htmlspecialchars($_GET["type"]), "personne") == 0){
					echo "<p><a href=\"index.php?page=adminList\"><input type=\"button\" name=\"reset\" value=\"ok\" class=\"btn btn-success\"></a></p>";
				}
				elseif ($_GET["type"] && strcasecmp(htmlspecialchars($_GET["type"]), "categorie") == 0) {
					echo "<p><a href=\"index.php?page=adminAdmin\"><input type=\"button\" name=\"reset\" value=\"ok\" class=\"btn btn-success\"></a></p>";
				}
			//include("success_page.php");
	}
	elseif ((isset($_GET["done"]) && strcasecmp(htmlspecialchars($_GET["done"]), "none") == 0)) {
		/*include("failure_page.php");*/
			echo "<div class=\"alert alert-danger\" role=\"alert\">
				  <p style=\"text-align: center;font-size: 20px;font-style: italic;\"> Une erreur s'est produite !</p>
				</div>";
				if($_GET["type"] && strcasecmp(htmlspecialchars($_GET["type"]), "personne") == 0){
					echo "<p><a href=\"index.php?page=adminList\"><input type=\"button\" name=\"reset\" value=\"ok\" class=\"btn btn-success\"></a></p>";
				}
				elseif ($_GET["type"] && strcasecmp(htmlspecialchars($_GET["type"]), "categorie") == 0) {
					echo "<p><a href=\"index.php?page=adminAdmin\"><input type=\"button\" name=\"reset\" value=\"ok\" class=\"btn btn-success\"></a></p>";
				}
	}
	elseif(isset($_GET["type"]) && strcasecmp(htmlspecialchars($_GET["type"]), "personne") == 0 && isset($_GET["id"])){
			$id =htmlspecialchars($_GET["id"]);
			$requete= "SELECT * FROM personne where id = $id";
		
			$result = mysql_query($requete);
			$personne = mysql_fetch_array($result);
			echo "
					<div class=\"alert alert-danger\" role=\"alert\" style='text-align: center;font-size:24px;margin-right:4%'>
					   Êtes-vous sûr de vouloir supprimer <strong>".$personne["prenom"]." ".$personne["nom"]."</strong> de l'annuaire ? 
					</div>

					<div class='row'>
			
						<div class='col-md-6'>
							<a href=\"index.php?page=adminList\"  style='float:right; width:50%'><input type=\"button\" name=\"reset\" value=\"Annuler\" class=\"btn btn-warning\"></a>
						</div>
						<div class='col-md-6' style='float:right'>
							<form method=\"POST\"  >
								<input type=\"hidden\" name=\"idPerson\" value=\"".$_GET["id"]."\">
								<input type=\"submit\" value=\"Valider\" name=\"\" class=\"btn btn-success\">
							</form>
						</div>
					</div>
						";
		}

	elseif (isset($_GET["type"]) && strcasecmp(htmlspecialchars($_GET["type"]), "categorie") == 0 && isset($_GET["id"])) {
		
		$id =htmlspecialchars($_GET["id"]);
			$requete= "SELECT * FROM categorie where id = $id";
		
			$result = mysql_query($requete);
			$categorie = mysql_fetch_array($result);
			echo "
					<div class=\"alert alert-danger\" role=\"alert\" style='text-align: center;font-size:24px;margin-right:4%'>
					   Êtes-vous sûr de vouloir supprimer  la catégrie <strong>".$categorie["designation"]."</strong> ? 
					</div>

					<div class='row'>
			
						<div class='col-md-6'>
							<a href=\"index.php?page=adminAdmin\"  style='float:right; width:50%'><input type=\"button\" name=\"reset\" value=\"Annuler\" class=\"btn btn-warning\"></a>
						</div>
						<div class='col-md-6' style='float:right'>
							<form method=\"POST\"  >
								<input type=\"hidden\" name=\"idCategorie\" value=\"".$_GET["id"]."\">
								<input type=\"submit\" value=\"Valider\" name=\"\" class=\"btn btn-success\">
							</form>
						</div>
					</div>
						";
	}

if(isset($_POST["idPerson"])){
	
	$id = htmlspecialchars($_POST["idPerson"]);
	$query = "SELECT * FROM personne where id =$id";
	$personne = mysql_fetch_array(mysql_query($query));
	if ($personne["url_photo"]) {
		# code...
			if(remove_image($personne["url_photo"])){
				$requete = "DELETE from `personne` where id = $id";
				if(mysql_query($requete)){
					header('Location: index.php?page=adminList&done=true&type=personne');
				}else{
					header('Location: index.php?page=adminList&done=false&type=personne');
				}

			}else{
				header('Location: index.php?page=adminList&done=false&type=personne');
			}
	}else{
		$requete = "DELETE from `personne` where id = $id";
		if(mysql_query($requete)){
			header('Location: index.php?page=adminList&done=true&type=personne');
		}else{
			header('Location: index.php?page=adminList&done=false&type=personne');
		}
	}

	
	mysql_close();
	//echo "<script> alert(\"".$_POST["idToRemoveT"]."\");</script>";
	
}
if(isset($_POST["idCategorie"])){
	
	$id = htmlspecialchars($_POST["idCategorie"]);			
	if(removeCategorie($id)){
		header("Location: index.php?page=adminAdmin&done=true&type=categorie");
	}else{
		//header("Location: index.php?page=adminAdmin&status=failure");
	}
}


if (isset($_POST["designation"]) && isset($_POST["ajouter"])) {
			$designation =htmlspecialchars($_POST["designation"]);
			if(ajouterCategorie($designation)){
				header("Location: index.php?page=adminAdmin&done=true&type=categorie");
			}else{
				header("Location: index.php?page=adminAdmin&done=false&type=categorie");
			}
		}
if (isset($_POST["designation"]) && isset($_POST["modifier"]) && isset($_POST["cat_id"])) {
	$designation =htmlspecialchars($_POST["designation"]);
	$id = htmlspecialchars($_POST["cat_id"]);
	if(modifierCategorie($designation,$id)){
		header("Location: index.php?page=adminAdmin&done=true&type=categorie");
	}else{
		header("Location: index.php?page=adminAdmin&done=false&type=categorie");
	}
}

// 
 ?>