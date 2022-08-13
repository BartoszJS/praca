<?php
include 'src/bootstrap.php';    
include 'src/database-connection.php'; 
include 'src/validate.php';
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Zwierze</title>
    <?php //include 'includes/loader.php'; ?>
    <?php if (isset($_SESSION['role'])){ ?> 
    <?php if($_SESSION['role'] == 'member'){ ?>
    <?php include 'includes/headermember.php'; ?>
    <?php }elseif($_SESSION['role'] == 'admin'){ ?>
    <?php include 'includes/headeradmin.php'; ?>
    <?php }}else{ ?> 
    <?php include 'includes/header.php'; ?>    
    <?php }?>
</head>
<body>
<br><br><br><br><br><br><br>
<div class="wypozycz">
    <div class="ramku">
            
    <h2>Pomyślnie usunięto</h2> <br>

    <h3>Powrót do strony głownej <a href="index.php">strony głównej</a></h3>
        
    
                            
    </div>   
    
</div>

    <?php include 'includes/footer.php'; ?>  
</body>
</html>