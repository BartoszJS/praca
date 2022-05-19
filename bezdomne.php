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
    $sql="SELECT animal.id , animal.zwierze, animal.imie, animal.rasa, animal.wielkosc, 
    animal.kolor, animal.wojewodztwo, animal.miasto,animal.id_member,animal.zaginiony,
    image.plik
    FROM animal
    join image on animal.id_image = image.id 
    where animal.zaginiony = 0  
    order by animal.id DESC
    limit 6;";
$animal = pdo($pdo,$sql)->fetchAll();



    }



if($term){
    
    $arguments['term1'] ='%'. $term .'%'; 
    // $arguments['term2'] ='%'.$term.'%';            // three times as placeholders
    // $arguments['term3'] ='%'.$term.'%';


    $sql="SELECT COUNT(zwierze) from animal 
    where zaginiony=0 
    and miasto     like :term1;";

$count = 0;
    
    $count = pdo($pdo, $sql, $arguments)->fetchColumn();


    if ($count > 0) {                                     // If articles match term
        $arguments['show'] = $show;                       // Add to array for pagination
        $arguments['from'] = $from; 

        $sql="SELECT animal.id , animal.zwierze, animal.imie, animal.rasa, animal.wielkosc, 
                animal.kolor, animal.wojewodztwo, animal.miasto,animal.id_member,animal.zaginiony,
                image.plik
                FROM animal
                join image on animal.id_image = image.id 
                where animal.zaginiony = 0
                and animal.miasto like :term1
               
                order by animal.id desc
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
    <br><br>
    <h3> Bezpańskie zwierzęta</h3>
    <br>
   <div class="shadow">
       
   </div>

</div>


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