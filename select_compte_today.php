<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
    require_once('connexion.php');
    $query="SELECT * FROM categorie_compte WHERE ID_Categorie!=0";
    if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){
        $query.=" AND ID_Etablissement=".$_GET['Ecole'];
        $liste_categorie=$pdo->query("SELECT * FROM categorie_compte WHERE ID_Etablissement=".$_GET['Ecole']." ORDER BY Design_Section");
    }
    if(isset($_GET['Categorie']) && $_GET['Categorie']!=''){
        $query.=" AND ID_Categorie=".$_GET['Categorie'];
    }
    $query.=" ORDER BY Cod_Categorie";
    // $req=$pdo->query($query);
    // $Total=$req->rowCount();
    // $totalparpage=10;
    // $pagesTotales=ceil($Total/$totalparpage);
    // if (isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page']<=$pagesTotales) {
    //     $_GET['page'] = intval($_GET['page']);
    //     $pageCourante=$_GET['page'];
    // } else{
    //     $pageCourante=1;
    // }
    // $depart=($pageCourante-1)*$totalparpage;
    // $query.=" LIMIT ".$depart.",".$totalparpage;
    $selection=$pdo->query($query);
    $liste_ecole=$pdo->query("SELECT * FROM etablissement ORDER BY Design_Etablissement");
    $app_info=$pdo->query("SELECT * FROM app_infos");
    $app_infos=$app_info->fetch();
    $Nbr=0;
?>
<!DOCTYPE html>
<html lang="fr-FR">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Options | <?php echo $app_infos['Design_App']; ?></title>
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
    <div class="page">
      <div class="page-wrapper">
        <div class="page-body">
          <div class="container-xl" style="border: 1px solid #E6E7E9">
            <div class="row row-deck row-cards">
            <input type="hidden" name="ID_Option" id="ID_Option">
            <input type="hidden" name="ID_Etab" id="ID_Etab" value="<?php if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){echo $_GET['Ecole']; } ?>">
            <input type="hidden" name="section" id="section" value="<?php if(isset($_GET['Section']) && $_GET['Section']!=''){echo $_GET['Section']; } ?>">
                <!-- <div class="col-md-12 col-lg-12"> -->
                    <!-- <div class="panel panel-default"> -->
                        <!-- <div class="panel-body"> -->
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th style="display: none;"></th>
                                        <th>N°compte</th>
                                        <th>Intitulé du compte</th>
                                        <th>Nature de compte</th>
                                    </tr>
                                </thead>
                                <tbody id="MaTable">
    <?php while($categories=$selection->fetch()){
        $compte=$pdo->query("SELECT * FROM compte INNER JOIN  nature_compte ON compte.ID_Nature=nature_compte.ID_Nature WHERE compte.ID_Categorie=".$categories['ID_Categorie']." AND compte.Date_Enreg like '".date("Y-m-d")."%' ORDER BY compte.Cod_Compte");
        ?>
        <tr class="odd gradeX" style="font-size: 13px">
            <td style="display: none;"></td>
            <td><?php echo $categories['Cod_Categorie']; ?></td>
            <td colspan="3"><?php echo stripslashes($categories['Design_Categorie']); ?></td>
            <td style="display: none;"></td>
            <td style="display: none;"></td>
        </tr>
        <?php while($comptes=$compte->fetch()){ ?>
            <tr class="odd gradeX" style="font-size: 13px">
                <td style="display: none;"></td>
                <td><?php echo $categories['Cod_Categorie'].$comptes['Cod_Compte']; ?></td>
                <td><?php echo stripslashes($comptes['Design_Compte']); ?></td>
                <td><?php echo stripslashes($comptes['Design_Nature']); ?></td>
            </tr>
    <?php }} ?>
</tbody>
                            </table>
                        <!-- </div> -->
                    <!-- </div> -->
                    <!-- /.panel -->
                <!-- </div> -->

            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="ModalMod" class="modal fade" data-backdrop="static" style="margin-top: 100px">
        <div class="modal-dialog modal-sm" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modification option</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <input id="tok" type="hidden" name="tok" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                    <div class="col-lg-12">Ecole *</div>
                    <select name="liste_ecole" class="form-control" id="liste_ecole" <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ echo 'disabled';} ?>>
                        <option value="">--</option>
                        <?php while($liste_ecoles=$liste_ecole->fetch()){ ?>
                        <option value="<?php echo($liste_ecoles['ID_Etablissement']) ?>"><?php echo(stripslashes($liste_ecoles['Design_Etablissement'])) ?></option>
                        <?php } ?>
                    </select>
                    <div class="col-lg-12">Section *</div>
                    <select name="liste_section" class="form-control" id="liste_section">
                        <option value="" id="add_section">--</option>
                        <?php if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){ while($liste_sections=$liste_section->fetch()){ ?>
                        <option value="<?php echo($liste_sections['ID_Section']) ?>"><?php echo(stripslashes($liste_sections['Design_Section'])) ?></option>
                        <?php }} ?>
                    </select>
                    <div class="col-lg-12">Désignation *</div>
                    <div class="col-lg-12"><input type="text" name="Design" id="Design" class="form-control" style="margin-top: 1%;" value="" required></div>
                    </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="enregistrer">Enregistrer</button>
                <button  class="btn btn-danger" onclick="fermerDialogue()">Annuler</button>
            </div>
            </div>
        </div>
    </div>
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
  function fermerDialogue(){
        $("#ModalMod").modal('hide');
  }
  function Function_Modifier(a, b, c, d){
      $("#ModalMod").modal('show');
      $('#ID_Option').val(a);
      $('#liste_ecole').val(b);
      $.ajax({
            url:'recherche_section.php',
            type:'post',
            dataType:'html', 
            data:{Ecole:$('#liste_ecole').val()},
            success:function(ret){
                $('#add_section').nextAll().remove();
                $('#add_section').after(ret);
                $('#liste_section').val(c);
            }
      });
      $('#Design').val(d);
      $('#Design').focus();
  }


  $('#liste_ecole').change(function(){
        if($('#liste_ecole').val()!=''){
            $.ajax({
                url:'recherche_section.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#liste_ecole').val()},
                success:function(ret){
                    $('#add_section').nextAll().remove();
                    $('#add_section').after(ret);
                    $('#liste_section').focus();
                }
            });
        }
    })
    $('#liste_section').change(function(){
        if($('#liste_section').val()!=''){
            $('#Design').focus();
        }
    })



  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

    $('#enregistrer').click(function(){
        if($('#Design').val()=='' || $('#liste_ecole').val()=='' || $('#liste_section').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!');
                $('#Design').focus();
        }else{
                $.ajax({
                        url:'Edit_Option.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        data: {Design:$('#Design').val(), token:$('#tok').val(), ID_Option:$('#ID_Option').val()},
                        success:function(ret){
                            if(ret==1){
                                alertify.success("L'opération a réussi");
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Modification éffectuée'
                                })
                                window.location.replace('table_option.php?Ecole='+$('#ID_Etab').val()+"&Section="+$('#section').val());
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