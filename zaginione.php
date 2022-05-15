<?php
declare(strict_types = 1);
include 'src/bootstrap.php';    
include 'src/database-connection.php'; 
include 'src/validate.php'; 

$term  = filter_input(INPUT_GET, 'term');                 // Get search term
$show  = filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ?? 3; // Limit
$from  = filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ?? 0; // Offset
$count = 0;
$animal=[];






    if(!$term){
        $count = 0;
        $sqlicz="SELECT COUNT(zwierze) from animal where zaginiony=1;";
        $count = pdo($pdo, $sqlicz)->fetchColumn();
        if($count>0){
            $arguments['show'] = $show;                     
            $arguments['from'] = $from;

            $sql="SELECT animal.id , animal.zwierze, animal.imie, animal.rasa, animal.wielkosc, 
            animal.kolor, animal.wojewodztwo, animal.miasto,animal.id_member,animal.zaginiony,animal.czas,
            image.plik
            FROM animal
            join image on animal.id_image = image.id 
            where animal.zaginiony = 1   
            order by animal.id DESC
            limit :show
            OFFSET :from;";
            $animal = pdo($pdo,$sql, $arguments)->fetchAll();
        }
    }



if($term){
    
    $arguments['term1'] ='%'. $term .'%'; 
    // $arguments['term2'] ='%'.$term.'%';            // three times as placeholders
    // $arguments['term3'] ='%'.$term.'%';


    $sql="SELECT COUNT(zwierze) from animal 
    where zaginiony=1 
    and miasto     like :term1;";

    $count = 0;
    
    $count = pdo($pdo, $sql, $arguments)->fetchColumn();


    if ($count > 0) {                                     // If articles match term
        $arguments['show'] = $show;                       // Add to array for pagination
        $arguments['from'] = $from; 

        $sql="SELECT animal.id , animal.zwierze, animal.imie, animal.rasa, animal.wielkosc, 
                animal.kolor, animal.wojewodztwo, animal.miasto,animal.id_member,animal.zaginiony,animal.czas,
                image.plik
                FROM animal
                join image on animal.id_image = image.id 
                where animal.zaginiony = 1
                and animal.miasto like :term1
                order by animal.id asc
                limit :show
                OFFSET :from;";
        
        $animal = pdo($pdo, $sql, $arguments)->fetchAll();

    }
}

if ($count > $show) {                                     // If matches is more than show
    $total_pages  = ceil($count / $show);                 // Calculate total pages
    $current_page = ceil($from / $show) + 1;              // Calculate current page
}
$section='';

?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.min.css">
    <title>Zaginione</title>
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
<br><br>
<div class="wyszukanie">
<br>
    <div class="place">
    
    <h3> Zaginione zwierzęta </h3>
    <br>
        <form action="zaginione.php" method="get" class="form-search">
                <label for="search"><span> </span></label>
                <input type="text" name="term" 
                    id="search" placeholder="Wpisz miasto:"  
                /><input type="submit" value="Szukaj" class="btn btn-search" />
                <a href="zglos.php" class="btn btn-search" >DODAJ</a>
        </form>

        

            <?php if ($term) { ?><p><b>Znaleziono:</b> <?= $count ?></p><?php } ?>
            <?php /* if (!$term) { ?><p><b>Najnowsze zaginione zwierzęta:</b></p><?php } */ ?>
    </div>
    <br>
    <?php foreach($animal as $pojedynczo) { ?> 
        <div class="ramka">

            <a href="animal.php?id=<?= $pojedynczo['id'] ?>">
            <div class="imie"> <?= html_escape($pojedynczo['imie'])?> </div>
            <div class="column">
                    <img class="image-resize" src="uploads/<?= html_escape($pojedynczo['plik'] ?? 'blank.png') ?>">
                </div> 
            <div class="tekst">
                                        Miejsce zaginięcia: <br> 
                                        <i class="fa fa-map-marker" ></i> <?= html_escape($pojedynczo['miasto']).', '.html_escape($pojedynczo['wojewodztwo'])?>
                                        
                                        <?php $datem = strtotime($pojedynczo['czas']);
                                        $wlasciwa = date('d'.'.'.'m'.'.'.'Y',$datem);?>
                                          
                                        <div class="calendar"><i class="fa fa-calendar"></i><?= $wlasciwa ?></div> 
                    
            </div>   
                
              
            
                <br>
            </a>

        </div>
    <?php }?>
    




        <?php  if ($count > $show) { ?>
    <nav class="pagination" role="navigation" aria-label="Pagination Navigation">
      <ul>
      <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
        <li>
          <a href="?term=<?= $term ?>&show=<?= $show ?>&from=<?= (($i - 1) * $show) ?>"
            class="btn <?= ($i == $current_page) ? 'active" aria-current="true' : '' ?>">
            <?= $i ?>
          </a>
        </li>
      <?php } ?>
      </ul>
    </nav>
    <?php } ?>
        
    
<?php include 'includes/footer.php'; ?>
<script src="script.js"></script> 
</body>
</html>