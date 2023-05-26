<?php

    include 'php/function/sqlCmd.php';

    //On creer un tableau ressencant les erreurs potentielles.
    $errors = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //On recupere les donnees du formulaire.
        $login = $_POST['login'];
        $password = $_POST['password'];
    
        //On verifie que le champ n'est pas vide.
        if($login == ""){
            $errors['login'] = "error";//S'il y a une erreur on ressance qu'il y a une erreur a cet endroit-la.
        }
        //On verifie que le champ n'est pas vide.
        if($password == ""){
            $errors['password'] = "error";
        }
    
        //Verification dans la db
        require 'sql/db-config.php';
        try{
            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);   

            $sql = "SELECT * FROM marketplace_user WHERE user_login = '".$login."';";
            $list = sqlSearch($PDO,$sql);

            if($list == null){
                $errors['login'] = "error";
            }
            else if($list[0]['user_passwd'] != $password){
                $errors['password'] = "error";
            }
            else{
                $role =  $list[0]['user_role'];
                $id = $list[0]['id_user'];
            }
  
        }
        catch(PDOExeption $pe){
            echo 'ERREUR : '.$pe->getMessage();
        }

        if(empty($errors)){
            $_SESSION['login'] = $login;
            $_SESSION['role'] = $role;
            $_SESSION['id'] = $id;
    
            header('Location: index.php');//L'utilisateur est redirige sur la page d'accueil du site.
        }
    }
?>
<!--S*-->