<?php
debug_backtrace() || die ("Direct access not permitted");

include 'assets/server.php';
$errors = array();
global $db;

if(isset($_POST['submitQue']) || isset($_POST['submitAndNext'])){
    //Save inputs
    $QueNum = mysqli_real_escape_string($db,$_SESSION['QueNum']+1);
    $Question = mysqli_real_escape_string($db,$_POST['Question']);
    $OptionA = mysqli_real_escape_string($db,$_POST['OptionA']);
    $OptionB = mysqli_real_escape_string($db,$_POST['OptionB']);
    $OptionC = mysqli_real_escape_string($db,$_POST['OptionC']);
    $OptionD = mysqli_real_escape_string($db,$_POST['OptionD']);
    $Answer = isset($_POST['Answer']) ? mysqli_real_escape_string($db,$_POST['Answer']) : '';
    $QzCode = $_SESSION['QuizCode'];
    $Time = mysqli_real_escape_string($db,$_POST['CustomTime']);

    if(empty($QueNum)){
        array_push($errors,"Question Number field seems to be empty");
    }
    if(empty($Question)){
        array_push($errors,"Question field seems to be empty");
    }
    if(empty($OptionA)){
        array_push($errors,"Option A field seems to be empty");
    }
    if(empty($OptionB)){
        array_push($errors,"Option B field seems to be empty");
    }
    if(empty($OptionC)){
        array_push($errors,"Option C field seems to be empty");
    }
    if(empty($OptionD)){
        array_push($errors,"Option D field seems to be empty");
    }
    if(empty($Time)){
        array_push($errors,"Time field seems to be empty");
    }
    if(empty($Answer)){
        array_push($errors,"Select a Right Answer!");
    }

    //Check IF Question is Already Posted
    $query = "SELECT Question FROM quizc.questiondb WHERE Question=? AND QuizCode=? LIMIT 1";  //Query
    if($stmt = $db->prepare($query)){       //Prepare
        $stmt->bind_param('ss',$Question,$QzCode);   //Bind
        if($stmt->execute()){       //Execute
            $stmt->store_result();
            $qCheck = "";
            $stmt->bind_result($qCheck);
            $stmt->fetch();
            if($stmt->num_rows == 1){
                array_push($errors,"Question already exist in DB");
            }
        }
    }

    if(count($errors) == 0) {
        $stmt = $db->prepare("INSERT INTO quizc.questiondb (QueNumber, Question, OptionA, OptionB, OptionC, OptionD, AnswerOptionNum, QuizCode, TimeInSeconds) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->bind_param('isssssisi',$QueNum,$Question,$OptionA,$OptionB,$OptionC,$OptionD,$Answer,$QzCode,$Time);
        $stmt->execute();
        $result = $stmt->get_result();
        //$question = $result->fetch_object();
        if(!$result){
            $_SESSION['QuizCode']=$QzCode;
            $_SESSION['QueNum']=$_SESSION['QueNum']+1;
            if (isset($_POST['submitAndNext'])){
                echo "<script>alert('Question Added Successfully')</script>";
            }else{
                header("Location: home.php");
            }
        }else{
            array_push($errors,"Error Occurred! Try again!");
        }

    }

}

?>