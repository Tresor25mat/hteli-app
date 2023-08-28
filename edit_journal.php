<?php
    session_start();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $ID_Journal=htmlentities($_POST['ID_Journal']);
    $Type=htmlentities($_POST['Type']);
    $Code=htmlentities($_POST['Code']);
    $Design=Securite::bdd($_POST['Design']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE table_journal SET ID_Type_Journal=?, Code_Journal=?, Design_Journal=? WHERE ID_Journal=?");
        $params=array($Type, $Code, $Design, $ID_Journal);
        $rs->execute($params);
        echo "1";
    }
?>