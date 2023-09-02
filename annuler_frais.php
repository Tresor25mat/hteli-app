<?php
    session_start();
    require_once ("connexion.php");
    $token=$_POST['token'];
    $Frais=$_POST['Frais'];
    if($token==$_SESSION['user_eteelo_app']['token']){
        $delete_classe_frais=$pdo->query("DELETE FROM classe_frais WHERE `ID_Frais`=".$Frais);
        $delete_tranche_frais=$pdo->query("DELETE FROM tranche_frais WHERE `ID_Frais`=".$Frais);
        $delete_frais=$pdo->query("DELETE FROM frais WHERE `ID_Frais`=".$Frais);
        echo '1';
    }
?>