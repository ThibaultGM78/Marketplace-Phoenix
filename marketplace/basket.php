<?php
    session_start();
    //Include
    include 'php/function/sqlCmd.php';
    include 'php/basketManagement/basketFunction.php';
    include 'php/basketManagement/reduction.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Panier</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <!-- pour les icons -->
    <script src="js/basket.js"></script>
</head>
<body>

    <?php include "structure/header.php" ?>

    <div class="content">
        <div class="col-md-4 offset-md-4">   
            <?php
                //On convertit la variblae de session sous fomre de JSON contenant le panier en tableau
                $basketTab = toBasketTab($_SESSION['basket']);
                
                //Tant qu'il reste un element a afficher dans le panier.
                echo '<table class="table">';
                require 'sql/db-config.php';
                try{
                    $options = [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false
                    ];
                    $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);  

                    $i = 0;
                    $total = 0;
                    $reduction = reduction($PDO);

                    echo '<tr>';
                    foreach($basketTab as $element){

                    if ($i % 3 == 0)
                    {
                        echo '</tr><tr>';
                    }

                    $product = explode(":", $element);
                    $productId = $product[0];
                    if ( ! isset($product[1])) {
                        $product[1] = null;
                    }
                    $nBuy = $product[1];

                    //Si l'element a été achete
                    //Lorque l'on retire de panier les lement il ne s'efface pas mais tombe a 0;
                    if($nBuy > 0){

                        $sql = 'select * from marketplace_product where id_product='.$productId.';';
                        $list = sqlSearch($PDO,$sql);

                        $total += $nBuy*$list[0]['product_price']*$reduction;

                        echo '<td id="element'.$i.'">
                        <img src="'.$list[0]['product_img'].'" class="img-fluid"></img><br>
                        <h2>'.$list[0]['product_name'].'</h2>'.
                        $list[0]['product_desc'].
                        '<br>';

                        basketField($i,$productId,$nBuy, $reduction, $list, true);

                        echo '</td>';

                        $i++;
                    }
                    }  
                    echo '</tr>';

                }
                catch(PDOExeption $pe){
                    echo 'ERREUR : '.$pe->getMessage();
                }    

                echo '<tr>';
                echo '<h3>Total</h3>';
                echo '<input name="number" id="basketTotal" value="'.$total.'" disabled>';
                echo '</tr>';

                // On ferme le tableau.
                echo '</table>';

                echo '<p><a href="php/basketManagement/optimization.php">Panier au prix le plus bas</a></p>';
                // Si l'utilisateur s'est connecte on lui propose de payer. Sinon on lui propose de se connecter. En le redirigent vers les pages correspondantes.
                if(empty($_SESSION['id'])) echo '<p><a href="connection.php" class="btn btn-dark">Se connecter pour payer</a></p>';
                else echo '<p><a href="formPayment.php" class="btn btn-dark">Payer</a></p>'

            ?>
        </div>
    </div>

    <?php include 'structure/footer.php'; ?>

</body>
<!--S*-->