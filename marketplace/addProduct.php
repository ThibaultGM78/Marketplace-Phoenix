<?php
    //session
    session_start();
    $_SESSION['id_compagny'] = 1;
    //include
    include "php/saveProduct.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Ajouter un Produit</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>
    <?php
            include 'structure/header.php'
        ?>
    <div class="d-flex justify-content-center align-items-center page-container" id="addPD">
        <div class="interieurAddProduct">
            <h1>Ajouter un Produit</h1>
            <form method="post" class="text-center" onsubmit="return validateForm()" enctype="multipart/form-data">

                <div class="labName">
                    <label for="name" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Entrez le nom du produit">
                </div>

                <div class="labName">
                    <label for="category" class="form-label">Categorie</label>
                    <input type="text" class="form-control" id="category" name="category"
                        placeholder="Entrez la categorie du produit"></div>

                <div class="labName">
                    <label for="desc" class="form-label">Description</label>
                    <input type="text" class="form-control" id="desc" name="desc"
                        placeholder="Entrez la description du produit"></div>

                <div class="labName">
                    <label for="price" class="form-label">Prix</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price"
                        placeholder="Entrez le prix"></div>

                <div class="labName">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" step="1" class="form-control" id="stock" name="stock"
                        placeholder="Entrez le prix"></div>

                <div class="labName">
                    <label for="img" class="form-label">Image</label>
                    <input type="file" id="img" name="img" accept="image/png, image/jpeg" required>
                </div>

                <button type="submit"
                    class="btn mt-5 rounded-pill btn-lg btn-custom2 btn-block text-uppercase">Valider</button>
            </form>
        </div>
    </div>
</body>
<?php include 'structure/footer.php' ?>
<script src="../verifProduct.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>

</html>