<?php
declare(strict_types = 1);
include 'src/bootstrap.php';    
include 'src/database-connection.php'; 
include 'src/validate.php'; 

$term  = filter_input(INPUT_GET, 'term');                 // Get search term
$term2  = filter_input(INPUT_GET, 'term2'); 
$show  = filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ?? 3; // Limit
$from  = filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ?? 0; // Offset
$count = 0;
$animal=[];

$sqlicz="SELECT COUNT(zwierze) from bezdomne ;";
        $count = pdo($pdo, $sqlicz)->fetchColumn();

$sql="SELECT bezdomne.id , bezdomne.zwierze, bezdomne.wielkosc, bezdomne.znaki, bezdomne.miasto,
            bezdomne.wojewodztwo, bezdomne.id_member, bezdomne.czas,
            image.plik
            FROM bezdomne
            join image on bezdomne.id_image = image.id 
            order by bezdomne.id DESC;";
            $bezdomne = pdo($pdo,$sql)->fetchAll();


?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <title>Zaginione</title>
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
 <?php 
 /* SELECT bezdomne.id , bezdomne.zwierze, bezdomne.wielkosc, bezdomne.znaki, bezdomne.miasto,
    bezdomne.wojewodztwo, bezdomne.id_member, bezdomne.czas, 
*/ ?>

<div class="wyszukanie">
   <div class="place">
        
    
  
        <br>
        <div class="szukajbtn">
            <h4>Wyszukaj zwierzaka: </h4>
            <form action="zaginione.php" method="get" class="form-search">
                    <label for="search"><span> </span></label>
    
                    <select name="term2" id="wojewodztwo" >
                        <label ><option name=""  value="" disabled selected hidden> - Wybierz województwo - <br></label>
                        <label ><option name="zachodnio-pomorskie"  value="zachodnio-pomorskie"> Zachodnio-pomorskie <br></label>
                        <label ><option name="pomorskie"            value="pomorskie"> Pomorskie <br></label>
                        <label ><option name="warmińsko-mazurskie"  value="warmińsko-mazurskie"> Warmińsko-mazurskie <br></label>
                        <label ><option name="podlaskie"            value="podlaskie"> Podlaskie <br></label>
                        <label ><option name="lubuskie"             value="lubuskie"> Lubuskie <br></label>
                        <label ><option name="wielkopolskie"        value="wielkopolskie"> Wielkopolskie <br></label>
                        <label ><option name="kujawsko-pomorskie"   value="kujawsko-pomorskie"> Kujawsko-pomorskie <br></label>
                        <label ><option name="mazowieckie"          value="mazowieckie"> Mazowieckie <br></label>
                        <label ><option name="lubelskie"            value="lubelskie"> Lubelskie <br></label>
                        <label ><option name="świetokrzyskie"       value="świetokrzyskie"> Świetokrzyskie <br></label>
                        <label ><option name="łódzkie"              value="łódzkie"> Łódzkie <br></label>
                        <label ><option name="dolnośląskie"         value="dolnośląskie"> Dolnośląskie <br></label>
                        <label ><option name="opolskie"             value="opolskie"> Opolskie <br></label>
                        <label ><option name="śląskie"              value="śląskie"> Śląskie <br></label>
                        <label ><option name="małopolskie"          value="małopolskie"> Małopolskie <br></label>
                        <label ><option name="podkarpackie"         value="podkarpackie"> Podkarpackie <br></label>
                    </select>
    
                    <?php if(isset($term)){
                        ?>
                    
    
                    <input type="text" name="term" 
                        id="search" placeholder="Wpisz miasto:" value="<?= html_escape($term)?>"
                    />
                    <?php } else {?>
                        <input type="text" name="term" 
                        id="search" placeholder="Wpisz miasto:" value=""
                    />
                    <?php } ?>
    
                    <input type="submit" value="Szukaj" class="btn btn-search" />
    
                    </div>
                  
    
              <div class="pytanie">
                Widziałeś bezdomne zwierze?
              </div>
              <div class="dodajbtn">
                    <a href="dodaj.php" class="btn btn-search" >DODAJ ZWIERZE DO BAZY</a>
                </div>
            </form>
    
            
    
              
                <?php /* if (!$term) { ?><p><b>Najnowsze zaginione zwierzęta:</b></p><?php } */ ?>
        </div>
       
       <br>
        <div class="podgora">
        <h3> Bezdomne zwierzęta:  <?php if ($term) { ?><p><b>Znaleziono:</b> <?= $count ?></p><?php }elseif ($term2) { ?>
    <p><b>Znaleziono:</b> <?= $count ?></p><?php } ?></h3>
        </div>

       
       
<?php foreach($bezdomne as $solo){?>
    
        <div class="ramka">

            <a href="bezdomnezwierze.php?id=<?= $solo['id'] ?>">
            <div class="imie"> <?= html_escape($solo['znaki'])?> </div>
            <div class="column">
                    <img class="image-resize" src="uploads/<?= html_escape($solo['plik'] ?? 'blank.png') ?>">
                </div> 
            <div class="tekst">
            <?= "Rasa: ".$solo['znaki'] ?><br><br>

                Miejsce zaginięcia: <br>
                <i class="fa fa-map-marker" ></i> <?= html_escape($solo['miasto']).', '.html_escape($solo['wojewodztwo'])?><br><br>
                                        
                <?php $datem = strtotime($solo['czas']);
                $wlasciwa = date('d'.'.'.'m'.'.'.'Y',$datem);?>
                                        
                 <div class="calendar"><i class="fa fa-calendar"></i><?= "Data dodania: ".$wlasciwa ?></div> 
                    
            </div>   

                
            

                <br>
            </a>

    </div>
    </div>

<?php } ?>
    
<?php include 'includes/footer.php'; ?>
<script src="script.js"></script> 
</body>
</html>