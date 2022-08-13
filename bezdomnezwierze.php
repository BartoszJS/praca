<?php
include 'src/bootstrap.php';    
include 'src/database-connection.php'; 
include 'src/validate.php'; 

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // Validate id
if (!$id) {     
    header("Location: page-not-found.php");  
    exit();                                         // If no valid id
}




$sql="SELECT bezdomne.id , bezdomne.zwierze, bezdomne.wielkosc, bezdomne.znaki, bezdomne.miasto,
    bezdomne.wojewodztwo, bezdomne.id_member, bezdomne.czas, 
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

            <div class="imie"> Bezdomny pies </div>
            <div class="column">
                    <img class="image-resize" src="uploads/<?= html_escape($bezdomne['plik'] ?? 'blank.png') ?>">
                </div> 
            <div class="tekst">
            Widziany  w<br>
               <i class="fa fa-map-marker" ></i> <?=html_escape($bezdomne['miasto']).', '.html_escape($bezdomne['wojewodztwo'])?><br><br>
                                        
                                        <?php $datem = strtotime($bezdomne['czas']);
                                        $wlasciwa = date('d'.'.'.'m'.'.'.'Y',$datem);?>
                                          
                                        <div class="calendar"><i class="fa fa-calendar" aria-hidden="true"></i><?= "Data zgłoszenia: ".$wlasciwa ?></div> <br>
                    
                <?= "Znaki szczególne: ".$bezdomne['znaki'] ?><br><br>
                <?= "Wielkość: ".$bezdomne['wielkosc'] ?><br><br>
              
            </div>   
            <div class="przerwa">


            
            </div>
          
                
              
            
                <br>
            

        </div>
        </div>
    <?php include 'includes/footer.php'; ?>
    <script src="script.js"></script> 
</body>
</html>

