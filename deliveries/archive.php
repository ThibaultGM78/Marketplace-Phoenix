<?php

    // file containing the parameters to connect to the sql database
    require 'sql/db-config.php';

    session_start();
    $_SESSION['nb_adresse'];
    $_SESSION['duree_trajet'];


    try
    {
        // we connect to MySQL
        $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);
    }

    // Show error message when there is a problem with MySQL
    catch(Exception $e)
    {
        die('Erreur : '.$e->getMessage());
    }

    $chaine = "'".$_SESSION['etape'][0]."'";

    // concatener toutes les adresses des livraisons, afin de la supprimer de la data base
    for ($i=0; $i<$_SESSION['nb_adresse']; $i++)
    {
        $chaine .= ",'".$_SESSION['etape'][$i]."'";
    }

    //Supprimer les livraisons de la data base

    //preparer la requet
    $requete = $PDO->prepare('DELETE FROM marketplace_purchase WHERE purchase_adress IN ('.$chaine.')');

    //transmettre la liste des parametres
    $requete->execute();

    //Arreter le traitement de la requette MySQL
    $requete->closeCursor();

    //preparer la requet
    $temp = 'UPDATE marketplace_archive SET etatExped = "Livré" WHERE purchase_adress IN (';
    $requete2 = $PDO->prepare($temp.$chaine.')');

    //transmettre la liste des parametres
    $requete2->execute();

    //Arreter le traitement de la requette MySQL
    $requete2->closeCursor();

    //On reinitialise les donnees de session car l'utilisateur s'est deconnecte.
    unset($_SESSION);
    //On detruit ensuite la session.
    session_destroy();

    header('Location: index.php');

?>