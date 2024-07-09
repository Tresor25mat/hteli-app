<?php
session_start();
require_once ("connexion.php");
$Token = $_POST['token'];
$Design = Securite::bdd($_POST['Design']);
if ($Token == $_SESSION['user_eteelo_app']['token']) {
    $rech = $pdo->query("SELECT * FROM table_titre_new WHERE UPPER(Design_Titre)='" . strtoupper($Design) . "'");
    if ($rechs = $rech->fetch()) {
        echo "2";
    } else {
        $select = $pdo->query("SELECT COUNT(*) AS Nombre FROM table_titre_new");
        $selects = $select->fetch();
        $Code = $selects['Nombre'] + 1;
        $rs = $pdo->prepare("INSERT INTO table_titre_new (Code_Titre, Design_Titre) VALUES (?,?)");
        $params = array($Code, $Design);
        $rs->execute($params);
        echo "1";
    }
}
?>