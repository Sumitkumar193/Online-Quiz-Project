<?php
debug_backtrace() || die ("Direct access not permitted");
include_once 'server.php';
    if(isset($_SESSION['isLoggedIn'])){
        include "headerLogon.php";
    }else{
        include "headerLogoff.php";
    }