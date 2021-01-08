<?php 
if(!isset($_SESSION)){
	session_start();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>ChatBot</title>
        <link href="public/css/main.css" rel="stylesheet" /> 
    </head>
        
    <body>
    	<ul class="navBar">
    		<li class="navBar"> <a class="navBar" href="index.php?action=listQuestionsUnanswered"> Questions non répondues </a> </li>
    		<li class="navBar"> <a class="navBar" href="index.php?action=listCoupleQRWeak"> Couple Q/R incertains </a> </li>
    		<li class="navBar"> <a class="navBar" href="index.php?action=listQuestions"> Liste des questions </a> </li>
            <li class="navBar"> <a class="navBar" href="index.php?action=listReponses"> Liste des reponses </a> </li>
		</ul>

		<header class=<?= $styleMenu ?> >
    		
    	</header>
        <?= $content ?>

        <section id="footer">
	    	<ul class="icons">
		        <li><a href="https://github.com/AdrienAlaryLim/chatBotTelegram" class="icon alt fa-github"><img src="public/images/github.png" alt="Github"/></a></li>
	   		</ul>
		    <ul class="copyright">
		        <li>&copy; AdrienAlaryLim</li>
		    </ul>
		</section>
    </body>
</html>