<?php

// file containing the parameters to connect to the sql database
require 'sql/db-config.php';

session_start();
$_SESSION['etape'] = array();
$_SESSION['colis'] = array();
$_SESSION['nb_adresse'];
$_SESSION['duree_trajet'];




// function to retrieve the number of products for an address
function recuperer_nb_produit($chaine){

    // We remove the characters ""","}" , "{" and "'".
    $caracter = array("\"", "{", "}");
    $chaine = str_replace($caracter, "", $chaine);

    // separate the character string into several delimited pieces using ","
    $basketTab = explode(",",$chaine);
    
    // know the size of the array obtained
    $taille = count($basketTab);

    $nb_produit = 0;

    // loop to retrieve the number of products needed for this address
    for ($i=0; $i<$taille; $i++)
    {
        $var = explode(":",$basketTab[$i]);
        $nb_produit += (int)$var[1];
    }
    
    return $nb_produit;
}







function livreur($req, $PDO){

    $i = 1;

    $adresse[0] = 'Av.duParc,95000Cergy';
    $colis[0] = '';

    // loop to retrieve all delivery addresses in the database and put them in an array
    while ($donnees = $req->fetch()){

        $adresse[$i] = $donnees['purchase_adress'];
        $colis[$i] = $donnees['purchase_basket'];
        $i++;
    }




    // get address nb
    $nb_adresse = $i;

    $duree_trajet_min = NULL; 


    $temp_livraison = (int)0;
    $nombre_colis_total = (int)0;


    $j = 0;

    $_SESSION['duree_trajet'] = 0;

    $indice = 0;

    // continues until the time is less than the set time
    $continue = 1;

    while (($continue == 1) && ($nb_adresse != 0))
    {

        // put the first address of the base = starting address
        $_SESSION['etape'][$j] = $adresse[$indice];
        $_SESSION['colis'][$j] = $colis[$indice];

        if ($indice != $nb_adresse-1)
        {
            $adresse[$indice] = $adresse[$nb_adresse-1];
            $colis[$indice] = $colis[$nb_adresse-1];
        }
        
        $nb_adresse --;

        for ($i = 0; $i < $nb_adresse; $i++)
        {

          // Fetch content from API
          include 'api/googleApi.php';
          $url = "https://maps.googleapis.com/maps/api/distancematrix/json?destinations=".$_SESSION['etape'][$j]."&origins=".$adresse[$i]."&units=imperial&key=".$key;
          $data = file_get_contents($url);

          // Convert content to JSON format
          $json = json_decode($data,true);

          // Check if the conversion to json format went well, if there is a problem, we write this error message
          if ($json === null && json_last_error() !== JSON_ERROR_NONE) {
              echo 'Erreur lors de la conversion en JSON : ' . json_last_error_msg();
          } 

          // get trip duration and convert it to int
          $duree_trajet = (int)$json['rows'][0]['elements'][0]['duration']['value'];              

          // compares the duration of the journey with the shortest duration
          if (($duree_trajet_min == NULL) || ($duree_trajet_min > $duree_trajet))
          {
              $duree_trajet_min = $duree_trajet;
              $indice = $i;
          }

        }


        $temp_livraison += $duree_trajet_min;
        
        // retrieve the number of parcels from the address to add and add it to the number of parcels already modified
        $nombre_colis_total += recuperer_nb_produit($colis[$indice]);

        
        // if the number of packages is greater than the maximum quantity authorized for the vehicle then we stop
        if ($nombre_colis_total > 15)
        {
            $continue = 0;
        }
        

        // if the estimated travel time is greater than 15,000 seconds then we stop
        else if ($temp_livraison > 15000)
        {
            // stop
            $continue = 0;
        }

        else if (($temp_livraison < 15000) && ($nombre_colis_total < 15))
        {
            $j++;
            $duree_trajet_min = NULL;
            $_SESSION['duree_trajet'] = $temp_livraison;
        }


    }

    $_SESSION['nb_adresse'] = $j;
    
    
}







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

//send list of parameters
$req->execute();

livreur($req,$PDO);

if (!empty($_SESSION['etape'][0]))
{

  // allows to write the different stages of delivery
  echo "<h3> Les différentes étapes de livraison sont :</h3>";
  echo "<ol>";
  echo "<li>".$_SESSION['etape'][0]."</li>";
  for ($i=1; $i<=$_SESSION['nb_adresse']; $i++)
  {
      echo "<li>".$_SESSION['etape'][$i]."</li>";
      

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


}


//Arreter le traitement de la requette MySQL
$req->closeCursor();

?>

<!DOCTYPE html>

<html>
  <head>
    <title>Affichage d'étapes</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
    <script src="../js/map.js"></script>
    <link rel= "stylesheet" type="text/css" href="../css/map.css">
  </head>
  <body>
    <div id="floating-panel">
      <strong>Start:</strong>
      <select id="start">

        <?php
        for ($i=0; $i<=$_SESSION['nb_adresse']; $i++)
        {
            echo "<option value=".$_SESSION['etape'][$i].">Etape ".($i+1)."</option>";

        }
        ?>

      </select>
      <br />
      <strong>End:</strong>
      <select id="end">
        <?php
            for ($i=0; $i<=$_SESSION['nb_adresse']; $i++)
            {
                echo "<option value=".$_SESSION['etape'][$i].">Etape ".($i+1)."</option>";

            }
            ?>
      </select>
      <br />
      <!--<b>Mode of Travel: </b>
      <select id="mode">
        <option value="DRIVING">Driving</option>
        <option value="WALKING">Walking</option>
        <option value="BICYCLING">Bicycling</option>
        <option value="TRANSIT">Transit</option>
      </select> -->
    </div>
    <div id="container">
      <div id="map"></div>
      <div id="sidebar"></div>
    </div>
    <!--<div style="display: none">
      <div id="floating-panel">
        <strong>Start:</strong>
        <select id="start">
          <option value="chicago, il">Chicago</option>
          <option value="st louis, mo">St Louis</option>
          <option value="joplin, mo">Joplin, MO</option>
          <option value="oklahoma city, ok">Oklahoma City</option>
          <option value="amarillo, tx">Amarillo</option>
          <option value="gallup, nm">Gallup, NM</option>
          <option value="flagstaff, az">Flagstaff, AZ</option>
          <option value="winona, az">Winona</option>
          <option value="kingman, az">Kingman</option>
          <option value="barstow, ca">Barstow</option>
          <option value="san bernardino, ca">San Bernardino</option>
          <option value="los angeles, ca">Los Angeles</option>
        </select>
        <br />
        <strong>End:</strong>
        <select id="end">
          <option value="chicago, il">Chicago</option>
          <option value="st louis, mo">St Louis</option>
          <option value="joplin, mo">Joplin, MO</option>
          <option value="oklahoma city, ok">Oklahoma City</option>
          <option value="amarillo, tx">Amarillo</option>
          <option value="gallup, nm">Gallup, NM</option>
          <option value="flagstaff, az">Flagstaff, AZ</option>
          <option value="winona, az">Winona</option>
          <option value="kingman, az">Kingman</option>
          <option value="barstow, ca">Barstow</option>
          <option value="san bernardino, ca">San Bernardino</option>
          <option value="los angeles, ca">Los Angeles</option>
        </select>
      </div>
    </div>-->
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB04_7zWKon7pqwnfihrhWGdKusU5fUGc4&callback=initMap&v=weekly"
      defer
    ></script>
  </body>
</html>
    