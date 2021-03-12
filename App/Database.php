<?php
namespace App;

use PDO;
use Exception;

class Database
{
    private $dns;
    private $login;
    private $password;
    private $pdo;

    public function __construct()
    {
        $this->login = $_ENV['DB_USERNAME'];
        $this->password = $_ENV['DB_PASSWORD'];
        $this->dns = 'mysql:host=' . $_ENV['DB_HOST'] . ';dbname=' . $_ENV['DB_NAME'] . ';charset=utf8;port=' . $_ENV['DB_PORT'];
        $this->setPDO();
    }

    private function setPDO()
    {
        if ($this->pdo === null) {
            try {
                $pdo = new PDO($this->dns, $this->login, $this->password);
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->pdo = $pdo;
            } catch (Exception $e) {
                echo 'Exception reçue : ' . $e->getMessage() . "\n";
            }
        }
    }

    private function request($request, $values, $type)
    {
        try {
            $request = $this->pdo->prepare($request);
            $request->execute($values);
            if ($type === 'fetchAll') {
                return $request->fetchAll(PDO::FETCH_ASSOC);
            } elseif ($type === 'fetch') {
                return $request->fetch();
            } else {
                return $request;
            }
        } catch (Exception $e) {
            die('Erreur: ' . $e->getMessage());
        }
    }

    public function getRequest($request, $values, $type = '')
    {
        return $this->request($request, $values, $type);
    }
}
