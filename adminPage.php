<?php 
$i =1;
	// requete de selection des inscrits
	$query = "SELECT * FROM categorie";

	$results = mysql_query($query) or die("Impossible d'effectuer la selection sur la table persone");
	/* encart d'eatat */

	if ((isset($_GET["done"]) && strcasecmp(htmlspecialchars($_GET["done"]), "false") == 0)) {
			echo "<div class=\" row alert alert-danger\" role=\"alert\">
				 <div class='col-md-6'> 
				 	<p style=\"text-align: center;font-size: 20px;font-style: italic;\"> Une erreur s'est produite</p>
				 </div>

				 <div class='col-md-6'>
				 ";
				  if($_GET["type"] && strcasecmp(htmlspecialchars($_GET["type"]), "personne") == 0){
					echo "<p style='float:right'><a href=\"index.php?page=adminList\"><input type=\"button\" name=\"reset\" value=\"ok\" class=\"btn btn-success\"></a></p>";
				}
				elseif ($_GET["type"] && strcasecmp(htmlspecialchars($_GET["type"]), "categorie") == 0) {
					echo "<p style='float:right'><a href=\"index.php?page=adminAdmin\"><input type=\"button\" name=\"reset\" value=\"ok\" class=\"btn btn-success\"></a></p>";
				}

			echo "</div>

			</div>";
	}
	elseif (isset($_GET["done"]) && strcasecmp(htmlspecialchars($_GET["done"]), "true") == 0) {
		echo "<div class=\" row alert alert-success\" role=\"alert\">
				 <div class='col-md-6'> 
				 	<p style=\"text-align: center;font-size: 20px;font-style: italic;\"> Action effectuée avec succès !</p>
				 </div>

				 <div class='col-md-6'>
				 ";
				  if($_GET["type"] && strcasecmp(htmlspecialchars($_GET["type"]), "personne") == 0){
					echo "<p style='float:right'><a href=\"index.php?page=adminList\"><input type=\"button\" name=\"reset\" value=\"ok\" class=\"btn btn-success\"></a></p>";
				}
				elseif ($_GET["type"] && strcasecmp(htmlspecialchars($_GET["type"]), "categorie") == 0) {
					echo "<p style='float:right'><a href=\"index.php?page=adminAdmin\"><input type=\"button\" name=\"reset\" value=\"ok\" class=\"btn btn-success\"></a></p>";
				}

			echo "</div>

			</div>";
				
			//include("success_page.php");
	}
	echo "
		<div class='row'> ";
		if (isset($_GET["addCategorie"]) && strcasecmp(htmlspecialchars($_GET["addCategorie"]), "true") == 0) {
		echo "	<div class='col-md-6'	>
					<form method='POST' class='form form-inline'>
		
						<div class='form-group'>
							<label for='designation'>désignation</label>
							<input class='form-control form-control-sm' type='text' required name='designation' placeholder='Entrer une désignation'/>
						</div>
						<input type='submit' name='ajouter' value='Ajouter' class='btn btn-success'>
					</form>
				</div>";
		}elseif (isset($_GET["updateCategorie"]) && strcasecmp(htmlspecialchars($_GET["updateCategorie"]), "true") == 0 && isset($_GET["cat_id"])) {
			$id = htmlspecialchars($_GET["cat_id"]);
			$requete = "SELECT * FROM categorie where id = $id ";
			$resultat = mysql_query($requete);
			$categorie = mysql_fetch_array($resultat);
			echo "	<div class='col-md-6'	>
					<form method='POST' class='form form-inline'>
		
						<div class='form-group'>
							<label for='designation'>désignation</label>
							<input class='form-control form-control-sm' type='text'  value ='".$categorie["designation"]."'required name='designation'/>
							<input  type='hidden'  value ='".$categorie["id"]."' name='cat_id'/>
						</div>
						<input type='submit' name='modifier' value='Modifier' class='btn btn-success'>
					</form>
				</div>";
		}

		else{
		echo "
			<div class='col-md-6'>
				<a href=\"index.php?page=adminAdmin&addCategorie=true\" style=\"text-decoration:none;color:#fff\">
					<button class=\"btn btn-primary\" style=\"float:right\" title=\"Ajouter\" data-toggle=\"tooltip\">
					 	
					 	Ajouter 
						 	<span class=\"badge badge-light\">
						 		<span class=\"glyphicon glyphicon-plus\">
			                    </span> 
			                </span>
		               
					</button>
				</a>
			</div>";
		}
		echo "
		</div>
		<div class='row'>
            <table class=\"table table-bordered table-striped table-info\">
            <caption>Catégories</caption>
				<tr>
					<th>N°</th>
					<th>Désignation</th>
                    <th>Actions</th>
				</tr>";
	while ($categorie = mysql_fetch_array($results)) {
		# code...
		echo "
				<tr class=''>
					<td>".$i."</td>
					<td style='text-transform:uppercase'>".$categorie["designation"]."</td>
                    <td style='text-align:center'>
	                    <a href='index.php?page=confirmation&type=categorie&id=".$categorie["id"]."'>
	                    	<span class=\"glyphicon glyphicon-trash\" style='color:red;font-size:18px;' title='Supprimer' data-toggle=\"tooltip\" >
	                    	</span> 
	                    </a>&nbsp;&nbsp;
	                              
	                    <a href='index.php?page=adminAdmin&updateCategorie=true&cat_id=".$categorie["id"]."'> 
	                   		<span class=\"glyphicon glyphicon-pencil\" style='font-size:18px;' title='Modifier' data-toggle=\"tooltip\" >
	                   		</span>
	                    </a>
                    </td>
				</tr>";

				$i++;
			  
	}
	echo "</table></div>";
		//<p class='btn'> <a href='formulaire.php'> Inscrire une autre personne </a> </p>

		

	mysql_close();

 ?>