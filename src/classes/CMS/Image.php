<?php
namespace PhpBook\CMS;     

class Image
{
    protected $db;                                       // Holds ref to Database object

    public function __construct(Database $db)
    {
        $this->db = $db;                                 // Store ref to Database object
    }

    

   
    public function getImage($id)
    { 
        $sql="SELECT id, plik
        FROM image
        where id = :id;";
      return $this->db->runSql($sql,[$id])->fetch();    
    }





    public function dodajImage($argumentsImage)
    { 
    $sql="INSERT INTO image(plik)
    value (:plik);";
  
    try{
    $this->db->runSql($sql,$argumentsImage)->fetch();  
    }catch(PDOException $e){
      throw $e;
    }
    }


    public function lastIdImage()
    { 
        $sql=  "SELECT id
        FROM image
        order by id desc
        limit 1;";
     return $this->db->runSql($sql)->fetchColumn(); 
    }
 
   


    
}