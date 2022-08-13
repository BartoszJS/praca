<?php
include 'src/bootstrap.php';    
include 'src/database-connection.php'; 
include 'src/validate.php'; 





$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // Validate id
if (!$id) {     
    header("Location: page-not-found.php");  
    exit();                                         // If no valid id
}
$idOwner=$cms->getMember()->getIdOwneraZaginionego($id);
$id_obecne=$_SESSION['id'];
is_owner($idOwner,$id_obecne);







$sql="SELECT animal.id , animal.zwierze, animal.imie, animal.rasa, animal.wielkosc, 
    animal.kolor, animal.wojewodztwo, animal.miasto,animal.id_member,animal.zaginiony,animal.czas,
    image.plik
    FROM animal
    join image on animal.id_image = image.id 
    where animal.id=:id;";

$animal = pdo($pdo, $sql, [$id])->fetch();    // Get article data
if (!$animal) {   
    header("Location: page-not-found.php");  
    exit();                              // Page not found
}
$idmember = $animal['id_member'];

$member = $cms->getMember()->getAnimalsMember($idmember);


if($_SERVER['REQUEST_METHOD'] == 'POST') {


   
    $zwierze =$cms->getAnimal()->usunAnimal($id);
    header("Location: potwierdzenie.php");  
    exit();                             
    
    
    
    }
    


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
<div class="animal">

    <br>
        <div class="ramka">

            <div class="imie"> Potwierdzenie usunięcia </div>
            <div class="column">
                    <img class="image-resize" src="uploads/<?= html_escape($animal['plik'] ?? 'blank.png') ?>">
                </div> 
            <div class="tekst">
            
            </div>   
            <div class="przerwa">


            
            </div>
            <div class="zglos1">
                Czy napewno chcesz usunąć? <br>
                <form action="usun.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data"> 
                <input type="submit" name="update" class="btnloguj" value="USUŃ"> 
                <a href = "javascript:history.back()" class="btnloguj">ANULUJ</a>
                </form>
            </div>
            <div class="bg-modal">
                <div class="content">
                    <div class="close">+</div>
                    <br>
                    <div class="tekscior">
                    <h3>Dane osoby zgłaszającej:</h3><br>
                    <i class="fa fa-user" aria-hidden="true"></i><?= "Imie: ".$member['imie'] ?><br>
                        <i class="fa fa-envelope" aria-hidden="true"></i><?= "E-mail: ".$member['email'] ?><br>
                        <i class="fa fa-phone-square" aria-hidden="true"></i><?= "Telefon: ".$member['telefon'] ?><br>
                    </div>
                
                </div>
                

            </div>
                
              
            
                <br>
            

        </div>
    <?php include 'includes/footer.php'; ?>
    <script src="script.js"></script> 
</body>
</html>

