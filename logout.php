<?php

session_start();
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: ablogin.php');
    exit();
}
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: autosalong.php');
    exit();
}
