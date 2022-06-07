<?php
$servername = "127.0.0.1";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo '...Setup Initiated...<br>';

$conn->query("CREATE DATABASE IF NOT EXISTS quizc;");

//Update $conn with DB select
$db = "quizc";
$conn = new mysqli($servername, $username, $password, $db);

    echo 'Creating User Table..<br>';
    $conn->query("CREATE TABLE IF NOT EXISTS `quizc`.`users` ( `serial` INT NOT NULL AUTO_INCREMENT , `username` VARCHAR(25) NOT NULL , `email` VARCHAR(50) NOT NULL , `password` VARCHAR(100) NOT NULL , `regDate` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP , UNIQUE (`email`), UNIQUE (`serial`)) ENGINE = InnoDB");
    $conn->query("ALTER TABLE `quizc`.`users` ADD `isTeacher` INT(1) NULL DEFAULT '0';");


//Quiz DB Here
    $conn->query("CREATE TABLE IF NOT EXISTS `quizc`.`quizdb` ( `recNum` INT NOT NULL AUTO_INCREMENT , `QuizCode` TEXT NOT NULL , `QuizTopic` TEXT NOT NULL , `Score` INT(10) NOT NULL , `datePosted` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`recNum`)) ENGINE = InnoDB;");
    echo 'Quiz DB Created<br>';
//Question DB Here
    $conn->query("CREATE TABLE IF NOT EXISTS `quizc`.`questiondb` ( `id` INT NOT NULL AUTO_INCREMENT , `QueNumber` INT NOT NULL , `Question` TEXT NOT NULL , `OptionA` TEXT NOT NULL , `OptionB` TEXT NOT NULL , `OptionC` TEXT NOT NULL , `OptionD` TEXT NOT NULL , `AnswerOptionNum` INT NOT NULL , `QuizCode` TEXT NOT NULL , `TimeInSeconds` INT(30) NOT NULL , PRIMARY KEY (`id`)) ENGINE = InnoDB;
");
    echo 'Questions DB Created<br>';
//Score DB Created
    $conn->query("CREATE TABLE IF NOT EXISTS `quizc`.`studentdb` ( `id` INT NOT NULL AUTO_INCREMENT , `email` TEXT NOT NULL , `score` INT NULL DEFAULT NULL , `tQuizCode` TEXT NOT NULL , `qDate` DATE NOT NULL DEFAULT CURRENT_TIMESTAMP , PRIMARY KEY (`id`)) ENGINE = InnoDB;");
    echo "Score DB Created<br>";


echo '<script type="text/javascript">';
echo 'alert("Initialization Complete!");';
echo 'window.location.href = "../index.php";';
echo '</script>';