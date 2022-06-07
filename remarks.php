<?php
include "assets/server.php";
global $db;

if(!isset($_SESSION['isLoggedIn'])){
    header("Location: login.php");
}

$qz = $_SESSION['QuizCode'];
$stmt = $db->prepare("Select * from quizc.questiondb where QuizCode=?");
$stmt->bind_param('s',$qz);
$stmt->execute();
$result = $stmt->get_result();
$obMarks = 0;
//Calculate Marks
foreach ($_SESSION['results'] as $marks) {
    if($marks == "Correct"){
        $obMarks += $_SESSION['MarksPerQuestion'];
    }
}
$_SESSION['Marks'] = $obMarks;

?>
<html lang="en">
<head>
    <title>Remarks!</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <script src="/js/jquery.min.js"></script>
    <script src="/js/bootstrap.min.js"></script>
    <link href="css/styles.css" rel="stylesheet" />
</head>
<?php include 'assets/header.php';?>
<body>
<div class="container">
        <table>
            <thead>
            <tr>
                <th rowspan="2" colspan="2">Q.No</th>
                <th rowspan="2">Question</th>
                <th rowspan="2">Remarks</th>
                <th rowspan="2">Correct Answers</th>
            </tr>
            </thead>
                <?php while($row = $result->fetch_object()){
                    static $i = 0;?>
                     <tr>
                        <td colspan="2"><?php echo $row->QueNumber;?></td>
                        <td rowspan="1"><?php echo $row->Question;?></td>
                        <td rowspan="1"><?php echo $_SESSION['results'][$i];$i++;?></td>
                         <?php
                            switch ($row->AnswerOptionNum) {
                                case 1:
                                    $answer = $row->OptionA;
                                    break;
                                case 2:
                                    $answer = $row->OptionB;
                                    break;
                                case 3:
                                    $answer = $row->OptionC;
                                    break;
                                case 4:
                                    $answer = $row->OptionD;
                                    break;
                            }
                         ?>
                         <td><a href="#" data-toggle="popover" title="Correct Answer Option : <?php echo $row->AnswerOptionNum ?>" data-content="Answer :<?php echo $answer; ?> ">Answer : <?php echo $row->AnswerOptionNum ?></a></td>
                     </tr>
                <?php } ?>
            <tr>
                <td colspan="3">Marks</td>
                <td colspan="2"><?php echo round($_SESSION['Marks'],2)."/".$_SESSION['Score']; ?></td>
            </tr>
        </table>
    <br>
    <form method="post" action="students/userboard.php">
        <?php
            $query = $db->prepare("SELECT * FROM quizc.studentdb WHERE tQuizCode=? AND email=?");
            $query->bind_param('ss',$_SESSION['QuizCode'],$_SESSION['email']);
            $query->execute();
            $res = $query->get_result();
            if($res->num_rows == 0){
        ?>
        <button class="btn btn-success" name="save" type="submit" value="save">Save</button>
                <?php }else{ ?>
        <button class="btn btn-success" name="save" type="submit" value="update">Update</button>
                <?php } ?>
        &ensp;<button class="btn btn-primary" name="tryAgain" type="submit" value="tryAgain">Try Again?</button>
    </form>
</div>
<script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
    });
</script>
<footer>
    <?php include 'assets/footer.php' ?>
</footer>
</body>
</html>