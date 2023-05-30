<?php
    /*session_start();*/
    include "php/verifConnection.php";
    include "php/function/field.php";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Livreur</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        body {
            background-color: #000;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
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
            background-color: #fff;
            border-color: #fff;
            color: #000;
            border-radius: 0;
        }

        .login-form .form-label {
            color: #fff;
        }
        
        a, a:visited, a:hover, a:active {
             color: rgba(238,224,208) ;
        }
    
        .login-form .btn:hover {
        background-color: #0D1024;
        border-color: #0D1024;
        color: #fff;
    }
</style>
</head>
<body>

<div class="d-flex flex-column justify-content-center align-items-center login-container">
        <img src="img/logow.png" alt="Logo" class="mb-3 text-center" style="width: 200px;">
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
            <p class="mt-3 font-weight-normal">Vous ne possédez pas de compte ? <a
            href="addLivreur.php"><strong>Inscrivez-vous</strong></a></p>
        </form>
        
    </div>
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
