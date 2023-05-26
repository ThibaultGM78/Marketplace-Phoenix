<?php

    include 'php/function/sqlCmd.php';
    include 'api/googleApi.php';

    //On creer un tableau ressencant les erreurs potentielles.
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
            echo "L'adresse existe.";
            } else {
            echo "L'adresse n'existe pas.";
            $errors['finalAdress'] = "error";
            }
        }

        
        if(empty($errors)){
            header('Location: php/basketManagement/payment.php?adress='.$finalAdress);
        }
       
    }
?>
<!--S*-->