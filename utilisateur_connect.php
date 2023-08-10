<?php 
    session_start();
	require_once('connexion.php');
	$user=$pdo->query("SELECT * FROM utilisateur WHERE Logged=1");
	if($users=$user->fetch()){
	    if($users['Photo']==""){
	        if($users['ID_Profil']==1){
	            $Photo="images/photo_femme.jpg";
	        }else{
	            $Photo="images/photo.jpg";
	        }
	    }else{
	        $Photo="images/profil/".$users['Photo'];
	    }
	    $update=$pdo->query("UPDATE utilisateur SET Logged=0 WHERE ID_Utilisateur=".$users['ID_Utilisateur']);
		echo $users['Prenom'].','.$users['Nom'].','.$Photo;
	}else{
		echo "0";
	}
?>