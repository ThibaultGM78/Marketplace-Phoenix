<?php
    function toBasketTab($basketData){ 

        //On retire les caractere "{","}" et """ afin de creer un tableau ou chaque compartiment contient un article et le nombre d'unite de ce dernier mis au panier par l'utilisateur.
        $basketJSON = preg_replace('({)', '', $basketData);
        $basketJSON = preg_replace('(})', '', $basketJSON);
        $basketJSON = preg_replace('(")', '', $basketJSON);
 
        $basketTab = explode(",",$basketJSON);
        return $basketTab;
    }

    function basketField($fieldId,$productId,$nBuy, $reduction, $list, $isCalculatingTotal){

        if($_SESSION['role'] != 'compagny'){

            $unitePrice = $list[0]['product_price'] * $reduction;

            $price = $unitePrice * $nBuy;

            echo '
                <link rel="stylesheet" type="text/css" href="css/productDetails.css">
                <button type="button" onclick="minus('.$fieldId.','.$isCalculatingTotal.')">-</button>

                <input  type="hidden" id="stockV'.$fieldId.'" value="'.$list[0]['product_stock'].'">

                <input name="number" id="basket'.$fieldId.'" style="width: 30px;" value="'.$nBuy.'" disabled>
                
                <input type="hidden" id="ref'.$fieldId.'" value="'.$productId.'">    
                
                <button type="button" onclick="plus('.$fieldId.','.$isCalculatingTotal.')">+</button>  
                <br>

                <button type="button" onclick="deleteElement('.$fieldId.','.$isCalculatingTotal.')">Supprimer</button> 
                <input type="hidden" id="price'.$fieldId.'" value="'.$unitePrice.'">
            <input name="number" class="displayNumber" id="group'.$fieldId.'" style="width: 30px;" value="'.$price.'" disabled>€';

        } 
    }
?>