<?php
    session_start();
    //Include
    include 'php/basketManagement/verifFormPayment.php';
    include 'php/function/field.php';

    //On verifie si le panier est vide
    function emptyBasket($json) {
        $data = json_decode($json, true); // Convertir le JSON en tableau associatif
      
        if (is_array($data)) {
          foreach ($data as $element) {
            if ($element !== 0) {
              return false;
            }
          }
          echo "Panier vide";
          return true;
        }
      
        return false;
    }

   if(emptyBasket($_SESSION['basket'])){
    header('Location: basket.php');
   }
?>
<!DOCTYPE html>
<html>
<head>
    <title>Paiement</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>
    <body>
        <?php
            include 'structure/header.php';
        ?>

          <div class="content">
            <div class="centered">
            <form method="post">
              
                <?php

                    //Affiche l'adresse ssi elle est nom conforme
                    if(isset($errors["finalAdress"])){
                        echo "<span>". $_POST['adress'].", ".$_POST['city'].", ".$_POST['postal']." n'est pas une adresse valide </span>";
                    }

                    //On standardise les classes
                    $classField = 'mb-3';
                    $classLabel = 'form-label';
                    $classInput = 'form-control';
                    $classSpan = 'd-none';
                    $classError = 'error';
                
                    //Adresse
                    $value = $_POST['adress'] ?? '';
                    $msgError = "Veuillez entrer votre adresse.";
                    field('adress',$classField,"Adresse",$classLabel,$classInput,'text',$classSpan,'errorAdress',$classError,$msgError,$value,$errors);

                    //City
                    $value = $_POST['city'] ?? '';
                    $msgError = "Veuillez entrer votre ville.";
                    field('city',$classField,"Ville",$classLabel,$classInput,'text',$classSpan,'errorCity',$classError,$msgError,$value,$errors);

                    //Postal code
                    $value = $_POST['postal'] ?? '';
                    $msgError = "Veuillez entrer votre code postal.";
                    field('postal',$classField,"Code postal",$classLabel,$classInput,'text',$classSpan,'errorPostal',$classError,$msgError,$value,$errors);
                     
                ?>

                <input class="button" type="submit" value="Soumettre">

            </form>
            </div>
          </div>  

        <?php
            include 'structure/footer.php';
        ?>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </body>
</html>