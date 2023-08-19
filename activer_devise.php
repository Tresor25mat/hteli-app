<?php
    session_start();
    $_SESSION['last_activity'] = time();
    require_once ("connexion.php");
    $token=$_GET['token'];
    $Etab=$_GET['Etab'];
    $Ecole=$_GET['Ecole'];
    $ID = Securite::bdd($_GET['ID']);
    if($token==$_SESSION['user_eteelo_app']['token']){
        $update=$pdo->query("UPDATE table_taux SET Active=0 WHERE ID_Etablissement=".$Etab);
        $rs=$pdo->prepare("UPDATE table_taux SET Active=1 WHERE `ID_Taux_Change`=?");
        $params=array($ID);
        $rs->execute($params);
        header("location:table_devise.php?Ecole=".$Ecole); 

    }
?>