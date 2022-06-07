<?php
include 'assets/server.php';

if($_SESSION['isTeacher'] === 0){
    header("Location: home.php");
}

global $db;
//Check for last question POSTED
$QuizCode = $_SESSION['QuizCode'];
$query = "SELECT MAX(QueNumber) as LastQuestion FROM quizc.questiondb WHERE QuizCode='$QuizCode'";
$result = $db->query($query);
$result = $result->fetch_object();
$lastQue = $result->LastQuestion;
if(!isset($lastQue)){
    $lastQue = 0;
}
$_SESSION['QueNum'] = $lastQue;
if(isset($_POST['QueEdit'])){
    header("Location: editQue.php");
}
?>
<html lang="en">
<head>
    <title>Edit Quiz!</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet" />
</head>
<?php include 'assets/header.php';?>
<body>
<div class="container">
    <div class="options" style="margin: 12.5%">
    <label for="AddQue">Add Question to selected Quiz?</label>
    <form method="get" action="postQue.php">
    <button class="btn btn-primary" name="submitAndNext" value="<?php echo $_SESSION['QueNum'];?>">Add Question</button>
    </form>
    <label for="editQue">Edit or Delete an Question in the Quiz?</label>
    <form method="post" action="">
        <button class="btn btn-success" name="QueEdit">Edit A Question!</button>
    </form>
    </div>
</div>
<footer>
    <?php include 'assets/footer.php' ?>
</footer>
</body>
</html>