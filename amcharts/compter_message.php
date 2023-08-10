<?php 
    session_start();
    require_once('connexion.php');
    $sms=$pdo->query("SELECT COUNT(*) AS NBR FROM participer WHERE Command=1 AND ID_Utilisateur=".$_SESSION['user_courrier']['ID_Utilisateur']);
    $smscount=$sms->fetch();
    echo $smscount['NBR'];
?>