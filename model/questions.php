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
                //$stringResult = $stringResult . $data["id_question"] . ";" . $data["date_question"] . ";" . $data["question"]. "~\r";

            }
            $stringResult = json_encode($array);
        }
            else 
                $stringResult = "No result";

        return $stringResult;
    }

}