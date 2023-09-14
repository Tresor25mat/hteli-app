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
        $liste_categorie=$pdo->query("SELECT * FROM categorie_compte WHERE ID_Etablissement=".$_GET['Ecole']." ORDER BY Cod_Categorie");
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
    $nature=$pdo->query("SELECT * FROM nature_compte ORDER BY Design_Nature");
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
            <input type="hidden" name="ID_Compte" id="ID_Compte">
            <input type="hidden" name="ID_Etab" id="ID_Etab" value="<?php if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){echo $_GET['Ecole']; } ?>">
            <input type="hidden" name="Categorie" id="Categorie" value="<?php if(isset($_GET['Categorie']) && $_GET['Categorie']!=''){echo $_GET['Categorie']; } ?>">
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
                                        <th>Opérations</th>
                                    </tr>
                                </thead>
                                <tbody id="MaTable">
    <?php while($categories=$selection->fetch()){
        $compte=$pdo->query("SELECT * FROM compte INNER JOIN  nature_compte ON compte.ID_Nature=nature_compte.ID_Nature WHERE compte.ID_Categorie=".$categories['ID_Categorie']." ORDER BY compte.Cod_Compte");
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
                <td><center>
                    <?php if($_SESSION['user_eteelo_app']['ID_Statut']==1 || $_SESSION['user_eteelo_app']['ID_Statut']==2 || $_SESSION['user_eteelo_app']['ID_Statut']==3 || $_SESSION['user_eteelo_app']['ID_Statut']==4){ ?>
                    <a href="#" onclick="Function_Modifier(<?php echo($comptes['ID_Compte']); ?>, <?php echo($categories['ID_Etablissement']); ?>, <?php echo($categories['ID_Categorie']); ?>, '<?php echo $categories['Cod_Categorie']; ?>', '<?php echo $comptes['Cod_Compte']; ?>', '<?php echo $comptes['Design_Compte']; ?>', <?php echo($comptes['ID_Nature']); ?>)" title="Modifier" style="margin-right: 5px; width: 25px; border-radius: 0;" class="btn btn-primary"><i class="fa fa-edit fa-fw"></i></a>
                    <?php } if($_SESSION['user_eteelo_app']['ID_Statut']==1 || $_SESSION['user_eteelo_app']['ID_Statut']==2){ ?>
                    <a style="width: 25px; border-radius: 0;" class="btn btn-danger" href="javascript: alertify.confirm('Voulez-vous vraiment supprimer ce compte?\n Toutes les informations concernant ce compte seront supprimées!').set('onok',function(closeEvent){window.location.replace('suppr_compte.php?ID=<?php echo($comptes['ID_Compte']) ?>&token=<?php echo($_SESSION['user_eteelo_app']['token']) ?>&Ecole=<?php if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){echo $_GET['Ecole']; } ?>&Categorie=<?php if(isset($_GET['Categorie']) && $_GET['Categorie']!=''){echo $_GET['Categorie']; } ?>');alertify.success('suppression éffectuée');}).set('oncancel',function(closeEvent){alertify.error('suppression annulée');}).set({title:''},{labels:{ok:'Oui', cancel:'Annuler'}});" title="Supprimer"><i class="fa fa-trash-o fa-fw"></i></a></center>
                    <?php } ?>
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
                    <h4 class="modal-title">Modification compte</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <input id="tok" type="hidden" name="tok" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                    <div class="col-lg-12" style="<?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){echo 'display: none';} ?>">Ecole *</div>
                    <div class="col-lg-12" style="<?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){echo 'display: none';} ?>">
                    <select name="liste_ecole" class="form-control" id="liste_ecole" <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ echo 'disabled';} ?>>
                        <option value="">--</option>
                        <?php while($liste_ecoles=$liste_ecole->fetch()){ ?>
                        <option value="<?php echo($liste_ecoles['ID_Etablissement']) ?>" <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1 && $liste_ecoles['ID_Etablissement']==$_SESSION['user_eteelo_app']['ID_Etablissement']){ echo 'selected';} ?>><?php echo(stripslashes($liste_ecoles['Design_Etablissement'])) ?></option>
                        <?php } ?>
                    </select>
                    </div>
                    <div class="col-lg-12">Catégorie *</div>
                    <select name="liste_categorie" class="form-control" id="liste_categorie">
                        <option value="" id="add_categorie">--</option>
                        <?php if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){ while($liste_categories=$liste_categorie->fetch()){ ?>
                        <option value="<?php echo($liste_categories['ID_Categorie']) ?>"><?php echo(stripslashes($liste_categories['Cod_Categorie'].' '.$liste_categories['Design_Categorie'])) ?></option>
                        <?php }} ?>
                    </select>
                    <div class="col-lg-12">N°compte *</div>
                    <div class="col-lg-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="afficher_code" style="border-top-right-radius: 0; border-bottom-right-radius: 0; border-right: none; height: 38px"></span>
                            </div>
                            <input class="form-control " id="numero_compte" type="text" name="numero_compte">
                        </div> 
                    </div>
                    <div class="col-lg-12">Intitulé du compte *</div>
                    <div class="col-lg-12">
                        <input class="form-control " id="design" type="text" name="design">
                    </div>
                    <div class="col-lg-12">Nature *</div>
                        <select name="nature" class="form-control" id="nature">
                            <option value="">--</option>
                            <?php while($natures=$nature->fetch()){ ?>
                            <option value="<?php echo($natures['ID_Nature']) ?>"><?php echo(stripslashes($natures['Design_Nature'])) ?></option>
                            <?php } ?>
                        </select>
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
  function Function_Modifier(a, b, c, d, e, f, g){
      $("#ModalMod").modal('show');
      $('#ID_Compte').val(a);
      $('#liste_ecole').val(b);
      $.ajax({
            url:'recherche_categorie_compte.php',
            type:'post',
            dataType:'html', 
            data:{Ecole:$('#liste_ecole').val()},
            success:function(ret){
                $('#add_categorie').nextAll().remove();
                $('#add_categorie').after(ret);
                $('#liste_categorie').val(c);
            }
      });
      $('#afficher_code').text(d);
      $('#numero_compte').val(e);
      $('#design').val(f);
      $('#nature').val(g);
      $('#design').focus();
  }

  $('#nature').change(function(){
        if($('#nature').val()!=''){
            $('#enregistrer').focus();
        }
    })

  $('#liste_ecole').change(function(){
        if($('#liste_ecole').val()!=''){
            $.ajax({
                url:'recherche_categorie_compte.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#liste_ecole').val()},
                success:function(ret){
                    $('#add_categorie').nextAll().remove();
                    $('#add_categorie').after(ret);
                    $('#liste_categorie').focus();
                }
            });
        }
    })
    $('#liste_categorie').change(function(){
        if($('#liste_categorie').val()!=''){
            $.ajax({
                url:'select_categorie.php',
                type:'post',
                dataType:'text', 
                data:{categorie:$('#liste_categorie').val()},
                success:function(ret){
                    $('#afficher_code').text(ret);
                    $('#numero_compte').val('');
                    $('#numero_compte').focus()
                }
            });
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
        if($('#design').val()=='' || $('#numero_compte').val()=='' || $('#liste_categorie').val()=='' || $('#nature').val()=='' || $('#liste_ecole').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!');
                $('#Design').focus();
        }else{
                $.ajax({
                        url:'edit_compte.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        data: {Design:$('#design').val(), Categorie:$('#liste_categorie').val(), Numero:$('#numero_compte').val(), Nature:$('#nature').val(), token:$('#tok').val(), ID_Compte:$('#ID_Compte').val()},
                        success:function(ret){
                            if(ret==1){
                                alertify.success("L'opération a réussi");
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Modification éffectuée'
                                })
                                window.location.replace('table_compte.php?Ecole='+$('#ID_Etab').val()+"&Categorie="+$('#Categorie').val());
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