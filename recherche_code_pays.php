<?php
require_once ("connexion.php");
$Pays = $_POST['Pays'];
$rech = $pdo->query("SELECT * FROM pays WHERE ID_Pays=" . $Pays);
$rechs = $rech->fetch();
echo $rechs['Code_Pays'];
?>