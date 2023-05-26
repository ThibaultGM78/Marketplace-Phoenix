<?php
    session_start();
    //Include
    include "php/userManagement/verifUser.php";  
    include "php/function/field.php"
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>inscription</title>
        <link rel="stylesheet" href="css/login.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        
        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

        <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
        <!-- pour les icons -->
        <script src="js/addUser.js"></script>
</head>
<body>

    <?php
        include 'structure/header.php';
    ?>

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

                //password
                $value = $_POST['password'] ?? '';
                $msgError = "Veuillez entrer un mot de passe.";
                field('password',$classField,'Mot de passe',$classLabel,$classInput,'password',$classSpan,'errorPassword',$classError,$msgError,$value,$errors);
            
                //password2
                $value = '';
                $msgError = 'Veuillez confirmer votre mot de passe.';
                field('password2',$classField,'Répeter votre mot de passe',$classLabel,$classInput,'password',$classSpan,'errorPassword',$classError,$msgError,$value,$errors);
            
                //mail
                $value = $_POST['email'] ?? '';
                $msgError =  "Votre adresse mail n'est pas valide ou existe à déjà été utilisé.";
                field('email',$classField,'Adresse e-mail',$classLabel,$classInput,'mail',$classSpan,'errorPassword',$classError,$msgError,$value,$errors);
            ?>  

            <!-- Fonction inexistante pour ce champ particulier mais suit la meme logique d'erruer que la fonction field-->

            <!--role--> 
            <div class="mb-3">
                <label for="role" class="form-label">Rôle :</label>
                <select class="form-control" id="role" name="role" onchange="showCompagnyField()"
                    <?php if (isset($errors['role'])) echo'class="error"'?> class="form-control" 
                    value="<?= $_POST['role'] ?? 'customer'?>"
                >
                    <option value="customer">Utilisateur</option>
                    <option value="compagny">Entreprise</option>
                </select>
                <span id="errorRole"  <?php if (isset($errors['login'])) echo'class=""'?> class="d-none">
                    Veuillez selectionner un role.
                </span>
            </div>

            <!--compagny name-->
            <!--S'affiche ssi l'utilisateur se definit comme entreprise-->
            <div class="mb-3" id="compagnyField" style="display:none;">
                <label for="compagnyName">Nom de l'entreprise (Par defaut votre nom d'utilisateur):</label>
                <input type="text" class="form-control" id="compagnyName" name="compagnyName">
            </div>
                    
            <button type="submit" class="btn mt-5 rounded-pill btn-lg btn-custom btn-block text-uppercase">inscription</button>

            <p class="mt-3 font-weight-normal">Vous possédez déjà un compte ? <a href="connection.php"><strong>Connectez-vous</strong></a></p>
        </form>
    </div>
    <?php
            include 'structure/footer.php';
    ?>
</body>
</html>