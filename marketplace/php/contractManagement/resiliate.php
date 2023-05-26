<?php
    //session
    session_start();
    include "../function/sqlCmd.php";
    //include
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


    <nav>
        <a href="../../index.php">Accueil</a>
    </nav>

	<h1>Résiliation du contrat</h1>
	<form action= "resiliate.php" method="post">
		<label>Etes vous sûrs de vouloir résilier votre contrat ?</label><br><br>
        <button name = "resilier" value= "resilier">Oui, je résilie mon contrat </button>
        <button name = "revenir">  Non, je souhaite revenir en arrière</button>
	</form>
</body>
</html>
<?php
    // Vérifie si des données ont été soumises
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['resilier'])) {
            //SQL
            require '../../sql/db-config.php';
            try{
                $options = [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_EMULATE_PREPARES => false
                ];
    
                $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);  
                $sql = "SELECT id_compagny FROM marketplace_compagny WHERE id_user = '".$_SESSION['id']."';";
                $list = sqlSearch($PDO,$sql);
                if (isset($list[0]['id_compagny'])){
                    $idCompagny = $list[0]['id_compagny'];
                    echo $idCompagny;
                }

                $sql = "SELECT contract_end FROM marketplace_contract
                        WHERE id_compagny ="."$idCompagny".";";
                $list = sqlSearch($PDO,$sql);
                /* s'il en a un on l'update a la date indiquée */
                if(!empty($list[0]['contract_end'])){
                    $sql = "DELETE marketplace_contract FROM marketplace_contract
                    WHERE id_compagny ='".$idCompagny."';";
                    //WHERE id_compagny =".$_SESSION['id_compagny'].";";			
                    $request = $PDO->prepare($sql);
                    $request->execute(); 
                }
                else {
                    echo("Vous ne pouvez résilier un contrat si vous n'en avez pas.");
                }   
            }
            catch(PDOExeption $pe){
                echo 'ERREUR : '.$pe->getMessage();
            }
            //On affiche le message pendant 3 secondes avant de rediriger l'utilisateur
            if(!empty($list[0]['contract_end'])){
                echo "<p style='font-weight:bold; color:red;'>Opération réussie, votre contrat a bien été résilié !</p>";
                header("refresh:3; url=../index.php");
                exit();
            }
        }
        elseif (isset($_POST['revenir'])) {
            header('Location: ../../contract.php');
            exit();
        }
    }
?>