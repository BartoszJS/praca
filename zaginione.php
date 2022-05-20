<?php
declare(strict_types = 1);
include 'src/bootstrap.php';    
include 'src/database-connection.php'; 
include 'src/validate.php'; 

$term  = filter_input(INPUT_GET, 'term');                 // Get search term
$term2  = filter_input(INPUT_GET, 'term2');                 // Get search term
$show  = filter_input(INPUT_GET, 'show', FILTER_VALIDATE_INT) ?? 3; // Limit
$from  = filter_input(INPUT_GET, 'from', FILTER_VALIDATE_INT) ?? 0; // Offset
$count = 0;
$animal=[];






    if(!$term and !$term2){
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

if(($term!="") and ($term!="")){

    $arguments['term1'] ='%'.$term.'%'; 
    $arguments['term2'] ='%'.$term2.'%';            // three times as placeholders
    // $arguments['term3'] ='%'.$term.'%';


    $sql="SELECT COUNT(zwierze) from animal 
    where wojewodztwo     like :term2
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
                where animal.wojewodztwo like :term2
                and animal.miasto like :term1
                order by animal.id asc
                limit :show
                OFFSET :from;";
        
        $animal = pdo($pdo, $sql, $arguments)->fetchAll();

    }


}else if($term){
    
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

}else if($term2){
    
    $arguments['term2'] ='%'. $term2 .'%'; 
    // $arguments['term2'] ='%'.$term.'%';            // three times as placeholders
    // $arguments['term3'] ='%'.$term.'%';


    $sql="SELECT COUNT(zwierze) from animal 
    where zaginiony=1 
    and wojewodztwo     like :term2;";

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
                and animal.wojewodztwo like :term2
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
              

          
          <div class="dodajbtn">
                <a href="zglos.php" class="btn btn-search" >DODAJ ZWIERZAKA</a>
            </div>
        </form>

        

          
            <?php /* if (!$term) { ?><p><b>Najnowsze zaginione zwierzęta:</b></p><?php } */ ?>
    </div>
    <br>
    <h3> Zaginione zwierzęta:   <?php if ($term) { ?><p><b>Znaleziono:</b> <?= $count ?></p><?php }elseif ($term2) { ?>
    <p><b>Znaleziono:</b> <?= $count ?></p><?php } ?>  </h3>
    <?php foreach($animal as $pojedynczo) { ?> 
        <div class="ramka">

            <a href="animal.php?id=<?= $pojedynczo['id'] ?>">
            <div class="imie"> <?= html_escape($pojedynczo['imie'])?> </div>
            <div class="column">
                    <img class="image-resize" src="uploads/<?= html_escape($pojedynczo['plik'] ?? 'blank.png') ?>">
                </div> 
            <div class="tekst">
            <?= "Rasa: ".$pojedynczo['rasa'] ?><br><br>

                Miejsce zaginięcia: <br>
                <i class="fa fa-map-marker" ></i> <?= html_escape($pojedynczo['miasto']).', '.html_escape($pojedynczo['wojewodztwo'])?><br><br>
                                        
                                        <?php $datem = strtotime($pojedynczo['czas']);
                                        $wlasciwa = date('d'.'.'.'m'.'.'.'Y',$datem);?>
                                          
                                        <div class="calendar"><i class="fa fa-calendar"></i><?= "Data dodania: ".$wlasciwa ?></div> 
                    
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