<?php
    //Il manque une verification php
    include "php/function/sqlCmd.php";

    // Vérifie si des données ont été soumises
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        //On recupere les donnees du formulaire.
        $name = $_POST['name'];
        $price = $_POST['price'];
        $category = $_POST['category'];
        $stock = $_POST['stock'];
        $desc =  $_POST['desc'];
        $img =  $_POST['img'];
       
        //SQL
        require 'sql/db-config.php';
        try{
            $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
            ];

            $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);   

            //Id compagny
            $sql = "SELECT id_compagny FROM marketplace_compagny WHERE id_user = '".$_SESSION['id']."';";
            $list = sqlSearch($PDO,$sql);
            $idCompagny = $list[0]['id_compagny'];
                
            //On recupere les donnee de l'entreprise
            //Dans le but de savoir dans quel dossier mettre l'image du produit
            $sql = 'SELECT compagny_name FROM marketplace_compagny WHERE id_compagny = '.$idCompagny;
            $results = $PDO->prepare($sql);
            $results->execute();

            $list = $results->fetchALL(PDO::FETCH_ASSOC);
            $nameCompagny = $list[0]['compagny_name'];
            $results->closeCursor();

            //On creer le dossier
            $dossier = 'img/compagny/'.$nameCompagny;
            if (!file_exists($dossier)) {
                mkdir($dossier, 0777, true);
            }


            // Récupérer le nom du fichier
            $nomImage = $_FILES['img']['name'];

            //On sauvegarde l'image dans le dossier image de l'entreprise
            $imgTmp = $_FILES['img']['tmp_name'];
            if (isset($imgTmp)) { 
                $imgPath = 'img/compagny/'.$nameCompagny.'/'.$nomImage ;
                move_uploaded_file($imgTmp, $imgPath);
            }

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
                "lastSaleMonth": "January"
            }';
            
            //On injecte le produit dans la base de données
            $sql = "INSERT INTO `marketplace_product`(`product_name`, `product_price`, `product_category`, `product_stock`, `product_desc`, `product_img`, `id_compagny`, `product_stats`)
            VALUES
            ('".$name."','".$price."','".$category."','".$stock."','".$desc."', 'img/compagny/".$nameCompagny."/".$nomImage."',".$idCompagny.",'".$monthJSON."');";

            $request = $PDO->prepare($sql);
            $request->execute();    
        }
        catch(PDOExeption $pe){
            echo 'ERREUR : '.$pe->getMessage();
        }
        header('Location: index.php');
    } 
?>