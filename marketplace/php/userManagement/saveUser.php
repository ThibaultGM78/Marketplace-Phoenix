<?php
  
    //On recupere les donnees du formulaire.
    $login = $_GET['login'];
    $password = $_GET['password'];
    $mail = $_GET['email'];
    $role = $_GET['role'];
    $compagnyName = $_GET['compagnyName'];

    if($compagnyName == ""){
        $compagnyName = $login;
    }
    
    //SQL
    require '../../sql/db-config.php';
    try{
        $options = [
            PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_EMULATE_PREPARES => false
        ];

        $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);   

        //On injecte le produit dans la base de donnée
        $sql = "INSERT INTO `marketplace_user`(`user_login`, `user_passwd`, `user_mail`, `user_role`)
        VALUES
        ('".$login."','".$password."','".$mail."','".$role."');";
        
        $request = $PDO->prepare($sql);
        $request->execute();    

        //On recupere l'id user
        $sql = "SELECT id_user FROM marketplace_user WHERE user_mail = '".$mail."';";
        $results = $PDO->prepare($sql);
        $results->execute();

        $list = $results->fetchALL(PDO::FETCH_ASSOC);
        $idUser = $list[0]['id_user'];
        $results->closeCursor();

        //creation user
        if($role == "customer"){
            $sql = "INSERT INTO `marketplace_customer`(`id_user`)
            VALUES
            ('".$idUser."');";
        }
        else{//role = compagny

            $monthJSON = '{
                "January": 0,
                "February": 0,
                "March": 0,
                "April": 0,
                "May": 0,
                "June": 0,
                "July": 0,
                "August": 0,
                "September": 0,
                "October": 0,
                "November": 0,
                "December": 0,
                "lastSaleMonth": ""
            }'; 

            $sql = "INSERT INTO `marketplace_compagny`(`id_user`,`compagny_name`,`compagny_turnover`)
            VALUES
            ('".$idUser."','".$compagnyName."','".$monthJSON."');";
        }
        $request = $PDO->prepare($sql);
        $request->execute();
    }
    catch(PDOExeption $pe){
        echo 'ERREUR : '.$pe->getMessage();
    }

    //On redirige l'utilisateur sur la page de connexion afin qu'il se connecte a son nouveau compte.
    header('Location: ../../index.php');
    
?>
<!--S*-->