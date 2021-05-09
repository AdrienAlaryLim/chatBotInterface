<?php

namespace ChatBot\Model;
use \PDO;

require_once("model/manager.php");

class Repondre extends Manager
{
    public function insertRepondre($idReponse, $idQuestion)
    {
        $db = $this->dbConnect();
        $sql = "INSERT INTO repondre(id_reponse, id_question, confiance, date_reponse) VALUES (:idReponse, :idQuestion, 100, DATE(NOW()))";
        try {
            $sth = $db->prepare($sql);
            $sth->execute(array(":idReponse" => $idReponse, ":idQuestion" => $idQuestion));
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
        }
    }

    public function deleteRepondreByQuestionAndConflicts($idQuestion, $conflicts)
    {
        $db = $this->dbConnect();
        $sql = "DELETE FROM repondre WHERE id_question =:idQuestion AND mots_cles_associes =:conflicts";
        try {
            $sth = $db->prepare($sql);
            $sth->execute(array(":idQuestion" => $idQuestion, ":conflicts" => $conflicts));
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
        }
    }

    public function getCoupleQRWeak()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT q.question, q.id_question, rs.response, r.confiance, rs.id_reponse, mots_cles_associes FROM questions q 
            INNER JOIN repondre r ON q.id_question = r.id_question 
            INNER JOIN reponses rs ON rs.id_reponse = r.id_reponse 
            WHERE r.confiance != 100');
        return $req;
    }

    public function getCouple($idQuestion, $idReponse)
    {
        $db = $this->dbConnect();
        $sql = 'SELECT q.question, q.id_question, rs.response, r.confiance, rs.id_reponse, mots_cles_associes FROM questions q 
            INNER JOIN repondre r ON q.id_question = r.id_question 
            INNER JOIN reponses rs ON rs.id_reponse = r.id_reponse 
            WHERE q.id_question = :idQuestion AND rs.id_reponse = :idReponse';
        try {
            $sth = $db->prepare($sql);
            $sth->execute(array(":idQuestion" => $idQuestion, ":idReponse" => $idReponse));
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
        }
        return $sth;
    }

    public function updateRepondre($newIdReponse, $idQuestion, $oldIdReponse)
    {
        $db = $this->dbConnect();
        $sql = "UPDATE repondre SET id_reponse = :newIdReponse, confiance = 100, questions_associees = NULL WHERE id_reponse = :oldIdReponse AND id_question = :idQuestion";
        try {
            $sth = $db->prepare($sql);
            $sth->execute(array(":newIdReponse" => $newIdReponse, ":oldIdReponse" => $oldIdReponse, ":idQuestion" => $idQuestion));
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
        }
    }
}