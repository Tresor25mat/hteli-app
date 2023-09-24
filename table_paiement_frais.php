<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
    require_once('connexion.php');
    $query="SELECT * FROM paiement_frais INNER JOIN paiement ON paiement_frais.ID_Paiement=paiement.ID_Paiement INNER JOIN frais ON paiement_frais.ID_Frais=frais.ID_Frais INNER JOIN type_frais ON frais.ID_Type_Frais=type_frais.ID_Type_Frais INNER JOIN taux_change ON paiement_frais.ID_Taux=taux_change.ID_Taux WHERE paiement_frais.ID_Paiement_Frais!=0";
    if(isset($_GET['Paiement']) && $_GET['Paiement']!=''){
        $query.=" AND paiement_frais.ID_Paiement='".$_GET['Paiement']."'";
    }
    if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){
        $default_devise=$pdo->query("SELECT * FROM taux_change INNER JOIN table_taux ON taux_change.ID_Taux=table_taux.ID_Taux WHERE table_taux.ID_Etablissement=".$_GET['Ecole']." AND table_taux.Active=1");
        $default_devises=$default_devise->fetch();
    }
    $query.=" ORDER BY paiement_frais.Date_Enreg";
    $req=$pdo->query($query);
    $Total=$req->rowCount();
    $totalparpage=10;
    $pagesTotales=ceil($Total/$totalparpage);
    if (isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page']<=$pagesTotales) {
        $_GET['page'] = intval($_GET['page']);
        $pageCourante=$_GET['page'];
    } else{
        $pageCourante=1;
    }
    $depart=($pageCourante-1)*$totalparpage;
    $query.=" LIMIT ".$depart.",".$totalparpage;
    $selection=$pdo->query($query);
    $app_info=$pdo->query("SELECT * FROM app_infos");
    $app_infos=$app_info->fetch();
    $Nbr=0;
    $MontantTotal=0;
