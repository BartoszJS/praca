<?php
include 'src/bootstrap.php';    
include 'src/database-connection.php'; 
include 'src/validate.php'; 

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // Validate id
if (!$id) {     
    header("Location: page-not-found.php");  
    exit();                                         // If no valid id
}




$sql="SELECT id , imie, nazwisko, email, data_dolaczenia, telefon, role
    FROM member
    where id=:id;";


$member = pdo($pdo, $sql, [$id])->fetch();
    // Get article data
if (!$member) {   
    header("Location: page-not-found.php");  
    exit();                              // Page not found
}
$idmember = $member['id'];

$animals = $cms->getMember()->getMembersAnimal($idmember);


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
    <div class="konto">
        <div class="myaccount">      
            <div class="ramka">
                <h3>Konto:</h3>
                <?= "ID: ".$member['id']; ?><br>
                <?= $member['imie']." "; ?>
                <?= $member['nazwisko']; ?><br>
                <?= "Email: ".$member['email']; ?><br>
                <?= "Data dołączenia: ".$member['data_dolaczenia']; ?><br>
                <?= "Telefon: ".$member['telefon']; ?>
            </div>
           
            

        </div>
        <br><br>
        <div class="zapisanee">
            <h3>Dodane zwierzeta</h3>
        </div>
        </a>
        <a href="zapisane.php">
        <div class="dodanee">
            <h3>Dodane bezdomne zwierzęta</h3>
        </div>
        </a>
        <div class="tekst">
            <?php foreach($animals as $pojedynczo) { ?> 
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

                    
                    <div class="usunzzaginionych">
                        
                    <a href="usun.php?id=<?= $pojedynczo['id'] ?>" id="button" class="btnloguj">EDYTU</a>
                    <a href="usun.php?id=<?= $pojedynczo['id'] ?>" id="button" class="btnloguj">USUŃ</a>
                    <a href="usun.php?id=<?= $pojedynczo['id'] ?>" id="button" class="btnloguj">ZOBACZ</a>
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