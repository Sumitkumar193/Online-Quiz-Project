<?php
//debug_backtrace() || die ("Direct access not permitted");
include '../assets/server.php';
global $db;
$errors = array();

//Get total Score
$stmt = $db->prepare("SELECT Score from quizc.quizdb WHERE QuizCode=?");
$stmt->bind_param('s',$_SESSION['QuizCode']);
$stmt->execute();
$Score = $stmt->get_result()->fetch_object();
$Score = $Score->Score;
$_SESSION['Score'] = $Score;

//Get Question Count
$stmt1 = $db->prepare("SELECT COUNT(Question) as qCount FROM quizc.questiondb WHERE QuizCode=?");
$stmt1->bind_param('s',$_SESSION['QuizCode']);
$stmt1->execute();
$count = $stmt1->get_result()->fetch_object();
$count = $count->qCount;

$_SESSION['MarksPerQuestion'] = ($Score/$count) ;

if(isset($_POST['takeQuiz'])){
    $_SESSION['QuizCode'] = mysqli_real_escape_string($db,$_POST['takeQuiz']);
    $_SESSION['QueNum'] = 1;
    header("Location: ../quiz.php");
}

if(isset($_POST['sAnswer'])){

    $nA = isset($_POST['option'])?mysqli_real_escape_string($db,$_POST['option']):0;
    $_SESSION['Answers'][]= $nA;

    $_SESSION['MarksPerQuestion'] = ($Score/$count) ;

    $_SESSION['QueNum'] = ++$_SESSION['QueNum'];

    if($_SESSION['QueNum'] <= $count){
        header('Location: ../quiz.php');
    }
}



if(isset($_POST['fAnswer'])){
    $nA = isset($_POST['option'])?mysqli_real_escape_string($db,$_POST['option']):0;
    $_SESSION['Answers'][]= $nA;

    print_r($_SESSION['Answers']);

    $score = 0;
    static $i = 1;
    foreach ($_SESSION['Answers'] as $answer) {
        //fetch Answer
        $stmt = $db->prepare("SELECT AnswerOptionNum FROM quizc.questiondb WHERE QuizCode=? AND QueNumber=?");
        $stmt->bind_param('si', $_SESSION['QuizCode'], $i);
        $stmt->execute();
        $originalAns = $stmt->get_result()->fetch_object();
        $originalAns = $originalAns->AnswerOptionNum;
        //Check if answer matches
        if ($answer == $originalAns) {
            $_SESSION['results'][] = "Correct";
            $score += $_SESSION['MarksPerQuestion'];
        } elseif($answer == "Skipped" || $answer === 0){
            $_SESSION['results'][] = "Skipped";
        }else{
            $_SESSION['results'][] = "Wrong";
        }
        $i++;
    }

    unset($_SESSION['Answers']);

    header("Location: ../remarks.php");

}

if((isset($_POST['tryAgain'])) || isset($_POST['save'])){
    if(isset($_POST['save'])){
        $stmt = $db->prepare("INSERT INTO quizc.studentdb (quizc.studentdb.email, quizc.studentdb.score, quizc.studentdb.tQuizCode) VALUES (?,?,?)");
        $stmt->bind_param('sis',$_SESSION['email'],$_SESSION['Marks'],$_SESSION['QuizCode']);
        $stmt->execute();
        $result = $stmt->get_result();
        echo '<script type="text/javascript">';
        echo 'alert("Quiz Saved!");';
        echo 'window.location.href = "../takeQuiz.php";';
        echo '</script>';
    }
    if(isset($_POST['tryAgain'])){
        echo '<script type="text/javascript">';
        echo 'alert("Quiz not saved! you can take quiz anytime else!");';
        echo 'window.location.href = "../takeQuiz.php";';
        echo '</script>';
    }

    resetSession();

}

if(isset($_POST['update'])){
    $query = "REPLACE INTO quizc.studentdb(email, score, tQuizCode) VALUES (?,?,?)";
    $stmt = $db->prepare("UPDATE quizc.studentdb SET score = ? WHERE email = ? LIMIT 1");
    $stmt->bind_param('is',$_SESSION['Marks'],$_SESSION['email']);
    $stmt->execute();
    resetSession();
    echo '<script type="text/javascript">';
    echo 'alert("Score updated!");';
    echo 'window.location.href = "../takeQuiz.php";';
    echo '</script>';
}

function resetSession(){
    unset($_SESSION['results']);
    unset($_SESSION['QuizCode']);
    unset($_SESSION['MarksPerQuestion']);
    unset($_SESSION['Score']);
    unset($_SESSION['Marks']);
    unset($_SESSION['QueNum']);
}


