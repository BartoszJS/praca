<?php
include 'src/bootstrap.php';    


is_member($session->role);  


$destination = '';                               // Validation functions

$file_types      = ['plik/jpeg', 'plik/png', 'plik/gif',];      // Allowed file types
$file_extensions = ['jpg', 'jpeg', 'png', 'gif',];                 // Allowed extensions
$max_size        = '5242880';       
$arguments=[];                              // Max file size

$upload_path = dirname(__FILE__).DIRECTORY_SEPARATOR. 'uploads'.DIRECTORY_SEPARATOR;

$animal['zwierze']    ='';
$animal['imie']    ='';
$animal['rasa']    ='';
$animal['wielkosc']    ='';
$animal['kolor']        ='';
$animal['wojewodztwo']    ='';
$animal['miasto']    ='';
$animal['id_member']    ='';
$animal['id_image']    ='';


$errors['zwierze']    ='';
$errors['imie']    ='';
$errors['rasa']    ='';
$errors['wielkosc']    ='';
$errors['kolor']        ='';
$errors['wojewodztwo']    ='';
$errors['miasto']    ='';
$errors['plik']    ='';
$errors['warning'] ='';


$lastImage = $cms->getImage()->lastIdImage();
$lastImage=$lastImage+1; 





if($_SERVER['REQUEST_METHOD'] == 'POST') {

  


  $animal['zwierze']    =$_POST['zwierze'];
  $animal['imie']    =$_POST['imie'];
  $animal['rasa']    =$_POST['rasa'];
  $animal['wielkosc']    =$_POST['wielkosc'];
  $animal['kolor']    =$_POST['kolor'];
  $animal['wojewodztwo']    =$_POST['wojewodztwo'];
  $animal['miasto']    =$_POST['miasto'];
  $animal['id_member']=$_POST['id_member'];
  $animal['id_image']= $lastImage;
 


    $temp = $_FILES['plik']['tmp_name'];
    $path = 'uploads/' . $_FILES['plik']['name'];
    $moved = move_uploaded_file($temp, $path);
    $image['plik']    =$_FILES['plik']['name'];
    
    $argumentsImage=$image;


    $cms->getImage()->dodajImage($argumentsImage); 

 
    $arguments=$animal;
  
    $cms->getAnimal()->dodajAnimal($arguments);  


}

?>          

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Zgłoś zaginięcie zwierzaka</title>
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

            <input type="hidden" name="id_member" value="<?= $_SESSION['id'] ?>" > 


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
          <label for="title">Znaki szczególne: </label>
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