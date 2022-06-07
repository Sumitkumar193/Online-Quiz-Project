<?php
include "assets/server.php";
global $db;

if(!isset($_SESSION['isLoggedIn'])){
    header("Location: login.php");
}

$qz = $_SESSION['QuizCode'];
$query = "SELECT * FROM quizc.questiondb WHERE QuizCode=? AND QueNumber=?";
$stmt = $db->prepare($query);
$stmt->bind_param('si',$qz, $_SESSION['QueNum']);
$stmt->execute();
$result = $stmt->get_result();
$result = $result->fetch_object();

//Get total questions in db
$stmt1 = $db->prepare("SELECT COUNT(Question) as qCount FROM quizc.questiondb WHERE QuizCode=?");
$stmt1->bind_param('s',$qz);
$stmt1->execute();
$count = $stmt1->get_result()->fetch_object();
$total = $count->qCount;

if(isset($_POST['skip'])){
    $_SESSION['Answers'][]= "Skipped";
    $_SESSION['QueNum'] = ++$_SESSION['QueNum'];
    header("Refresh:0");
}

//Calculate % Completed Progress
$percent = round((($_SESSION['QueNum'] -1) / $total * 100),2) ;
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



    <form method="post" action="students/userboard.php">

        <?php if($_SESSION['QueNum'] > 1) { ?>
        <div class="progress" style="width: 80%; margin-left: 10%;margin-top: 4%;">
            <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="<?php echo $percent;?>" aria-valuemin="1" aria-valuemax="100" style="width:<?php echo $percent;?>%">
                <?php echo $percent; ?>% Completed
            </div>
        </div>
        <?php } ?>

        <?php include('assets/errors.php'); ?>
        <div class="question" style="background-color: white;margin-left: 10%;margin-top: 5%; max-height: 30%;overflow: auto;max-width:80%;">
            <h3>Q<?php echo $result->QueNumber ?>/<?php echo $total; ?>:&nbsp  <?php echo $result->Question; ?></h3>
        </div>

        <p><b>Time Left :&nbsp<span id="countdown"></span></b></p>

        <div class="options">
            <input style="float:right;max-width: 10%;margin-right: 10%" class="form-control" type="radio" value="1" name="option">
            <input style="margin-left: 20%;text-align: center;max-width: 60%" class="form-control" disabled placeholder="<?php echo $result->OptionA;?>">


            <br>

            <input style="float:right;max-width: 10%;margin-right: 10%" class="form-control" type="radio" value="2" name="option">
            <input style="margin-left: 20%;text-align: center;max-width: 60%" class="form-control" disabled placeholder="<?php echo $result->OptionB;?>">

            <br>

            <input style="float:right;max-width: 10%;margin-right: 10%" class="form-control" type="radio" value="3" name="option">
            <input style="margin-left: 20%;text-align: center;max-width: 60%" class="form-control" disabled placeholder="<?php echo $result->OptionC;?>">

            <br>

            <input style="float:right;max-width: 10%;margin-right: 10%" class="form-control" type="radio" value="4" name="option">
            <input style="margin-left: 20%;text-align: center;max-width: 60%" class="form-control" disabled placeholder="<?php echo $result->OptionD;?>">

            <br>
        </div>
        <?php if($_SESSION['QueNum'] < $total){ ?>
        <button class="btn btn-success" type="submit" name="sAnswer">Submit</button>
        <?php } ?>
        <?php if($_SESSION['QueNum'] === $total){ ?>
            <button class="btn btn-success" type="submit" id="fAnswer" name="fAnswer">Submit</button>
        <?php } ?>
    </form>
    <?php if ($_SESSION['QueNum'] < $total){ ?>
    <form name="skip" method="post" action="">
        <button style="margin-top: 1%" id="skip" class="btn btn-primary" type="submit" name="skip">Skip</button>
    </form>
    <?php } ?>
</div>
    <script>
        var seconds = <?php
            $sec = $db->prepare("SELECT * From quizc.questiondb WHERE QueNumber=? AND QuizCode=?");
            $sec->bind_param('ss',$_SESSION['QueNum'],$_SESSION['QuizCode']);
            $sec->execute();
            $sec = $sec->get_result()->fetch_object()->TimeInSeconds;
            echo $sec;
            ?>, $seconds = document.querySelector('#countdown');
        (function countdown() {
            $seconds.textContent = seconds + ' second' + (seconds === 1 ?  '' :  's')
            if(seconds --> 0) {setTimeout(countdown, 1000)}
            if(seconds===0) {
                <?php if ($_SESSION['QueNum'] < $total){ ?>
                    clearTimeout();
                    alert('Time Up!');
                    document.getElementById("skip").click();
                <?php } else { ?>
                        clearTimeout();
                        alert('Time Up!');
                        document.getElementById("fAnswer").click();
                <?php } ?>
            }
            })();
    </script>

<footer>
    <?php include 'assets/footer.php' ?>
</footer>
</body>
</html>