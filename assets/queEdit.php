<?php

debug_backtrace() || die ("Direct access not permitted");



global $db;
$qz = $_SESSION['QuizCode'];


//Check if there is 0 Questions in Quiz
$query = "SELECT * FROM quizc.questiondb WHERE QuizCode='$qz' ORDER BY QueNumber";
$result = $db->query($query);
$row_cnt = $result->num_rows;
if($row_cnt == 0){
    echo '<script type="text/javascript">';
    echo 'alert("This quiz does not have any question yet! try adding some questions first :)");';
    echo 'window.location.href = "editQuiz.php";';
    echo '</script>';
}

if(isset($_POST['edit'])){
    $_SESSION['QueNum'] = mysqli_real_escape_string($db,$_POST['edit']);
    header('Location: editor.php');
}
if(isset($_POST['delete'])){
    $del = mysqli_real_escape_string($db,$_POST['delete']);
    $query = "Delete From quizc.questiondb Where QueNumber = '$del'";
    $result = $db->query($query);

    //Update Question Numbers
    $query = "SELECT * FROM quizc.questiondb WHERE QuizCode='$qz' ORDER BY id";
    $data = $db->query($query);
    $counts =1;
    while($nData = $data->fetch_object()){
        $queNum = $nData->QueNumber;
        $query = "UPDATE quizc.questiondb SET QueNumber='$counts' WHERE QuizCode='$qz' LIMIT 1";
        $exec = $db->query($query);
        $counts=$counts++;
    }
     //Refresh Current Page
    header("Refresh:0");
}

while ($rows = $result->fetch_object()){
    $queNum = $rows->QueNumber;
    $Question = $rows->Question
?>
     <form method="post" action="">
            <tr>
                <td colspan="2"><?php echo $queNum?></td>
                <td rowspan="1"><?php echo $Question?></td>
                <td rowspan="1"><button class="btn btn-primary" type="submit" name="edit" value="<?php echo $queNum ?>">Edit</td>
                <td rowspan="1"><button class="btn btn-danger" type="submit" name="delete" value="<?php echo $queNum ?>">Delete</td>
            </tr>
     </form>
 <?php } //Close Loop ?>
