<?php
namespace PhpBook\CMS;     

class Animal
{
    protected $db;                                       // Holds ref to Database object

    public function __construct(Database $db)
    {
        $this->db = $db;                                 // Store ref to Database object
    }

    

   
    public function insertAnimal($arguments,$last)
    { 
        $sql="INSERT INTO animal(zwierze,imie,rasa,wielkosc,kolor,wojewodztwo,miasto,id_image,id_member,zaginiony)
        values (:zwierze,:imie,:rasa,:wielkosc,:kolor,:wojewodztwo,:miasto,$lastId,4,1);";
    
    try{
        $this->db->runSql($sql,$arguments)->fetch();  
          header("Location: animal.php?id=".$last); 
          exit();
        }catch(PDOException $e){
          throw $e;
        }   
    }


    public function getAnimalIndex()
    { 

    $sql="SELECT animal.id , animal.zwierze, animal.imie, animal.rasa, animal.wielkosc, 
    animal.kolor, animal.wojewodztwo, animal.miasto,animal.id_member,animal.zaginiony,animal.czas,
    image.plik
    FROM animal
    join image on animal.id_image = image.id 
    where animal.zaginiony = 1   
    order by animal.id DESC
    limit 6;";


    return $this->db->runSql($sql)->fetchAll();     
    }


    
 
   


    
}