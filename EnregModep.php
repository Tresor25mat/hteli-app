<?php
    session_start();
    $_SESSION['last_activity'] = time();
    require_once ("connexion.php");
    $token=$_POST['token'];
    $Ancienpass = Securite::bdd(sha1($_POST['Ancienpass']));
    $Nouveaupass=Securite::bdd(sha1($_POST['Nouveaupass']));
    $Nouveaupass2=Securite::bdd($_POST['Nouveaupass2']);
    if($token==$_SESSION['user_siges']['token']){
        $rs=$pdo->prepare("SELECT * FROM utilisateur WHERE Login=? AND Password=?");
        $params=array($_SESSION['user_siges']['Login'], $Ancienpass);
        $rs->execute($params);
        if ($user=$rs->fetch()){
            $rs=$pdo->prepare("UPDATE `utilisateur` SET `Password`=? WHERE `Login`=? and  `Password`=?");
            $params=array($Nouveaupass, $_SESSION['user_eteelo_app']['Login'], $Ancienpass);
            $rs->execute($params);
            echo '1';
        }else{
            echo '2';
        }
    }
?>