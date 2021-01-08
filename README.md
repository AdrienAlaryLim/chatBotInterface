# Projet AtoutProtect

Le projet AtoutProtect est une demande de la société Atout SA. Le besoin de ce projet est de livrer une dll permettant la gestion de licence logiciel. Nous intégrons un jeu d'essais aux livrables afin de vérifier le bon fonctionnement des intérractions. Ce jeu d'essais est composé de:

<ul>
  <li> Un executable, ayant besoin d'une licence active pour accéder à toutes ces fonctionnalités </li>
  <li> Un site internet permettant de consulter les licences disponnibles, et de les acheter en passant par paypal ou Hipay </li>
  <li> Une base de données afin de recenser les clients dont la licence est activée </li>
  <li> Une dll qui permettra de vérifier si la licence est activée ou non </li>
</ul>

<h1> Installation </h1>

<h2> Partie site Web </h2>

Pour installer ce projet, il faut déposer les fichiers sur un répertoire accessible par un serveur web. Prenez soin d'ouvrir le répertoire atout-sa/BDD/ afin d'importer le fichier "Licence_BDD.sql" dans votre base de données, pour que le jeu d'essais prenne en compte des données plausibles.
