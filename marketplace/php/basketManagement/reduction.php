<?php
    //Trouve le pourcentage de reduction accore au client en fonction de son abonnement
    function reduction($PDO){
 
        $reduction = 1;

        //Si l'utilisateur n'est pas connectée
        if(empty($_SESSION['id'])){
            return 1;
        }

        $sql = 'SELECT * 
            FROM marketplace_subscription s
            JOIN marketplace_customer c ON c.id_subscription = s.id_subscription
            JOIN marketplace_user u ON u.id_user = c.id_user
            WHERE u.id_user = '.$_SESSION['id'].'
            GROUP BY c.id_subscription, u.id_user
        ';
        $list = sqlSearch($PDO,$sql);

        //Verifie si la reduction est encore active
        if(!empty($list[0]) && strtotime($list[0]['subscription_end']) > strtotime(date('Y-m-d'))){
            //Convertie le reduction du format x % a 0,x 
            $reduction = (100 - $list[0]['subscription_reduction'])/100;
        }
  
        return $reduction;
    }
?>