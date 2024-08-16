<?php
session_start();
require_once ("connexion.php");
$Token = $_POST['token'];
$Province = htmlentities($_POST['province']);
$Site = htmlentities($_POST['ID_Site']);
$Daterap = date('Y-m-d', strtotime($_POST['daterap']));
$Project = htmlentities($_POST['project']);
$ID_Agent = htmlentities($_POST['ID_Agent']);
$Field_Eng = Securite::bdd($_POST['field_eng']);
$Fichier = basename($_FILES['fichier']['name']);
$dossier_fichier = 'documents/';
if (!is_dir($dossier_fichier)) {
    mkdir($dossier_fichier);
}
if ($Fichier != '') {
    $extensions = array('.JPG', '.JPEG', '.PNG', '.XLS', '.XLSX', '.PDF', '.DOC', '.DOCX', '.PPT', '.PPTX');
    $extension = strrchr($_FILES['fichier']['name'], '.');
    $extension_maj = strtoupper($extension);
    if (!in_array($extension_maj, $extensions)) {
        echo "2";
    } else {
        $Time = time() . rand(0, 9);
        $Time = substr($Time, 3, 8);
        $Fichier = 'FICHIER_' . $Time . $extension_maj;
        if (move_uploaded_file($_FILES['fichier']['tmp_name'], $dossier_fichier . $Fichier)) //Si la fonction renvoie TRUE, c'est
        {
            if ($Token == $_SESSION['user_eteelo_app']['token']) {
                if($ID_Agent=='' && $Field_Eng!=''){
                    $insert_agent=$pdo->query("INSERT INTO agent SET Nom_Agent='".$Field_Eng."'");
                    $select=$pdo->query("SELECT MAX(ID_Agent) AS ID_Agent FROM agent");
                    $selects=$select->fetch();
                    $ID_Agent=$selects['ID_Agent'];
                }
                $rs = $pdo->prepare("INSERT INTO table_rapport_quality (ID_Site, ID_Project, ID_Agent, Date_Rapport, Fichier, ID_Utilisateur) VALUES (?,?,?,?,?,?)");
                $params = array($Site, $Project, $ID_Agent, $Daterap, $Fichier, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
                $rs->execute($params);
                $select = $pdo->query("SELECT MAX(ID_Rapport) AS ID_Rapport FROM table_rapport_quality");
                $selects = $select->fetch();
                echo "1," . $selects['ID_Rapport'];
            }
        } else {
            echo "3";
        }
    }
} else {
    if ($Token == $_SESSION['user_eteelo_app']['token']) {
        if($ID_Agent=='' && $Field_Eng!=''){
            $insert_agent=$pdo->query("INSERT INTO agent SET Nom_Agent='".$Field_Eng."'");
            $select=$pdo->query("SELECT MAX(ID_Agent) AS ID_Agent FROM agent");
            $selects=$select->fetch();
            $ID_Agent=$selects['ID_Agent'];
        }
        $rs = $pdo->prepare("INSERT INTO table_rapport_quality (ID_Site, ID_Project, ID_Agent, Date_Rapport, ID_Utilisateur) VALUES (?,?,?,?,?)");
        $params = array($Site, $Project, $ID_Agent, $Daterap, $_SESSION['user_eteelo_app']['ID_Utilisateur']);
        $rs->execute($params);
        $select = $pdo->query("SELECT MAX(ID_Rapport) AS ID_Rapport FROM table_rapport_quality");
        $selects = $select->fetch();
        echo "1," . $selects['ID_Rapport'];
    }
}
?>