<?php
    session_start();
    //Include
    include "php/userManagement/verifUser.php";  
    include "php/function/field.php"
?>
<!DOCTYPE html>
<html>
<head>
    <title>Inscription</title>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">

    <link href='https://unpkg.com/boxicons@2.1.2/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" type="text/css"
        href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
</head>

<body>

    <?php
        include 'structure/header.php';
    ?>

    <div class="d-flex justify-content-center align-items-center login-container" id="Inscr">
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
                if($value == null){
                    $msgError = "Veuillez entrer un nom d'utilisateur";
                }
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
                    value="<?= $_POST['role'] ?? 'customer'?>">
                    <option value="customer">Utilisateur</option>
                    <option value="compagny">Entreprise</option>
                </select>
                <span id="errorRole" <?php if (isset($errors['login'])) echo'class=""'?> class="d-none">
                    Veuillez selectionner un role.
                </span>
            </div>

            <!--compagny name-->
            <!--S'affiche ssi l'utilisateur se definit comme entreprise-->
            <div class="mb-3" id="compagnyField" style="display:none;">
                <label for="compagnyName">Nom de l'entreprise (Par defaut votre nom d'utilisateur):</label>
                <input type="text" class="form-control" id="compagnyName" name="compagnyName">
            </div>

            <button type="submit"
                class="btn-lg btn-custom btn-block text-uppercase">inscription</button>

            <p class="mt-3 font-weight-normal">Vous possédez déjà un compte ? <a
                    href="connection.php"><strong>Connectez-vous</strong></a></p>
        </form>
    </div>
    <?php
            include 'structure/footer.php'
    ?>
    <script src="js/addUser.js"></script>
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