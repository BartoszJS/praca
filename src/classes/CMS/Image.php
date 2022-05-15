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

    public function insertImage($arguments)
    { 
    $sql="INSERT INTO image(plik)
        values (:plik);";
    $this->db->runSql($sql,$arguments)->fetch();  
    }
 
   


    
}