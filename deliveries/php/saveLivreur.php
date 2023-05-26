<?php
  
    //On recupere les donnees du formulaire.
    $login = $_GET['login'];
    $permit = $_GET['permit'];

    //SQL
    require '../sql/db-config.php';
    try{
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);   

        //On injecte le produit dans la base de donnée
        $sql = "INSERT INTO `marketplace_livreur`(`nom`, `typePermis`)
        VALUES
        ('".$login."','".$permit."');";

        echo $sql;
        
        $request = $PDO->prepare($sql);
        $request->execute();    
    }
    catch(PDOExeption $pe){
        echo 'ERREUR : '.$pe->getMessage();
    }

    //On redirige l'utilisateur sur la page de connexion afin qu'il se connecte a son nouveau compte.
    header('Location: ../index.php');
    
?>
<!--S*-->