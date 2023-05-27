<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>

    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/searchbar.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- pour les icons -->
</head>

<body>
    <!-- navbar top -->
    <div class="container">
        <div class="navbar-top">
            <div class="social-link">
                <a href="index.php"><i><img src="img/logo.png" alt="" width="90"></i></a>
            </div>
            <div class="logo">
                <h3>PHOENIX</h3>
            </div>
            <div class="icons">
                <i><img src="" alt="" width="20px"></i>
                <?php
                    if($_SESSION['role'] == 'compagny'){
                        echo '<div class="input-box">
                        <input type="text" placeholder="Rechercher...">
                        <span class="icon">
                            <i class="uil uil-search search-icon"></i>
                            <a href=""><i><img src="" id="decal" alt="" width="30px"></i></a>
                        </span>
                        <i class="uil uil-times close-icon"></i>
                        </div>';
                    }
                    else{

                        

                        echo '
                        <div class="input-box">
                            <form method="post" onsubmit="return validateForm()" action="market.php">
                                <div class="mb-3">
                                    <input type="text"  id="category" name="category" placeholder="Rechercher...">
                                    <span class="icon">
                                        <i class="uil uil-search search-icon"></i>';
                                        
                                        
                        if(!empty($_SESSION['id'])){
                            echo '<a href="../deliveries/php/history.php"><i><img src="img/historique.png" alt="" width="25px"></i></a>';
                        }
                                        
                        echo               '<a id="decal" href="basket.php"><i><img src="img/shopping-cart.png"  alt="" width="30px"></i></a>
                                    </span>
                                    <i class="uil uil-times close-icon"></i>
                                </div>
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
                <span><i><img src="img/menu.png" alt="" width="30px"></i></span>
            </button>

            <!-- Navbar links -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="market.php">Marche</a>
                    </li>

                    <?php

                if($_SESSION['role'] == 'compagny'){
                    echo '<li class="nav-item"><a class="nav-link" href="addProduct.php">Ajouter un produit</a></li>';
                    echo '<li class="nav-item"><a class="nav-link" href="dashboard.php">Tableau de bord</a></li>';
                    echo '<li class="nav-item dropdown">';

                    if($_SESSION['id'] != 1){
                        echo '
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Contrat</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="php/contractManagement/resiliate.php">Résilier</a>
                                <a class="dropdown-item" href="php/contractManagement/renewal.php">Renouveler</a>
                                <a class="dropdown-item" href="php/contractManagement/signContract.php">Signer</a>
                            </div>
                        </li>';
                    }
                   
                }
                if($_SESSION['role'] == 'customer'){
                    echo '
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Abonnement</a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="php\subscriptionManagement\suscribe.php">Souscrire</a>
                        </div>
                    </li>';
                }
                ?>

                    <?php
        
                if(empty($_SESSION['login'])){
                    echo '<li><a class="nav-link" aria-current="page" href="connection.php">Connexion</a></li>';
                }
                else{
                   // echo '//ID == '.$_SESSION['id']." //";
                   // echo '<li> Panier ='.json_encode($_SESSION['basket']).'</li>';
                    echo'<li><a class="nav-link" aria-current="page" href="php/userManagement/logout.php">Deconnexion</a></li>';
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
</body>