<?php
namespace PhpBook\CMS;                                  

class CMS
{
    protected $db        = null;                                        
    protected $member    = null;                        
    protected $session   = null;                              
    protected $animal   = null;                                                         
    protected $image   = null;                                                         
                  

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


    public function getAnimal()
    {
        if ($this->animal === null) {                     // If $animal property null
            $this->animal = new Animal($this->db);         // Create Token object
        }
        return $this->animal;                             // Return Token object
    }
    
    public function getImage()
    {
        if ($this->image === null) {                     // If $image property null
            $this->image = new Image($this->db);         // Create Token object
        }
        return $this->image;                             // Return Token object
    }



  
}