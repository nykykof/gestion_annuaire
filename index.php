<?php 
   require("connexion_db.php");
    require("fonctions.php");
  session_start();
  if(!isset($_SESSION["client"])){
    $char = 'abcdefghijklmnopqrstuvwxyz0123456789';
    $rand_name = str_shuffle($char);
    $_SESSION["client"] = $rand_name;
    $nbre_visiteurs = getVisitorsNumber();
    $nbre_visiteurs++;
    $fp=fopen("compteur.txt", "w");
    fwrite($fp, $nbre_visiteurs);
    fclose($fp);
   // $_SESSION["nbre_visiteurs"]=$nbre_visiteurs;
  }
 ?>
<!DOCTYPE html>
<html>
<head>
	<title>Accueil</title>
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap-3.3.6/dist/css/bootstrap.min.css">
   
    <!-- Latest compiled and minified CSS -->
    <!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"> -->

    <!-- Optional theme -->
    <!-- <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"> -->
    <script type="text/javascript" src="vendor/jquery/jquery-1.11.3.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <!-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" type="text/css" href="vendor/font-awesome-4.7.0/css/font-awesome.min.css">
    <script src="vendor/bootstrap-3.3.6/dist/js/bootstrap.min.js"></script>
     <link rel="stylesheet" type="text/css" href="styles/style.css">
    <meta charset="utf-8"/>
</head>
<body>
    
    <div id="container" class="container">
        <div class=" navbar-fixed-top" style="background-color: #666;">
          <div class="navbar navbar-pills" id="menu">
            <div class="container" style="">
                <div class="navbar-header" >
                <!--     <a class="navbar-brand" href="index.php" style="font-size: 36px;margin-top: -10px;"><i class="fa fa-home"></i></a>  -->
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar" ">
                         <span class="icon-bar"></span>
                         <span class="icon-bar"></span>
                         <span class="icon-bar"></span>
                    </button> 
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li><a href="#" id="administration" data-toggle="modal" data-target="#modalAdmin">Administration</a></li>
                        <li><a href="index.php?page=liste" id="modeListe">Liste</a></li>
                        <li><a href="index.php?page=trombinoscope" id="modeTrombino">Trombinoscope</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                      <li><a href="#"><span class="glyphicon glyphicon-user"></span> S'enregistrer</a></li>
                      <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> S'identifier</a></li>
                    </ul>
                 </div>
            </div>
            
        </div>
        </div>
        <div class="container content">
                <?php
                    if(isset($_GET["page"]) && strcasecmp(htmlspecialchars($_GET["page"]), "liste") == 0){
                        include("liste.php");
                    }
                    elseif (isset($_GET["page"]) && strcasecmp(htmlspecialchars($_GET["page"]), "trombinoscope") == 0) {
                        include("fiche.php");
                    }
                    elseif (isset($_GET["page"]) && strcasecmp(htmlspecialchars($_GET["page"]), "adminAdd") == 0) {
                         include("formulaire.php");
                     }
                     elseif (isset($_GET["page"]) && strcasecmp(htmlspecialchars($_GET["page"]), "adminList") == 0) {
                         include("listeMembresAdmin.php");
                     } 
                     elseif (isset($_GET["remove"]) && strcasecmp(htmlspecialchars($_GET["remove"]), "ok") == 0) {
                         include("listeMembresAdmin.php");

                     }
                     elseif ((isset($_GET["page"]) && strcasecmp(htmlspecialchars($_GET["page"]), "confirmation") == 0) ||(isset($_POST["designation"]))) {
                         include("confirmationSuppression.php");

                     }
                     elseif (isset($_GET["page"]) && strcasecmp(htmlspecialchars($_GET["page"]), "adminAdmin") == 0) {
                         include("adminPage.php");

                     }
                     elseif (isset($_GET["action"]) && strcasecmp(htmlspecialchars($_GET["action"]), "modifperso") == 0) {
                         include("formulaire-modification.php");
                     } 

                     elseif (isset($_GET["page"]) && strcasecmp(htmlspecialchars($_GET["page"]), "modifpersoPhoto") == 0) {
                         include("formulaire-modif-photo.php");
                     } 
                     elseif (isset($_GET["page"]) && strcasecmp(htmlspecialchars($_GET["page"]), "adminStats") == 0 ){
                       # code...
                          include("stats.php");
                     }
                     elseif (isset($_GET["page"]) && strcasecmp(htmlspecialchars($_GET["page"]), "consultation") == 0 ){
                       # code...
                          include("ficheIdentite.php");
                     }elseif (isset($_GET["page"]) && strcasecmp(htmlspecialchars($_GET["page"]), "erreur") == 0 ) {
                         include("affiche_erreurs.php");
                     }
                     else{
                        include("liste.php");// a modifier plus tard
                    }
                   
                ?>
        </div>
        <div class="modal fade" id="modalAdmin" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Choix d'action</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">          
                <div class="navbar navbar-default" >
                    <div class="container">
                        <!-- <div class="navbar-header">
                            <a class="navbar-brand" href="#">Gestion annuaire</a>  
                        </div> -->
                        <div>
                            <ul class="nav navbar-nav">
                                <li><a href="index.php?page=adminAdd" id="">Ajouter</a></li>
                                <li><a href="index.php?page=adminList" id="">Voir liste</a></li>
                                <li><a href="index.php?page=adminStats" id="">Statistiques</a></li>
                                <li><a href="index.php?page=adminAdmin" id="">Administrer le site</a></li>
                            </ul>
                        </div>
                    </div>
                    
                </div>

              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Quiter</button>
                <!-- <button type="button" class="btn btn-primary">Quiter</button> -->
              </div>
            </div>
          </div>
        </div>

        <!-- footer -->
        <div class="container" >
          <div class="navbar navbar-pills navbar-fixed-bottom " style="background-color: #ccc">
           <h5 style="text-align: center;">&copy Tout droit réservé</h5>
            
        </div>
        </div>
    </div>
    <script type="text/javascript" src="js/scripts.js"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip(); 
        });
    </script>
</body>
</html>