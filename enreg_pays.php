<?php
session_start(); 
require_once ("connexion.php");
$Token=$_POST['token'];
$Design=Securite::bdd($_POST['Design']);
$Code=Securite::bdd($_POST['Code']);
if($Token==$_SESSION['user_eteelo_app']['token']){
    $rech=$pdo->query("SELECT * FROM pays WHERE UPPER(Design_Pays)='".strtoupper($Design)."'");
    if($rechs=$rech->fetch()){
        echo "2";
    }else{
        $rs=$pdo->prepare("INSERT INTO pays (Design_Pays, Code_Pays) VALUES (?, ?)");
        $params=array($Design, $Code);
        $rs->execute($params);
        $selection = $pdo->query("SELECT * FROM pays ORDER BY Design_Pays");
        $last_country = $pdo->query("SELECT MAX(ID_Pays) AS ID_Pays FROM pays");
        $last = $last_country->fetch();
        $list = "";
        while ($selections = $selection->fetch()) {
            if($selections['ID_Pays']==$last['ID_Pays']) {
                $list .= '<option value="' . $selections['ID_Pays'] . '" selected>' . stripslashes($selections['Design_Pays']) . '</option>';
            }else{
                $list .= '<option value="' . $selections['ID_Pays'] . '">' . stripslashes($selections['Design_Pays']) . '</option>';
            }
        }
        echo ($list);
    }
}
?>