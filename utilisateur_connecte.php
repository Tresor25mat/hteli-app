<?php 
    session_start();
	require_once('connexion.php');
	$user=$pdo->query("SELECT * FROM utilisateur WHERE Loged=1 AND Statut!='User_Checkin'");
	if(isset($_SESSION['user_slj_wings']) && $_SESSION['user_slj_wings']['Statut']=='Admin'){
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
		    $update=$pdo->query("UPDATE utilisateur SET Loged=0 WHERE ID_Utilisateur=".$users['ID_Utilisateur']);
			echo $users['Prenom'].','.$users['Nom'].','.$Photo;
		}else{
			echo "0";
		}
	}else{
		echo "0";
	}
?>