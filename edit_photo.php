<?php
    session_start();
    $_SESSION['last_activity'] = time();
    require_once ("connexion.php");
    $Token=$_POST['token'];
    $ID=Securite::bdd($_POST['ID_User']);
    $Type_Photo=htmlentities($_POST['Type_Photo']);
    $Photo_Data=htmlentities($_POST['Photo_Data']);
    if($Token==$_SESSION['user_eteelo_app']['token']){
        $rs=$pdo->prepare("UPDATE utilisateur SET Photo=?, Photo_Type=? WHERE ID_Utilisateur=?");
        $params=array($Photo_Data, $Type_Photo, $ID);
        $rs->execute($params);
        echo "1";
    }
?>