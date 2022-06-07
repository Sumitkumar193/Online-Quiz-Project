<?php

debug_backtrace() || die ("Direct access not permitted");

include_once 'server.php';
global $db;
$errors = array();

if(isset($_POST['submitQuiz'])){
    $QCode = substr(md5(uniqid(mt_rand(), true)) , 0, 12);;
    $QTopic = mysqli_real_escape_string($db,$_POST['QuizTopic']);
    $Score = mysqli_real_escape_string($db,$_POST['Score']);

    if(empty($QCode)){
        array_push($errors,"Quiz Code field seems to be empty");
    }
    if(empty(($QTopic))){
        array_push($errors,"Quiz Topic field seems to be empty!");
    }
    if (empty($Score)){
        array_push($errors,"Score field seems to be empty!");
    }


    //Check if Quiz Already Exist (prevent post Data twice)
    $query = "SELECT QuizTopic FROM quizc.quizdb WHERE QuizTopic=? LIMIT 1";  //Query
    if($stmts = $db->prepare($query)){       //Prepare
        $stmts->bind_param('s',$QTopic);   //Bind
        if($stmts->execute()){       //Execute
            $stmts->store_result();
            $qCheck = "";
            $stmts->bind_result($qCheck);
            $stmts->fetch();
            if($stmts->num_rows == 1){
                array_push($errors,"Quiz already exist in DB");
            }
        }
    }

    if(count($errors) == 0) {
        $stmt = $db->prepare("INSERT INTO quizc.quizdb (QuizCode,QuizTopic,Score) VALUES (?,?,?)");
        $stmt->bind_param('ssi', $QCode, $QTopic, $Score);
        $stmt->execute();
        $result = $stmt->get_result();
        if (!$result) {
            $_SESSION['QuizCode']=$QCode;
            $_SESSION['QueNum']=0;
            header("Location: ../postQue.php");
        } else {
            array_push($errors, "Error Occurred! CheckCode");
        }
    }
}