<?php
    session_start();
    require_once ("connexion.php");
    $rs=$pdo->query("SELECT COUNT(*) AS Nbr FROM utilisateur");
    $Nutilisateur=$rs->fetch();
    echo ($Nutilisateur['Nbr']+1);
?>