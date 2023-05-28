<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>MarketPlace</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/market.css">

    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</head>
<body>

    <?php include 'structure/header.php' ?>

    <div class="content">
        <div class="col-4 offset-4">

            <!--Barre de recherche-->
            <h2>Rechercher un produit</h2>    
            <form method="post" onsubmit="return validateForm()">
                <div class="mb-3">
                    <label for="category" class="form-label">Categorie</label>
                    <input type="text" class="form-control" id="category" name="category" placeholder="Entrez la categorie du produit">
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>           
            <br>

            <!--Selection de produit -->
            <?php include "php/marketRequest.php" ?>

        </div>
    </div>
    
    
    <!--
    <div class="content">
        <div class="col-4 offset-4">

            <?php include "php/marketRequest.php" ?>

        </div>
    </div> -->

    <?php  include 'structure/footer.php'; ?>
</body>
</html>