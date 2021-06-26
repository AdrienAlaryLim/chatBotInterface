<?php

namespace ChatBot\Model;
use \PDO;

require_once("model/manager.php");

class Reponses extends Manager
{
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

    public function getReponsesInWordsLike($words)
    {
        $array = explode("/", $words);
        $count = 1;
        $stringRequest = "";
        if($array[0] != null || trim($array[0]) != "")
        {
            foreach ($array as $word) {
                if($count == 1)
                {
                    $stringRequest = " WHERE response LIKE '%".$word."%'";
                    $count++;
                }
                else if(sizeof($array) != $count)
                {
                    $stringRequest = $stringRequest." OR response LIKE '%".$word."%'";
                    $count++;
                }
            }
        }

        $db = $this->dbConnect();
        $req = $db->query("SELECT * FROM reponses".$stringRequest);
        $req->execute();
        return $req;
    }


    public function getReponseByMotCle($motCle)
    {
        $db = $this->dbConnect();
        $sql = $db->prepare('SELECT r.id_reponse, r.response FROM reponses r INNER JOIN repondre ON  repondre.id_reponse = r.id_reponse INNER JOIN questions ON  questions.id_question = repondre.id_question INNER JOIN contenir ON  contenir.id_question = questions.id_question INNER JOIN mots_cles ON mots_cles.id_mot_cle = contenir.id_mot_cle WHERE mots_cles.mot = :motCle');
        $sql->execute(array(':motCle'=>$motCle));

        $array = null;
        if (!empty($sql)) {
            while ($data = $sql->fetch())
            {
                $array = array('id_reponse' => $data["id_reponse"], 'reponse' => $data["response"]);
            }
            $stringResult = json_encode($array);
        }
            else 
                $stringResult = "No result";

        return $stringResult;

    }

    public function getReponseByIdQuestion($idQuestion)
    {

        $db = $this->dbConnect();
        $sql = $db->prepare(' SELECT r.response FROM reponses r INNER JOIN repondre ON  r.id_reponse = repondre.id_reponse INNER JOIN questions q ON q.id_question = repondre.id_question WHERE q.id_question = :idQuestion');
        $sql->execute(array(':idQuestion'=>$idQuestion));

        $array = null;
        if (!empty($sql)) {
            while ($data = $sql->fetch())
            {
                $array = array('reponse' => $data["response"]);
            }
            $stringResult = json_encode($array);
        }
            else 
                $stringResult = "No result";

        return $stringResult;
       
    }

}