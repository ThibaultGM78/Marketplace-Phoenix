<?php
    session_start();
    //On creer le panier de l'utilisateur. Qui sera stocke dans les donnees de session sous format JSON.
    if(empty($_SESSION['basket'])) {
        $_SESSION['basket'] = "{}"; 
    }
    if(empty($_SESSION['role'])){
        $_SESSION['role'] = "customer"; 
    }
?>
<!DOCTYPE html>
<html>

<head>
    <title>MarketPlace</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.js"></script>
</head>

<body>
    <?php
        include 'structure/header.php';
    ?>

    <div class="container-fluid">
        <div class="row">
            <!-- slider banner	 -->
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <a href="productDetails.php?id=8"><button class="btn btn-3">Voir le produit</button></a>
                    </div>
                    <div class="carousel-item">
                        <a href="productDetails.php?id=7"><button class="btn btn-3">Voir le produit</button></a>
                    </div>
                    <div class="carousel-item">
                    <a href="productDetails.php?id=9"><button class="btn btn-3">Voir le produit</button></a>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </a>
            </div>
        </div>
        <!-- scripts -->
        <!-- bootstrap javascript cdn -->
        <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js">
        </script>

    </div>

    <?php
            include 'structure/footer.php';
        ?>
</body>

</html>