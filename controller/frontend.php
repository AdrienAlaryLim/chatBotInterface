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
	$repondre = new \ChatBot\Model\repondre();

	$reponse->insertReponse($reponseToSet);

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
	$reponseToSet = isset($_POST['reponse']) ? $_POST['reponse'] : '';
	$submitRecherche=isset($_POST['submitRecherche']) ? $_POST['submitRecherche'] : '';
	$submitAssignation=isset($_POST['submitAssignation']) ? $_POST['submitAssignation'] : '';

    $ListQuestions = new \ChatBot\Model\questions();
    $list = $ListQuestions->getQuestion($idQuestion);
    require('view/frontend/creerReponse.php');

    if ($submitAssignation)
	{
		if($reponseToSet == null || trim($reponseToSet) == "") 
		{
			echo '<script type="text/javascript"> alert("La réponse saisie est invalide"); </script>';
		}else{
			insertReponse($reponseToSet, $idQuestion);
		}
	}
}

function creerMotCle(){
	$idQuestion = $_GET['idQuestion'];
	$searchMotCle = isset($_POST['searchMotCle']) ? $_POST['searchMotCle'] : '';
	$selectMotCle = isset($_POST['selectMotCle']) ? $_POST['selectMotCle'] : '';
	$createMotCle = isset($_POST['createMotCle']) ? $_POST['createMotCle'] : '';
	//$submit = isset($_POST['submit']) ? $_POST['submit'] : '';
	$submitSearch = isset($_POST['submitSearch']) ? $_POST['submitSearch'] : '';
	$submitAssociate = isset($_POST['submitAssociate']) ? $_POST['submitAssociate'] : '';
	$submitCreate = isset($_POST['submitCreate']) ? $_POST['submitCreate'] : '';

    $Questions = new \ChatBot\Model\questions();
    $question = $Questions->getQuestion($idQuestion);
    
    $ListMotsCles = new \ChatBot\Model\mots_cles();
    $listMotsCles = $ListMotsCles->getMotsClesByMots($searchMotCle);

    //$ListMotsCles = new \ChatBot\Model\mots_cles();
    //$insertMotCle = $ListMotsCles->getMotsClesByMots($searchMotCle);
    
    if ($submitSearch) //$submitSearch
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
			echo '<script type="text/javascript"> alert("La réponse saisie est invalide"); </script>';
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

/*function getUtilisateur()
{
	$utilisateurByMail = new \ChatBot\Model\utilisateur();
	$utilisateur = $utilisateurByMail->getutilisateurByMail($_SESSION['mailUtilisateur']);
	$data = $utilisateur->fetch();
}

function connectUtilisateur()
{
	$inscription = false;
	$submit=isset($_POST['submit']) ? $_POST['submit'] : '';
	require('view/frontend/connexion.php');
	$MailUtilisateur = isset($_POST['mailUtilisateur']) ? $_POST['mailUtilisateur'] : '';
	$MdpUtilisateur = isset($_POST['mdpUtilisateur']) ? hash('gost-crypto', $_POST['mdpUtilisateur']) : '';
	echo $MdpUtilisateur;
	
	if ($submit) 
	{
		$utilisateur = new \ChatBot\Model\utilisateur();
		
		$tabUtilisateur = $utilisateur->find($MailUtilisateur)->fetch();
		
		if ($tabUtilisateur['mailUtilisateur']== $MailUtilisateur && $tabUtilisateur['mdpUtilisateur']== $MdpUtilisateur)
		{
			$_SESSION['mailUtilisateur'] = $MailUtilisateur;
			$_SESSION['idUtilisateur'] = $tabUtilisateur['idUtilisateur'];
			header('Location: index.php');
		}
		else 
		{
			echo '<script type="text/javascript"> alert("Utilisateur ou mot de passe non reconnu "); </script>';   
		}
	}
}

function inscriptionUtilisateur()
{
	$inscription = true;
	$submit=isset($_POST['submit']) ? $_POST['submit'] : '';
	require('view/frontend/connexion.php');
	$MailUtilisateur = isset($_POST['mailUtilisateur']) ? $_POST['mailUtilisateur'] : '';
	$MdpUtilisateur = isset($_POST['mdpUtilisateur']) ? hash('gost-crypto', $_POST['mdpUtilisateur']) : '';
	$VerifMdp =  isset($_POST['verifMdp']) ? hash('gost-crypto', $_POST['verifMdp']) : '';
	$AdresseUtilisateur = isset($_POST['adresseUtilisateur']) ? $_POST['adresseUtilisateur'] : '';
	$NomUtilisateur = isset($_POST['nomUtilisateur']) ? $_POST['nomUtilisateur'] : '';

    if ($submit)
    {
        if($MdpUtilisateur == $VerifMdp)
        {
			$tableau = array("mailUtilisateur" => $MailUtilisateur, "mdpUtilisateur" => $MdpUtilisateur, "nomUtilisateur" => $NomUtilisateur, "adresseUtilisateur" => $AdresseUtilisateur);
			$utilisateur = new \ChatBot\Model\utilisateur();
			$utilisateur->creationUtilisateur($tableau);
			header('Location: index.php?action=connexionUtilisateur');
        }
        else {
        	echo "les deux mots de passes sont différents";
        }
    }
}

function deconnexionUtilisateur()
{
	session_start();
	session_unset();
	session_destroy();
	header('Location: index.php');
}*/
