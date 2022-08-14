<?php
include 'src/bootstrap.php';    
include 'src/database-connection.php'; 
include 'src/validate.php'; 

is_admin($session->role);  






$members = $cms->getMember()->czytelnicy();









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
    <br>
<div class="members">
    <div class="member">
        <h1>Użytkownicy:</h1>
    </div>
    <div class="dane">
        <br><br><br>
    </div>
    <?php foreach ($members as $member){ ?>
        <a href="member.php?id=<?= $member['id'] ?>">
        <div class="member">
            id: <?= $member['id'] ?><br>
            imię: <?= $member['imie'] ?><br>
            nazwisko: <?= $member['nazwisko'] ?><br>
            e-mail: <?= $member['email'] ?>
        </div>
        <div class="dane">
            Uprawnienia - <?= $member['role'] ?><br>
            <?php 
            $bezdomne = $cms->getMember()->liczBezdomne($member['id']);
            $zaginione = $cms->getMember()->liczZaginione($member['id']);
            ?>
            Dodane bezdomne zwierzęta: <?= $bezdomne ?> <br>  
            Dodane zaginione zwierzęta: <?= $zaginione ?> <br>  
        </div>
        <div class="ddd">
            
        </div>
        </a>
    <?php } ?>
</div>

    <?php include 'includes/footer.php'; ?>
    <script src="script.js"></script> 
</body>
</html>

