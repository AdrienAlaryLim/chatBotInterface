<?php

// Chargement des classes
require_once('model/questions.php');
require_once('model/reponses.php');
require_once('model/repondre.php');
require_once('model/mots_cles.php');
require_once('model/contenir.php');

function getAccueil()
{
	require('view/frontend/accueil.php');
}

function getListQuestionsUnanswered()
{
    $ListQuestions = new \ChatBot\Model\Questions();
    $list = $ListQuestions->getQuestionsUnanswered();
    require('view/frontend/listQuestionsUnanswered.php');
}

function getListQuestionsWithoutMotCle()
{
    $ListQuestions = new \ChatBot\Model\Questions();
    $list = $ListQuestions->getQuestionsWithoutMotCle();
    require('view/frontend/listQuestionsWithoutMotCle.php');
}

function getListCoupleQRWeak()
{
    $ListQuestions = new \ChatBot\Model\Repondre();

    $list = $ListQuestions->getCoupleQRWeak();
    require('view/frontend/listCoupleWeak.php');
}

function getListReponses()
{
	$ListReponses = new \ChatBot\Model\Reponses();
    $list = $ListReponses->getReponses();
    require('view/frontend/listReponses.php');
}

function getMotsClesByMots($mots)
{
	$MotsCles = new \ChatBot\Model\Mots_cles();
    $list = $MotsCles->getMotsClesByMots($mots);
}

function insertReponse($reponseToSet, $idQuestion, $conflicted){
	$reponse = new \ChatBot\Model\Reponses();

	$reponse->insertReponse($reponseToSet);
	$list = $reponse->getReponseByWords($reponseToSet);
	$idNewReponse = $list->fetch();
	associateReponse($idNewReponse['id_reponse'], $idQuestion, $conflicted);
}

function associateReponse($reponseToSet, $idQuestion, $conflicted){
	$repondre = new \ChatBot\Model\Repondre();
	if(null == $conflicted || '' == trim($conflicted))
	{
		$repondre->insertRepondre($reponseToSet, $idQuestion);
		header('Location: index.php?action=listQuestionsUnanswered');
	}
	else
	{
		$repondre->deleteRepondreByQuestionAndConflicts($idQuestion, $conflicted);
		$repondre->insertRepondre($reponseToSet, $idQuestion);
		header('Location: index.php?action=listCoupleQRWeak');
	}
}

function insertMotCle($motCleToSet, $idQuestion){
	$motCle = new \ChatBot\Model\Mots_cles();

	$motCle->insertMotCle($motCleToSet);
	associateMotCle($motCleToSet, $idQuestion);
}

function associateMotCle($motCleToSet, $idQuestion){
	$motCle = new \ChatBot\Model\Mots_cles();
	$contenir = new \ChatBot\Model\Contenir();

	$list = $motCle->getMotCleByMot($motCleToSet);
	$data = $list->fetch();

	$contenir->insertContenir($data['id_mot_cle'], $idQuestion);
	header('Location: index.php?action=listQuestionsWithoutMotCle');
}

function insertReponseUpdateRepondre($reponseToSet, $idQuestion, $initialIdReponse){
	$reponse = new \ChatBot\Model\Reponses();
	$repondre = new \ChatBot\Model\Repondre();

	$reponse->insertReponse($reponseToSet);
	$list = $reponse->getReponseByWords($reponseToSet);
	$data = $list->fetch();

	$repondre->updateRepondre($data['id_reponse'], $idQuestion, $initialIdReponse);

	header('Location: index.php?action=listCoupleQRWeak');
}

function creerReponse(){
	$idQuestion = $_GET['idQuestion'];
	$conflicted = isset($_GET['conflicts']) ? $_GET['conflicts'] : '';
	$searchReponse = isset($_POST['searchReponse']) ? $_POST['searchReponse'] : '';
	$selectReponse = isset($_POST['selectReponse']) ? $_POST['selectReponse'] : '';
	$createReponse = isset($_POST['createReponse']) ? $_POST['createReponse'] : '';
	$submitSearch = isset($_POST['submitSearch']) ? $_POST['submitSearch'] : '';
	$submitAssociate = isset($_POST['submitAssociate']) ? $_POST['submitAssociate'] : '';
	$submitCreate = isset($_POST['submitCreate']) ? $_POST['submitCreate'] : '';

    $Questions = new \ChatBot\Model\Questions();
    $question = $Questions->getQuestion($idQuestion);

	$ListReponses = new \ChatBot\Model\Reponses();
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
		associateReponse($selectReponse, $idQuestion, $conflicted);
	}

	if ($submitCreate) 
	{
		if($createReponse == null || trim($createReponse) == "") 
		{
			echo '<script type="text/javascript"> alert("La réponse saisie est invalide"); </script>';
		}else{
			//TODO vérification séparation mot clé
			insertReponse($createReponse, $idQuestion, $conflicted);
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

    $Questions = new \ChatBot\Model\Questions();
    $question = $Questions->getQuestion($idQuestion);
    
    $ListMotsCles = new \ChatBot\Model\Mots_cles();
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

function modifierCouple(){
	$idQuestion = $_GET['idQuestion'];
	$idReponse = $_GET['idReponse'];
	//$reponseToSet = isset($_POST['reponse']) ? $_POST['reponse'] : '';
	$submitConfirm = isset($_POST['submitConfirm']) ? $_POST['submitConfirm'] : '';
	$submitModify = isset($_POST['submitModify']) ? $_POST['submitModify'] : '';
	$conflicts = isset($_POST['conflicts']) ? $_POST['conflicts'] : '';

    $repondre = new \ChatBot\Model\Repondre();
    $list = $repondre->getCouple($idQuestion, $idReponse);    
    
    if ($submitConfirm) 
	{
		associateReponse($idReponse, $idQuestion, $conflicts);
	}

	if ($submitModify) 
	{
		header('Location: index.php?action=creerReponse&idQuestion='.$idQuestion.'&conflicts='.$conflicts);
	}

	require('view/frontend/modifierCouple.php');
}

function dateFormat($stringDate)
{
	setlocale(LC_TIME, "fr_FR.utf8", "fra");
	$format = "%d/%m/%Y";
	$formated = strftime($format, strtotime($stringDate));

	return $formated;
}