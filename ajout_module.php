<?php 
    session_start();
    require_once('connexion.php');
    if(isset($_POST['Modules'])){
        $Modules = $_POST['Modules'];
        // echo var_dump($Modules);
        $list="";
        foreach($Modules as $module) {
            $tab_module=$pdo->query("select * from module where Id_Module=".$module);
            $fetch_module=$tab_module->fetch();
            if($list==""){
                $list.= stripslashes($fetch_module['Design_Module'])." <a href='#' title='Supprimer' onclick='delete_module(".$fetch_module["Id_Module"].")'><img src='images/trash.png' style='height:15px; width:auto'></a>";
            }else{
                $list.= " | ".stripslashes($fetch_module['Design_Module'])." <a href='#' title='Supprimer' onclick='delete_module(".$fetch_module["Id_Module"].")'><img src='images/trash.png' style='height:15px; width:auto'></a>";
            }
        }
        echo $list;
    }
?>