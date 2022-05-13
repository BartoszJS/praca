<?php
namespace PhpBook\CMS;                                   // Declare namespace

class Session
{                                                        // Define Session class
    public $id;                                          // Store member's id
    public $imie;                                    // Store member's imie
    public $role;                                        // Store member's role

    public function __construct()
    {                                                    // Runs when object created
        session_start();                                 // Start, or restart, session
        $this->id       = $_SESSION['id'] ?? 0;          // Set id property of this object
        $this->imie = $_SESSION['imie'] ?? '';   // Set imie property of this object
        $this->nazwisko = $_SESSION['nazwisko'] ?? '';   // Set imie property of this object
        $this->email = $_SESSION['email'] ?? '';   // Set imie property of this object
        $this->telefon = $_SESSION['telefon'] ?? '';   // Set imie property of this object
        $this->data_dolaczenia = $_SESSION['data_dolaczenia'] ?? '';   // Set imie property of this object
        $this->role     = $_SESSION['role'] ?? 'public'; // Set role property of this object
    }

    // Create new session
    public function create($member)
    {
        session_regenerate_id(true);                     // Update session id
        $_SESSION['id']       = $member['id'];           // Add member id to session
        $_SESSION['imie'] = $member['imie'];     // Add imie to session
        $_SESSION['nazwisko']     = $member['nazwisko'];
        $_SESSION['email'] = $member['email'];     // Add imie to session
        $_SESSION['telefon']     = $member['telefon'];   
        $_SESSION['data_dolaczenia']     = $member['data_dolaczenia'];
        $_SESSION['role']     = $member['role'];        // Add role to session
    }



    // Update existing session - alias for create()
    public function update($member)
    {
        $this->create($member);                          // Update data in session
    }

    // Delete existing session
    public function delete()
    {
        $_SESSION['id'] = 0;          // Set id property of this object
        $_SESSION['imie'] = '';   // Set imie property of this object
        $_SESSION['nazwisko'] = '';   // Set imie property of this object
        $_SESSION['email'] = '';   // Set imie property of this object
        $_SESSION['telefon'] = '';   // Set imie property of this object
        $_SESSION['data_dolaczenia'] = '';   // Set imie property of this object
        $_SESSION['role'] = 'public';                                 // Empty $_SESSION superglobal
        $param    = session_get_cookie_params();         // Get session cookie parameters
        setcookie(session_name(), '', time() - 2400, $param['path'], $param['domain'],
            $param['secure'], $param['httponly']);       // Clear session cookie
        session_destroy();                               // Destroy the session
    }
}