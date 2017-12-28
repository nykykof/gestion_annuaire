
<?php 

	$stats= stats();
    $nbre_visiteurs = getVisitorsNumber();
 ?>
<div class="row" id="stats">
	<table class="table table-striped table-bordered table-info" style="background-color: #fff;margin-left: -17px;">
		<tr>
			<th>Désignation</th>
			<th>Valeur total</th>
			<th>pourcentage</th>
		</tr>
		<tr>
			<td>Personne de sexe masculin</td>
			<td><?php echo $stats["part_homme"]["total"] ;?></td>
			<td><?php echo $stats["part_homme"]["pourcentage"] ;?>%</td>
		</tr>
		<tr>
			<td>Personne de sexe féminin</td>
			<td><?php echo $stats["part_femme"]["total"] ;?></td>
			<td><?php echo $stats["part_femme"]["pourcentage"] ;?>%</td>
		</tr>
		<tr>
			<td>consultation de l'annuaire</td>
			<td><?php echo $nbre_visiteurs ;?></td>
			<td><?php echo "--" ;?></td>
		</tr>
		<tr>
			<td>Personne sans pages personnelles</td>
			<td><?php echo $stats["nbre_perso_sans_pages_perso"]["total"] ;?></td>
			<td><?php echo $stats["nbre_perso_sans_pages_perso"]["pourcentage"] ;?>%</td>
		</tr>
		<tr>
			<td>Personne sans photo</td>
			<td><?php echo $stats["nbre_perso_sans_photo"]["total"] ;?></td>
			<td><?php echo $stats["nbre_perso_sans_photo"]["pourcentage"] ;?>%</td>
		</tr>

	</table>
	
</div>