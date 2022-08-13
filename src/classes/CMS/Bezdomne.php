<?php
namespace PhpBook\CMS;    

use PDOException;

class Bezdomne
{
    protected $db;                                       // Holds ref to Database object

    public function __construct(Database $db)
    {
        $this->db = $db;                                 // Store ref to Database object
    }

    public function dodajBezdomne($arguments)
    { 
       
    

        $sql=  "SELECT id
        FROM bezdomne
        order by id desc
        limit 1;";
     $ostatnia = $this->db->runSql($sql)->fetchColumn(); 
     $ostatnia=$ostatnia+1;

    
    $sql="INSERT INTO bezdomne(zwierze,wielkosc,znaki,wojewodztwo,miasto,id_image,id_member)
    values                  (:zwierze,:wielkosc,:znaki,:wojewodztwo,:miasto,:id_image,:id_member);";

    try{
    $this->db->runSql($sql,$arguments)->fetch(); 
      header("Location: bezdomnezwierze.php?id=".$ostatnia); 
      exit();
    }catch(PDOException $e){
      header("Location: nieznaleziono.php"); 
      exit();
      throw $e;
    }
}

public function usunBezdomne($id)
    { 

        $sql="DELETE FROM bezdomne where id=:id;";
        return $this->db->runSql($sql,[$id])->fetch();

    }

}