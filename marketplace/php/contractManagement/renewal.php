<?php
    //session
    session_start();
    include "../function/sqlCmd.php";
    //include
?>
<!DOCTYPE html>
<html>
<head>
	<title>Renouvellement de contrat</title>
</head>
<body>

    <nav>
        <a href="../../contract.php">Contrat</a>
    </nav>
    
    <?php
        require '../../sql/db-config.php';
        include 'actualContract.php';
    ?>

	<h1>Renouvellement de contrat</h1>
	<form action="renewal.php" method="post">
		<label for="date_fin">Jusqu'à quand voulez-vous renouveler votre contrat ?</label>
		<input type="date" id="date_fin" <?php echo 'min="'.$contractEnd.'"'?> name="date_fin">
		<br><br>
		<input type="submit" value="Valider">
	</form>
   
</body>
</html>
<?php
    // Vérifie si des données ont été soumises
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($_POST["date_fin"] != "0000-00-00"){
            $date_fin = $_POST["date_fin"];
            // Gérer les actions des boutons
                //SQL
                require '../../sql/db-config.php';
                try{
                    $options = [
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_EMULATE_PREPARES => false
                    ];
                    // on récupere l'idCompagny de l'utilisateur
                    $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS); 
                    $sql = "SELECT id_compagny FROM marketplace_compagny WHERE id_user = '".$_SESSION['id']."';";
                    $list = sqlSearch($PDO,$sql);
                    $idCompagny = $list[0]['id_compagny'];
                    //On regarde s'il a un contrat
                    $sql = "SELECT contract_end FROM marketplace_contract
                            WHERE id_compagny ="."$idCompagny".";";
                    $list = sqlSearch($PDO,$sql);
                    /* s'il en a un on l'update a la date indiquée */
                    if(!empty($list[0]['contract_end'])){
                        $sql ="UPDATE marketplace_contract
                        SET contract_end ="."'".$date_fin."'"."WHERE id_compagny = '".$idCompagny."';";		
                        $request = $PDO->prepare($sql);
                        $request->execute(); 
                        echo($date_fin);
                        //On redirige l'utilisateur sur la page de connexion afin qu'il se connecte a son nouveau compte.
                        header('Location: ../../contract.php');
                    } /* sinon on l'incite à se rediriger */
                    else{
                        echo("Vous n'avez pas de contrat, veuillez d'abord en signer un si vous voulez le renouveler.");
                    }
                } 
                catch(PDOExeption $pe){
                    echo 'ERREUR : '.$pe->getMessage();
                }
            }
        else{
            echo("Vous devez remplir tous les champs.");
        }
    }
?>