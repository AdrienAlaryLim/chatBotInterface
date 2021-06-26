<?php

namespace ChatBot\Model;
use \PDO;

require_once("model/manager.php");

class Mots_cles extends Manager
{    
    public function getMotCle($getId)
    {
        $db = $this->dbConnect();
        $question = $db->prepare('SELECT * FROM mots_cles WHERE id_mot_cle = :getId');
        $question->execute(array(':getId'=>$getId));
        return $question;
    }

    public function getMotCleByMot($getMot)
    {
        $db = $this->dbConnect();
        $question = $db->prepare('SELECT * FROM mots_cles WHERE mot = :getMot');
        $question->execute(array(':getMot'=>$getMot));
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
        $req->execute();
        $result = $req->fetch(PDO::FETCH_NUM); 
        return $result;
    }

    public function getMotsClesByMots($stringWords)
    {
        $array = explode("/", $stringWords);
        $count = 1;
        $stringRequest = "";
        foreach ($array as $word) {
            if($count == 1)
            {
                
                $stringRequest = "LIKE '%".$word."%/%'";
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
        $req->execute();
        return $req;
    }

    public function insertMotCle($motCle)
    {
        $db = $this->dbConnect();
        $sql = "INSERT INTO mots_cles(mot) VALUES (:motCle)";
        try {
            $sth = $db->prepare($sql);
            $sth->execute(array(":motCle" => $motCle));
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
        }
    }

    public function getMotsClesSoundsLike($stringWords)
    {
        $array = explode("/", $stringWords);
        $count = 1;
        $stringRequest = "";
        foreach ($array as $word) {
            if($count == 1)
            {
                
                $stringRequest = "LIKE '%".$word."/%'";
                $count++;
            }
            else if(sizeof($array) != $count)
            {
                $stringRequest = $stringRequest." OR mot LIKE '%".$word."/%'";
                $count++;
            }
        }

        $db = $this->dbConnect();
        $req = $db->query('SELECT id_mot_cle, mot FROM mots_cles WHERE mot SOUNDS '.$stringRequest);

        $req->execute();
        $array = array();
        if (!empty($req)) {
            while ($data = $req->fetch())
            {
                $line = array('id_mot_cle' => $data["id_mot_cle"], 'mot' =>$data["mot"]);
                array_push($array, $line);
            }
            $stringResult = json_encode($array);
        }
            else 
                $stringResult = "No result";

        return $stringResult;
    }
    
}