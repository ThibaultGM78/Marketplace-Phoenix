<?php
    include 'php/function/sqlCmd.php';

    //On creer un tableau ressencant les erreurs potentielles.
    $errors = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //On recupere les donnees du formulaire.
        $login = $_POST['login'];
        $permit = $_POST['permit'];
        

        
        //On verifie que le champ n'est pas vide.
        if($login == ""){
            $errors['login'] = "error";//S'il y a une erreur on ressance qu'il y a une erreur a cet endroit-la.
        }
        //On verifie que le champ n'est pas vide.
        if($permit == ""){
            $errors['permit'] = "error";
        }
       
        //Verification dans la dbv
        require 'sql/db-config.php';
        try{
            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);   

            //On verifie si le login existe
            $sql = "SELECT id_Livreur FROM marketplace_Livreur WHERE nom= '".$login."';";
            $list = sqlSearch($PDO,$sql);

            if($list != null){
                $errors['login'] = "error";
            }
            
        }
        catch(PDOExeption $pe){
            echo 'ERREUR : '.$pe->getMessage();
        }

        if(empty($errors)){
            header('Location: php/saveLivreur.php?login='.$login.'&permit='.$permit);
        }
    }
?>
<!--S*-->