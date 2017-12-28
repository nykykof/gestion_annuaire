
	<div id="container">
		<?php 
		require("connexion_db.php");
   		 require("fonctions.php");
   		if(isset($_POST["enreg_personne"]) or isset($_POST["modification"])){


			$data = validatonFormulaire($_POST,$_FILES);
			if ($data["valide"]) {
				if(!$_POST["personne_id"]) {
					if(enregistrer_infos($_POST["nom"],$_POST["prenom"],$_POST["sexe"],$_POST["categorie"],$_POST["age"],$_POST["url_facebook"],$_POST["url_linkedin"],$_POST["url_twiter"],$data["photo"]["photo_name"])){

					header("Location: index.php?page=adminList&done=true");

					}else{

						header("Location: index.php?page=adminList&done=false");

					}
				}
				elseif(isset($_POST["personne_id"])){//update case

					$id = htmlspecialchars($_POST["personne_id"]);

					if(updatePerson($id,$_POST["nom"],$_POST["prenom"],$_POST["sexe"],$_POST["categorie"],$_POST["age"],$_POST["url_facebook"],$_POST["url_linkedin"],$_POST["url_twiter"])){

						header("Location: index.php?page=adminList&done=true");

					}else{

						header("Location: index.php?page=adminList&done=false");

					}
				}
			}	else{
				foreach ($data as $key => $value) {
					if(strcasecmp($key,"valide")!=0){
						if(!$value["is_valide"]){
							$erreurs[$key] = $value["erreur"];
						}
						}
				}
				session_start();
				$_SESSION["erreurs"]=$erreurs;
				header("Location: index.php?page=erreur&autre=adminAdd");
			}
		}elseif (isset($_POST["envoie_modif_photo"])) {
				# code...
				$id = htmlspecialchars($_POST["id"]);
				$resultats = modifier_photo($id,$_FILES,$_POST["envoie_modif_photo"]);
				if($resultats["valide"]){
					if(setPhoto($resultats["photo_name"],$id)){
						header("Location: index.php?page=adminList&done=true");
					}else{
						header("Location: index.php?page=adminList&done=false");
					}
				}else{
					$erreur["photo"]=$resultats["erreur"];
					session_start();
					$_SESSION["erreurs"]=$erreur;
					header("Location: index.php?page=erreur&autre=adminList");
				}
			}
		

			mysql_close($db);
		?>

	</div>


