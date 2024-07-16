<?php 
    session_start();
	require_once('connexion.php');
    if($_SESSION['user_eteelo_app']['ID_Statut']==3){
        $query="SELECT * FROM site INNER JOIN utilisateur_site ON site.ID_Site=utilisateur_site.ID_Site WHERE utilisateur_site.ID_Utilisateur=".$_SESSION['user_eteelo_app']['ID_Utilisateur'];
    }else{
        $query="SELECT * FROM site INNER JOIN province ON site.ID_Prov=province.ID_Prov WHERE province.ID_Pays=".$_POST['Pays'];
    }
    if(isset($_POST['Province']) && $_POST['Province']!=''){
        $query.=" AND ID_Prov=".$_POST['Province'];
    }
    $query.=" ORDER BY Site_ID, Site_Name";
    $req_site=$pdo->query($query);
    $tab_site=array();
    while($sites=$req_site->fetch()){
        $tab_site[]=array(
            'ID_Site'=>$sites['ID_Site'],
            'Design'=>stripslashes(strtoupper($sites['Site_ID'].' - '.$sites['Site_Name']))
        );
    }
    echo json_encode($tab_site);
?>