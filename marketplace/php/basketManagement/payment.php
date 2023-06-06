<?php
    session_start();
    //Include
    include '../function/sqlCmd.php';
    include 'basketFunction.php';
    include 'reduction.php';
    //-

    $basketTab = toBasketTab($_SESSION['basket']);

    require '../../sql/db-config.php';
    try{
        $options = [
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_EMULATE_PREPARES => false
        ];
        $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);  

        foreach($basketTab as $element){

            $product = explode(":", $element);
            $productId = $product[0];
            if (!isset($product[1])) {
                $product[1] = null;
            }
            $nBuy = $product[1];

            if($nBuy > 0){

                //--Partie StatVente
                //On recupere les stats actuel du produits
                $sql = "SELECT product_stats, id_compagny, product_price FROM marketplace_product WHERE id_product = ".$productId.";";
                $list = sqlSearch($PDO, $sql);
                
                $idCompagny = $list[0]["id_compagny"];
                $price = $list[0]["product_price"]*reduction($PDO)*$nBuy;               
                $actualMonth = date('F');

                $productStats = json_decode($list[0]["product_stats"], true);
                if($productStats["lastSaleMonth"] != $actualMonth){
                    $productStats[$actualMonth] == 0;
                }
                $productStats[$actualMonth] += $nBuy;
                $productStats["lastSaleMonth"] = $actualMonth;
              
                //ON met a jour
                $sql = "UPDATE marketplace_product SET product_stats = '".json_encode($productStats)."' WHERE id_product = ".$productId.";";
                $request = $PDO->prepare($sql);
                $request->execute();  
                
                //--Partie CA
                $sql = "SELECT compagny_turnover, id_contract FROM marketplace_compagny WHERE id_compagny = ".$idCompagny.";";
                $list = sqlSearch($PDO, $sql);
                $idContract = $list[0]["id_contract"];
                
                $productStats = json_decode($list[0]["compagny_turnover"], true);
                if($productStats["lastSaleMonth"] != $actualMonth){
                    $productStats[$actualMonth] == 0;
                }
                $productStats[$actualMonth] += $price;
                $productStats["lastSaleMonth"] = $actualMonth;
                
                //ON met a jour
                $sql = "UPDATE marketplace_compagny SET compagny_turnover = '".json_encode($productStats)."' WHERE id_compagny = ".$idCompagny.";";
                $request = $PDO->prepare($sql);
                $request->execute(); 

                //--Partie CA phoenix
                //Si ce n'est pas phoenix
                if($idCompagny > 1){
                    $sql = "SELECT contract_commission FROM marketplace_contract WHERE id_contract = ".$idContract.";";
                    $list = sqlSearch($PDO, $sql);
                    $commission = $list[0]["contract_commission"];

                    $sql = "SELECT compagny_turnover FROM marketplace_compagny WHERE id_compagny = 1;";
                    $list = sqlSearch($PDO, $sql);
                    
                    $productStats = json_decode($list[0]["compagny_turnover"], true);
                    if($productStats["lastSaleMonth"] != $actualMonth){
                        $productStats[$actualMonth] == 0;
                    }
                    $productStats[$actualMonth] += $price*$commission/100;
                    $productStats["lastSaleMonth"] = $actualMonth;

                    $sql = "UPDATE marketplace_compagny SET compagny_turnover = '".json_encode($productStats)."' WHERE id_compagny = 1;";
                    $request = $PDO->prepare($sql);
                    $request->execute();
                }
            }
        }  
        //--Part Purchase
        //On retire du panier les produits acheté 0 fois
        $data = json_decode($_SESSION['basket'], true);
        $data = array_filter($data, function($value) {
            return $value !== 0;
        });
        $basket = json_encode($data);

        $sql = "SELECT id_customer FROM marketplace_customer WHERE id_user = '".$_SESSION['id']."';";
        $list = sqlSearch($PDO,$sql);
        $idCustomer = $list[0]['id_customer'];

        $sql = "INSERT INTO `marketplace_purchase`(`id_customer`, `purchase_date`, `purchase_basket`, `purchase_adress`)
        VALUES
        ('".$idCustomer."','".date('Y-m-d')."','".$_SESSION['basket']."','".$_GET['adress']."');";
        $request = $PDO->prepare($sql);
        $request->execute();

        //--Part archive
        $sql = "SELECT id_customer FROM marketplace_customer WHERE id_user = '".$_SESSION['id']."';";
        $list = sqlSearch($PDO,$sql);
        $idCustomer = $list[0]['id_customer'];

        $sql = "INSERT INTO `marketplace_archive`(`id_customer`, `purchase_date`, `purchase_basket`, `purchase_adress`)
        VALUES
        ('".$idCustomer."','".date('Y-m-d')."','".$_SESSION['basket']."','".$_GET['adress']."');";
        $request = $PDO->prepare($sql);
        $request->execute();

    }
    catch(PDOExeption $pe){
        echo 'ERREUR : '.$pe->getMessage();
    }    

    $_SESSION['basket'] = "{}"; 
    header('Location: ../../index.php');

?>