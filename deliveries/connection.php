<?php
    /*session_start();*/
    include "php/verifConnection.php";
    include "php/function/field.php"
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Livreur</title>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-form {
            width: 100%;
            max-width: 380px;
            padding: 15px;
            margin: auto;
        }

        .login-form .btn {
            font-size: 18px;
            font-weight: bold;
            height: 50px;
            background-color: rgb(162, 10, 10);
            border-color: rgb(162, 10, 10);
            color: white;
            border-radius: 0;
        }

        .login-form .form-label {
            color: #6c757d;
        }
    </style>
</head>
<body>

    <div class="d-flex justify-content-center align-items-center login-container">

        <form method="post" class="login-form text-center">

            <?php
                $classField = 'mb-3';
                $classLabel = 'form-label';
                $classInput = 'form-control';
                $classSpan = 'd-none';
                $classError = 'error';

                //Login
                $value = $_POST['login'] ?? '';
                field('login',$classField,"Nom d'utilisateur",$classLabel,$classInput,'text',$classSpan,'errorLogin',$classInput,'',$value,$errors, 'Pseudonyme');
                                
            ?>
            
            <button type="submit" class="btn mt-5 btn-lg btn-custom btn-block text-uppercase">Connexion</button>
            
            <p class="mt-3 font-weight-normal"><a href="addLivreur.php"><strong>Ajouter un livreur</strong></a></p>
        </form>
        
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>
