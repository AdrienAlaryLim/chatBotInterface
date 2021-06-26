<?php

namespace ChatBot\Model;
use \PDO;

require_once("model/manager.php");

class Questions extends Manager
{
    public function getQuestion($getId)
    {
        $db = $this->dbConnect();
        $question = $db->prepare('SELECT * FROM questions WHERE id_question = :getId');
        $question->execute(array(':getId'=>$getId));
        return $question;
    }

    public function getQuestionsUnanswered()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT q.id_question, q.date_question, q.question FROM questions q LEFT JOIN repondre r ON q.id_question = r.id_question WHERE r.id_question IS NULL');
        return $req;
    }

    public function getQuestionsWithoutMotCle()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT q.id_question, q.date_question, q.question FROM questions q LEFT JOIN contenir c ON q.id_question = c.id_question WHERE c.id_question IS NULL');
        return $req;
    }

    public function requestGetQuestionById($questionId)
    {
        $db = $this->dbConnect();
        $sql = $db->prepare('SELECT * FROM questions WHERE id_question = :questionId');
        $sql->execute(array('questionId' => $questionId));

        
        $array = null;
        if (!empty($sql)) {
            while ($data = $sql->fetch())
            {
                $array = array('id_question' => $data["id_question"], 'date_question' =>$data["date_question"], 'question' => $data["question"]);
            }
            $stringResult = json_encode($array);
        }
            else 
                $stringResult = "No result";

        return $stringResult;
    }

    public function requestGetQuestionByWords($words)
    {
        $db = $this->dbConnect();
        $sql = $db->prepare('SELECT id_question, date_question, question FROM questions WHERE question = :words');
        $sql->execute(array('words' => $words));

        
        $array = null;
        if (!empty($sql)) {
            while ($data = $sql->fetch())
            {
                $array = array('id_question' => $data["id_question"], 'date_question' =>$data["date_question"], 'question' => $data["question"]);
            }
            $stringResult = json_encode($array);
        }
            else 
                $stringResult = "No result";

        return $stringResult;
    }

    public function requestInsertQuestion($question)
    {
        $db = $this->dbConnect();
        $sql = "INSERT INTO questions (question, date_question) VALUES (:question, NOW())";
        try {
            $sth = $db->prepare($sql);
            $sth->execute(array(':question' => $question));
        } catch (PDOException $e) {
            throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
        }
    }

    public function requestQuestionsUnanswered()
    {
        $db = $this->dbConnect();
        $req = $db->query('SELECT question FROM questions q WHERE q.id_question NOT IN (SELECT repondre.id_question FROM repondre)');

        $req->execute();
        $array = array();
        if (!empty($req)) {
            while ($data = $req->fetch())
            {
                $line = array('question' => $data["question"]);
                array_push($array, $line);
            }
            $stringResult = json_encode($array);
        }
            else 
                $stringResult = "No result";

        return $stringResult;
    }
}