<?php
include 'src/bootstrap.php';    
include 'src/database-connection.php'; 
include 'src/validate.php'; 





$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // Validate id
if (!$id) {     
    header("Location: page-not-found.php");  
    exit();                                         // If no valid id
}
$idOwner=$cms->getMember()->getIdOwneraBezdomnego($id);
$id_obecne=$_SESSION['id'];
is_owner($idOwner,$id_obecne);







$sql="SELECT bezdomne.id , bezdomne.zwierze, bezdomne.wielkosc, 
    bezdomne.znaki, bezdomne.wojewodztwo, bezdomne.miasto,bezdomne.id_member,bezdomne.czas,
    image.plik
    FROM bezdomne
    join image on bezdomne.id_image = image.id 
    where bezdomne.id=:id;";

$bezdomne = pdo($pdo, $sql, [$id])->fetch();    // Get article data
if (!$bezdomne) {   
    header("Location: page-not-found.php");  
    exit();                              // Page not found
}
$idmember = $bezdomne['id_member'];

$member = $cms->getMember()->getAnimalsMember($idmember);


if($_SERVER['REQUEST_METHOD'] == 'POST') {


   
    $zwierze =$cms->getBezdomne()->usunBezdomne($id);
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
                    <img class="image-resize" src="uploads/<?= html_escape($bezdomne['plik'] ?? 'blank.png') ?>">
                </div> 
            <div class="tekst">
            
            </div>   
            <div class="przerwa">


            
            </div>
            <div class="zglos1">
                Czy napewno chcesz usunąć? <br>
                <form action="usunbezdomne.php?id=<?= $id ?>" method="POST" enctype="multipart/form-data"> 
                <input type="submit" name="update" class="btnloguj" value="USUŃ"> 
                <a href = "javascript:history.back()" class="btnloguj">ANULUJ</a>
                </form>
            </div>
            
                
              
            
                <br>
            

        </div>
    <?php include 'includes/footer.php'; ?>
    <script src="script.js"></script> 
</body>
</html>

