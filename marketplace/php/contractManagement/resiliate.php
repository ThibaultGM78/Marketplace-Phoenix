<?php
    //session
    session_start();
    include "../function/sqlCmd.php";
    require '../../sql/db-config.php';
    include 'actualContract.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Résiliation du contrat</title>
    <style>
            button {
            background-color: #007bff; /* couleur de fond */
            color: #fff; /* couleur du texte */
            border: none; /* suppression de la bordure */
            border-radius: 5px; /* arrondi des coins */
            padding: 10px 20px; /* espacement du contenu dans le bouton */
            font-size: 16px; /* taille de la police */
            cursor: pointer; /* changement de curseur au survol */
            transition: background-color 0.3s ease; /* animation de transition */
            }

            button:hover {
            background-color: #0062cc; /* couleur de fond au survol */
            }
        </style>
</head>
<body>

	<h1>Résiliation du contrat</h1>
	<form action= "resiliate.php" method="post">
		<label>Etes vous sûrs de vouloir résilier votre contrat ?</label><br><br>
        <button name = "resilier" value= "resilier">Oui, je résilie mon contrat </button>
        <button name = "revenir">  Non, je souhaite revenir à l'accueil</button>
	</form>
</body>
</html>
<?php
    // Vérifie si des données ont été soumises
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['resilier'])) {
            //SQL
            
            try{
                if(!empty($list[0]['contract_end'])){
                    $sql = "DELETE FROM marketplace_contract
                    WHERE id_compagny ='".$idCompagny."';";
                    $request = $PDO->prepare($sql);
                    $request->execute();
                    echo "<p style='font-weight:bold; color:red;'>Opération réussie, votre contrat a bien été résilié !</p>";
                    //On reinitialise les donnees de session car l'utilisateur s'est deconnecte.
                    echo "<p style='font-weight:bold; color:red;'>Déconnexion en cours</p>";
                    unset($_SESSION);
                    //On detruit ensuite la seesion.
                    session_destroy();
                    //L'utilisateur est ensuite redirige sur la page d'accueil.
                    header("refresh:2; url=../../index.php");
                    exit();
                }
                else {
                    echo('<p style="font-size: 20px; font-weight: bold;">Vous ne pouvez pas résilier un contrat si vous n\'en avez pas.</p>');
                }   
            }
            catch(PDOExeption $pe){
                echo 'ERREUR : '.$pe->getMessage();
            }
        }
        /* On redirige le vendeur à l'accueil s'il a appuyé sur le bouton revenir */
        elseif (isset($_POST['revenir'])) {
            header('Location: ../../index.php');
            exit();
        }
    }
?>