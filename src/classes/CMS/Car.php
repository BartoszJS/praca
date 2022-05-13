<?php
namespace PhpBook\CMS;     

class Car
{
    protected $db;                                       // Holds ref to Database object

    public function __construct(Database $db)
    {
        $this->db = $db;                                 // Store ref to Database object
    }

    
    //potwwypo.php, czytelnik.php edytujczytelnika.php usunczytelnika.php
   
    public function indexCar()
    { 
        $sql="SELECT id,marka,model,rocznik,silnik,paliwo,konie,skrzynia,kiedy_dodany,cena,liczba_miejsc,wypozyczony,image
        FROM car
        where wypozyczony=0   
        order by id desc
        limit 5;";
       return $this->db->runSql($sql)->fetchAll();     
    }
    public function getCar($id)
    { 
        $sql="SELECT id,marka,model,rocznik,silnik,paliwo,konie,skrzynia,kiedy_dodany,cena,liczba_miejsc,wypozyczony,image
        FROM car 
         where id=:id;";
       return $this->db->runSql($sql,[$id])->fetch();     
    }

    public function lastIdCar()
    { 
        $sql=   "SELECT ID
        FROM car 
        order by id desc
        limit 1;";
     return $this->db->runSql($sql)->fetchColumn(); 
    }


    public function dodajCar($arguments,$last)
    { 
    $sql="INSERT INTO car(marka,model,rocznik,silnik,paliwo,konie,skrzynia,cena,liczba_miejsc,wypozyczony,image)
    values            (:marka,:model,:rocznik,:silnik,:paliwo,:konie,:skrzynia,:cena,:liczba_miejsc,0,:image);";
    try{
    $this->db->runSql($sql,$arguments)->fetch();  
      header("Location: car.php?id=".$last); 
      exit();
    }catch(PDOException $e){
      throw $e;
    }
    }

    public function updateCar($arguments,$id)
    { 

    $sql="UPDATE car 
          set marka=:marka,model=:model,rocznik=:rocznik,silnik=:silnik,
          paliwo=:paliwo,konie=:konie,
          skrzynia=:skrzynia,cena=:cena,liczba_miejsc=:liczba_miejsc,
          wypozyczony=:wypozyczony,image=:image,kiedy_dodany=:kiedy_dodany
          where id=:id;";
   

    try{       
        $this->db->runSql($sql,$arguments)->fetch();  
        header("Location: car.php?id=".$id); 
        exit();
    }catch(PDOException $e){
      $pdo->rollBack();   
      throw $e;
    }
}

    public function countCars()
    { 
        $sql=   "SELECT COUNT(id) from car where wypozyczony=0;";
         return $this->db->runSql($sql)->fetchColumn(); 
    }

    public function getCars($show,$from)
    { 
        $arguments['show'] = $show;                     
        $arguments['from'] = $from;

        $sql="SELECT id,marka,model,rocznik,silnik,paliwo,konie,skrzynia,kiedy_dodany,cena,liczba_miejsc,wypozyczony,image
        FROM car
        where wypozyczony=0   
        order by id desc
        limit :show
        OFFSET :from;";

       return $this->db->runSql($sql,$arguments)->fetchAll();
    }

    public function countCarsTerm($term)
    { 
        $arguments['term1'] ='%'.$term.'%'; 
        $sql=   "SELECT COUNT(id) from car where marka like :term1;";
         return $this->db->runSql($sql,$arguments)->fetchColumn(); 
    }

    public function getCarsTerm($show,$from,$term)
    { 
        $arguments['show'] = $show;                     
        $arguments['from'] = $from;
        $arguments['term1'] ='%'.$term.'%'; 

        $sql="SELECT id,marka,model,rocznik,silnik,paliwo,konie,skrzynia,kiedy_dodany,cena,liczba_miejsc,wypozyczony,image
        FROM car
        where marka like :term1  
        
        order by id desc
        limit :show
        OFFSET :from;";

       return $this->db->runSql($sql,$arguments)->fetchAll();
    }

    public function usunCar($id)
    { 
        $sql="DELETE FROM car where id=:id;";
        return $this->db->runSql($sql,[$id])->fetch();  
    }




    
   


    
}