<?php
//Ce fichier php ajoute au panier une seul unite de l'article choisi au panier de l'utilisateur. Et remet les stocks a jour.
session_start();

//Variables permettant de voir a la fin de la procedure si cette derniere c'est bien deroule.//Variables permettant de voir a la fin de la procedure si cette derniere c'est bien deroule.
$success = 0;
$msg = "Une erreur est survenue (error2)";

//On verifie que les donnees necaissaire au bon fonctionnement du programme sont presentes.
if(!empty($_POST['ref'])){
    //On recupere les donnees.
    $productId = htmlspecialchars(strip_tags($_POST['ref']));

    /*On ajoute une unite du produit au panier*/
    //On recupere les donnees du panier en decodant le JSON contenue dans $_SESSION['basket'].
    $data = $_SESSION['basket'];
    $basket = json_decode($data);

    //On ajoute au panier une seul unite de l'article choisi.
    $basket->$productId += 1;

    //On met le panier a jour en encodant le JSON et en le stockant dans $_SESSION['basket'].
    $_SESSION['basket'] = json_encode($basket);

    /*On retire une unite du produit dans les stocks*/
    //SQL

    require '../../sql/db-config.php';
    try{
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);      

        $sql = "UPDATE marketplace_product SET product_stock = product_stock  - 1 where id_product = '".$productId."'";
        $request = $PDO->prepare($sql);
        $request->execute();    
    }
    catch(PDOExeption $pe){
        echo 'ERREUR : '.$pe->getMessage();
    }
    //La procedure est un succes.
    $success = 1;

} else $msg = "Veuillez renseigner tous les champs (error3)";//Affiche un message d'erreur sinon.

//On affiche les informations suivantes dans la console afin de voir comment la procedure s'est deroule.
$res = ["success" => $success, "msg" => $msg];
echo json_encode($res);
?>