<?php
    session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Page de connexion</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            background-color: #000;
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
            color: #fff;
        }

        button {
            width: 200px;
            height: 50px;
            font-size: 18px;
            font-weight: bold;
            background-color: #fff;
            color: black;
            border: 1px solid;
            transition: background-color 0.3s ease;
            /* Transition pour une animation fluide */
        }

        button:hover {
            background-color: #0D1024;
            /* Gris foncé au survol */
            border-color: #0D1024;
            color: #fff;
            /* Couleur du texte au survol */
        }

        hr {
            border-top: 1px solid #fff;
        }
    </style>
</head>

<body>

    <?php
            /*if(isset($_SESSION['login'])){
                echo "<p class='lead text-muted'>Login :".$_SESSION['login']."</p>";
            }*/
        ?>
    <img src="img/logow.png" alt="Logo" class="mb-3 text-center" style="width: 200px;">
    <h1>Livreur</h1>
    <hr>

    <main>
        <button onclick="window.location.href='connection.php'">Connexion</button>
    </main>
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