<?php

// Chargement des classes
require_once('model/utilisateur.php');
require_once('model/questions.php');
require_once('model/reponses.php');
require_once('model/repondre.php');
require_once('model/mots_cles.php');
require_once('model/contenir.php');

function getAccueil()
{
	require('view/frontend/accueil.php');
}

function getListQuestions()
{
    $ListQuestions = new \ChatBot\Model\questions();
    $list = $ListQuestions->getQuestions();
    require('view/frontend/listQuestions.php');
}

function getQuestion()
{
    $ListQuestions = new \ChatBot\Model\questions();
    $list = $ListQuestions->getQuestions();
    require('view/frontend/listQuestions.php');
}

function getListQuestionsUnanswered()
{
    $ListQuestions = new \ChatBot\Model\questions();
    $list = $ListQuestions->getQuestionsUnanswered();
    require('view/frontend/listQuestionsUnanswered.php');
}

function getListQuestionsWithoutMotCle()
{
    $ListQuestions = new \ChatBot\Model\questions();
    $list = $ListQuestions->getQuestionsWithoutMotCle();
    require('view/frontend/listQuestionsWithoutMotCle.php');
}

function getListCoupleQRWeak()
{
    $ListQuestions = new \ChatBot\Model\repondre();

    $list = $ListQuestions->getCoupleQRWeak();
    require('view/frontend/listCoupleWeak.php');
}

function getListReponses()
{
	$ListReponses = new \ChatBot\Model\reponses();
    $list = $ListReponses->getReponses();
    require('view/frontend/listReponses.php');
}

function getMotsClesByMots($mots)
{
	$MotsCles = new \ChatBot\Model\mots_cles();
    $list = $MotsCles->getMotsClesByMots($mots);
    //require('view/frontend/listReponses.php');
}

function insertReponse($reponseToSet, $idQuestion){
	$reponse = new \ChatBot\Model\reponses();

	$reponse->insertReponse($reponseToSet);
	associateReponse($reponseToSet, $idQuestion);
}

function associateReponse($reponseToSet, $idQuestion){
	$reponse = new \ChatBot\Model\reponses();
	$repondre = new \ChatBot\Model\repondre();
	$list = $reponse->getReponseByWords($reponseToSet);
	$data = $list->fetch();

	$repondre->insertRepondre($data['id_reponse'], $idQuestion);
	header('Location: index.php?action=listQuestionsUnanswered');
}

function insertMotCle($motCleToSet, $idQuestion){
	$motCle = new \ChatBot\Model\mots_cles();

	$motCle->insertMotCle($motCleToSet);
	associateMotCle($motCleToSet, $idQuestion);
}

function associateMotCle($motCleToSet, $idQuestion){
	$motCle = new \ChatBot\Model\mots_cles();
	$contenir = new \ChatBot\Model\contenir();

	$list = $motCle->getMotCleByMot($motCleToSet);
	$data = $list->fetch();

	$contenir->insertContenir($data['id_mot_cle'], $idQuestion);
	header('Location: index.php?action=listQuestionsWithoutMotCle');
}

function insertReponseUpdateRepondre($reponseToSet, $idQuestion, $initialIdReponse){
	$reponse = new \ChatBot\Model\reponses();
	$repondre = new \ChatBot\Model\repondre();

	$reponse->insertReponse($reponseToSet);
	$list = $reponse->getReponseByWords($reponseToSet);
	$data = $list->fetch();

	$repondre->updateRepondre($data['id_reponse'], $idQuestion, $initialIdReponse);

	header('Location: index.php?action=listCoupleQRWeak');
}

function creerReponse(){
	$idQuestion = $_GET['idQuestion'];
	$searchReponse = isset($_POST['searchReponse']) ? $_POST['searchReponse'] : '';
	$selectReponse = isset($_POST['selectReponse']) ? $_POST['selectReponse'] : '';
	$createReponse = isset($_POST['createReponse']) ? $_POST['createReponse'] : '';
	$submitSearch = isset($_POST['submitSearch']) ? $_POST['submitSearch'] : '';
	$submitAssociate = isset($_POST['submitAssociate']) ? $_POST['submitAssociate'] : '';
	$submitCreate = isset($_POST['submitCreate']) ? $_POST['submitCreate'] : '';

    $Questions = new \ChatBot\Model\questions();
    $question = $Questions->getQuestion($idQuestion);

	$ListReponses = new \ChatBot\Model\reponses();
    $listReponses = $ListReponses->getReponsesInWordsLike($searchReponse);

    if ($submitSearch)
	{
		if($searchReponse == null || trim($searchReponse) == "") 
		{
			echo '<script type="text/javascript"> alert("Entrez une combinaisons de mots clés valide"); </script>';
		}
	}

	if ($submitAssociate) 
	{
		associateReponse($selectReponse, $idQuestion);
	}

	if ($submitCreate) 
	{
		if($createReponse == null || trim($createReponse) == "") 
		{
			echo '<script type="text/javascript"> alert("La réponse saisie est invalide"); </script>';
		}else{
			//TODO véification séparation mot clé
			insertReponse($createReponse, $idQuestion);
		}
	}
	require('view/frontend/creerReponse.php');
}

function creerMotCle(){
	$idQuestion = $_GET['idQuestion'];
	$searchMotCle = isset($_POST['searchMotCle']) ? $_POST['searchMotCle'] : '';
	$selectMotCle = isset($_POST['selectMotCle']) ? $_POST['selectMotCle'] : '';
	$createMotCle = isset($_POST['createMotCle']) ? $_POST['createMotCle'] : '';
	$submitSearch = isset($_POST['submitSearch']) ? $_POST['submitSearch'] : '';
	$submitAssociate = isset($_POST['submitAssociate']) ? $_POST['submitAssociate'] : '';
	$submitCreate = isset($_POST['submitCreate']) ? $_POST['submitCreate'] : '';

    $Questions = new \ChatBot\Model\questions();
    $question = $Questions->getQuestion($idQuestion);
    
    $ListMotsCles = new \ChatBot\Model\mots_cles();
    $listMotsCles = $ListMotsCles->getMotsClesByMots($searchMotCle);
    
    if ($submitSearch)
	{
		if($searchMotCle == null || trim($searchMotCle) == "") 
		{
			echo '<script type="text/javascript"> alert("Entrez une combinaisons de mots clés valide"); </script>';
		}
	}

	if ($submitAssociate) 
	{
		associateMotCle($selectMotCle, $idQuestion);
	}

	if ($submitCreate) 
	{
		if($createMotCle == null || trim($createMotCle) == "") 
		{
			echo '<script type="text/javascript"> alert("La mot clé saisit est invalide"); </script>';
		}else{
			//TODO véification séparation mot clé
			insertMotCle($createMotCle, $idQuestion);
		}
	}

	require('view/frontend/creerMotCle.php');

	
}

function modifierReponse(){

}

function modifierCouple(){
	$idQuestion = $_GET['idQuestion'];
	$idReponse = $_GET['idReponse'];
	$reponseToSet = isset($_POST['reponse']) ? $_POST['reponse'] : '';
	$submit=isset($_POST['submit']) ? $_POST['submit'] : '';

    $repondre = new \ChatBot\Model\repondre();
    $list = $repondre->getCouple($idQuestion, $idReponse);
    require('view/frontend/modifierCouple.php');

    if ($submit) 
	{
		if($reponseToSet == null || trim($reponseToSet) == "") 
		{
			echo '<script type="text/javascript"> alert("La réponse saisie est invalide"); </script>';
		}else{
			insertReponseUpdateRepondre($reponseToSet, $idQuestion, $idReponse);
		}
	}
}
