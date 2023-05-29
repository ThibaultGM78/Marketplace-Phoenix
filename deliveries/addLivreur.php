<?php
    session_start();
    //Include
    include "php/verifLivreur.php";  
    include "php/function/field.php"
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inscription</title>
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

        .error {
            margin: auto;
            width: 370px;
            padding: 15px;
            max-width: 100%;
            font-size: 15px;
            height: 45px;
            font-weight: 500;
            background-color: #ffe6e6;
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

        #permit {
            width: 100%;
            padding: 0.375rem 0.75rem;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
            background-color: #000;
            color: #fff;
        }
        
        a, a:visited, a:hover, a:active {
            color: #4d0000;
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
        <form method="post" class="login-form text-center" onsubmit="return validateForm()">

            <?php
                //On attribut les classes en fonction du types de champ
                $classField = 'mb-3';
                $classLabel = 'form-label';
                $classInput = 'form-control';
                $classSpan = 'd-none';
                $classError = 'error';

                //Login
                $value = $_POST['login'] ?? '';//On recupere la valeur precedement insere par l'utlisateur
                $msgError = "Ce nom d'utilisateur existe déjà.";//Message d'erreur
                //Champ standardise par soucis de praticites
                field('login',$classField,"Nom d'utilisateur",$classLabel,$classInput,'text',$classSpan,'errorLogin',$classError,$msgError,$value,$errors);
            ?>

            <label for="permis">Sélectionnez votre type de permis:</label>
            <select id="permit" name="permit">
                <option value="B">Permis B</option>
                <option value="A">Permis A</option>
                <option value="C">Permis C</option>
            </select>

            <button type="submit" class="btn mt-5 btn-lg btn-custom btn-block text-uppercase">inscription</button>

            <p class="mt-3 font-weight-normal">Vous possédez déjà un compte ? <a
                    href="connection.php"><strong>Connectez-vous</strong></a></p>
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
