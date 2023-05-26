<?php
    session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Page de connexion</title>
	<style>
		h1 {
			font-size: 36px;
			font-weight: bold;
			text-align: center;
		}
		button {
			display: block;
			margin: 0 auto;
			font-size: 24px;
			padding: 10px 20px;
			border-radius: 5px;
			border: none;
			background-color: #007bff;
			color: #fff;
			cursor: pointer;
		}
	</style>
</head>
<body>
	<header>
		<?php
			if(isset($_SESSION['login'] )){
				echo "Login :".$_SESSION['login'] ;
			}
			
		?>
		<h1>Livreur</h1>
        <hr>
	</header>
	<main>
        <button onclick="window.location.href='connection.php'">Connexion</button>
	</main>
</body>
</html>
