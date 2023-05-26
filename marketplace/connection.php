<?php
    session_start();
    include "php/userManagement/verifConnection.php";
    include "php/function/field.php"
?>
<!DOCTYPE html>
<html>
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion</title>
        <link rel="stylesheet" href="css/login.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <!-- pour les icons -->
</head>
<body>

    <?php include 'structure/header.php' ?>

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
                                
                //password
                $value = '';
                $msgError = "Le nom d'utilisateur ou le mot de passe est incorrect.";
                field('password',$classField,"Mot de passe",$classLabel,$classInput,'password',$classSpan,'errorPassword',$classError,$msgError,$value,$errors, 'Mot de passe');
            ?>
            
            <button type="submit" class="btn mt-5 rounded-pill btn-lg btn-custom btn-block text-uppercase">Connexion</button>
            <p class="mt-3 font-weight-normal">Vous ne possédez pas de compte ? <a href="addUser.php"><strong>Inscrivez-vous</strong></a></p>
        
        </form>
    </div>
   
   <?php include 'structure/footer.php'; ?>
</body>