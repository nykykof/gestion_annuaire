<?php 
	if (isset($_GET["id"])) {
		# code...
		$id=htmlspecialchars($_GET["id"]);
		$requete = "SELECT * FROM personne where id = $id";
		$resultat = mysql_query($requete);
		$personne = mysql_fetch_array($resultat);
	}
 ?>

<div class="row" style=" margin-left: -50px">
	<h1 style="font-weight: bold;text-align: center;text-decoration: underline;margin-bottom: 50px;">Fiche d'identité personnelle</h1>
	<div class="col-md-8 col-xs-12" style="font-size: 24px;padding-left: 50px">
		
		<p>Prénoms: <span class="text-info" style="font-style: italic;"><?php echo $personne["prenom"] ?></span></p>
		<p>Nom:<span class="text-info" style="font-style: italic;"><?php echo $personne["nom"] ?></span> </p>
		<p>Sexe:<span class="text-info" style="font-style: italic;"> <?php echo $personne["sexe"] ?></span></p>
		<p>Age: <span class="text-info" style="font-style: italic;"><?php echo $personne["age"] ?> ans</span></p>
		<p>Catégorie: <span class="text-info" style="font-style: italic;"><?php echo getCategorieDesignationById($personne["categorie_id"]) ?></span></p>
		<p>Email: <span class="text-info" style="font-style: italic;"><?php echo "<a href=\"mailto:".(email($personne['nom'],$personne['prenom']))."?subject=votre demande de renseignement\">".(email($personne['nom'],$personne['prenom']))."</a>" ?></span></p>
	</div>
	<div class="col-md-4" style=""><p><?php 

		if(!$personne["url_photo"]){
                if(strcasecmp($personne["sexe"], "Féminin") == 0) {
                    # code...
                     echo" <img src=\"images/icone-femme.jpg\" style='float:right'/>";
                }else{
                    echo" <img src=\"images/icone-homme.png \" style='float:right'/>";
                }
                        
        }else{
            echo "<img src=\"".$personne["url_photo"]."\" style='float:right;height:70%;width:70%'/>";
        }

	 ?></p></div>
</div>