<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="css/style.css"> 
</head>
<?php

    include 'php/function/sqlCmd.php';
    include 'php/basketManagement/reduction.php';
    

    function displayProduct($req, $PDO){
        echo '<div class="col-md-4 py-3 py-md-0">';
        //afficher chaque ligne une par une
        $i = 0;
        while ($donnees = $req->fetch()) {
            if ($i % 3 == 0) {
                echo '</div><div class="card-deck d-flex justify-content-center">';
            }
    
            $id = $donnees['id_product'];
            $unitePrice = $donnees['product_price'] * reduction($PDO);
            ?>
            <div class="card mb-4" style="width: 18rem;">
                <a href="productDetails.php?id=<?php echo $id; ?>">
                    <img class="card-img-top" src="<?php echo $donnees['product_img']; ?>" alt="<?php echo $donnees['product_name']; ?>">
                </a>
                <div class="card-body">
                    <h5 class="card-title"><?php echo $donnees['product_name']; ?></h5>
                    <p class="card-text"><?php echo $donnees['product_desc']; ?></p>
                    <p class="card-text"><?php echo $unitePrice; ?> €</p>
                </div>
                <div class="card-footer d-flex justify-content-center">
                    <a href="productDetails.php?id=<?php echo $id; ?>" class="btn btn-dark">Voir plus</a>
                </div>
            </div>
            <?php
            $i++;
        }
        echo '</div>';
    }
    
// Vérifie si des données ont été soumises
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require 'sql/db-config.php';
    try
    {
        //on se connecte a MySQL
        $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);
    }

    //Afficher un message d'erreur si problème avec MySQL
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

    /*
    //Recuperer le resultat de la requete sql si l'on sait ce que l'on cherche (telephone)
    $reponse = $bdd->query('select * from marketplace_product where product_category="telephone"');
    */

   //preparer la requet
   $req = $PDO->prepare('SELECT * FROM marketplace_product WHERE product_category LIKE ? OR product_name LIKE ?');
   //transmettre la liste des parametres
   $req->execute(array('%' . $_POST['category'] . '%', '%' . $_POST['category'] . '%'));

    displayProduct($req,$PDO);

    //Arreter le traitement de la requette MySQL
    $req->closeCursor();
}
else{
    require 'sql/db-config.php';
    try
    {
        //on se connecte a MySQL
        $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);
    }

    //Afficher un message d'erreur si problème avec MySQL
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

    /*
    //Recuperer le resultat de la requete sql si l'on sait ce que l'on cherche (telephone)
    $reponse = $bdd->query('select * from marketplace_product where product_category="telephone"');
    */

    //preparer la requet
    $req = $PDO->prepare('select * from marketplace_product ORDER BY id_product LIMIT 45');
    //
    //transmettre la liste des parametres
    $req->execute();

    displayProduct($req,$PDO);

    //Arreter le traitement de la requette MySQL
    $req->closeCursor();
}
?>