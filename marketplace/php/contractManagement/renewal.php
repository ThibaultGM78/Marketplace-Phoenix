<?php
    //session
    session_start();
    include "../function/sqlCmd.php";
    //include
?>
<!DOCTYPE html>
<html>
<head>
    <title>Renouvellement de Contrat</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    
    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>
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
                    //On regarde s'il a un contrat
                    /* s'il en a un on l'update a la date indiquée */
                    if(!empty($list[0]['contract_end'])){
                        $sql ="UPDATE marketplace_contract
                        SET contract_end ="."'".$date_fin."'"."WHERE id_compagny = '".$idCompagny."';";		
                        $request = $PDO->prepare($sql);
                        $request->execute(); 
                        echo($date_fin);
                        //On redirige l'utilisateur sur la page de connexion afin qu'il se connecte a son nouveau compte.
                        header('Location: ../../index.php');
                    } /* sinon on l'incite à se rediriger */
                    else{
                        echo('<p style="font-size: 20px; font-weight: bold;">Vous ne pouvez pas renouveler un contrat si vous n\'en avez pas.</p>');
                    }
                } 
                catch(PDOExeption $pe){
                    echo 'ERREUR : '.$pe->getMessage();
                }
    }
}
?>