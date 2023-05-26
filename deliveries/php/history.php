<?php
	session_start(); 
    include "function/sqlCmd.php"
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Historique des commandes</title>
	<style>
		/* Style pour le tableau */
		table {
			border-collapse: collapse;
			width: 100%;
		}

		th, td {
			text-align: left;
			padding: 8px;
			border: 1px solid #ddd;
		}

		th {
			background-color: #f2f2f2;
		}
	</style>
</head>
<body>
	<h1>Historique des commandes</h1>
			<?php

				require '../sql/db-config.php';
				// Code PHP pour récupérer les données d'historique de commandes depuis la base de données et les afficher dans le tableau
                try{
                    $options = [
                        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_EMULATE_PREPARES => false
                    ];
            
                    $PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS); 	
                    
                    //Id compagny
                    $sql = "SELECT id_customer FROM marketplace_customer WHERE id_user = '".$_SESSION['id']."';";
                    $list = sqlSearch($PDO,$sql);
                
                    if ( !isset($list[0])) {
                        $list[0] = null;
                    }
                    if (isset($list[0]['id_customer'])){
                        $idCustomer = $list[0]['id_customer'];
                    }
				

					// On exécute la requête pour obtenir les commandes archivées
					$sql = 'SELECT * FROM marketplace_archive WHERE id_customer =' . $idCustomer . ';';
					$results = $PDO->prepare($sql);
					$results->execute();
					$archivedOrders = $results->fetchAll(PDO::FETCH_ASSOC);
					$results->closeCursor();  

					// On calcule le nombre total de commandes
					//$totalOrders = count($activeOrders) + count($archivedOrders);
					$totalOrders = count($archivedOrders);

					// On affiche le tableau
					echo '<table>';
					echo '<thead><tr><th>ID commande</th><th>Date de la commande</th><th>Panier</th><th>Adresse de livraison</th><th>État de la commande</th></tr></thead>';
					echo '<tbody>';

					for ($i = 0; $i < $totalOrders; $i++) {
						$order = null;
						$type = '';

						$order = $archivedOrders[$i];

						echo '<tr class="' . $type . '">';
						echo '<td>' . $order['id_purchase'] . '</td>';
						echo '<td>' . $order['purchase_date'] . '</td>';

						//Allows to make the link between the id and the name of the product in the database

						echo '<td>';
						// We remove the characters ""","}" , "{" and "'".
						$caracter = array("\"","'", "{", "}");
						$chaine = str_replace($caracter, "",  $order['purchase_basket']);
					
						// split the string into multiple delimited chunks using ","
						$basketTab = explode(",",$chaine);
						
						// connaitre la taille du tableau obtenu
						$taille = count($basketTab);
					
						echo "<ul>";
						for ($j=0; $j<$taille; $j++)
						{
							$var = explode(":",$basketTab[$j]);
					
					
							//preparer la requet
							$request = $PDO->prepare("SELECT product_name FROM marketplace_product WHERE id_product= ? ");
					
							$request->execute([$var[0]]);                
					
							$donnees = $request->fetch();
					
							$produit = $donnees['product_name'];  
							
							$request->closeCursor();
							
					
							echo "<li>".$var[1]." ".$produit."</li>";
						}
						echo "<br></ul></td>";

						echo '<td>' . $order['purchase_adress'] . '</td>';
						echo '<td>' . $order['etatExped'] . '</td>';
						echo '</tr>';
					}

					echo '</tbody>';
					echo '</table>';
				}
                catch(PDOExeption $pe){
                    echo 'ERREUR : '.$pe->getMessage();
                }
			?>
</body>
</html>