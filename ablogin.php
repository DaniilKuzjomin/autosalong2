<?php
function login($login, $pass)
{
    require_once ('connect3.php');
    session_start();
    if (isset($_SESSION['tuvastamine'])) {
        header('Location: autosalong.php');
        exit();
    }
    //kontrollime kas väljad on täidetud
    if (!empty($_POST['login']) && !empty($_POST['pass'])) {
        global $yhendus;
        //eemaldame kasutaja sisestusest kahtlase pahna
        $login = htmlspecialchars(trim($_POST['login']));
        $pass = htmlspecialchars(trim($_POST['pass']));

        //SIIA UUS KONTROLL
        $sool = 'taiestisuvalinetekst';
        $kryp = crypt($pass, $sool);

        //kontrollime kas andmebaasis on selline kasutaja ja parool
        //$paring = "SELECT * FROM kasutajad WHERE kasutaja='$login' AND parool='$kryp'";
        //$valjund = mysqli_query($yhendus, $paring);
        //kui on, siis loome sessiooni ja suuname

        $kask = $yhendus -> prepare("SELECT kasutaja, onAdmin, koduleht FROM kasutajad WHERE kasutaja=? AND parool=?");
        $kask -> bind_param("ss",$login, $kryp);
        $kask -> bind_result($nimi, $onAdmin, $koduleht);
        $kask -> execute();

        if($kask->fetch()){
            //if (mysqli_num_rows($valjund) == 1) {
            $_SESSION['tuvastamine'] = 'misiganes';
            $_SESSION['kasutaja'] = $nimi;
            $_SESSION['onAdmin'] = $onAdmin;
            if(isset($koduleht) && $onAdmin==1){
                header("Location: $koduleht");
            } else{
                header('Location: autosalong.php');
                exit();
            }
        } else {
            echo "<strong>".'kasutaja või parool on vale'."<strong>";
        }
    }
}


?>
