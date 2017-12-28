<?php 
$i =0;
	// requete de selection des inscrits
	$query = "SELECT * FROM personne";

	$results = mysql_query($query,$db) or die("Impossible d'effectuer la selection sur la table persone");
	$nbre_inscrit = mysql_num_rows($results);
	if ($nbre_inscrit>0) {
		# code...
		if(isset($_GET["done"]) && strcasecmp(htmlspecialchars($_GET["done"]), "true") == 0){
		include("success_page.php");
	}
	elseif (isset($_GET["done"]) && strcasecmp(htmlspecialchars($_GET["done"]), "false") == 0) {
		include("failure_page.php");
	}
	echo "<div id='container' class='fond-table'>
				
	            <table class=\"table table-bordered table-striped table-info\">
	            <caption style='padding-left:10px;'> il y a <strong>$nbre_inscrit</strong> personne(s) inscrite(s)</caption>
	            <button type=\"button\" class=\"btn btn-primary\" style='float:right'>
				  <a href='index.php?page=adminAdd' style='text-decoration:none;color:#fff'>Ajouter une personne <span class=\"badge badge-light\">+</span></a>
				</button>
					<tr>
						<th>N°</th>
						<th>Nom</th>
						<th>Prénom</th>
						<th>Sexe</th>
						<th>Catégorie</th>
	                    <th>Âge</th>
	                    <th>Inscrit depuis</th>
	                    <th>Actions</th>
					</tr>";
				$nbr = 1;
	while ($personne = mysql_fetch_array($results)) {
		# code...
		echo "
				<tr class=''>
					<td>".$nbr."</td>
					<td style='text-transform:uppercase'>".$personne["nom"]."</td>
					<td>".$personne["prenom"]."</td>
					<td>".$personne["sexe"]."</td>
					<td>".getCategorieDesignationById($personne["categorie_id"])."</td>
                    <td>".$personne["age"]." ans </td>
                    <td>";
                    if ( ageInscription($personne["date_inscription"]) == 0) {
                    	echo "Aujourd'hui";
                    }elseif ( ageInscription($personne["date_inscription"])==1) {
                    	echo "Hier";
                    }elseif ( ageInscription($personne["date_inscription"])%7==0) {
                    	if(ageInscription($personne["date_inscription"])/7==1){
                    		echo  (strval(ageInscription($personne["date_inscription"]))/7)." semaine";
                    	}
                    	else{
                    		echo  (strval(ageInscription($personne["date_inscription"]))/7)." semaines";
                    	}
                    }else  {
                    	echo strval(strval(ageInscription($personne["date_inscription"])))." Jours";
                    }
                   

                    echo "</td>
                    <td style='text-align:center; font-size:18px;'>
	                    <a href='index.php?page=confirmation&type=personne&id=".($personne["id"])."' style='text-decoration:none'>
	                    <span class=\"glyphicon glyphicon-trash\" data-toggle=\"tooltip\"  style='color:red;'title='supprimer'></span>           
	                    </a>&nbsp
	                   <a href='index.php?page=consultation&id=".$personne["id"]."'> <span title='consulter' data-toggle=\"tooltip\" class=\"glyphicon glyphicon-eye-open\"></span></a>&nbsp;
	                   <a href='index.php?action=modifperso&id=".$personne["id"]."'> <span title='modifier' data-toggle=\"tooltip\" class=\"glyphicon glyphicon-pencil\"></span></a>&nbsp;
	                   <a href='index.php?page=modifpersoPhoto&id=".$personne["id"]."'> <span title='modifier la photo' data-toggle=\"tooltip\" class=\"glyphicon glyphicon-camera\"></span></a>
                    </td>

				</tr>";

				$nbr++;
			  
	}
	echo "</table></div>";  
	}else{
		include("aucune_donnees.php");
	}

	 
	mysql_close();

 ?>