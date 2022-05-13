<?php
namespace PhpBook\CMS;                                  

class CMS
{
    protected $db        = null;                                        
    protected $member    = null;                        
    protected $session   = null;                              
    protected $car   = null;                              
    protected $rent   = null;                              
                  

    public function __construct($dsn, $username, $password)
    {
        $this->db = new Database($dsn, $username, $password); // Create Database object
    }

   

    public function getMember()
    {
        if ($this->member === null) {                    // If $member property null
            $this->member = new Member($this->db);       // Create Member object
        }
        return $this->member;                            // Return Member object
    }

    public function getSession()
    {
        if ($this->session === null) {                   // If $session property null
            $this->session = new Session($this->db);     // Create Session object
        }
        return $this->session;                           // Return Session object
    }


    public function getCar()
    {
        if ($this->car === null) {                     // If $car property null
            $this->car = new Car($this->db);         // Create Token object
        }
        return $this->car;                             // Return Token object
    }
    public function getRent()
    {
        if ($this->rent === null) {                     // If $rent property null
            $this->rent = new Rent($this->db);         // Create Token object
        }
        return $this->rent;                             // Return Token object
    }



  
}