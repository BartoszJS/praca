<?php
include 'includes/database-connection.php'; 
include 'includes/functions.php'; 

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT); // Validate id
if (!$id) {     
    header("Location: page-not-found.php");  
    exit();                                         // If no valid id
}

$sql="SELECT animal.id , animal.zwierze, animal.imie, animal.rasa, animal.wielkosc, 
    animal.kolor, animal.wojewodztwo, animal.miasto,animal.id_member,animal.zaginiony,
    image.plik
    FROM animal
    join image on animal.id_image = image.id 
    where animal.id=:id;";

$animal = pdo($pdo, $sql, [$id])->fetch();    // Get article data
if (!$animal) {   
    header("Location: page-not-found.php");  
    exit();                              // Page not found
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Zwierze</title>
    <?php include 'includes/loader.php'; ?>
    <?php include 'includes/header.php'; ?>
</head>
<body>
    <div class="zwierze"><br>
            <p><?= html_escape($animal['imie'])?> 
            <?= html_escape($animal['zwierze'])?> 
            <?= html_escape($animal['rasa'])?> 
            <?= html_escape($animal['kolor'])?> <br>
            <img class="zwierzeimage" src="uploads/<?= html_escape($animal['plik'] ?? 'blank.png') ?>"> </p>
    
    </div>
    <?php include 'includes/footer.php'; ?>
    <script src="script.js"></script> 
</body>
</html>

