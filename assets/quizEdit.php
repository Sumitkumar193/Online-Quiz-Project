<?php
debug_backtrace() || die("Direct access not permitted");
global $db;
if(!isset($_SESSION['isLoggedIn'])){
    header("Location: login.php");
}
if(isset($_SESSION['isTeacher'])){
        $query = "SELECT QuizTopic,QuizCode FROM quizc.quizdb ORDER BY id DESC";
        $result = $db->query($query);
        if(empty($result->num_rows)){
            echo '<script type="text/javascript">';
            echo 'alert("You dont have any quiz created! Perhaps want to make a quiz first!");';
            echo 'window.location.href = "home.php";';
            echo '</script>';
        }
}else{
    header("Location: home.php");
}

if(isset($_POST['delete'])){
    //Save value of QuizCode selected
    $val = mysqli_real_escape_string($db,$_POST['delete']);
    $delQuizQuery = "DELETE FROM quizc.quizdb WHERE QuizCode='$val'";
    $delQuestionQuery = "DELETE FROM quizc.questiondb WHERE QuizCode='$val'";
    $delQuiz = $db->query($delQuizQuery);
    $delQuestion = $db->query($delQuestionQuery);
    echo "<script>alert('".$val."Quiz has been deleted successfully')</script>";
    header("Refresh:0");
}

if(isset($_POST['edit'])){
    //
    $val = mysqli_real_escape_string($db,$_POST['edit']);
    $_SESSION['QuizCode'] = $val;
    $query2= "SELECT MAX(QueNumber) AS LastQuestion,Question FROM quizc.questiondb WHERE QuizCode='$val' LIMIT 1";
    $result = $db->query($query2);
    $row = $result->fetch_object();
    $_SESSION['QueNum'] = $row->LastQuestion;
    header("Location: editQuestions.php");
}

while($result1 = $result->fetch_array()) {
        $code = $result1['QuizCode'];
        $query2= "SELECT COUNT(QueNumber) AS LastQuestion,Question FROM quizc.questiondb WHERE QuizCode='$code' LIMIT 1";
        $result2 = $db->query($query2);
        while ($ro = $result2->fetch_object()) {

            $Topic = $result1['QuizTopic'];
            $QuizCode = $result1['QuizCode'];
            $QueNum = $ro->LastQuestion;
            if ($QueNum == 0) {
                $QueNum = 0;
        }


?>

<form method="post" action="">
<tr>
            <td colspan="2"><?php echo $Topic?></td>
            <td rowspan="1"><?php echo $QuizCode?></td>
            <td rowspan="1"><?php echo $QueNum?></td>
            <td rowspan="1"><button class="btn btn-primary" type="submit" name="edit" value="<?php echo $QuizCode ?>">Edit</td>
            <td rowspan="1"><button class="btn btn-danger" type="submit" name="delete" value="<?php echo $QuizCode ?>">Delete</td>
</tr>
</form>
<?php
        }
    }
?>
