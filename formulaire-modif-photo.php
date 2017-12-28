<?php 
	if (isset($_GET["id"])) {
		# code...
		$id = htmlspecialchars($_GET["id"]);
		$result = mysql_query("select * from personne where id = $id");
		if($result){
			$personne = mysql_fetch_array($result);
		}
	
	if (isset($personne)) {
		# code...
	
 ?>

<div class="row">
	<div class="col-md-4" style="padding-top: 100px;">
		<form  action="traitement_formulaire.php" enctype="multipart/form-data" method="POST">
		
		<div class="form-group">
			<label for="modif_photo">Choisir une nouvele photo</label>
			<input type="file" class="form-control" name="photo">
			<input type="hidden" name="id" value="<?php echo $id ?>">
		</div>
		<div>
			<a href="index.php?page=adminList"><input type="button" name="reset" class="btn btn-warning" value="Annuler"></a>
			<input type="submit" name="envoie_modif_photo" class="btn btn-success" value="Modifier">
		</div>			
	</form>
	</div>
	<?php if (isset($personne) && $personne["url_photo"]) {?>
	<div class="col-md-8">
		<div class="row">
			<div class="col-md-12" style="text-align: center; ">
				<?php 
				echo "<img src='".$personne["url_photo"]."'  style='max-height: 400px;max-width: 250px;' />";
				?>
			</div>
			<div class="col-md-12">
				<h4 style="text-align: center;text-decoration: underline;"> Votre photo actuelle</h4>
			</div>
			<?php } ?>
		</div>
			
	</div>
	
</div>
<?php 
}
}
if(!isset($_GET["id"]) or !isset($personne)){

 ?>
 <div class="row">
 	
	<div class="container" >
		<div class="alert alert-danger col-md-10" role="alert" style="border-radius: 5px 0px 0px 5px">
					 <p style="text-align: center;font-size: 20px;font-style: italic;">  Réquête male formée !</p>
		</div>
		<div class="col-md-2" style="padding-left: 0px;">
			<a href="index.php?page=adminList"><input type="button" style="height: 60px;width: 80px;font-size: 18px;border-radius: 0px 5px 5px 0px" name="reset" value="ok" class="btn btn-success"></a>
		</div>

	</div>

	
 </div>
<?php 
}
 ?>