<?php 
    session_start();
	require_once('connexion.php');
	$update=$pdo->query("UPDATE utilisateur SET Logged=0");
?>