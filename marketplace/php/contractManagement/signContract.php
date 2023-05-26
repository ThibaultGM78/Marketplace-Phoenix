<?php
    //session
    session_start();
    include "../function/sqlCmd.php";
    //include
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Phoenix</title>
        <script src="js/verifContrat.js"></script>
    </head>
    <body>
    
        <nav>
            <a href="../../index.php">Accueil</a>
        </nav>
        
        <?php
            require '../../sql/db-config.php';
            include 'actualContract.php';
        ?>

        <div>
            <h2>Signer le contrat</h2>    
            <form method="post">
                <!-- <div class="mb-3">
                <label for="category" class="form-label">Date de debut du contrat : </label>
                    <input type="date" class="form-control" id="date_debut" name="date_debut" placeholder="Entrez la date">
                </div> !-->
                <div class="mb-3">
                    <label for="category" class="form-label">Date de fin du contrat : </label>
                    <input type="date" class="form-control" id="date_fin" name="date_fin" <?php echo 'min="'.$contractEnd.'"'?> placeholder="Entrez la date" required>
                </div>
                <label for="menu">Commission :</label><br>
                <select id="menu" name="commission", id="commission">
                    <optgroup label="Faible commission Faible visibilité">
                    <option value="5">5%</option>
                    <option value="10">10%</option>
                    </optgroup>
                    <optgroup label="Forte commission Grosse visibilité">
                    <option value="30">20%</option>
                    <option value="30">30%</option>
                    </optgroup>
                </select><br><br>
                <!-- recuperer toutes les valeurs et ajouter dans la bdd, creer marketplace_contract et marketplace_compagny !-->
                <button type="submit" class="btn btn-primary">Valider</button> 
            </form>      
        </div>
    </body>
</html>
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
        $date_fin = $_POST["date_fin"];
        if(!empty($date_fin)){
            $date = date('Y-m-d');  // récupère la date au format 'AAAA-MM-JJ'
            $commission = $_POST["commission"];

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
                }
                
                // Met à jour la date de fin du contrat dans la base de données
                $sql ="INSERT INTO `marketplace_contract`(`contract_start`, `contract_end`, `contract_commission`, `id_compagny`)
                VALUES ('".$date."','".$date_fin."',".$commission.",".$idCompagny.");";			
                $request = $PDO->prepare($sql);
                $request->execute();    

                $sql = "SELECT id_contract FROM marketplace_contract WHERE id_compagny = ".$idCompagny." ORDER BY id_contract DESC";
                $list = sqlSearch($PDO,$sql);
                $idContract = $list[0]["id_contract"];

                $sql = "UPDATE marketplace_compagny SET id_contract = ".$idContract." WHERE id_compagny =".$idCompagny;
                $request = $PDO->prepare($sql);
                $request->execute();   
            }
            catch(PDOExeption $pe){
                echo 'ERREUR : '.$pe->getMessage();
            }
        }  
    }
?>
