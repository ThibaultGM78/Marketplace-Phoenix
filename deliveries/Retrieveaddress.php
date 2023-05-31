<?php

// file containing the parameters to connect to the sql database
require 'sql/db-config.php';


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

  if ($chaine != '')
  {
    // loop to retrieve the number of products needed for this address
    for ($i=0; $i<$taille; $i++)
    {
      if ($basketTab[$i] != "")
      {
        $var = explode(":",$basketTab[$i]);
        $nb_produit += (int)$var[1];
      }
      
    }

  }

  return $nb_produit;
}



// function that retrieves the delivery addresses as long as the number of packages is lower than the capacity of the delivery person's vehicle.
// The function first retrieves the addresses of customers who have subscribed to a subscription, then those of customers who have not subscribed
function listeCommandes($reqsub, $requnsub, $nb_max_commandes ,$PDO)
{
  //initialize session variables
  $_SESSION['etape'] = array();
  $_SESSION['colis'] = array();
  $_SESSION['nb_adresse'] = 0;

  $i = 1;

  $adresse_s[0] = 'Av.duParc,95000Cergy';
  $colis_s[0] = '';

  $nombre_colis_total = (int)0;
  $nombre_adresse_total = 0;
  $continue = 1;

  // loop to retrieve all delivery addresses of the customers who are subscribed in the database and put them in an array
  while ($donnees = $reqsub->fetch())
  {
    $adresse_s[$i] = $donnees['purchase_adress'];
    $colis_s[$i] = $donnees['purchase_basket'];
    $i++;
  }

  $nb_adresses = $i;

  $i = 0;

  // loop to assign each subscribed customer's delivery and address to the $_SESSION variables
  while (($continue == 1) && ($nb_adresses != 0))
  {
    $nombre_colis_total += recuperer_nb_produit($colis_s[$i]);

    if($nombre_colis_total > $nb_max_commandes) 
    {
      $nombre_colis_total -= recuperer_nb_produit($colis_s[$i]);
      $continue = 0 ;
    }

    else
    {
      $_SESSION['etape'][$i] = $adresse_s[$i];
      $_SESSION['colis'][$i] = $colis_s[$i];

      $nb_adresses--;
      $nombre_adresse_total ++;
      $i++;
    }

  }

  if($continue == 1)
  {

    $j = 0;

    // loop to retrieve all delivery addresses of the customers who aren't subscribed in the database and put them in an array
    while ($donnees = $requnsub->fetch())
    {

      $adresse_u[$j] = $donnees['purchase_adress'];
      $colis_u[$j] = $donnees['purchase_basket'];
      $j++;
      
    }

    $nb_adresses = $j;

    $j = 0;

      
    // loop to assign each unsubscribed customer's delivery and address to the $_SESSION variables
    while (($nb_adresses != 0)&&($continue == 1))
    {

      $nombre_colis_total += recuperer_nb_produit($colis_u[$j]);

      if($nombre_colis_total > $nb_max_commandes) 
      {
        $nombre_colis_total -= recuperer_nb_produit($colis_u[$j]);
        $continue = 0 ;
      }

      else
      {
        $_SESSION['etape'][$i+$j] = $adresse_u[$j];
        $_SESSION['colis'][$i+$j] = $colis_u[$j];

        $nb_adresses--;
        $nombre_adresse_total ++;
        $j++;
      }
    
    }

  }

  $_SESSION['nb_adresse'] = $nombre_adresse_total;

  $duree_trajet = 0;

  // loop to retrieve the delivery time
  for ($i=1; $i<$nombre_adresse_total; $i++)
  {
    // Fetch content from API
    include 'api/googleApi.php';
    $url = "https://maps.googleapis.com/maps/api/distancematrix/json?destinations=".$_SESSION['etape'][$i-1]."&origins=".$_SESSION['etape'][$i]."&units=imperial&key=".$key;
    $data = file_get_contents($url);

    // Convert content to JSON format
    $json = json_decode($data,true);

    // Check if the conversion to json format went well, if there is a problem, we write this error message
    if ($json === null && json_last_error() !== JSON_ERROR_NONE) {
    echo 'Erreur lors de la conversion en JSON : ' . json_last_error_msg();
    } 

    // get trip duration and convert it to int
    $duree_trajet += (int)$json['rows'][0]['elements'][0]['duration']['value'];
  }

  $_SESSION['duree_trajet'] = $duree_trajet;

}

?>