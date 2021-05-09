<?php

namespace ChatBot\Model;
use \PDO;

require_once("model/manager.php");

class Contenir extends Manager
{
    public function insertContenir($idMotCle, $idQuestion)
    {
        $db = $this->dbConnect();
        $sql = "INSERT INTO contenir(id_mot_cle, id_question) VALUES (:idMotCle, :idQuestion)";
        try {
            $sth = $db->prepare($sql);
            $sth->execute(array(":idMotCle" => $idMotCle, ":idQuestion" => $idQuestion));
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
        }
    }
}