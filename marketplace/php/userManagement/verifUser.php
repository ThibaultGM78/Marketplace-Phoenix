<?php
    include 'php/function/sqlCmd.php';

    $errors = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        //On recupere les donnees du formulaire.
        $login = $_POST['login'];
        $password = $_POST['password'];
        $password2 = $_POST['password2'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $compagnyName = $_POST['compagnyName'];

        if($compagnyName == ""){
            $compagnyName = $login;
        }

        //On creer un tableau ressencant les erreurs potentielles.

        //On verifie que le champ n'est pas vide.
        if($login == ""){
            $errors['login'] = "error";//S'il y a une erreur on ressance qu'il y a une erreur a cet endroit-la.
        }
        //On verifie que le champ n'est pas vide.
        if($password == ""){
            $errors['password'] = "error";
        }
        //On verifie qu'est les deux mot passes soit les memes.
        if($password2 != $password){
            $errors['password2'] = "error";
        }
        //On verifie le format mail. Soit un nom, un "@"", une plateforme, un "." et une direction.
        if(!preg_match('/[a-z0-9_\-\.]+@[a-z0-9_\-\.]+\.[a-z]+/i', $email)){
            $errors['email'] = "error";
        }
        //On verifie qu'une des 3 fonctions a ete coche.
        if($role != "customer" && $role != "compagny"){
            $errors['fonction'] = "error";
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
            $sql = "SELECT id_user FROM marketplace_user WHERE user_login = '".$login."';";
            $list = sqlSearch($PDO,$sql);

            if($list != null){
                $errors['login'] = "error";
            }

            //On verifie si l'adresse mail existe
            $sql = "SELECT id_user FROM marketplace_user WHERE user_mail = '".$email."';";
            $list = sqlSearch($PDO,$sql);
            
            if($list != null){
                $errors['email'] = "error";
            }

        }
        catch(PDOExeption $pe){
            echo 'ERREUR : '.$pe->getMessage();
        }

        if(empty($errors)){
            header('Location: php/userManagement/saveUser.php?login='.$login.'&password='.$password.'&email='.$email.'&role='.$role.'&compagnyName='.$compagnyName);
        }
    }
?>
<!--S*-->