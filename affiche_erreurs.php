 <div class="well" id="erreurs">
 	<h2 style="text-align: center;">Erreurs dans les données transmises</h2>
 	<ul>
 		
 	
 	<?php 
 		if (isset($_SESSION["erreurs"])) {
 			foreach ($_SESSION["erreurs"] as $key => $value) {
 				echo "<li class='text-danger'> <span style='text-transform:capitalize'>".$key.":</span> <strong>".$value."</strong></li>";
 			}
 		}
 	 ?>
 	 </ul>
 	<a href="index.php?page=<?php echo isset($_GET["autre"]) ? $_GET["autre"]:"#" ?>" class="btn btn-warning" >Retour</a>
 </div>