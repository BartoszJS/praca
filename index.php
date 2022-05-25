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
    <title>Znajdz zwierzaka</title>

    <?php include 'includes/loader.php'; ?>
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

            <div class="banner-area">
            <div class="content2">

<p id="znajdz" >ZNAJDŹ ZWIERZAKA</p><br>
<p id="znajdz2" >W przypadku zaginięcia zwierzęcia, <br> możesz dodać zwierzę na naszą stronę.</p><br>
<a href="zglos.php" class="btnglowna" >ZGŁOŚ ZAGINIĘCIE</a>

</div>
                <div class="content-area">

                    
                    <div class="content1">

                        <a href="#index" class="btndown" ><i class="fa-solid fa-arrow-down"></i></a>
                    </div>
                    
                   
                </div>
                <div class="content3">
                        <p>.</p>
                    </div>
            </div>
              <div id="index" class="index">   
        
          
  <h1 class="tytul">Najnowsze zaginione zwierzęta:</h1>
            
       
       
      
            
                <?php foreach($animal as $pojedynczo) { ?> 
                    <div class="baza"><br>
                        <div class="ramka">
                            <a href="animal.php?id=<?= $pojedynczo['id'] ?>">
                                <p> 
                                    <div class="teksty">           
                                         
                                            
                                          
                                                <div class="imie"> <?= html_escape($pojedynczo['imie'])?> </div>
                                                <?php $datem = strtotime($pojedynczo['czas']);
                                                $wlasciwa = date('d'.'.'.'m'.'.'.'Y',$datem);?><br>

                                    <div class="city"><i class="fa-solid fa-location-dot"></i><?= " ".$pojedynczo['miasto']?></div> 
                                    <div class="calendar"><i class="fa fa-calendar"></i><?= " ".$wlasciwa ?></div> 
                                    </div>
                                                
                                    <div class="column">
                                        <img class="image-resize"  src="uploads/<?= html_escape($pojedynczo['plik'] ?? 'blank.png') ?>" >
                                    </div> 
                                    
                                                
                                                
                                            
                                </p>
                                            
                            </a>
                        </div>
                      
                    </div>
                    
                <?php } ?>
                
                <div class="lastbutton">
                    <a href="zglos.php" class="btnglowna" >Zobacz wszystkie zwierzaki</a>
    </div>
        
    </div> 
  
   
    
<?php include 'includes/footer.php'; ?>
<script src="script.js"></script> 
</body>
</html>