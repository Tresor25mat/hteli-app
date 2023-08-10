<?php
    session_start();
    require_once ("connexion.php");
    $rs=$pdo->query("SELECT COUNT(*) AS Nbr FROM utilisateur WHERE Etat=1");
    $Ndemande=$rs->fetch();
    if($Ndemande['Nbr']==0 || $Ndemande['Nbr']==NULL){
    	echo (0);
    }else{
    	echo ($Ndemande['Nbr']);
    }
?>