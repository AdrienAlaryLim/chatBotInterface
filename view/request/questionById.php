<?php
require_once ("config.php");
$questionId = (isset($_GET['idQuestion'])) ? $_GET['idQuestion'] : "";

$sqm = $pdo->prepare('SELECT * FROM questions WHERE id_question = :questionId');
$question = $sql->execute(array('questionId' => $questionId));
if (!empty($question)) {
    foreach ($question as $k => $q) {
        echo $question[$k]["id_question"] . ";" . $question[$k]["date_question"] . ";" . $question[$k]["question"]. "~";
        }
}
    else 
        echo "No question";
?> 