<?php
include 'src/bootstrap.php';    
include 'src/database-connection.php'; 
include 'src/validate.php'; 


$animal = $cms->getAnimal()->getAnimalIndex();


?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Dodaj bezpańskie zwierzę</title>
    
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
    <div class="konto">
        <div class="myaccount">      
            <div class="ramka">
                <h3>Moje konto:</h3>
                <?= "ID: ".$_SESSION['id']; ?><br>
                <?= $_SESSION['imie']." "; ?>
                <?= $_SESSION['nazwisko']; ?><br>
                <?= "Email: ".$_SESSION['email']; ?><br>
                <?= "Data dołączenia: ".$_SESSION['data_dolaczenia']; ?><br>
                <?= "Telefon: ".$_SESSION['telefon']; ?>
            </div>
        </div>
        <br><br>
       
        <a href="myaccount.php">
    <div class="zapisane">
            <h3>Dodane zwierzeta</h3>
        </div>
        </a>
            
        <div class="dodane">
            <h3>Zapisane zwierzęta</h3>
        </div>
       
        <div class="tekst">
            <?php foreach($animal as $pojedynczo) { ?> 
                <?= $pojedynczo['id']; ?><br>
                <?= $pojedynczo['imie']; ?><br>
                <?= $pojedynczo['rasa']; ?><br>
            <?php } ?> 

            <br><br><br><br>
        </div>

    </div>
<?php include 'includes/footer.php'; ?>
<script src="script.js"></script>
</body>
</html>