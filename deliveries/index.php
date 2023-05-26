<?php
    session_start();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Page de connexion</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        header {
            text-align: center;
            margin-bottom: 2rem;
        }

        h1 {
            color: #6c757d;
        }

        button {
            width: 200px;
            height: 50px;
            font-size: 18px;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <header>
        <?php
            if(isset($_SESSION['login'])){
                echo "<p class='lead text-muted'>Login :".$_SESSION['login']."</p>";
            }
        ?>
        <h1>Livreur</h1>
        <hr>
    </header>
    <main>
        <button class="btn btn-primary" onclick="window.location.href='connection.php'">Connexion</button>
    </main>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
