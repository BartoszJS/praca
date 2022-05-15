<?php
declare(strict_types = 1);
include 'src/bootstrap.php';    
include 'src/database-connection.php'; 
include 'src/validate.php'; 

$term  = filter_input(INPUT_GET, 'term');                 // Get search term
$show  = filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ?? 3; // Limit
$from  = filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ?? 0; // Offset
$count = 0;
$animal = [];     

if($term){
    $arguments['term1'] ='%'.$term .'%'; 
    $arguments['term2'] ='%'.$term .'%';              // three times as placeholders
    $arguments['term3'] ='%'.$term .'%'; 


$sql="SELECT COUNT(zwierze) from animal
    where zwierze like :term1
    or imie       like :term2
    or miasto      like :term3
    and zaginiony=1;";

$count = pdo($pdo, $sql, $arguments)->fetchColumn();

if ($count > 0) {                                     // If articles match term
    $arguments['show'] = $show;                       // Add to array for pagination
    $arguments['from'] = $from; 

    $sql="SELECT animal.id , animal.zwierze, animal.imie, animal.rasa, animal.wielkosc, 
    animal.kolor, animal.wojewodztwo, animal.miasto,animal.id_member,animal.zaginiony,
    image.plik
    FROM animal
    join image on animal.id_image = image.id 
    where animal.zwierze like :term1
    or animal.imie       like :term2
    or animal.miasto      like :term3
    and animal.zaginiony = 1 
    order by animal.id DESC
    limit :show
    OFFSET :from;";
    
    $animal = pdo($pdo, $sql, $arguments)->fetchAll();

}
}

if ($count > $show) {                                     // If matches is more than show
    $total_pages  = ceil($count / $show);                 // Calculate total pages
    $current_page = ceil($from / $show) + 1;              // Calculate current page
}
$section     = '';      


?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Znajdz zwierzaka</title>
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
<div class="wyszukanie">
    <br><br><br> <br>
    <form action="search.php" method="get" class="form-search">
            <label for="search"><span> </span></label>
            <input type="text" name="term" 
                id="search" placeholder="Wyszukaj zwierzę"  
            /><input type="submit" value="Szukaj" class="btn btn-search" />
    </form>
<br>
    <?php if ($term) { ?><p><b>Znaleziono:</b> <?= $count ?></p><?php } ?>
    <br>
    <?php foreach($animal as $pojedynczo) { ?> 

        <a href="animal.php?id=<?= $pojedynczo['id'] ?>">
                    <?= html_escape($pojedynczo['imie'])?> 
                    <?= html_escape($pojedynczo['zwierze'])?> 
                    <?= html_escape($pojedynczo['rasa'])?> 
                    <br>
                    
                    <div class="column">
                        <img class="image-resize" src="uploads/<?= html_escape($pojedynczo['plik'] ?? 'blank.png') ?>">
                    </div> 
        </a>


<?php }?>

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
</body>
</html>