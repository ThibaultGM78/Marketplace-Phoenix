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
    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
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

        #permit {
            width: 100%;
            padding: 0.375rem 0.75rem;
            margin-top: 0.5rem;
            margin-bottom: 0.5rem;
            border: 1px solid #ced4da;
            border-radius: 0.25rem;
        }
    </style>
</head>

<body>

    <div class="d-flex justify-content-center align-items-center login-container">
        <!--Formulaire d'ajour d'utilisateur-->
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
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>

</html>