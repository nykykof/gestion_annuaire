<?php


	function email($nom,$prenom){
        $domaine = "telecom-bretagne.eu";
		$result = [];
		// remove spaces
		$nom=str_replace(" ", "-", $nom);
		$nom=preg_replace("['|\"|\#|&|\.|$|£|=|\-|\+]", "", $nom);#(\W+)(^ )
		$prenom=str_replace(" ", "-", $prenom);
		$prenom=preg_replace("[\W+^ ]", "", $prenom);

		// remove accente
		$nom=preg_replace('[é|è|ê|ë]', 'e', $nom);
		$nom=preg_replace('[ö|ô]', 'o', $nom);
		$nom=preg_replace('[î|ï]', 'i', $nom);
		$prenom=preg_replace('[é|è|ê|ë]', 'e', $prenom);
		$prenom=preg_replace('[ö|ô]', 'o', $prenom);
		$prenom=preg_replace('[î|ï]', 'i', $prenom);

         $email = $prenom.".".$nom."@".$domaine;
		return $email;

	}


	function validatonFormulaire($request,$photo){
		$retour = ["nom"=>["is_valide"=>true],
					"prenom"=>["is_valide"=>true],
					"age"=>["is_valide"=>true],
					"sexe"=>["is_valide"=>true],
					"categorie"=>["is_valide"=>true]
					];
		$valide= true;

		$retour["valide"]=$valide;
		if(!isset($request["nom"]) or strlen($request["nom"]) < 2){
			$retour["nom"] = ["is_valide"=>false,"erreur"=>"Entrer un nom valide (au moins deux caractères)"];
			$valide= false;
			$retour["valide"]=$valide;
		}
		if (!isset($request["prenom"]) or strlen($request["prenom"]) < 2) {
			# code...
			$retour["prenom"] = ["is_valide"=>false,"erreur"=>"Entrer un Prénom valide (au moins deux caractères)"];
			$valide= false;
			$retour["valide"]=$valide;
		}
		if (!isset($request["age"]) or $request["age"]<=0 or $request["age"]>110) {
			# code...
			$retour["age"] = ["is_valide"=>false,"erreur"=>"Entrer un âge valide (compris entre 0 et 110 ans)"];
			$valide= false;
			$retour["valide"]=$valide;
		}
		if(!isset($request["sexe"])){
			$retour["sexe"] = ["is_valide"=>false,"erreur"=>"Choisir le sexe svp"];	
			$valide= false;
			$retour["valide"]=$valide;
		}
		if (!isset($request["categorie"])  or $request["categorie"] == "--Selectionner--") {
			# code...
			$retour["categorie"] = ["is_valide"=>false,"erreur"=>"Choisir une Catégorie svp"];
			$valide= false;
			$retour["valide"]=$valide;
		}
		if(isset($request["enreg_personne"])){
			$photo_uploaded = traitement_photo($photo,$request["submit"]);
		if ($photo_uploaded["state"]!=0) {
			# code...
			if ($photo_uploaded["state"]==-1) {
				# code...
				$message_error = "Erreur d'upload";
			}
			elseif($photo_uploaded["state"]==1) {
				# code...
				$message_error = "Le fichier n'est pas une image";
			}
			elseif($photo_uploaded["state"]==2) {
				# code...
				$message_error="L'image existe deja";
			}
			elseif($photo_uploaded["state"]==3) {
				# code...
				$message_error="La taille est superieure a la taille limite (2 Mo)";
			}
			elseif($photo_uploaded["state"]==4) {
				# code...
				$message_error="L'image n'est pas au bon format (formats acceptés: jpg, jpeg, png et gif)";
			}
			$retour["photo"] = ["is_valide"=>false,"erreur"=>$message_error];
			$valide= false;
			$retour["valide"]=$valide;
		}else{
			$retour["photo"]["photo_name"] = $photo_uploaded["photo_name"];
			$retour["photo"]["is_valide"] = true;
		}
		}

		

		return $retour;
	}

    function enregistrer_infos($nom,$prenom,$sexe,$categorie,$age,$url_facebook,$url_linkedin,$url_twitter,$url_photo){
    	$temps = date("Y-m-d H:i:s");
        $query = "INSERT INTO personne(nom,prenom,age,categorie_id,sexe,date_inscription,url_facebook,url_linkedin,url_twitter,url_photo) VALUES('$nom','$prenom','$age','$categorie','$sexe','$temps','$url_facebook','$url_linkedin','$url_twitter','$url_photo');";
        if(mysql_query($query)){
            return true;
        }else{
        	echo $query ;
            return false;
        }

    }
    function ageInscription($timestamp){
    	return date("z") - date("z",strtotime($timestamp));
    }
    function cryptId($id){
    	$tab = ["a","b"];
    	return 2*$id +5;
    }

    function ajouterCategorie($designation){
    	$query1="SELECT * FROM categorie where designation='$designation'";
    	$query2 = "INSERT INTO categorie(designation) VALUES('$designation')";
    	$result =  mysql_query($query1);
    	if(mysql_num_rows($result)>0){
    		return false;
    	}else{
    		if(mysql_query($query2)){
    			return true;
    		}
    		return false;
    	}
    }
    function modifierCategorie($designation,$id){
    	$query="UPDATE categorie SET
    			designation='$designation'
    			where id='$id'";
    	if(mysql_query($query)){
    		return true;
    	}

    	return false;
    	
    }

    function removeCategorie($id){
    	$query = "DELETE FROM categorie where id = $id";

    	if(mysql_query($query)){
    		return true;
    	}else{
    		return false;
    	}
    }
