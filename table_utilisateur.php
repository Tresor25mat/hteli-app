<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
    require_once('connexion.php');
    $utilisateur=$pdo->query("SELECT * FROM utilisateur WHERE ID_Utilisateur!=1");
?>

    <!-- Bootstrap Core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <link href="notifica/css/alertify.min.css" rel="stylesheet">

    <script type="text/javascript" src="notifica/alertify.min.js"></script>
    <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
    <!-- DataTables Responsive CSS -->
    <link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="dist/css/sb-admin-2.css" rel="stylesheet">
    <!-- <link href="css/style-2.css" rel="stylesheet"> -->
    <!-- Custom Fonts -->
    <script src="js/jquery.slimscroll.min.js"></script>
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <style>
      .mylink:hover{
          font-weight: bold;
          text-decoration: none;
      }
  </style>
</head>

<body>


   <div class=" profile">

    <div class="profile-bottom col-lg-12">
            <!-- <div class="row" style="padding: 20px"> -->
            <div class="row" style="padding: 20px; margin-bottom: 30px; border-bottom: 1px solid #DEE2E6">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12" style="padding-top: 10px;">
                    <a href="ajouter_utilisateur.php" class="btn btn-primary form-control mybtn" style="border-radius: 20px; margin-left: 0; margin-bottom: 10px; font-size: 17px;">Ajouter</a>
                </div>
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12"></div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- </div> -->
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <!-- <div class="panel panel-default"> -->
                        <!-- <div class="panel-body"> -->
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead style="display: none;">
                                    <tr>
                                        <th></th>
                                        <th></th>
