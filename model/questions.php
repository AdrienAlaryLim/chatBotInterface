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
}