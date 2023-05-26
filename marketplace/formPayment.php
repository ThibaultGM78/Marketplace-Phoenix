<?php
    session_start();
    //Include
    include 'php/basketManagement/verifFormPayment.php';
    include 'php/function/field.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>MarketPlace</title>
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <?php
            include 'structure/header.php';
        ?>

          <div class="content" style="text-align: center">

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
                    $msgError = "Veuillez entrer votre code postale.";
                    field('postal',$classField,"Code postale",$classLabel,$classInput,'text',$classSpan,'errorPostal',$classError,$msgError,$value,$errors);
                     
                ?>

                <input type="submit" value="Soumettre">

            </form>
    
          </div>  

        <?php
            include 'structure/footer.php';
        ?>
    </body>
</html>