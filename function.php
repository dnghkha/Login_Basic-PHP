<?php

function check_login(){
    if (!isset($_SESSION['status_login']) || !$_SESSION['status_login']) {
        header('location: login.php');
        exit();
    }
}