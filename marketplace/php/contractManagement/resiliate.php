<?php
    //session
    session_start();
    include "../function/sqlCmd.php";
    require '../../sql/db-config.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Résiliation du Contrat</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="../../css/style.css">

    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>
    <header>
        <!-- navbar top -->
        <div class="container">
            <div class="navbar-top">
                <div class="social-link">
                    <a href="index.php"><i><img src="../../img/logo.png" alt="" width="90"></i></a>
                </div>
                <div class="logo">
                    <h3>PHOENIX</h3>
                </div>
                <div class="icons">
                    <i><img src="" alt="" width="20px"></i>
                    <?php
                    if($_SESSION['role'] == 'compagny'){
                        echo '<div class="input-box">
                            <form method="post" onsubmit="return validateForm()" action="../../market.php" class="mb-3">
                                <input type="text" id="category" name="category" placeholder="Rechercher...">
                                <span class="icon">
                                    <i class="uil uil-search search-icon"></i>
                                    <i><img src="" id="decal" alt="" width="30px"></i>
                                </span>
                                <i class="uil uil-times close-icon"></i>
                            </form>
                        </div>';
                    }
                    else{
                        echo '
                        <div class="input-box">
                            <form method="post" onsubmit="return validateForm()" action="../../market.php" class="mb-3">
                                <input type="text" id="category" name="category" placeholder="Rechercher...">
                                <span class="icon">
                                    <i class="uil uil-search search-icon"></i>';

                                if(!empty($_SESSION['id'])){
                                    echo '<a href="../../../deliveries/php/history.php"><i><img src="../../img/historique.png" alt="" width="25px"></i></a>';
                                }

                                echo '<a id="decal" href="../../basket.php"><i><img src="../../img/shopping-cart.png"  alt="" width="30px"></i></a>
                                </span>
                                <i class="uil uil-times close-icon"></i>
                            </form>
                        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
        </div>
        <!-- navbar top -->

        <!-- main content -->

        <nav class="navbar navbar-expand-md" id="navbar-color">
            <div class="container">
                <!-- Toggler/collapsibe Button -->
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                    <span><i><img src="../../img/menu.png" alt="" width="30px"></i></span>
                </button>

                <!-- Navbar links -->
                <div class="collapse navbar-collapse" id="collapsibleNavbar">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="../../index.php">Accueil</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../../market.php">Marche</a>
                        </li>

                        <?php

                if($_SESSION['role'] == 'compagny'){
                    echo '<li class="nav-item"><a class="nav-link" href="../../addProduct.php">Ajouter un produit</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="../../dashboard.php">Tableau de bord</a></li>';
                    echo '<li class="nav-item dropdown">';

                    if($_SESSION['id'] != 1){
                        echo '
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Contrat</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="../../php/contractManagement/resiliate.php">Résilier</a>
                                <a class="dropdown-item" href="../../php/contractManagement/renewal.php">Renouveler</a>
                                <a class="dropdown-item" href="../../php/contractManagement/signContract.php">Signer</a>
                            </div>
                        </li>';
                    }
                   
                }
                if($_SESSION['role'] == 'customer'){
                    echo '
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Abonnement</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="../../php\subscriptionManagement\suscribe.php">Souscrire</a>
                        </div>
                    </li>';
                }        
                if(empty($_SESSION['login'])){
                    echo '<li><a class="nav-link" aria-current="page" href="../../connection.php">Connexion</a></li>';
                }
                else{
                    echo'<li><a class="nav-link" aria-current="page" href="../../php/userManagement/logout.php">Deconnexion</a></li>';
                }
                ?>
                    </ul>
                </div>
            </div>
        </nav>

        <script>
            let inputBox = document.querySelector(".input-box"),
                searchIcon = document.querySelector(".icon"),
                closeIcon = document.querySelector(".close-icon");
            searchIcon.addEventListener("click", () => inputBox.classList.add("open"));
            closeIcon.addEventListener("click", () => inputBox.classList.remove("open"));
        </script>
    </header>

    <div class="centered">
        <h1>Résiliation du contrat</h1>
        <?php
            include 'actualContract.php';
        ?>
        <form action="resiliate.php" method="post">
            <button name="resilier" value="resilier">Je résilie mon contrat </button>
            <button name="revenir"> Je souhaite revenir à l'accueil</button>
        </form>
    <?php
    // Vérifie si des données ont été soumises
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['resilier'])) {
            //SQL
            
            try{
                if(!empty($list[0]['contract_end'])){
                    // desactive les contraintes de cle etrangeres
                    $delete = "SET FOREIGN_KEY_CHECKS=0;";
                    $request = $PDO->prepare($delete);
                    $request->execute();
                    //Supprime le contrat
                    $sql = "DELETE FROM marketplace_contract
                    WHERE id_compagny ='".$idCompagny."';";
                    echo $sql;
                    $request = $PDO->prepare($sql);
                    $request->execute();
                    // reactive les contraintes de clés etrangeres
                    $add = "SET FOREIGN_KEY_CHECKS=1;";
                    $request = $PDO->prepare($add);
                    $request->execute();
                    echo "<p style='font-weight:bold; color:red;'>Opération réussie, votre contrat a bien été résilié !</p>";
                    //L'utilisateur est ensuite redirige sur la page d'accueil.
                    echo "<script type='text/javascript'>document.location.replace('../../index.php');</script>";
                    exit();
                }
                else {
                    echo('<p class="centered"; style="font-size: 20px; font-weight: bold; color : red;">Vous ne pouvez pas résilier un contrat si vous n\'en avez pas.</p>');
                }   
            }
            catch(PDOExeption $pe){
                echo 'ERREUR : '.$pe->getMessage();
            }
        }
        /* On redirige le vendeur à l'accueil s'il a appuyé sur le bouton revenir */
        elseif (isset($_POST['revenir'])) {
            echo "<script type='text/javascript'>document.location.replace('../../index.php');</script>";
            exit();
        }
    }
    ?>

    </div>
    <footer id="footer">
        <h1 class="text-center">PHOENIX</h1>
        <div class="icons text-center">
            <i class="bx bxl-twitter"></i>
            <i class="bx bxl-facebook"></i>
            <i class="bx bxl-instagram"></i>
        </div>
        <div class="copyright text-center">
            &copy; Copyright <strong><span>Phoenix</span></strong>. All Rights Reserved
        </div>
        <div class="credite text-center">
            Designed By <a href="#">CY Tech</a>
        </div>
        <br>
    </footer>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>

</body>

</html>