<?php 
$i =1;
	// requete de selection des inscrits
	$query = "SELECT * FROM personne";

	$results = mysql_query($query,$db) or die("Impossible d'effectuer la selection sur la table persone");
	$nbre_inscrit = mysql_num_rows($results);

	if ($nbre_inscrit>0) {
		echo "<div id='container' class='fond-table'>
            <table class=\"table table-bordered table-striped table-info\">
            <caption style='padding-left:10px;'> il y a <strong>$nbre_inscrit</strong> personne(s) inscrite(s)</caption>
				<tr>
					<th>N°</th>
					<th>Nom</th>
					<th>Prénom</th>
					<th>Sexe</th>
					<th>Catégorie</th>
                    <th>Âge</th>
                    <th>Actions</th>
				</tr>";
	while ($personne = mysql_fetch_array($results)) {
		# code...
		echo "
				<tr class=''>
					<td>".$i."</td>
					<td style='text-transform:uppercase'>".$personne["nom"]."</td>
					<td>".$personne["prenom"]."</td>
					<td>".$personne["sexe"]."</td>
					<td>".getCategorieDesignationById($personne["categorie_id"])."</td>
                    <td>".$personne["age"]." ans </td>
                    <td style='text-align:center'>
                    	<div class='row'>
	                    	<div class='col-md-6'>
			                    <a href=\"mailto:".(email($personne['nom'],$personne['prenom']))."?subject=votre demande de renseignement\">
			                    	<span class=\"glyphicon glyphicon-envelope\" title='envoyer un mail à ".$personne["prenom"]."' data-toggle=\"tooltip\" >
			                    	</span> 
			                    </a>
		                    </div>
		                              
	   						 <div class=\"dropdown col-md-6\" data-toggle=\"tooltip\" title='pages personelles de ".$personne["prenom"]."'>   					
	   						 	<span class=\"glyphicon glyphicon-user\" dropdown-toggle\" id=\"menu1\" data-toggle=\"dropdown\" >
			                    </span>
							    <ul class=\"dropdown-menu\" role=\"menu\" aria-labelledby=\"menu1\">							     
							      ";  
					              if ($personne['url_facebook']) {
					                echo "
					                   <!--Facebook-->
									<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" href=\"".$personne['url_facebook']."\" target='_blank'>
										<button type=\"button\" class=\"btn btn-fb\" style='background-color:#3B5998;color:#fff'><i class=\"fa fa-facebook left\"></i> Facebook</button>
									 </a></li>";
						            }if ($personne['url_twitter']) {
					                # code...
						                echo "
						                     <!--Twitter-->
											<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" href=\"".$personne['url_twitter']."\" target='_blank'>
											<button type=\"button\" class=\"btn btn-tw\" style='background-color:#55ACEE;color:#fff'><i class=\"fa fa-twitter left\"></i> Twitter</button>
						                     </a></li>";
						            }
						             if ($personne['url_google']) {
						                # code...
						                echo "
						                  <!--Google +-->
									<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" href=\"".$personne['url_google']."\" target='_blank'>
									<button type=\"button\" class=\"btn btn-gplus\" style='background-color:#DD4B39;color:#fff'><i class=\"fa fa-google-plus left\"></i> Google +</button> </a></li>";
						            }
						           if ($personne['url_linkedin']) {
						               # code...
						            echo "
						                   		<!--Linkedin-->
									<li role=\"presentation\"><a role=\"menuitem\" tabindex=\"-1\" href=\"".$personne['url_linkedin']."\" target='_blank'>
									<button type=\"button\" class=\"btn btn-li\" style='background-color:#007BB6;color:#fff'><i class=\"fa fa-linkedin left\"></i> Linkedin</button> </a></li>";
						           }
						           if (!$personne['url_linkedin'] && !$personne['url_google'] && !$personne['url_twitter'] && !$personne['url_facebook']) {
						              echo "<p style='text-align:center'>". $personne['prenom']." n'a pas de pages personneles</p>";
						           	}     
							    echo"  </a></li>
							     
							    </ul>
						  	</div>
						 </div>
                    </td>
				</tr>";

				$i++;
			  
	}
	echo "</table></div>";
	}else{
		include("aucune_donnees.php");
	}
	mysql_close();

 ?>