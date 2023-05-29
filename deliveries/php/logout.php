<?php
    session_start();
    //On reinitialise les donnees de session car l'utilisateur s'est deconnecte.
    unset($_SESSION);
    //On detruit ensuite la session.
    session_destroy();
    //L'utilisateur est ensuite redirige sur la page d'accueil.
    header('Location: ../index.php');
?>