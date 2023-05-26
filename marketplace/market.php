<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MarketPlace</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/market.css">
    <script src="verifProduct.js"></script>    
</head>
<body>

    <?php include 'structure/header.php' ?>

    <div class="content">
        <div class="col-4 offset-4">

            <?php include "php/marketRequest.php" ?>

        </div>
    </div>

    <?php  include 'structure/footer.php'; ?>
</body>
</html>