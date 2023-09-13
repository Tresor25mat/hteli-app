<?php 
    session_start();
	require_once('connexion.php');
    $Paiement=htmlentities($_POST['Paiement']);
    $req_operation=$pdo->query("SELECT * FROM paiement INNER JOIN operation ON paiement.ID_Operation=operation.ID_Operation INNER JOIN operation_compte ON operation.ID_Operation=operation_compte.ID_Operation WHERE paiement.ID_Paiement='".$Paiement."' AND operation_compte.ID_Type_Operation=1");
    $operations=$req_operation->fetch();
	echo $operations['ID_Compte'];
?>