/* mettre à jour les informations d'une personnes présente dans la base de données */
     function updatePerson($idperson,$nom,$prenom,$sexe,$categorie,$age,$url_facebook,$url_linkedin,$url_twitter){
        $query = "
        			UPDATE personne SET
        			nom='$nom',
        			prenom='$prenom',
        			age='$age',
        			categorie_id='$categorie',
        			sexe='$sexe',
        			url_facebook='$url_facebook',
        			url_linkedin='$url_linkedin',
        			url_twitter='$url_twitter'
        			WHERE id = $idperson
        		;";
        if(mysql_query($query)){
            return true;
        }else{
            return false;
        }

    }

    function select_with_pagination($nbre_article,$page){
    	$offset = $nbre_article*($page-1);
    	$query ="SELECT * FROM personne 
    			LIMIT  $nbre_article OFFSET $offset;";
    	 return mysql_query($query);
    }
    function select_all(){
    	$query ="SELECT * FROM personne;";
    	 return mysql_query($query);
    }
    function compute_page_numbers($nbre_article_per_page, $query_result){
    	$nbre_pages = 0;
    	$nbr_rows = mysql_num_rows($query_result);
    	if($nbr_rows<$nbre_article_per_page){
    		$nbre_pages = 1;
    	}else{
    		while($nbr_rows>$nbre_article_per_page){
    			$nbre_pages++;
    			$nbr_rows = $nbr_rows-$nbre_article_per_page;
    		}
    		if($nbr_rows>0){
    			$nbre_pages ++;
    		}
    	}

    	return $nbre_pages;
    }

    function traitement_photo($photo,$submit){
    	$retour = ["state"=>true,"photo_name"=>""];
    	$target_dir = "photos/";
    	$char = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$rand_name = str_shuffle($char);
		if($photo["photo"]["size"] >0 ){
			$target_file = $target_dir . basename($photo["photo"]["name"]);
		/*print_r($photo["photo"]);*/
		$uploadOk = 0;
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		$final_target_file = $target_dir.time().$rand_name.".".$imageFileType;
		// Check if image file is a actual image or fake image
		if(isset($submit)) {
		    $check = getimagesize($photo["photo"]["tmp_name"]);
		    if($check !== false) {
		      //  echo "File is an image - " . $check["mime"] . ".";
		        $uploadOk = 0;
		    } else {
		       // echo "File is not an image.";
		        $uploadOk = 1;
		    }
		}
		// Check if file already exists
		if (file_exists($target_file)) {
		    //echo "Sorry, file already exists.";
		    $uploadOk =2;
		}
		// Check file size
		if ($photo["photo"]["size"] > 2000000) {
		   // echo "Sorry, your file is too large.";
		    $uploadOk = 3;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
		    //echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
		    $uploadOk = 4;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk > 0) {
		    //echo "Sorry, your file was not uploaded.";
		    $retour["state"]=$uploadOk;
		    $retour["photo_name"]=null;
		    return $retour;
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($photo["photo"]["tmp_name"], $final_target_file)) {
		       // echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		    	$retour["state"]=0;
			    $retour["photo_name"]=$final_target_file;
			    return $retour;
		    } else {
		       // echo "Sorry, there was an error uploading your file.";
		    	$retour["state"]=-1;
			    $retour["photo_name"]=null;
			    return $retour;
		    }
		}
		}
	}

	function modifier_photo($id,$photo,$submit){
		$id = htmlspecialchars($id);
		$retour = ["valide"=>false,"photo_name"=>"","erreur"=>""];
		$personne = mysql_fetch_array(mysql_query("SELECT * FROM personne where id = $id"));
		if($personne){
			if($personne["url_photo"]){
				remove_image($personne["url_photo"]);
			}
			$photo_uploaded = traitement_photo($photo,$submit);
			if ($photo_uploaded["state"]!=0) {
			# code...
				if ($photo_uploaded["state"]==-1) {
					# code...
					$message_error = "Erreur d'upload";
				}
				elseif($photo_uploaded["state"]==1) {
					# code...
					$message_error = "Le fichier n'est pas une image";
				}
				elseif($photo_uploaded["state"]==2) {
					# code...
					$message_error="L'image existe deja";
				}
				elseif($photo_uploaded["state"]==3) {
					# code...
					$message_error="La taiille est superieure a 2 Mo";
				}
				elseif($photo_uploaded["state"]==4) {
					# code...
					$message_error="L'image n'est pas au bon format";
				}
				$retour["erreur"] = $message_error;
			}else{
				$retour["photo_name"] = $photo_uploaded["photo_name"];
				$retour["valide"] = true;
			}
		}

		return $retour;
	}

	function remove_image($filename){
		return (unlink($filename));
	}
	function stats(){
		$query = "select * from personne;";
		$reslts=mysql_query($query);
		$nbre_total= mysql_num_rows($reslts);
		$nbre_femme=0;
		$nbre_homme=0;
		$nbre_perso_sans_pages_perso=0;
		$nbre_perso_sans_photo=0;
		while ($personne=mysql_fetch_array($reslts)) {
			# code...
			if($personne["sexe"]=="Féminin"){
				$nbre_femme++;
			}else{
				$nbre_homme++;
			}

			if (!$personne["url_facebook"] && !$personne["url_twitter"] && !$personne["url_linkedin"]) {
				# code...
				$nbre_perso_sans_pages_perso++;
			}
			if(!$personne["url_photo"]){
				$nbre_perso_sans_photo++;
			}
		}
		$stats["nbre_total"]=$nbre_total;
		if($nbre_total==0){
			$nbre_total=1;
		}
		$stats["part_femme"]["pourcentage"]=ceil(($nbre_femme/$nbre_total)*100);
		$stats["part_femme"]["total"]=$nbre_femme;

		$stats["part_homme"]["total"]=$nbre_homme;
		$stats["part_homme"]["pourcentage"]=100- ceil(($nbre_femme/$nbre_total)*100);

		$stats["nbre_perso_sans_pages_perso"]["pourcentage"]=ceil(($nbre_perso_sans_pages_perso/$nbre_total)*100);
		$stats["nbre_perso_sans_pages_perso"]["total"]=$nbre_perso_sans_pages_perso;

		$stats["nbre_perso_sans_photo"]["pourcentage"]=ceil(($nbre_perso_sans_photo/$nbre_total)*100);
		$stats["nbre_perso_sans_photo"]["total"]=$nbre_perso_sans_photo;
		return $stats;
	}

	function getVisitorsNumber(){
		$filename = "compteur.txt";
		if (file_exists($filename)) {
			$fp = fopen($filename, "r");
		    $nbre_visiteurs = fread($fp, 512);
		    fclose($fp);
		    return $nbre_visiteurs;
		}else{
			$fp = fopen($filename, "w");
		    $nbre_visiteurs = fwrite($fp, 0);
		    fclose($fp);
		    return 0;
		}

		
	}

	function getCategorieDesignationById($id){
		return mysql_fetch_array(mysql_query("SELECT designation from categorie where id=$id;"))["designation"];
	}

	function setPhoto($url_photo,$id){
		$requete = "UPDATE personne SET url_photo= '$url_photo' WHERE id = $id;";
		if(mysql_query($requete)){
			return true;
		}
		return false;
	}
?>