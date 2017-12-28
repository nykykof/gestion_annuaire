
<?php
   
    $nbre_article_per_page=6;

	/*$results = mysql_query($query,$db) or die("Impossible d'effectuer la selection sur la table persone");*/
    $nbre_pages = compute_page_numbers($nbre_article_per_page,select_all());
    if(isset($_GET["trombinoPage"])){
        $results = select_with_pagination($nbre_article_per_page,htmlspecialchars($_GET["trombinoPage"]));
    }else{
        $results = select_with_pagination($nbre_article_per_page,1);
    }
    
	$nbre_inscrit = mysql_num_rows($results);
    if($nbre_inscrit>0){
        echo "<div class='container'>";
      while($personne = mysql_fetch_array($results) ){
          echo " 
          
    <div id=\"bloc\" class=\"col-xs-6 col-md-4\">
        <div id=\"head\" class=\"row\">
            <div id=\"infos\" class=\"col-md-5\">
                <strong id=\"nom\">".$personne['nom']."</strong><br>
                <span id=\"prenom\">".$personne['prenom']."</span><br>
                <span id=\"age\">".$personne['age']." ans</span>
            </div>
            <div id=\"photo\" class=\"col-md-7\"> 
            <a href='index.php?page=consultation&id=".$personne["id"]."'>";

            if(!$personne["url_photo"]){
                if(strcasecmp($personne["sexe"], "Féminin") == 0) {
                    # code...
                     echo" <img src=\"images/icone-femme.jpg\"/>";
                }else{
                    echo" <img src=\"images/icone-homme.png\"/>";
                }
                        
            }else{
                echo "<img src=\"".$personne["url_photo"]."\"/>";
            }
            echo "<a/>
            </div>
        </div>
        <div class=\"row\" id=\"info_perso\" >
            <p>
                <span> Courriel: <a href=\"mailto:".(email($personne['nom'],$personne['prenom']))."?subject=votre demande de renseignement\">".(email($personne['nom'],$personne['prenom']))."</a> </span><br>
                
            </p>
        </div>
        <div id=\"foot\" class=\"row\">";
            if ($personne['url_facebook']) {
                echo "
                    <!--Facebook-->
                 <a href='".$personne['url_facebook']."' target='_blank'><button type=\"button\" class=\"  btn btn-fb\" style='background-color:#3B5998;color:#fff'><i class=\"fa fa-facebook left\"></i></button></a>";
            }
            if ($personne['url_twitter']) {
                # code...
                echo "
                     <!--Twitter-->
                    <a href='".$personne['url_twitter']."' target='_blank'> <button type=\"button\" class=\"btn btn-tw\" style='background-color:#55ACEE;color:#fff'><i class=\"fa fa-twitter left\"></i> </button></a>
                    ";
            }
            if ($personne['url_google']) {
                # code...
                echo "
                    <!--Google +-->
                   <a href='".$personne['url_google']."' target='_blank'> <button type=\"button\" class=\"btn btn-gplus\" style='background-color:#DD4B39;color:#fff'><i class=\"fa fa-google-plus left\"></i></button></a>";
            }
           if ($personne['url_linkedin']) {
               # code...
            echo "
                    <!--Linkedin-->
                   <a href='".$personne['url_linkedin']."' target='_blank'> <button type=\"button\" class=\" btn btn-li\" style='background-color:#007BB6;color:#fff'><i class=\"fa fa-linkedin left\"></i></button></a>";
           }
           if (!$personne['url_linkedin'] && !$personne['url_google'] && !$personne['url_twitter'] && !$personne['url_facebook']) {
              echo "<span style='color:#fff'>". $personne['prenom']." n'a pas de pages personnelles</span>";
           }
           
           echo "
        </div>
    </div>
          ";
      }
      /* Gestion de la pagination */
      echo "</div>
      <ul class=\"pagination pagination-lg\">";
      $i=1;
      while ($nbre_pages>0) {
          # code...
        if(!isset($_GET["trombinoPage"])){
            if($i==1){
                 echo " <li  class='active'><a href=\"index.php?page=trombinoscope&trombinoPage=$i\">".$i."</a></li>";
            }else{
                 echo " <li><a href=\"index.php?page=trombinoscope&trombinoPage=$i\">".$i."</a></li>";
            }
        }else{
            if (htmlspecialchars($_GET["trombinoPage"]) == $i) {
                echo " <li class='active'><a href=\"index.php?page=trombinoscope&trombinoPage=$i\" >".$i."</a></li>";
            }else{
                 echo " <li><a href=\"index.php?page=trombinoscope&trombinoPage=$i\">".$i."</a></li>";
            }
        }
       
        $i++;
        $nbre_pages--;
      }
      echo"
        </ul>
      ";
    }else{
        include("aucune_donnees.php");
    }
  mysql_close();
?>
