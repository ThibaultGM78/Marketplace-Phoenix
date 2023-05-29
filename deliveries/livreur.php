<?php

// file containing the parameters to connect to the sql database
require 'sql/db-config.php';

include "Retrieveaddress.php";
include "optimizeroute.php";

session_start();


try
{
    // we connect to MySQL
    $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);
}

// Show error message when there is a problem with MySQL
catch(Exception $e)
{
    die('Erreur : '.$e->getMessage());
}

// query to update addresses by removing spaces
$req_supp_espace = $PDO->prepare("UPDATE marketplace_purchase SET purchase_adress = REPLACE(purchase_adress, ' ', '')");

$req_supp_espace->execute();

$req_supp_espace->closeCursor();


// query to update addresses by removing spaces
$req_supp_espace = $PDO->prepare("UPDATE marketplace_archive SET purchase_adress = REPLACE(purchase_adress, ' ', '')");

$req_supp_espace->execute();

$req_supp_espace->closeCursor();

//prepare the request
$req = $PDO->prepare('SELECT * from marketplace_purchase order by purchase_date');

//request for unsebscribed customers
$requnsub = $PDO->prepare('SELECT mp.purchase_adress, mp.purchase_basket
FROM marketplace_purchase AS mp
LEFT JOIN marketplace_customer AS mc ON mp.id_customer = mc.id_customer
WHERE mc.id_customer IS NULL;');


//request for subscribed customers
$reqsub = $PDO -> prepare('SELECT mp.purchase_adress,  mp.purchase_basket
FROM marketplace_customer AS mc
JOIN marketplace_purchase AS mp ON mc.id_customer = mp.id_customer
JOIN marketplace_subscription AS ms ON mc.id_subscription = ms.id_subscription
');


//send list of parameters
$req->execute();
$reqsub->execute();
$requnsub->execute();

switch ($_SESSION['permis']) {
    case "A":
        $nb_max_commandes = 3;
        break;
    case "B":
        $nb_max_commandes = 15;
        break;
    case "C":
        $nb_max_commandes = 40;
        break;
    default:
        break;
}

listeCommandes($reqsub, $requnsub, $nb_max_commandes ,$PDO);

//livreur();

if (!empty($_SESSION['etape'][0]))
{

  // allows to write the different stages of delivery
  echo "<h3> Les différentes étapes de livraison sont :</h3>";
  echo "<ol>";
  echo "<li><b>".$_SESSION['etape'][0]."</b></li>";
  for ($i=1; $i<$_SESSION['nb_adresse']; $i++)
  {
      echo "<li><b>".$_SESSION['etape'][$i]."</b></li>";
      

      // We remove the characters ""","}" , "{" and "'".
      $caracter = array("\"","'", "{", "}");
      $chaine = str_replace($caracter, "", $_SESSION['colis'][$i]);

      // split the string into multiple delimited chunks using ","
      $basketTab = explode(",",$chaine);
      
      // connaitre la taille du tableau obtenu
      $taille = count($basketTab);

      echo "<ul>";
      for ($j=0; $j<$taille; $j++)
      {
          $var = explode(":",$basketTab[$j]);


          //preparer la requet
          $request = $PDO->prepare("SELECT product_name FROM marketplace_product WHERE id_product= ? ");

          $request->execute([$var[0]]);                

          $donnees = $request->fetch();

          $produit = $donnees['product_name'];  
          
          $request->closeCursor();
          

          echo "<li>".$var[1]." ".$produit."</li>";
      }
      echo "<br></ul>";

    }
    echo "</ol>";



    // convertir la duree du trajet en heure:minute:seconde
    $date =  date('H:i:s', mktime(0, 0, $_SESSION['duree_trajet'], 0, 0, 00));

    echo "<br>Le temps du trajet estimé est de <b>".$date."</b><br>";

    echo "<form method='post' action='archive.php'>";
    echo "<input type='submit' value='Livraison terminé'>";
    echo "</form>";

    echo "<form method='post' action='archive.php'>";
    echo "<input type='submit' value='Optimiser le Trajet'>";
    echo "</form>";

}

/*
//Arreter le traitement de la requette MySQL
$req->closeCursor();*/

?>

<!DOCTYPE html>
<html>
  <head>
    <title>Affichage d'étapes</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="./js/map.js"></script>
    <link rel="stylesheet" type="text/css" href="./css/map.css">
    <style>
      body {
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        align-items: center;
        height: 100vh;
        margin: 20px 0 0 0; /* Ajout d'une marge en haut de 20px */
        background: #f8f9fa;
      }
      #floating-panel {
        text-align: center;
        padding: 20px;
        border-radius: 5px;
        background: #ffffff;
        box-shadow: 0px 0px 10px rgba(0,0,0,0.1);
      }
      #container {
        width: 100%;
        max-width: 900px;
        margin-top: 20px;
      }
    </style>
  </head>
  <body>
    <div id="floating-panel" class="mb-3">
      <strong>Start:</strong>
      <select id="start" class="form-control mb-2">
        <?php
          for ($i=0; $i<$_SESSION['nb_adresse']; $i++) {
            echo "<option value=".$_SESSION['etape'][$i].">Etape ".($i+1)."</option>";
          }
        ?>
      </select>
      <strong>End:</strong>
      <select id="end" class="form-control mb-2">
        <?php
            for ($i=0; $i<$_SESSION['nb_adresse']; $i++) {
                echo "<option value=".$_SESSION['etape'][$i].">Etape ".($i+1)."</option>";
            }
        ?>
      </select>
    </div>
    <div id="container">
      <div id="map"></div>
      <div id="sidebar"></div>
    </div>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB04_7zWKon7pqwnfihrhWGdKusU5fUGc4&callback=initMap&v=weekly" defer></script>
    <div>
      <br><br>
    </div>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
  </body>
</html>
