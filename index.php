<?php
require('controller/frontend.php');

try {
     if(isset($_GET['action'])) {
        if ($_GET['action'] == 'listQuestions') {
            getListQuestions();
        }elseif ($_GET['action'] == 'listQuestionsUnanswered') {
            getListQuestionsUnanswered();
        }elseif ($_GET['action'] == 'listCoupleQRWeak') {
            getListCoupleQRWeak();
        }elseif ($_GET['action'] == 'listReponses') {
            getListReponses();
        }elseif ($_GET['action'] == 'insertReponse') {
            insertReponse();
        }elseif ($_GET['action'] == 'creerReponse') {
            creerReponse();
        }elseif ($_GET['action'] == 'creerMotCle') {
            creerMotCle();
        }elseif ($_GET['action'] == 'modifierReponse') {
            modifierReponse();
        }elseif ($_GET['action'] == 'modifierCouple') {
            modifierCouple();
        }elseif ($_GET['action'] == 'listQuestionsWithoutMotCle') {
            getListQuestionsWithoutMotCle();
        }
    }
    else {
        getListQuestionsUnanswered();
    }
}
catch(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}

