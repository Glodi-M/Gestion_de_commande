<?php

class Connect extends PDO
{
    const DB_HOST = 'localhost';
    const DB_NAME = 'ge-commande';
    const DB_USER = "root";
    const DB_PASS = "";


    public function __construct()
    {
        try {
            parent::__construct('mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME, self::DB_USER, self::DB_PASS);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            echo 'Connexion réussie';
        } catch (PDOException $e) {
            die('Erreur : ' . $e->getMessage());
        }
    }
}
