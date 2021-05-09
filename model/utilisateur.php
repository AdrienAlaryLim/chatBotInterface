<?php

namespace ChatBot\Model;
use \PDO;
require_once("model/manager.php");

class Utilisateur extends Manager
{
    public function getUtilisateurByMail($MailUtilisateur)
    {
        $db = $this->dbConnect();
        $req = $db->prepare('SELECT * FROM utilisateur where MailUtilisateur = :MailUtilisateur');
        $req->execute(array(':MailUtilisateur' => $MailUtilisateur));
        $result = $req->fetch(PDO::FETCH_NUM);
        return $result;
    }

    function find($MailUtilisateur) 
    {
	  	$db = $this->dbConnect();
	    $sql = "select MailUtilisateur, MdpUtilisateur, IdUtilisateur from utilisateur where MailUtilisateur=:MailUtilisateur";
	    try {
	    	$sth = $db->prepare($sql);
	        $sth->execute(array(":MailUtilisateur" => $MailUtilisateur));
	        
	    } catch (PDOException $e) {
	        throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
	    }
	    print_r($sth);
	    return $sth;
    }

    function creationUtilisateur($utilisateur) 
    {
		$db = $this->dbConnect();
		$sql = "INSERT INTO Utilisateur(MailUtilisateur ,MdpUtilisateur ,NomUtilisateur, AdresseUtilisateur) VALUES ( :MailUtilisateur, :MdpUtilisateur, :NomUtilisateur, :AdresseUtilisateur)";
		try {
			$sth = $db->prepare($sql);

		    $sth->execute(array(":MailUtilisateur" => $utilisateur['MailUtilisateur'], ":MdpUtilisateur" => $utilisateur['MdpUtilisateur'], ":NomUtilisateur" => $utilisateur['NomUtilisateur'], ":AdresseUtilisateur" => $utilisateur['AdresseUtilisateur']));
		} catch (PDOException $e) {
			throw new Exception("Erreur lors de la requête SQL : " . $e->getMessage());
		}
	}
}