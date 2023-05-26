<?php

    //Include
    include '../function/sqlCmd.php';

    $errors = [];

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $nMonth = $_POST['nMonth'];
        $reduction = $_POST['reduction'];

        if($nMonth <= 0 && $nMonth > 12){
            $errors['nMonth'] = "error";
        }
        if($reduction != 10 && $reduction != 20){
            $errors['reduction'] = "error";
        }

        if(empty($errors)){
            
            require '../../sql/db-config.php';
            try{
                $options = [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false
                ];

                $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);  
                
                $sql = "SELECT id_customer FROM marketplace_customer WHERE id_user = '".$_SESSION['id']."';";
                $list = sqlSearch($PDO,$sql);
                $idCustomer = $list[0]['id_customer'];

                //On injecte le produit dans la base de donnée
                $date = new DateTime();
                $date->modify("+$nMonth month");

                $sql = "INSERT INTO `marketplace_subscription`(`subscription_start`, `subscription_end`, `subscription_reduction`, `id_customer`)
                VALUES
                ('".date('Y-m-d')."','".$date->format('Y-m-d')."',".$reduction.",".$idCustomer.");";
                $request = $PDO->prepare($sql);
                $request->execute(); 

                //On met a jour l'abbonnement
                $sql = "SELECT id_subscription FROM marketplace_subscription WHERE id_customer = ".$idCustomer." ORDER BY id_subscription DESC";
                echo $sql;
                $list = sqlSearch($PDO,$sql);
                $idSubscription = $list[0]["id_subscription"];

                $sql = "UPDATE marketplace_customer SET id_subscription = ".$idSubscription." WHERE id_customer =".$idCustomer;
                $request = $PDO->prepare($sql);
                $request->execute();   

        
            }
            catch(PDOExeption $pe){
                echo 'ERREUR : '.$pe->getMessage();
            }
            header('Location: ../../index.php');
        }
    }
?>