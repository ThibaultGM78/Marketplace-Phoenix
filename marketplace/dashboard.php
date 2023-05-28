<?php
    session_start();
    //include
    include 'php/function/sqlCmd.php';

    //Fonction qui affiche le graphique du produit concernee
    function displayGraph($data,$idGraph){
       
        // Créez un tableau contenant les mois dans l'ordre
        $months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

        // Trouvez l'index du mois actuel
        $current_month_index = date('n') - 1;

        // Réorganiser le tableau des mois pour commencer par le mois actuel à la fin
        $months = array_merge(array_slice($months, $current_month_index + 1), array_slice($months, 0, $current_month_index + 1));

        // Initialisez les tableaux de données pour le graphique
        $chart_labels = $months;
        $chart_data = array_values($data);

        // Créer le graphique avec Chart.js
        echo ' <div class="centered">
            <canvas id="myChart'.$idGraph.'"></canvas>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                var ctx = document.getElementById(\'myChart'.$idGraph.'\').getContext(\'2d\');
                var myChart = new Chart(ctx, {
                    type: \'line\',
                    data: {
                        labels: ' . json_encode($chart_labels) . ',
                        datasets: [{
                            label : "Hide",
                            data: ' . json_encode($chart_data) . ',
                            borderColor: \'rgb(75, 192, 192)\',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        title: {
                            display: true,
                            text: \'Sales by Month\'
                        },
                        legend: {
                            display: true
                        }
                    }
                });
            </script>
        </div>';
            }
?>

<!DOCTYPE html>
<html>

<head>
    <title>Tableau de Bord</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>
    <?php
            include 'structure/header.php';
    

            require 'sql/db-config.php';
            try{
                $options = [
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_EMULATE_PREPARES => false
                ];
                $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS);  
    
                //--Graphique chiffre d'affaires
                $sql = "SELECT compagny_turnover, id_compagny FROM marketplace_compagny WHERE id_user = '".$_SESSION['id']."';";
		        $list = sqlSearch($PDO,$sql);
                // Décodez la chaîne JSON en un tableau associatif
                $data = json_decode($list[0]["compagny_turnover"], true);
                $idCompagny = $list[0]["id_compagny"];
                echo ("<div class=\"centered\">");
                echo "<h3>Chiffre d'affaires</h3>";
                $idGraph = 0;
                displayGraph($data,$idGraph);

                echo "<h3>Ventes</h3>
                    <p>Nombre de ventes depuis les 12 dernier mois</p>
                ";

                //--Graphique nombre de ventes par produits
                $req = $PDO->prepare('SELECT product_name, product_stats FROM marketplace_product WHERE id_compagny = ?');
                $req->execute(array($idCompagny));

                while ($list = $req->fetch()) {

                    $idGraph++;
                    echo "<h6>".$list["product_name"]."</h6>";
                    $data = json_decode($list["product_stats"], true);
                    displayGraph($data,$idGraph);
                   
                }
                echo "</div>";
            }  
            catch(PDOExeption $pe){
                echo 'ERREUR : '.$pe->getMessage();
            }    
    
            include 'structure/footer.php';
        ?>
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