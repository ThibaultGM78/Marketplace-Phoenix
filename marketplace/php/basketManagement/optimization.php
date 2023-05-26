<?php

    session_start();
    include '../function/sqlCmd.php';
    include 'basketFunction.php';

    $basketTab = toBasketTab($_SESSION['basket']);
    $JSON = json_decode('{}');

    require '../../sql/db-config.php';
    try{
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ];
        $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);  
        
        //Pour chaque element trouve le prix le moins chere
        foreach($basketTab as $element){

            $product = explode(":", $element);
            $productId = $product[0];
            $nBuy = $product[1];
     
            $sql = 'SELECT * 
                FROM marketplace_product
                WHERE product_name = (
                    SELECT product_name 
                    FROM marketplace_product 
                    WHERE id_product = '. $productId.'
                )
                ORDER BY product_price;
            ';
            $list = sqlSearch($PDO,$sql);

            $productId = $list[0]['id_product'];
            $JSON->$productId = $nBuy;

        }  

        //Met a jour le panier
        $_SESSION['basket'] = json_encode($JSON);

    }
    catch(PDOExeption $pe){
        echo 'ERREUR : '.$pe->getMessage();
    }   

    header('Location: ../../basket.php');
?>