<!--                                         <th>Profil</th>
                                        <th>Téléphone</th>
                                        <th>Login</th>
                                        <th>Photo</th>
                                        <th>Messages</th>
                                        <th>Opérations</th>
                                        <th>Statut</th> -->
                                    </tr>
                                </thead>
                                <tbody id="MaTable">
    <?php while($utilisateurs=$utilisateur->fetch()){ 
            $profil=$pdo->query("SELECT * FROM profil WHERE ID_Profil=".$utilisateurs['ID_Profil']." ORDER BY ID_Profil");
            $profils=$profil->fetch();
            $ecole=$pdo->query("SELECT * FROM etablissement WHERE ID_Etablissement=".$utilisateurs['ID_Etablissement']);
            $ecoles=$ecole->fetch();
        ?>
        <tr class="odd gradeX">
            <td style="width: 80px; border: none; border-top: 1px solid RGB(168,168,168)"><!-- <center> --><img src="<?php if($utilisateurs['Photo']==''){if($utilisateurs['ID_Profil']==1){echo('images/photo_femme.jpg');}else{echo('images/photo.jpg');}}else{ echo('images/profil/'.$utilisateurs['Photo']);} ?>" style="width: 70px; height: 70px; border: 1px solid RGB(232,232,232); margin-top: 35%" class="img-circle"><?php if($utilisateurs['Etat']==1){echo("<img src='images/connecte.gif' style='width: 12px; height: 12px; margin-top: 79px; margin-left: -15px'>");} ?></td><td style=" border: none; border-top: 1px solid RGB(168,168,168)"><h4 style="color: RGB(42,100,150)"><?php echo stripslashes($utilisateurs['Nom'].' '.$utilisateurs['Prenom']); ?></h4><h6 style="margin-top: -5px">Profil: <?php echo stripslashes($profils['Design_Profil']); ?></h6><h6 style="margin-top: -5px">Téléphone: <?php echo ($utilisateurs['Tel']); ?></h6><h6 style="margin-top: -5px">Login: <?php echo ($utilisateurs['Login']); ?></h6><h6 style="margin-top: -5px">Statut: <?php echo ($utilisateurs['Statut']); ?></h6>
                <h6 style="margin-top: -5px">Ecole: <?php echo stripslashes($ecoles['Design_Etablissement']); ?></h6>
                <h6 style="margin-top: -5px"><?php if($utilisateurs['ID_Utilisateur']!=1 && $utilisateurs['ID_Utilisateur']!=$_SESSION['user_slj_wings']['ID_Utilisateur']){ ?><a href="modifier_utilisateur.php?ID=<?php echo($utilisateurs['ID_Utilisateur']) ?>&token=<?php echo($_SESSION['user_slj_wings']['token']) ?>" title="Modifier" style="margin-right: 5px; width: 30px; border-radius: 0" class="btn btn-primary"><i class="fa fa-edit fa-fw" style="margin-left: -5px"></i></a><?php if ($utilisateurs['Active']==1){ echo '<a class="btn btn-success" href="desactiver_utilisateur.php?ID='.$utilisateurs['ID_Utilisateur'].'&token='.$_SESSION['user_slj_wings']['token'].'" title="Désactiver" style="margin-right: 5px; width:30px; border-radius: 0"><i class="fa fa-close fa-fw" style="margin-left: -7px"></i></a>';}else{ echo '<a class="btn btn-success" style="width:30px; margin-right: 5px; border-radius: 0" href="activer_utilisateur.php?ID='.$utilisateurs['ID_Utilisateur'].'&token='.$_SESSION['user_slj_wings']['token'].'" title="Activer" style="margin-right: 5px"><i class="fa fa-check fa-fw" style="margin-left: -7px"></i></a>';} ?><?php if($utilisateurs['Etat']!=1){ ?><a style="width: 30px; border-radius: 0" class="btn btn-danger" href="javascript: alertify.confirm('Voulez-vous vraiment supprimer cet utilisateur?\n Tous les fichiers concernant cet utilisateur seront supprimés!').set('onok',function(closeEvent){window.location.replace('suppr_utilisateur.php?ID=<?php echo($utilisateurs['ID_Utilisateur']) ?>&token=<?php echo($_SESSION['user_slj_wings']['token']) ?>&IMG=<?php echo($utilisateurs['Photo']) ?>');alertify.success('suppression éffectuée');}).set('oncancel',function(closeEvent){alertify.error('suppression annulée');}).set({title:''},{labels:{ok:'Oui', cancel:'Annuler'}});" title="Supprimer"><i class="fa fa-trash-o fa-fw" style="margin-left: -7px"></i></a><?php }} ?></h6></td>
<!--             <td><?php echo stripslashes($utilisateurs['Prenom']); ?></td>
            <td><?php echo stripslashes($utilisateurs['Nom']); ?></td>
            <td><center><?php echo stripslashes($utilisateurs['Profil']); ?></center></td>
            <td><?php echo ($utilisateurs['Tel']); ?></td>
            <td><?php echo ($utilisateurs['Login']); ?></td> -->

<!--             <td><a href="select_sms.php?ID=<?php echo($utilisateurs['ID_Utilisateur']) ?>" style="margin-right: 5px" class="mylink"><?php echo "Messages(".$smscount['NBR'].")"; ?></a></td>
            <td><center><?php if($utilisateurs['ID_Utilisateur']!=1){ ?><a href="modifier_utilisateur.php?ID=<?php echo($utilisateurs['ID_Utilisateur']) ?>&token=<?php echo($_SESSION['user_slj_wings']['token']) ?>" title="Modifier" style="margin-right: 5px"><i class="fa fa-edit fa-fw"></i></a><a href="javascript: alertify.confirm('Voulez-vous vraiment supprimer cet utilisateur?\n Tous les fichiers concernant cet utilisateur seront supprimés!').set('onok',function(closeEvent){window.location.replace('suppr_utilisateur.php?ID=<?php echo($utilisateurs['ID_Utilisateur']) ?>&token=<?php echo($_SESSION['user_slj_wings']['token']) ?>&IMG=<?php echo($utilisateurs['Photo']) ?>');alertify.success('suppression éffectuée');}).set('oncancel',function(closeEvent){alertify.error('suppression annulée');}).set({title:''},{labels:{ok:'Oui', cancel:'Annuler'}});" title="Supprimer"><i class="fa fa-trash-o fa-fw"></i></a><?php } ?></center></td>
            <td><center><?php echo ($utilisateurs['Statut']); ?></center></td> -->
        </tr>
    <?php } ?>
</tbody>
                            </table>
                        <!-- </div> -->
                    <!-- </div> -->
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
        </div>
    </div>
        </div>
    </div>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
  <!-- <script src="lib/jquery.scrollTo.min.js"></script> -->
  <script src="vendor/jquery/jquery-ui.min.js"></script>
  <!-- <script src="js/jquery.nicescroll.js"></script> -->
  <!--common script for all pages-->
  <script src="js/scripts.js"></script>
  <!--script for this page-->
  <script src="lib/form-validation-script.js"></script>

    <!-- DataTables JavaScript -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="dist/js/sb-admin-2.js"></script>
        <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
            $.ajax({
                url:'utilisateur_conn.php',
                type:'post',
                dataType:'text',
                success:function(ret){
                }
            }); 
    });

        function utilisateur_connecte(){
            $.ajax({
                url:'utilisateur_connect.php',
                type:'post',
                dataType:'text',
                success:function(ret){
                    if(ret!=0){
                        window.location.replace('table_utilisateur.php');
                    }
                }
            }); 

        }
        setInterval(utilisateur_connecte,2000);

    </script>