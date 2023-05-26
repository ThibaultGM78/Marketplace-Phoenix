<?php
	try{
		$options = [
			PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
			PDO::ATTR_EMULATE_PREPARES => false
		];

		$PDO = new PDO($DB_DSN, $DB_USER, $DB_PASS); 	
		
		//Id compagny
		$sql = "SELECT id_compagny FROM marketplace_compagny WHERE id_user = '".$_SESSION['id']."';";
		$list = sqlSearch($PDO,$sql);
	
		if ( !isset($list[0])) {
			$list[0] = null;
		}
		if (isset($list[0]['id_compagny'])){
			$idCompagny = $list[0]['id_compagny'];
		}
		//--
		$sql = "SELECT contract_end 
			FROM marketplace_contract
			WHERE id_contract = (
				SELECT id_contract
				FROM marketplace_compagny
				WHERE id_compagny = ".$idCompagny."
			)
		;";
		$list = sqlSearch($PDO,$sql);
		
		if(!empty($list[0]['contract_end'])){
			$contractEnd= $list[0]['contract_end'];
		}
		else{
			$contractEnd = "Aucun contrat";
		}
		
	}
	catch(PDOExeption $pe){
		echo 'ERREUR : '.$pe->getMessage();
	}

    echo("<p>Vous avez un contrat valable jusqu'au : ".$contractEnd."</p>");
?>