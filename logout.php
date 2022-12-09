<?php

session_start();
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: index.php');
    exit();
}
if (isset($_POST['logout'])) {
    session_destroy();
    header('Location: autosalong.php');
    exit();
}
