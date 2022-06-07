<?php
include "assets/server.php";
global $db;

$qz = $db->prepare("SELECT * FROM quizc.quizdb ORDER BY datePosted");
$qz->execute();
$qz = $qz->get_result();

if(isset($_POST['select'])){
    $stmt = $db->prepare("SELECT * FROM quizc.studentdb WHERE tQuizCode=? ORDER BY score DESC ");
    $stmt->bind_param('s',$_POST['option']);
    $stmt->execute();
    $result = $stmt->get_result();
}

?>
<html lang="en">
<head>
    <title>Leaderboard</title>
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link href="css/styles.css" rel="stylesheet" />
</head>
<?php include 'assets/header.php';?>
<body>
<div class="container">

    <form action="" method="post" style="margin-top: 5%">
    <br>
    <label for="quizMenu">Select a Quiz:</label>
    <select name="option">
        <?php while ($row = $qz->fetch_object()) { ?>
        <option value="<?php echo $row->QuizCode ?>"><?php echo $row->QuizTopic ?></option>
        <?php } ?>
    </select>

    <br>
        <button type="submit" name="select" class="btn btn-primary">Select Quiz</button>
        <button type="submit" name="clear" class="btn btn-danger">Clear</button>
    </form>
        <?php if(!empty($result)){?>
        <table>
            <thead>
                <tr>
                    <th style="width: 30%">Name</th>
                    <th style="width: 30%">Email</th>
                    <th style="width: 10%">Score</th>
                    <th style="15%">Date (yyyy-mm-dd)</th>
                </tr>
            </thead>
            <?php while ($row = $result->fetch_object()){?>
            <tr>
                <td><?php
                    $new = $db->prepare("SELECT username FROM quizc.users WHERE email=?");
                    $new->bind_param('s',$row->email);
                    $new->execute();
                    $new = $new->get_result()->fetch_object()->username;
                    echo $new;
                ?></td>
                <td><?php echo $row->email; ?></td>
                <td><?php echo $row->score; ?></td>
                <td><?php echo $row->qDate; ?></td>
            </tr>
            <?php }}else{ echo 'Select a Quiz to view scores!'; }?>
        </table>
</div>
<footer>
    <?php include 'assets/footer.php' ?>
</footer>
</body>
</html>