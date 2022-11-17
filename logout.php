<?php
session_start();
session_destroy();
setcookie('auto_login', '', time()-60);
header('location: login.php');
