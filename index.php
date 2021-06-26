<?php
require('controller/frontend.php');
require('controller/requests.php');

try {
    if(isset($_GET['action'])) {
        switch ($_GET['action']) {
            case 'listQuestionsUnanswered':
                getListQuestionsUnanswered();
                break;
            case 'listCoupleQRWeak':
                getListCoupleQRWeak();
                break;
            case 'insertReponse':
                insertReponse();
                break;
            case 'creerReponse':
                creerReponse();
                break;
            case 'creerMotCle':
                creerMotCle();
                break;
            case 'modifierReponse':
                modifierReponse();
                break;
            case 'modifierCouple':
                modifierCouple();
                break;
            case 'listQuestionsWithoutMotCle':
                getListQuestionsWithoutMotCle();
                break;    
            default:
                getListQuestionsUnanswered();
                break;
        }
    }
    elseif(isset($_GET['request'])){
        switch ($_GET['request']) {
            case 'getQuestionById':
                getQuestionById();
                break;   
            case 'getQuestionByWords':
                getQuestionByWords();
                break;  
            case 'insertQuestion':
                insertQuestion();
                break; 
            case 'motCleSounds':
                motCleSounds();
                break;
            case 'getReponseByMotCle':
                getReponseByMotCle();
                break;
            case 'getReponseByIdQuestion':
                getReponseByIdQuestion();
                break;
            case 'insertReponse':
                requestInsertReponse();
                break;
            case 'questionUnanswered':
                questionUnanswered();
                break;  
            default:
                getListQuestionsUnanswered();
                break;
        }
    }
    else {
        getListQuestionsUnanswered();
    }
}
catch(Exception $e) {
    echo 'Erreur : ' . $e->getMessage();
}

