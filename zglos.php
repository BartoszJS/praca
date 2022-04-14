<?php
include 'includes/database-connection.php'; 
include 'includes/functions.php'; 
include 'includes/validate.php';  
$destination = '';                               // Validation functions

$file_types      = ['plik/jpeg', 'plik/png', 'plik/gif',];      // Allowed file types
$file_extensions = ['jpg', 'jpeg', 'png', 'gif',];                 // Allowed extensions
$max_size        = '5242880';                                     // Max file size

$upload_path = dirname(__FILE__).DIRECTORY_SEPARATOR. 'uploads'.DIRECTORY_SEPARATOR;

$animal['zwierze']    ='';
$animal['imie']    ='';
$animal['rasa']    ='';
$animal['wielkosc']    ='';
$animal['kolor']        ='';
$animal['wojewodztwo']    ='';
$animal['miasto']    ='';


$errors['zwierze']    ='';
$errors['imie']    ='';
$errors['rasa']    ='';
$errors['wielkosc']    ='';
$errors['kolor']        ='';
$errors['wojewodztwo']    ='';
$errors['miasto']    ='';
$errors['plik']    ='';
$errors['warning'] ='';



if($_SERVER['REQUEST_METHOD'] == 'POST') {



  if ($_FILES['plik']['error'] === 0) {  

    $temp = $_FILES['plik']['tmp_name'];
    $path = 'uploads/' . $_FILES['plik']['name'];
    $moved = move_uploaded_file($temp, $path);
    $image['plik']    =$_FILES['plik']['name'];
    $sql="INSERT INTO image(plik)
    values (:plik);";
    $arguments=$image;
  
    try{
      pdo($pdo,$sql,$arguments)  ;  
    }catch(PDOException $e){
      throw $e;
    }
}

  $lastId=$pdo->lastInsertId();

  $animal['zwierze']    =$_POST['zwierze'];
  $animal['imie']    =$_POST['imie'];
  $animal['rasa']    =$_POST['rasa'];
  $animal['wielkosc']    =$_POST['wielkosc'];
  $animal['kolor']    =$_POST['kolor'];
  $animal['wojewodztwo']    =$_POST['wojewodztwo'];
  $animal['miasto']    =$_POST['miasto'];

    $errors['imie']  = is_text($animal['imie'], 1, 40)
        ? '' : 'Imie musi miec od 1-40 znaków';
    $errors['rasa']  = is_text($animal['rasa'], 1, 40)
        ? '' : 'Rasa musi miec od 1-40 znaków';
    $errors['kolor']  = is_text($animal['kolor'], 1, 40)
        ? '' : 'Kolor musi miec od 1-40 znaków';
    $errors['miasto']  = is_text($animal['miasto'], 1, 40)
        ? '' : 'Miasto musi miec od 1-40 znaków';
    $errors['zwierze']  = is_text($animal['zwierze'], 1, 40)
        ? '' : 'Proszę wybrać opcję';
    $errors['wojewodztwo']  = is_text($animal['wojewodztwo'], 1, 40)
        ? '' : 'Proszę wybrać opcję';
    $errors['wielkosc']  = is_text($animal['wielkosc'], 1, 40)
        ? '' : 'Proszę wybrać opcję';

    $invalid = implode($errors);

    if ($invalid) {                                              // If invalid
      $errors['warning'] = 'Popraw poniższe błędy';  // Store message
  } else {

    $sql="INSERT INTO animal(zwierze,imie,rasa,wielkosc,kolor,wojewodztwo,miasto,id_image,id_member,zaginiony)
    values (:zwierze,:imie,:rasa,:wielkosc,:kolor,:wojewodztwo,:miasto,$lastId,2,1);";
  
    $arguments=$animal;

    try{
      pdo($pdo,$sql,$arguments)  ;  
      $lastAnimal=$pdo->lastInsertId();
      header("Location: animal.php?id=".$lastAnimal); 
      exit();
    }catch(PDOException $e){
      throw $e;
    }
  }
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
    <title>Zgłoś zaginięcie zwierzaka</title>
    <?php include 'includes/loader.php'; ?>
    <?php include 'includes/header.php'; ?>
</head>
<body>

<form action="zglos.php" method="POST" enctype="multipart/form-data"> 
<br><br><br><br>
    <section class="formularz">
    <div class="ramka">
      <br>
      <h1>Zgłoszenie zaginionego zwierzaka</h1> <br>

      <?php if ($errors['warning']) { ?>
        <div class="error"><?= $errors['warning'] ?></div>
      <?php } ?>
      
      
      <label for="plik">Dodaj zdjęcie zwierzaka:</label>
            <div class="form-group image-placeholder">
              <input type="file" name="plik" class="form-control-file" id="plik"
              accept="plik/jpeg,plik/jpg,plik/png"><br>
              <span class="errors"><?= $errors['plik'] ?></span>
            </div><br>


        <div class="form-group">
        <label for="zwierze">Pies czy kot? </label> <br>
          <label><input type="radio" name="zwierze" value="Pies"> Pies <br> </label>
          <label><input type="radio" name="zwierze" value="Kot" > Kot </label>
          <span class="errors"><?= $errors['zwierze'] ?></span>
        </div><br>

        <div class="form-group">
          <label for="title">Imie zwierzaka: </label> <br>
          <input type="text" name="imie" id="imie" value="<?= html_escape($animal['imie']) ?>"
                 class="form-control">
                 <span class="errors"><?= $errors['imie'] ?></span>
        </div><br>

        <div class="form-group">
          <label for="title">Rasa zwierzaka: </label>
          <input type="text" name="rasa" id="rasa" value="<?= html_escape($animal['rasa']) ?>"
                 class="form-control">
                 <span class="errors"><?= $errors['rasa'] ?></span>
        </div><br>

        <div class="form-group">
          <label for="wielkosc">Wielkość zwierzaka:  <br>
          <label ><input type="radio" name="wielkosc" value="maly"> Mały <br></label>
          <label ><input type="radio" name="wielkosc" value="sredni" > Średni<br></label>
          <label ><input type="radio" name="wielkosc" value="duzy" > Duży<br></label>
          </label>
          <span class="errors"><?= $errors['wielkosc'] ?></span>
        </div><br>

        <div class="form-group">
          <label for="title">Kolor zwierzaka: </label>
          <input type="text" name="kolor" id="kolor" value="<?= html_escape($animal['kolor']) ?>"
                 class="form-control">
                 <span class="errors"><?= $errors['kolor'] ?></span>
        </div><br>

        <div class="form-group">
          <!-- category -->
          <label for="Województwo">Województwo: </label> <br>
          <select name="wojewodztwo" id="wojewodztwo">
            <label ><option name="zachodnio-pomorskie"  value="zachodnio-pomorskie"> Zachodnio-pomorskie <br></label>
            <label ><option name="pomorskie"            value="pomorskie"> Pomorskie <br></label>
            <label ><option name="warmińsko-mazurskie"  value="warmińsko-mazurskie"> Warmińsko-mazurskie <br></label>
            <label ><option name="podlaskie"            value="podlaskie"> Podlaskie <br></label>
            <label ><option name="lubuskie"             value="lubuskie"> Lubuskie <br></label>
            <label ><option name="wielkopolskie"        value="wielkopolskie"> wielkopolskie <br></label>
            <label ><option name="kujawsko-pomorskie"   value="kujawsko-pomorskie"> kujawsko-pomorskie <br></label>
            <label ><option name="mazowieckie"          value="mazowieckie"> mazowieckie <br></label>
            <label ><option name="lubelskie"            value="lubelskie"> lubelskie <br></label>
            <label ><option name="świetokrzyskie"       value="świetokrzyskie"> świetokrzyskie <br></label>
            <label ><option name="łódzkie"              value="łódzkie"> łódzkie <br></label>
            <label ><option name="dolnośląskie"         value="dolnośląskie"> dolnośląskie <br></label>
            <label ><option name="opolskie"             value="opolskie"> opolskie <br></label>
            <label ><option name="śląskie"              value="śląskie"> śląskie <br></label>
            <label ><option name="małopolskie"          value="małopolskie"> małopolskie <br></label>
            <label ><option name="podkarpackie"         value="podkarpackie"> podkarpackie <br></label>
          </select>
          <span class="errors"><?= $errors['wojewodztwo'] ?></span>
        </div><br>

        <div class="form-group">
          <label for="title">Miasto: </label>
          <input type="text" name="miasto" id="miasto" value="<?= html_escape($animal['miasto']) ?>"
                 class="form-control">
                 <span class="errors"><?= $errors['miasto'] ?></span>
        </div><br>


        <input type="submit" name="update" class="btn" value="ZAPISZ" class="btn btn-primary">

        <br>
     
      </div>
    </section>
    <br>
</form>

<?php include 'includes/footer.php'; ?>
<script src="script.js"></script> 
</body>
</html>