?>
<!DOCTYPE html>
<html lang="fr-FR">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Sections | <?php echo $app_infos['Design_App']; ?></title>
    <!-- CSS files -->
    <!-- DataTables CSS -->
    <link href="vendor/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">
    <!-- DataTables Responsive CSS -->
    <link href="vendor/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
    <!-- <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
    <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="notifica/css/alertify.min.css" rel="stylesheet">
    <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
    <link href="./dist/css/demo.min.css" rel="stylesheet"/>
    <link href="images/icon.png" rel="icon">
    <link href="images/icon.png" rel="apple-touch-icon">
    <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
  <style>
      .mylink:hover{
          font-weight: bold;
          text-decoration: none;
      }
      .alertify .ajs-dialog {
        top: 15%;
        transform: translateY(-50%);
        margin: auto;
    }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" style="overflow-x: hidden;">
    <!-- <div class="page"> -->
      <!-- <div class="page-wrapper"> -->
        <!-- <div class="page-body"> -->
          <!-- <div class="container-xl"> -->
            <!-- <div class="row row-deck row-cards"> -->
                <!-- <div class="col-md-12 col-lg-12"> -->
                    <!-- <div class="panel panel-default"> -->
                        <!-- <div class="panel-body"> -->
                            <table width="100%" class="table-bordered" id="dataTables-example" style="border: 1px solid #E6E7E9">
                                <thead style="display: none">
                                    <tr style="height: 35px;">
                                        <!-- <th colspan="4" style="text-align: center">Répartition</th> -->
                                        <th>Désignation</th>
                                        <th>Montant</th>
                                        <th>Opérations</th>
                                    </tr>
                                </thead>
                                <tbody id="MaTable">
    <?php while($selections=$selection->fetch()){$Nbr++;
        if($selections['ID_Taux']==$default_devises['ID_Taux']){
            $MontantTotal+=$selections['Montant_Paie'];
        }else{
            if($selections['ID_Taux']==1){
                $MontantTotal+=($selections['Montant_Paie']/$selections['Taux']);
            }else{
                $MontantTotal+=($selections['Montant_Paie']*$selections['Taux']);
            }
        }
        ?>
        <tr style="background: transparent; height: 35px;">
            <td style="width: 80px; "><center><?php echo sprintf('%02d', $Nbr); ?></center></td>
            <td style="padding-left: 10px"><!-- <center> --><?php echo strtoupper(stripslashes($selections['Libelle_Type_Frais'])); ?></td>
            <td style="padding-left: 10px"><!-- <center> --><?php echo number_format($selections['Montant_Paie'], 2, ',', ' ').stripslashes($selections['Symbole']); ?></td>
            <td><center>
                <?php if($_SESSION['user_eteelo_app']['ID_Statut']==1 || $_SESSION['user_eteelo_app']['ID_Statut']==2){ ?>
                <a style="width: 25px; border-radius: 0;" class="btn btn-danger" href="javascript: alertify.confirm('Voulez-vous vraiment supprimer cet enregistrement?\n Toutes les informations concernant cet enregistrement seront supprimées!').set('onok',function(closeEvent){window.location.replace('suppr_paiement_frais.php?ID=<?php echo($selections['ID_Paiement_Frais']) ?>&token=<?php echo($_SESSION['user_eteelo_app']['token']) ?>&Paiement=<?php if(isset($_GET['Paiement']) && $_GET['Paiement']!=''){echo $_GET['Paiement']; } ?>&Ecole=<?php if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){echo $_GET['Ecole']; } ?>');alertify.success('suppression éffectuée');}).set('oncancel',function(closeEvent){alertify.error('suppression annulée');}).set({title:''},{labels:{ok:'Oui', cancel:'Annuler'}});" title="Supprimer"><i class="fa fa-trash-o fa-fw"></i></a></center>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</tbody>
<tfoot>
                                    <tr style="height: 35px;">
                                        <th scope="row" colspan="2" style="padding-left: 10px">Total</th>
                                        <td style="font-weight: bold; padding-left: 10px"><?php if(isset($_GET['Paiement']) && $_GET['Paiement']!=''){ echo number_format($MontantTotal, 2, ',', ' ').stripslashes($default_devises['Symbole']);} ?></td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        <!-- </div> -->
                    <!-- </div> -->
                    <!-- /.panel -->
                <!-- </div> -->

            <!-- </div> -->
          <!-- </div> -->
        <!-- </div> -->
      <!-- </div> -->
    <!-- </div> -->
    <script src="./dist/libs/apexcharts/dist/apexcharts.min.js" defer></script>
    <script src="./dist/libs/jsvectormap/dist/js/jsvectormap.min.js" defer></script>
    <script src="./dist/libs/jsvectormap/dist/maps/world.js" defer></script>
    <script src="./dist/libs/jsvectormap/dist/maps/world-merc.js" defer></script>
    <script src="plugins/toastr/toastr.min.js"></script>
    <script src="plugins/sweetalert2/sweetalert2.min.js"></script>
    <script src="plugins/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="notifica/alertify.min.js"></script>
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js" defer></script>
    <script src="./dist/js/demo.min.js" defer></script>
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>

    <script>
        $(document).ready(function() {
            // $("#ModalAjoutPoint").modal('show');
            // $('#dataTables-example').DataTable({
            //     responsive: true
            // });
        });
  function fermerDialogueSection(){
        $("#ModalModSection").modal('hide');
  }
  function Function_Modifier(a, b, c){
      $("#ModalModSection").modal('show');
      $('#ID_Section').val(a);
      $('#liste_Frais').val(b);
      $('#Design').val(c);
      $('#Design').focus();
  }
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

    $('#enregsection').click(function(){
        if($('#Design').val()=='' || $('#liste_Frais').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!');
                $('#Design').focus();
        }else{
                $.ajax({
                        url:'Edit_Section.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        data: {Design:$('#Design').val(), token:$('#tok').val(), ID_Section:$('#ID_Section').val()},
                        success:function(ret){
                            if(ret==1){
                                alertify.success("L'opération a réussi");
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Modification éffectuée'
                                })
                                window.location.replace('table_tranche_frais.php?Frais='+$('#ID_Etab').val());
                            }else if(ret==2){
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>', 'Cette désignation existe déjà'); 
                            }else{
                                alertify.alert('<?php echo $app_infos['Design_App']; ?>',ret); 
                            }
                        }
                    });
        }
    });

  });
    </script>
</body>