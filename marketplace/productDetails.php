<?php
    session_start();
    include 'php/function/sqlCmd.php';
    include 'php/basketManagement/basketFunction.php';
    include 'php/basketManagement/reduction.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>PHOENIX</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/productDetails.css">

    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>
    <?php
include 'structure/header.php';
require 'sql/db-config.php';
try {
    $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
    ];
    $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);

    $productId = $_GET['id'];
    $basketJSON = json_decode($_SESSION['basket']);
    $nBuy = empty($basketJSON->$productId) ? 0 : $basketJSON->$productId;

    $sql = 'select * from marketplace_product where id_product='.$productId.';';
    $list = sqlSearch($PDO,$sql);

    $reduction = reduction($PDO);
    $unitePrice = $list[0]['product_price'] * $reduction;

    echo '<div class="container my-5">';
    echo '<div class="row">';
    echo '<div class="col-md-6">';
    echo '<img src="'.$list[0]['product_img'].'" class="img-fluid rounded"></img><br>';
    echo '</div>';
    echo '<div style="text-align: center;';
    echo '<div class="col-md-6">';
    echo '<h2>'.$list[0]['product_name'].'</h2><br>';
    echo '<p class="lead">'.$list[0]['product_desc'].'</p><br>';
    echo '<h3><strong>'.$unitePrice.'€</strong></h3><br>';

    if($list[0]['product_stock'] == 0){
        echo '<p>Rupture de stock</p>';
    }
    if($list[0]['id_compagny'] == 1){
        echo '<p>Produit vendu par votre marketplace Phoenix</p>';
    }
    else{
        $sql = "SELECT compagny_name FROM marketplace_compagny WHERE id_compagny = ".$list[0]["id_compagny"].";";
        $list2 = sqlSearch($PDO, $sql);
        echo '<p>Entreprise: '.$list2[0]["compagny_name"].'</p>';

    }
    basketField(0,$productId,$nBuy,$reduction,$list,false);
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    echo '<hr>';

    //Produits similaires
    echo '<div class="container my-5">';
    echo '<h3>Produits similaires</h3>';
    $sql = 'SELECT * FROM marketplace_product WHERE product_name = 
    (SELECT product_name FROM marketplace_product WHERE id_product = '. $productId.');';
    $list = sqlSearch($PDO,$sql);

    echo '<div class="row">';
    //Afficher chaque produit une par une
    foreach($list as $element) {
        if($element['id_product'] != $productId) {
            $id = $element['id_product'];
            echo '<div class="col-md-4">';
            echo '<div class="card">';
            echo '<a href="productDetails.php?id='.$id.'">';
            echo '<img src="'.$element['product_img'].'" class="card-img-top">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">'.$element['product_name'].'</h5>';
            echo '<p class="card-text">'.$element['product_desc'].'</p>';
            echo '<p class="card-text"><strong>'.$element['product_price'].'€</strong></p>';
            echo '</div>';
            echo '</a>';
            echo '</div>';
            echo '</div>';
        }
    }
    echo '</div>';
    echo '</div>';
} catch(Exception $pe) {
    die('Erreur : '.$pe->getMessage());
}

?>
    <?php
    include 'structure/footer.php';
?>
    <script src="js/basket.js"></script>
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