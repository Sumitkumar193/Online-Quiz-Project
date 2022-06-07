<?php
include 'assets/server.php';

if(($_SESSION['isTeacher']) === 0){
    header("Location: home.php");
}

global $db;
$QueNum = $_SESSION['QueNum'];
$errors = array();
$QuizCode = $_SESSION['QuizCode'];
$query = "SELECT * FROM quizc.questiondb WHERE QuizCode='$QuizCode' AND QueNumber='$QueNum' LIMIT 1";
$result = $db->query($query);
$obj = $result->fetch_array();
$Question = $obj['Question'];
$OptionA = $obj['OptionA'];
$OptionB = $obj['OptionB'];
$OptionC = $obj['OptionC'];
$OptionD = $obj['OptionD'];
$Checked = $obj['AnswerOptionNum'];

if(isset($_POST['update'])){
    $Question = mysqli_real_escape_string($db,$_POST['question']);
    $OptionA = mysqli_real_escape_string($db,$_POST['optA']);
    $OptionB = mysqli_real_escape_string($db,$_POST['optB']);
    $OptionC = mysqli_real_escape_string($db,$_POST['optC']);
    $OptionD = mysqli_real_escape_string($db,$_POST['optD']);
    $Answer = isset($_POST['Answer']) ? mysqli_real_escape_string($db,$_POST['Answer']) : '';
    $Times = mysqli_real_escape_string($db,$_POST['timer']);

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
    if(empty($Times)){
        array_push($errors,"Time field seems to be empty");
    }
    if(empty($Answer)){
        array_push($errors,"Select a Right Answer!");
    }

    if(count($errors) == 0) {
        $sql = "UPDATE quizc.questiondb SET Question=?,OptionA=?,OptionB=?,OptionC=?,OptionD=?,AnswerOptionNum=?,TimeInSeconds=? WHERE QueNumber=? AND QuizCode=?";
        $stmt = $db->prepare($sql);
            $stmt->bind_param('sssssiiis',$Question,$OptionA,$OptionB,$OptionC,$OptionD,$Answer,$Times,$QueNum,$QuizCode);
            $stmt->execute();
            $result = $stmt->get_result();
            //$question = $result->fetch_object();
            if(!$result){
                    echo "<script>alert('Question #".$QueNum." has been updated successfully!')</script>";
                    header("Location: home.php");
            }else{
                array_push($errors,"Error Occurred! Try again!");
            }
    }


}
?>
<html lang="en">
<head>
    <title>Edit Question!</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet" />
</head>
<?php include 'assets/header.php';?>
<body>
<div class="container">
    <div class="form-controller" style="max-width: 75%; margin: 12.5%">
        <?php include 'assets/errors.php'?>
        <form method="post" action="">
            <label for="QueNum">Question Number:</label>
            <input class="form-control" disabled name="qnum" value="<?php echo $QueNum ?>">
            <label for="QueNum">Question:</label>
            <textarea rows="3" class="form-control" name="question" value="<?php echo $Question ?>"><?php echo $Question ?></textarea>
            <label for="QueNum">Option A:</label>
            <input class="form-control" name="optA" value="<?php echo $OptionA ?>">
            <label for="QueNum">Option B:</label>
            <input class="form-control" name="optB" value="<?php echo $OptionB ?>">
            <label for="QueNum">Option C:</label>
            <input class="form-control" name="optC" value="<?php echo $OptionC ?>">
            <label for="QueNum">Option D:</label>
            <input class="form-control" name="optD" value="<?php echo $OptionD ?>">
<br>
            <label>Confirm Answer:</label><br>
            <label class="checkbox-inline">
                <input type="radio" name="Answer" value="1"> Option A
            </label>
            <label class="checkbox-inline">
                <input type="radio" name="Answer" value="2"> Option B
            </label>
            <label class="checkbox-inline">
                <input type="radio" name="Answer" value="3"> Option C
            </label>
            <label class="checkbox-inline">
                <input type="radio" name="Answer" value="4"> Option D
            </label><br>
<br>
            <label for="Time">Time(isSeconds):</label>
            <input type="text" class="form-control" name="timer" VALUE="30"  placeholder="Time"><br>


            <button type="submit" name="update" class="btn btn-success  ">Submit</button><br>
        </form>

    </div>
</div>
<footer>
    <?php include 'assets/footer.php' ?>
</footer>
</body>
</html>
