<?php

namespace ChatBot\Model;
use \PDO;

require_once("model/manager.php");

class Contenir extends Manager
{
    public function getMotsCles()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT * FROM Questions');
        return $req;
    }
    
    public function getMotCle($getId)
    {
        $db = $this->dbConnect();
        $question = $db->prepare('SELECT * FROM mots_cles WHERE id_mot_cle = :getId');
        $question->execute(array(':getId'=>$getId));
        return $question;
    }

    public function getMotsClesInQuestion($question)
    {
        $array = explode(" ", $question);
        $count = 1;
        $stringRequest = "";
        foreach ($array as $word) {
            if($count == 1)
            {
                $stringRequest = "LIKE '%" + $word + "/%'";
                $count++;
            }
            else if(sizeof($array) != $count)
            {
                $stringRequest = $stringRequest." OR mot LIKE '%".$word."/%'";
                $count++;
            }
        }

        $db = $this->dbConnect();
        $req = $db->query('SELECT * FROM mots_cles WHERE mot '.$stringRequest);
        $reponse->execute();
        $result = $sth->fetch(PDO::FETCH_NUM); 
        return $result;
    }

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