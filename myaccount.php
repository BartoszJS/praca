<?php
include 'src/bootstrap.php';    

is_member($session->role);  


$id = $_SESSION['id'];
$animal = $cms->getAnimal()->getMembersAnimal($id);


?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
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
        <div class="zapisanee">
            <h3>Dodane zwierzeta</h3>
        </div>
        </a>
        <a href="zapisane.php">
        <div class="dodanee">
            <h3>Zapisane zwierzęta</h3>
        </div>
        </a>
        <div class="tekst">
            <?php foreach($animal as $pojedynczo) { ?> 
                <div class="animalcontainer">
                    <div class="photo">
                        <img class="image-resize" src="uploads/<?= html_escape($pojedynczo['plik'] ?? 'blank.png') ?>">
                    </div>
                    <div class="opis">
                        <?= "ID: ".$pojedynczo['id']; ?><br><br>
                        <?= "Imie: ".$pojedynczo['imie']; ?><br><br>
                        <?= "Rasa: " .$pojedynczo['rasa']; ?><br><br>
                        <?= "Miejsce zaginięcia: " .$pojedynczo['miasto'].", ".$pojedynczo["wojewodztwo"]; ?><br><br>
                        <?= "Data dodania: " .$pojedynczo['czas']; ?><br>
                    </div>
                    
                </div>
            <?php } ?> 

            
        </div>

    </div>
<?php include 'includes/footer.php'; ?>
<script src="script.js"></script>
</body>
</html>