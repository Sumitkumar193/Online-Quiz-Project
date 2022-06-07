<?php
include 'assets/server.php';
global $db;
if(!isset($_SESSION['isLoggedIn'])){
    header("Location: login.php");
}
$query = $db->prepare("SELECT * FROM quizc.quizdb ORDER BY id");
$query->execute();
$result = $query->get_result();
if($result->num_rows === 0){
    echo '<script type="text/javascript">';
    echo 'alert("Seems like no quiz is available please try again later or contact teacher");';
    echo 'window.location.href = "home.php";';
    echo '</script>';
}
static $sno = 1;


?>
<html lang="en">
<head>
    <title>Quiz!</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet" />
</head>
<?php include 'assets/header.php';?>
<body>
<div class="container">
    <table>
        <thead>
        <tr>
            <th colspan="2" rowspan="2" style="width: 10%">#S.No</th>
            <th rowspan="2" style="width: 50%">Quiz Topic</th>
            <th rowspan="2">Score</th>
            <th colspan="2">Action</th>
        </tr>
        </thead>

        <form method="post" action="students/userboard.php">
        <?php while ($rows = $result->fetch_object()){?>
            <tr>
                <td colspan="2"><?php echo $sno;?></td>
                <td><?php echo $rows->QuizTopic;?></td>
                <td><?php
                    //Check if User already taken test
                    $query = "SELECT score FROM quizc.studentdb WHERE email=? AND tQuizCode=? ORDER BY id DESC LIMIT 1";
                    $query = $db->prepare($query);
                    $query->bind_param('ss',$_SESSION['email'],$rows->QuizCode);
                    $query->execute();
                    $res= $query->get_result();
                    $res =$res->fetch_object();
                    if($res){
                        echo $res->score;
                    }elseif(!isset($res)){
                        echo "N/A";
                    }?></td>
                <td><button class="btn btn-primary" name="takeQuiz" value="<?php echo $rows->QuizCode;?>">Take Quiz <?php echo $sno;?></button></td>
            </tr>

        <?php $sno+=1; } ?>
        </form>
</div>
<footer>
    <?php include 'assets/footer.php' ?>
</footer>
</body>
</html>
<?php
unset($_SESSION['results']);
?>