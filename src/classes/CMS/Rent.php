<?php
namespace PhpBook\CMS;     

class Rent
{
    protected $db;                                       // Holds ref to Database object

    public function __construct(Database $db)
    {
        $this->db = $db;                                 // Store ref to Database object
    }

    

    //klient
    public function getRents($id)
    { 
        $sql="SELECT rent.id_car,rent.id_member,rent.data_wypozyczenia,rent.czas_wypozyczenia,
        member.id, car.marka, car.model, car.image,car.wypozyczony,car.cena
        FROM rent
        join member on rent.id_member = member.id
        left join car on rent.id_car = car.id
        where member.id = :id;";

       return $this->db->runSql($sql,[$id])->fetchAll();     
    }

    public function getRentMember()
    { 
    
    $sqlre="SELECT rent.id_car,rent.id_member,rent.data_wypozyczenia,rent.czas_wypozyczenia,
    member.id, car.marka, car.model, car.image,car.wypozyczony,car.cena
    FROM rent
    join member on rent.id_member = member.id
    left join car on rent.id_car = car.id;";
    return $this->db->runSql($sqlre)->fetchAll();     
    }



    public function usunRent($id)
    { 
        $sql="DELETE FROM rent where id=:id;";
        return $this->db->runSql($sql,[$id])->fetch();  
    }

    public function insertRent($arguments)
    { 
    $sql="INSERT INTO rent(id_car,id_member,data_wypozyczenia,czas_wypozyczenia)
                values(:id_car,:id_member,:data_wypozyczenia,:czas_wypozyczenia);";
                
        try{
            $this->db->runSql($sql,$arguments)->fetch();  
            header("Location: index.php"); 
            exit();
        }catch(PDOException $e){
            throw $e;
        }

    }


    
}