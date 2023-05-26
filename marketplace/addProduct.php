<?php
    //session
    session_start();
    $_SESSION['id_compagny'] = 1;
    //include
    include "php/contractManagement/saveProduct.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Test</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
        <script src="../verifProduct.js"></script>
    </head>
    <body>
        <?php
            include 'structure/header.php'
        ?>
        <div>
            <!--Formulaire d'ajout de produit-->
            <h2>Form</h2>    
            <form method="post" onsubmit="return validateForm()" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Entrez le nom du produit">
                </div>
                <div class="mb-3">
                    <label for="category" class="form-label">Categorie</label>
                    <input type="text" class="form-control" id="category" name="category" placeholder="Entrez la categorie du produit">
                </div>
                <div class="mb-3">
                    <label for="desc" class="form-label">Description</label>
                    <input type="text" class="form-control" id="desc" name="desc" placeholder="Entrez la description du produit">
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Prix</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" placeholder="Entrez le prix">
                </div>
                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" step="1" class="form-control" id="stock" name="stock" placeholder="Entrez le prix">
                </div>
                <div class="mb-3">
                    <label for="img" class="form-label">Image</label>
                    <input type="file" class="form-control" id="img" name="img" accept="image/png, image/jpeg" required>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>           
        </div>
    </body>
</html>