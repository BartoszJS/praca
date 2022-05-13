<?php
namespace PhpBook\CMS;                                   // Namespace declaration

class Member
{
    protected $db;                                       // Holds ref to Database object

    public function __construct(Database $db)
    {
        $this->db = $db;                                 // Add ref to Database object
    }

    // Get individual member by id
    public function get($id)
    {
        $sql = "SELECT id, imie, nazwisko, email, data_dolaczenia, telefon, role 
                  FROM member
                 WHERE id = :id;";    
                 
       
        return $this->db->runSQL($sql, [$id])->fetch();  
    }

    // Get details of all members
    public function getAll()
    {
        $sql = "SELECT id, imie, nazwisko,email,data_dolaczenia, telefon, role 
                  FROM member;";                         
        return $this->db->runSQL($sql)->fetchAll();      
    }


    public function getIdByEmail(string $email)
    {
        $sql = "SELECT id
                  FROM member
                 WHERE email = :email;";                         // SQL query to get member id
        return $this->db->runSQL($sql, [$email])->fetchColumn(); // Run SQL and return member id
    }

    // Login: returns member data if authenticated, false if not
    public function login(string $email, string $haslo)
    {
        $sql = "SELECT id, imie, nazwisko, data_dolaczenia, email, haslo, telefon, role 
                  FROM member 
                 WHERE email = :email;";                         // SQL to get member data
        $member = $this->db->runSQL($sql, [$email])->fetch();    // Run SQL
        if (!$member) {                                          // If no member found
            return false;                                        // Return false
        }           
        // if($haslo == $member['haslo']){
        // return $member;
        // }else{

        //     return false;
        // }
        $authenticated = password_verify($haslo, $member['haslo']); // Passwords match?
        return ($authenticated ? $member : false);               // Return member or false
    }

    // Get total number of members
    public function count(): int
    {
        $sql = "SELECT COUNT(id) FROM member;";                  // SQL to count number of members
        return $this->db->runSQL($sql)->fetchColumn();           // Run SQL and return count
    }

    // Create a new member
    public function create(array $member): bool
    {
        $member['haslo'] = password_hash($member['haslo'], PASSWORD_DEFAULT);  // Hash haslo
        try {                                                          // Try to add member
            $sql="INSERT INTO member(imie,nazwisko,email,haslo,telefon,role)
            values (:imie,:nazwisko,:email,:haslo,:telefon,'member');"; // SQL to add member
            $this->db->runSQL($sql, $member);                          // Run SQL
            return true;                                               // Return true
        } catch (\PDOException $e) {                                   // If PDOException thrown
            if ($e->errorInfo[1] === 1062) {                           // If error indicates duplicate entry
                return false;                                          // Return false to indicate duplicate name
            }                                                          // Otherwise
            throw $e;                                                  // Re-throw exception
        }
    }

    // Update an existing member
    public function update(array $member): bool
    {
        unset($member['data_dolaczenia'],  $member['telefon']);                // Remove data_dolaczenia and member from array
        try {                                                         // Try to update member
            $sql = "UPDATE member 
                       SET imie = :imie, nazwisko = :nazwisko, email = :email, role = :role 
                     WHERE id = :id;";                                // SQL to update member
            $this->db->runSQL($sql, $member);                         // Run SQL
            return true;                                              // Return true
        } catch (\PDOException $e) {                                  // If PDOException thrown
            if ($e->errorInfo[1] == 1062) {                           // If a duplicate (email in use)
                return false;                                         // Return false
            }                                                         // Any other error
            throw $e;                                                 // Re-throw exception
        }
    }

    // Upload member profile image


    // Update member haslo
    public function passwordUpdate(int $id, string $haslo): bool
    {
        $hash = password_hash($haslo, PASSWORD_DEFAULT);           // Hash the haslo
        $sql = 'UPDATE member 
                   SET haslo = :haslo 
                 WHERE id = :id;';                                    // SQL to update haslo
        $this->db->runSQL($sql, ['id' => $id, 'haslo' => $hash,]); // Run SQL
        return true;                                                  // Return true
    }
}