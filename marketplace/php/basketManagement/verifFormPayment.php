<?php

include 'php/function/sqlCmd.php';
include 'api/googleApi.php';

//On crée un tableau resencant les erreurs potentielles.
$errors = [];

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    //On recupere les donnees du formulaire.
    $adress = $_POST['adress'];
    $city = $_POST['city'];
    $postal = $_POST['postal'];

    //Verif si non nul
    if($adress == ""){
        $errors['adress'] = "error";
    }
    if($city == ""){
        $errors['city'] = "error";
    }
    if($postal == ""){
        $errors['postal'] = "error";
    }
    
    if(empty($errors)){

        $finalAdress = $adress.", ".$city.", ".$postal;

        //Verification a l'aide de l'api google de la validité de l'adresse
        $adress_encodee = urlencode($finalAdress);
        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=".$adress_encodee."&key=".$key;

        $result = file_get_contents($url);
        $data = json_decode($result, true);

        if ($data['status'] === 'OK') {
            $adresse = 'Av.duParc,95000Cergy';

            $url = "https://maps.googleapis.com/maps/api/distancematrix/json?destinations=".$adresse."&origins=".$adress_encodee."&units=imperial&key=".$key;
            $data = file_get_contents($url);

            // Convert content to JSON format
            $json = json_decode($data,true);

            // Check if the conversion to json format went well, if there is a problem, we write this error message
            if ($json === null && json_last_error() !== JSON_ERROR_NONE) {
                echo 'Erreur lors de la conversion en JSON : ' . json_last_error_msg();
            } 

            // get trip duration and convert it to int
            $duree_trajet = (int)$json['rows'][0]['elements'][0]['duration']['value'];

            if ($duree_trajet > 26000)
            {
                echo '<script src="js/alert.js"></script>';
                echo '<script> alertDuree(); </script>';

                $errors['finalAdress'] = "error";

            }

        } 
        
        
        else 
        {
            echo '<script src="js/alert.js"></script>';
            echo '<script> alertAdresse(); </script>';
            $errors['finalAdress'] = "error";
        }

        
    }

    
    if(empty($errors)){
        header('Location: php/basketManagement/payment.php?adress='.$finalAdress);
    }
   
}
?>
<!--S*-->