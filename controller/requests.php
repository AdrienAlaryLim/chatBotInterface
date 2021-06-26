<?php

// Chargement des classes

function getQuestionById()
{
    $questionId = (isset($_GET['idQuestion'])) ? $_GET['idQuestion'] : "";
    $question = new \ChatBot\Model\Questions();
    $result = $question->requestGetQuestionById($questionId);

    require('view/request/resultSql.php');
}

function getQuestionByWords()
{
    $words = (isset($_GET['question'])) ? $_GET['question'] : "";

    $words = str_replace("_", " ", $words);
    $question = new \ChatBot\Model\Questions();
    $result = $question->requestGetQuestionByWords($words);

    require('view/request/resultSql.php');
}

function insertQuestion()
{
    $words = (isset($_GET['question'])) ? $_GET['question'] : "";

    $words = str_replace("_", " ", $words);
    $question = new \ChatBot\Model\Questions();
    $question->requestInsertQuestion($words);

    $result = $question->requestGetQuestionByWords($words);

    require('view/request/resultSql.php');
}

function motCleSounds()
{
    $motsCles = (isset($_GET['motsCles'])) ? $_GET['motsCles'] : "";

    $motCle = new \ChatBot\Model\Mots_cles();
    $result = $motCle->getMotsClesSoundsLike($motsCles);

    require('view/request/resultSql.php');
}

function getReponseByMotCle()
{
    $motsCles = (isset($_GET['motsCles'])) ? $_GET['motsCles'] : "";

    $reponse = new \ChatBot\Model\Reponses();
    $result = $reponse->getReponseByMotCle($motsCles);

    require('view/request/resultSql.php');
}

function getReponseByIdQuestion()
{
    $idQuestion = (isset($_GET['idQuestion'])) ? $_GET['idQuestion'] : "";

    $reponse = new \ChatBot\Model\Reponses();
    $result = $reponse->getReponseByIdQuestion($idQuestion);

    require('view/request/resultSql.php');
}

function requestInsertReponse()
{
    $idQuestion = (isset($_GET['idQuestion'])) ? $_GET['idQuestion'] : "";
    $idReponse = (isset($_GET['idReponse'])) ? $_GET['idReponse'] : "";
    $confiance = (isset($_GET['confiance'])) ? $_GET['confiance'] : "";
    $conflits = (isset($_GET['conflits'])) ? $_GET['conflits'] : "";

    $repondre = new \ChatBot\Model\Repondre();
    $result = $repondre->requestInsertRepondre($idQuestion, $idReponse, $confiance, $conflits);

    require('view/request/resultSql.php');
}

function questionUnanswered()
{
    $question = new \ChatBot\Model\Questions();
    $result = $question->requestQuestionsUnanswered();

    require('view/request/resultSql.php');
}