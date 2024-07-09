<?php 
    session_start();
    require_once('connexion.php');
    if(isset($_POST['Sites'])){
        $Sites = $_POST['Sites'];
        // echo var_dump($Modules);
        $list="";
        foreach($Sites as $site) {
            $tab_site=$pdo->query("SELECT * FROM site WHERE ID_Site=".$site);
            $fetch_site=$tab_site->fetch();
            if($list==""){
                $list.= stripslashes($fetch_site['Site_ID'])." <a href='#' title='Supprimer' onclick='delete_site(".$fetch_site["ID_Site"].")'><img src='images/trash.png' style='height:15px; width:auto'></a>";
            }else{
                $list.= " | ".stripslashes($fetch_site['Site_ID'])." <a href='#' title='Supprimer' onclick='delete_site(".$fetch_site["ID_Site"].")'><img src='images/trash.png' style='height:15px; width:auto'></a>";
            }
        }
        echo $list;
    }
?>