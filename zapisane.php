<?php
include 'src/bootstrap.php';    

is_member($session->role);  


$id = $_SESSION['id'];
$animal = $cms->getMember()->getMembersHomeless($id);


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
            <div class="ramka2">.</div>
            <div class="clear">.</div>
        </div>
        <br><br>
        <a href="myaccount.php">
        <div class="zapisane">
            <h3>Dodane zaginione zwierzeta</h3>
        </div>
        </a>
       
        <div class="dodane">
            <h3>Dodane bezdomne zwierzęta</h3>
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
                       
                        <?= "Miejsce zaginięcia: " .$pojedynczo['miasto'].", ".$pojedynczo["wojewodztwo"]; ?><br><br>
                        <?= "Data dodania: " .$pojedynczo['czas']; ?><br>

                    </div>

                    
                    <div class="usunzzaginionych">
                        
                    <a href="usunbezdomne.php?id=<?= $pojedynczo['id'] ?>" id="button" class="btnloguj">USUŃ Z BAZY</a>
                    </div>
                   
                    <?php /*
                    <div class="usunzzaginionych">
                <a href="#" id="button" class="btnloguj">USUŃ Z ZAGINIONYCH</a>
            </div>
            <div class="bg-modal">
                <div class="content">
                    <div class="close">+</div>
                    <br>
                    <div class="tekscior">
                    <h3>Czy napewno chcesz usunąć?</h3><br>
                    
                    </div>
                
                </div>
                

            </div>
                     */?>
                    
                </div>
            <?php } ?> 

            
        </div>

    </div>
<?php include 'includes/footer.php'; ?>
<script src="script.js"></script>
</body>
</html>