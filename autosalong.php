<?php
require_once ('connect3.php');
global $yhendus;

// sessiooni algus
session_start();
if (!isset($_SESSION['tuvastamine'])) {
    header('Location: index.php');
    exit();
}

if(isset($_REQUEST['kustuta'])){

    $paring=$yhendus -> prepare("DELETE FROM autod WHERE autoID=?");
    $paring -> bind_param("i",$_REQUEST['kustuta']);
    $paring -> execute();

}

// andmete lisamine tabelisse
if(isset($_REQUEST['Lisamisvorm']) && !empty($_REQUEST["automark"])){


    $paring = $yhendus -> prepare("INSERT INTO autod(automark, varv, labisoit, hind) VALUES (?,?,?,?)");
    $paring -> bind_param("ssii", $_REQUEST["automark"],$_REQUEST["varv"],$_REQUEST["labisoit"],$_REQUEST["hind"]);
    $paring->execute();
    

}


?>

<!DOCTYPE html>
<html lang="et">
<head>
    <meta charset="UTF-8">
    <title>Autosalong</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Autosalongi baas</h1>



<br>

<?= $_SESSION['kasutaja']?> on sisse logitud!
<br>
<br>
<form action="logout.php" method="post">
    <input type="submit" value="Logi välja" name="logout">
</form>

<br>
<br>

<div id="meny">
    <ul>
        <?php


        $paring=$yhendus -> prepare("SELECT autoID, automark, hind, labisoit, varv FROM autod");
        $paring -> bind_result($autoID, $mark, $hind, $labisoit, $varv);
        $paring -> execute();


        while($paring->fetch()){


            echo "<li><a href='?autoID=$autoID'>$mark</a></li>";
            echo "<br>";
        }
        echo "</ul>";

        echo "<a href='?lisaauto=jah'>Lisa auto autosalongi baasile</a>";

        ?>

</div>
<div id="sisu">

    <?php
    if(isset($_REQUEST["autoID"])) {

        $paring = $yhendus->prepare("SELECT automark, varv, labisoit, hind FROM autod WHERE autoID=?");
        $paring->bind_param("i", $_REQUEST['autoID']);
        // ? küsimarke asemel adressoribalt tuleb id
        $paring->bind_result($mark, $varv, $labisoit, $hind);
        $paring->execute();

        if ($paring->fetch()) {
            echo "<div><strong>" . htmlspecialchars($mark) . "</strong><br> ";
            echo "Auto värv on - ".htmlspecialchars($varv)."<br>";
            echo "Auto labisõit on - ".htmlspecialchars($labisoit). "km<br>";
            echo "Hind - ".htmlspecialchars($hind). "eur<br>";
            echo "</div>";
        }
        echo "<br><a href='?kustuta=".$_REQUEST["autoID"]."'>Kustuta auto tabelist</a>";
    }
    else if(isset($_REQUEST["lisaauto"])){
        ?>
        <h2>Uue auto lisamine autosalongi baasil</h2>
        <form name="uusauto" method="post" action="?">
            <INPUT type="hidden" name="Lisamisvorm" value="jah">
            <input type="text" name="automark" placeholder="Automark">
            <br>
            <br>
            <input type="text" name="varv" placeholder="Autovärv">
            <br>
            <br>
            <input type="number" name="labisoit" placeholder="Autolabisoit">
            <br>
            <br>
            <input type="number" name="hind" placeholder="Auto hind">
            <br>
            <br>
            <input type="submit" value="OK">



        </form>
        <?php

    }
    else {
        echo "<h3>Siia tuleb auto info.</h3>";
    }


    $yhendus->close();
    ?>





</div>





</body>
</html>
