<?php

namespace ChatBot\Model;
use \PDO;

require_once("model/Manager.php");

class Reponses extends Manager
{
    public function getReponses()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT * FROM reponses');
        return $req;
    }
    
    public function getReponse($getId)
    {
        $db = $this->dbConnect();
        $reponse = $db->prepare('SELECT * FROM reponses WHERE id_reponse = :getId');
        $reponse->execute(array(':getId'=>$getId));
        return $reponse;
    }

    public function getReponseByWords($reponseToGet)
    {
        $db = $this->dbConnect();
        $reponse = $db->prepare('SELECT id_reponse FROM reponses WHERE response = :reponseToGet');
        $reponse->execute(array(':reponseToGet'=> $reponseToGet));
        return $reponse;
    }

    public function insertReponse($reponse)
    {
        $db = $this->dbConnect();
        $sql = "INSERT INTO reponses(response) VALUES (:reponse)";
        try {
            $sth = $db->prepare($sql);
            $sth->execute(array(":reponse" => $reponse));
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
        }
    }

    public function updateReponse($idReponse, $reponse)
    {
        $db = $this->dbConnect();
        $sql = "UPDATE reponses SET response = :reponse WHERE idReponse = :idReponse";
        try {
            $sth = $db->prepare($sql);
            $sth->execute(array(":idReponse" => $idReponse));
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
        }
        $result = $sth->fetch(PDO::FETCH_NUM); 
        return $result;
    }
}