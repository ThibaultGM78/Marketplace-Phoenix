<?php

// file containing the parameters to connect to the sql database
require 'sql/db-config.php';

function livreur()
{

    for ($i = 0; $i< $_SESSION['nb_adresse'] ; $i++)
    {
      $adresse[$i] = $_SESSION['etape'][$i];
      $colis[$i] = $_SESSION['colis'][$i];
    }



    // get address nb
    $nb_adresse = $_SESSION['nb_adresse'];

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

        $j++;
        $duree_trajet_min = NULL;
        $_SESSION['duree_trajet'] = $temp_livraison;


    }

    $_SESSION['nb_adresse'] = $j;
    
    
}