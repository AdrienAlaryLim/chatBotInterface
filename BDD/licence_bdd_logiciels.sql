#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Database : Licence_BDD
#------------------------------------------------------------

DROP DATABASE if EXISTS Licence_BDD;
CREATE DATABASE Licence_BDD;
USE Licence_BDD;

#------------------------------------------------------------
# Table: Licence
#------------------------------------------------------------

CREATE TABLE Licence(
        IdLicence   Int  Auto_increment  NOT NULL ,
        Libelle     Varchar (25) NOT NULL ,
        Description Text NOT NULL ,
        DureeValide Text NOT NULL,
        Prix        Float NOT NULL
	,CONSTRAINT Licence_PK PRIMARY KEY (IdLicence)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Utilisateur
#------------------------------------------------------------

CREATE TABLE Utilisateur(
        IdUtilisateur      Int Auto_increment NOT NULL ,
        MailUtilisateur    Varchar (120) NOT NULL ,
        NomUtilisateur     Varchar (30) NOT NULL ,
        MdpUtilisateur     Varchar (150) NOT NULL ,
        AdresseUtilisateur Varchar (80) NOT NULL,
	MacUtilisateur Varchar (40) NOT NULL
        ,CONSTRAINT Utilisateur_PK PRIMARY KEY (IdUtilisateur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: acheter
#------------------------------------------------------------

CREATE TABLE acheter(
        IdUtilisateur     Int NOT NULL ,
        IdLicence         Int NOT NULL ,
        IdLogiciel		  Int NOT NULL ,
        DateAchat		  Date,
        GenerationLicence Varchar (150) default NULL,
        AdresseMac 		  Varchar (150) default NULL
	,CONSTRAINT acheter_PK PRIMARY KEY (IdUtilisateur,IdLicence)

	,CONSTRAINT acheter_Utilisateur_FK FOREIGN KEY (IdUtilisateur) REFERENCES Utilisateur(IdUtilisateur)
	,CONSTRAINT acheter_Licence0_FK FOREIGN KEY (IdLicence) REFERENCES Licence(IdLicence)
)ENGINE=InnoDB;

#------------------------------------------------------------
# Table: Logiciels
#------------------------------------------------------------

CREATE TABLE Logiciel(
        IdLogiciel	      Int Auto_increment NOT NULL ,
        NomLogiciel       Varchar (40) NOT NULL,  
        DescriptionLogiciel Text NOT NULL,       
	CONSTRAINT Logiciel_PK PRIMARY KEY (IdLogiciel)
)ENGINE=InnoDB;

#------------------------------------------------------------
# Insertion : Licence
#------------------------------------------------------------

INSERT INTO Licence (Libelle, Description, DureeValide, Prix) VALUES
('Mensuelle', "Cette licence n'est active que durant 30 jours à compter du jour de l'achat. Elle permet d'accéder à toutes les fonctionnalité pendant sa durée d'activation", '30','35'),
#('Ponctuelle 30j', "Cette licence consomme un jeton à chaque démmarage du logiciel. Chaque jeton consommé est valable pendant 10 heures. Au bout de 10 heures d'utilisation, le programme se ferme en sauvegardant votre travail", '60'),
('Annuelle', "Cette licence est active durant 360 jours à compter du jour de l'achat. Elle permet d'accéder à toutes les fonctionnalité pendant sa durée d'activation", '365','350');


#------------------------------------------------------------
# Insertion : Logiciel
#------------------------------------------------------------

INSERT INTO Logiciel (NomLogiciel, DescriptionLogiciel) VALUES
( 'Word', 'Logiciel permmetant le traitement de texte.' ),
( 'Excel', 'Tableur permmetant de faciliter une multitudes de tâches liées aux calculs.' ),
( 'PdfCreator', 'Logiciels de génrétation de PDF, et de modifications de ces derniers.' ),   
( 'Audacity', 'Logiciel de traitement de son.' );

#------------------------------------------------------------
# Insertion : Utilisateur
#------------------------------------------------------------

INSERT INTO Utilisateur (NomUtilisateur, MailUtilisateur, MdpUtilisateur, AdresseUtilisateur ) VALUES
( 'Jean', 'user1@user1.fr', '44613bb6951be885fa66cf86196d45570eb23d370d332a485357280421b30fde', '1 rue de grange' );
