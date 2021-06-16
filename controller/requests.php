<?php

// Chargement des classes

function getQuestionById()
{
    $questionId = (isset($_GET['idQuestion'])) ? $_GET['idQuestion'] : "";
    $question = new \ChatBot\Model\Questions();
    $result = $question->requestGetQuestionById($questionId);

    require('view/request/resultSql.php');
}

