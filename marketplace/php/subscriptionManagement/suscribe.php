<?php
    //session
    session_start();
    //include
    include "saveSubscribe.php" ;
?>
<!DOCTYPE html>
<html>
<head>
    <title>Phoenix</title>
    <script src="js/verifContrat.js"></script>
</head>
<body>

    <a href="../../index.php">Accueil</a>

    <form method="post">
        <h1>Souscription abonnement Phoenix</h1>
       
        <label for="nMonth">Nombre de mois:</label>
        <input type="number" id="nMonth" name="nMonth" min="1" max="12" required>
        </br>

        <label for="reduction">Pourcentage de reduction:</label>
        <select name="reduction" required>      
            <option value="10">10</option>
            <option value="20">20</option>  
        </select>
        </br>

        <button type="submit">Valider</button>
    </form>

</body>
</html>
