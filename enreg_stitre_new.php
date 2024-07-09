<?php
session_start();
require_once ("connexion.php");
$Token = $_POST['token'];
$ID_Titre = htmlentities($_POST['ID_Titre']);
$Design = Securite::bdd($_POST['Design']);
$Nombre = htmlentities($_POST['Nombre']);
if ($Token == $_SESSION['user_eteelo_app']['token']) {
    $rech = $pdo->query("SELECT * FROM table_sous_titre_new WHERE UPPER(Design_Sous_Titre)='" . strtoupper($Design) . "'");
    if ($rechs = $rech->fetch()) {
        echo "2";
    } else {
        $select = $pdo->query("SELECT COUNT(*) AS Nombre FROM table_sous_titre_new WHERE ID_Titre=" . $ID_Titre);
        $selects = $select->fetch();
        $Code = $selects['Nombre'] + 1;
        $rs = $pdo->prepare("INSERT INTO table_sous_titre_new (ID_Titre, Code_Sous_Titre, Design_Sous_Titre, Nombre_Photo) VALUES (?,?,?,?)");
        $params = array($ID_Titre, $Code, $Design, $Nombre);
        $rs->execute($params);
        echo "1";
    }
}
?>