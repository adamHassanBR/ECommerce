<?php

require_once("./config/database.php");

class Bdd
{
    private $link = null;
    private $sth = null;

    function __construct()
    {
        try
        {
            $this->link = new PDO('mysql:host='.BDD_HOST.'; dbname='.BDD_BDD, BDD_USER, BDD_PASSWORD);
        }
        catch (PDOExeption $e)
        {
            echo "Erreur !: ". $e->getMessage(). "<br>";
            die();
        }
    }

    function execute ($sql, $data = null)
    {
        $this->sth = $this->link->prepare($sql);
        return  $this->sth->execute($data);
    }

    public function fetch ($sql, $data = null) 
    {
        $this->execute($sql, $data);
        return $this->sth->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll ($sql, $data = null) 
    {
        $this->execute($sql, $data);
        return $this->sth->fetchAll(PDO::FETCH_ASSOC);
    }
}

?>