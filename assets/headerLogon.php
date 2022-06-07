<?php
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['email']);
    unset($_SESSION['isLoggedIn']);
    unset($_SESSION['isTeacher']);
    header("location: login.php");
}
?>
<header>
    <nav class="navbar navbar-default" style="width: 100%">
        <div class="container-fluid">
            <div class="navbar-header navbar-left">
                <a class="navbar-brand" href="index.php">CSE-COE-CGC</a>
            </div>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="index.php">Home</a> </li>
                <li><a href="Leaderboard.php">Leaderboard</a></li>
                <li><a href="home.php">Dashboard</a></li>
                <li><a href="index.php?logout='1'">Logout</a></li>
            </ul>
        </div>
    </nav>
</header>