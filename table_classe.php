<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
    require_once('connexion.php');
    $query="SELECT * FROM classe INNER JOIN table_option ON classe.ID_Option=table_option.ID_Option INNER JOIN section ON table_option.ID_Section=section.ID_Section WHERE classe.ID_Classe!=0";
    if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){
        $query.=" AND section.ID_Etablissement=".$_GET['Ecole'];
        $liste_option=$pdo->query("SELECT * FROM table_option INNER JOIN section ON table_option.ID_Section=section.ID_Section WHERE section.ID_Etablissement=".$_GET['Ecole']." ORDER BY Design_Option");
    }
    if(isset($_GET['Option']) && $_GET['Option']!=''){
        $query.=" AND classe.ID_Option=".$_GET['Option'];
    }
    if(isset($_GET['Niveau']) && $_GET['Niveau']!=''){
        $query.=" AND classe.ID_Niveau=".$_GET['Niveau'];
    }
    $query.=" ORDER BY classe.Design_Classe";
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
    $liste_ecole=$pdo->query("SELECT * FROM etablissement ORDER BY Design_Etablissement");
    $liste_niveau=$pdo->query("SELECT * FROM niveau ORDER BY ID_Niveau");
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
    <title>Classes | <?php echo $app_infos['Design_App']; ?></title>
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
    <link rel="stylesheet" type="text/css" href="vendor/jquery/jquery-ui.min.css" />
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
      .ui-autocomplete{
        background-color:#CCC ! important;
        z-index: 10000;
        width: 200px
      }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" style="overflow: hidden;">
    <div class="page">
      <div class="page-wrapper">
      <div class="text-muted mt-1">

<?php if($Total!=0){ 
        if($totalparpage<$Total){
            if($depart+$totalparpage<$Total){

    ?>
        Affiche de <?php echo $depart+1; ?> à <?php echo $depart+$totalparpage; ?> sur <?php echo $Total; ?> enregistrements
        <?php }else{ ?>
            Affiche de <?php echo $depart+1; ?> à <?php echo $Total; ?> sur <?php echo $Total; ?> enregistrements
<?php }}else{ ?>
    Affiche de <?php echo $depart+1; ?> à <?php echo $Total; ?> sur <?php echo $Total; ?> enregistrements
<?php }}else{ ?>
    Affiche de 0 à 0 sur 0 enregistrements
<?php } ?>

</div>
        <div class="page-body">
          <div class="container-xl" style="border: 1px solid #E6E7E9">
            <div class="row row-deck row-cards">
            <input type="hidden" name="ID_Classe" id="ID_Classe">
            <input type="hidden" name="ID_Enseignant" id="ID_Enseignant">
            <input type="hidden" name="ID_Etab" id="ID_Etab" value="<?php if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){echo $_GET['Ecole']; } ?>">
            <input type="hidden" name="Option" id="Option" value="<?php if(isset($_GET['Option']) && $_GET['Option']!=''){echo $_GET['Option']; } ?>">
            <input type="hidden" name="Niveau" id="Niveau" value="<?php if(isset($_GET['Niveau']) && $_GET['Niveau']!=''){echo $_GET['Niveau']; } ?>">
                <!-- <div class="col-md-12 col-lg-12"> -->
                    <!-- <div class="panel panel-default"> -->
                        <!-- <div class="panel-body"> -->
                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Désignation</th>
                                        <th>Titulaire</th>
                                        <th>Opérations</th>
                                    </tr>
                                </thead>
                                <tbody id="MaTable">
    <?php while($selections=$selection->fetch()){
                $titulaire=$pdo->query("SELECT * FROM enseignant WHERE ID_Enseignant=".$selections['ID_Enseignant']);
                $titulaires=$titulaire->fetch();
                $noms=strtoupper(stripslashes($titulaires['Nom_Enseignant'].' '.$titulaires['Pnom_Enseignant'].' '.$titulaires['Prenom_Enseignant']));
                $Nbr++; ?>
        <tr class="odd gradeX" style="background: transparent;">
            <td style="width: 80px; "><center><?php echo sprintf('%02d', $Nbr); ?></center></td>
            <td><!-- <center> --><?php echo strtoupper(stripslashes($selections['Design_Classe'])); ?></td>
            <td><!-- <center> --><?php echo strtoupper(stripslashes($titulaires['Nom_Enseignant'].' '.$titulaires['Pnom_Enseignant'].' '.$titulaires['Prenom_Enseignant'])); ?></td>
            <td><center>
                <?php if($_SESSION['user_eteelo_app']['ID_Statut']==1 || $_SESSION['user_eteelo_app']['ID_Statut']==2 || $_SESSION['user_eteelo_app']['ID_Statut']==3 || $_SESSION['user_eteelo_app']['ID_Statut']==4){ ?>
                <a href="#" onclick="Function_Modifier(<?php echo($selections['ID_Classe']); ?>, <?php echo($selections['ID_Etablissement']); ?>, <?php echo($selections['ID_Option']); ?>, <?php echo($selections['ID_Niveau']); ?>, <?php echo($selections['ID_Enseignant']); ?>, '<?php echo $noms; ?>', '<?php echo strtoupper(stripslashes($selections['Design_Classe'])); ?>')" title="Modifier" style="margin-right: 5px; width: 25px; border-radius: 0;" class="btn btn-primary"><i class="fa fa-edit fa-fw"></i></a>
                <?php } if($_SESSION['user_eteelo_app']['ID_Statut']==1 || $_SESSION['user_eteelo_app']['ID_Statut']==2){ ?>
                <a style="width: 25px; border-radius: 0;" class="btn btn-danger" href="javascript: alertify.confirm('Voulez-vous vraiment supprimer cette classe ?\n Toutes les informations concernant cette classe seront supprimées!').set('onok',function(closeEvent){window.location.replace('suppr_classe.php?ID=<?php echo($selections['ID_Classe']) ?>&token=<?php echo($_SESSION['user_eteelo_app']['token']) ?>&Ecole=<?php if(isset($_GET['Ecole']) && $_GET['Ecole']!=''){echo $_GET['Ecole']; } ?>&Option=<?php if(isset($_GET['Option']) && $_GET['Option']!=''){echo $_GET['Option']; } ?>&Niveau=<?php if(isset($_GET['Niveau']) && $_GET['Niveau']!=''){echo $_GET['Niveau']; } ?>');alertify.success('suppression éffectuée');}).set('oncancel',function(closeEvent){alertify.error('suppression annulée');}).set({title:''},{labels:{ok:'Oui', cancel:'Annuler'}});" title="Supprimer"><i class="fa fa-trash-o fa-fw"></i></a></center>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</tbody>
                            </table>
                            <div class="d-flex mt-4">
              <ul class="pagination ms-auto">
                                <?php 
                                if($pageCourante>1){
                                    $page=$pageCourante-1;
                                    echo '<li class="page-item"><a class="page-link" href="table_classe.php?page='.$page.'&Ecole='.$_GET['Ecole'].'&Option='.$_GET['Option'].'&Niveau='.$_GET['Niveau'].'"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>Previous</a></li>';
                                }else{
                                    echo '<li class="page-item disabled"><a class="page-link" href="#"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>Previous</a></li>';
                                }
                                if($pagesTotales>3){
                                    $pagePrecedente=$pageCourante-1;
                                    $pageNexte=$pageCourante+1;
                                    $pageTrois=$pageCourante+2;
                                    $pageAvantPrecedente=$pageCourante-2;
                                    $pagesAvantTotales=$pagesTotales-1;
                                    if($pageCourante==1){
                                        echo '<li class="page-item"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="table_classe.php?page='.$pageNexte.'&Ecole='.$_GET['Ecole'].'&Option='.$_GET['Option'].'&Niveau='.$_GET['Niveau'].'">'.$pageNexte.'</a></li><li class="page-item"><a class="page-link" href="table_classe.php?page='.$pageTrois.'&Ecole='.$_GET['Ecole'].'&Option='.$_GET['Option'].'&Niveau='.$_GET['Niveau'].'">'.$pageTrois.'</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    }else if($pageCourante==2){
                                        echo '<li class="page-item"><a class="page-link" href="table_classe.php?page='.$pagePrecedente.'&Ecole='.$_GET['Ecole'].'&Option='.$_GET['Option'].'&Niveau='.$_GET['Niveau'].'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li><li class="page-item"><a class="page-link" href="table_classe.php?page='.$pageNexte.'&Ecole='.$_GET['Ecole'].'&Option='.$_GET['Option'].'&Niveau='.$_GET['Niveau'].'">'.$pageNexte.'</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    }else if($pageCourante==$pagesAvantTotales){
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_classe.php?page='.$pagePrecedente.'&Ecole='.$_GET['Ecole'].'&Option='.$_GET['Option'].'&Niveau='.$_GET['Niveau'].'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li><li class="page-item"><a class="page-link" href="table_classe.php?page='.$pageNexte.'&Ecole='.$_GET['Ecole'].'&Option='.$_GET['Option'].'&Niveau='.$_GET['Niveau'].'">'.$pageNexte.'</a></li>';
                                    }else if($pageCourante==$pagesTotales){
                                            echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_classe.php?page='.$pageAvantPrecedente.'&Ecole='.$_GET['Ecole'].'&Option='.$_GET['Option'].'&Niveau='.$_GET['Niveau'].'">'.$pageAvantPrecedente.'</a></li><li class="page-item"><a class="page-link" href="table_classe.php?page='.$pagePrecedente.'&Ecole='.$_GET['Ecole'].'&Option='.$_GET['Option'].'&Niveau='.$_GET['Niveau'].'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li>';
                                    }else{
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_classe.php?page='.$pagePrecedente.'&Ecole='.$_GET['Ecole'].'&Option='.$_GET['Option'].'&Niveau='.$_GET['Niveau'].'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li><li class="page-item"><a class="page-link" href="table_classe.php?page='.$pageNexte.'&Ecole='.$_GET['Ecole'].'&Option='.$_GET['Option'].'&Niveau='.$_GET['Niveau'].'">'.$pageNexte.'</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>'; 
                                    }
                                }else{
                                    for ($i=1; $i <= $pagesTotales ; $i++) { 
                                        if ($i==$pageCourante) {
                                            echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
                                        }else{
                                            echo '<li class="page-item"><a class="page-link" href="table_classe.php?page='.$i.'&Ecole='.$_GET['Ecole'].'&Option='.$_GET['Option'].'&Niveau='.$_GET['Niveau'].'">'.$i.'</a></li>';
                                        }
                                    } 
                                }
                                if($pagesTotales>$pageCourante){
                                    $page=$pageCourante+1;
                                    echo '<li class="page-item"><a class="page-link" href="table_classe.php?page='.$page.'&Ecole='.$_GET['Ecole'].'&Option='.$_GET['Option'].'&Niveau='.$_GET['Niveau'].'">Next<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg></a></li>';
                                }else{
                                    echo '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Next<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg></a></li>';
                                }

                            ?>
              </ul>
            </div>
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
        <div class="modal-dialog" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Modification d'une classe</h4>
                    <!-- <button type="button" class="close" datadismiss="modal" ariahidden="true" onclick="fermerDialogueEcole()">&times;</button> -->
                </div>
                <div class="modal-body">
                   <form method="post" action="">
                    <input id="tok" type="hidden" name="tok" value="<?php echo($_SESSION['user_eteelo_app']['token']); ?>">
                    <div class="row">
                        <div class="col-6" style="<?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){echo 'display: none';} ?>">
                            <div class="col-lg-12">Ecole *</div>
                            <select name="liste_ecole" class="form-control" id="liste_ecole" <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ echo 'disabled';} ?>>
                                <option value="">--</option>
                                <?php while($liste_ecoles=$liste_ecole->fetch()){ ?>
                                <option value="<?php echo($liste_ecoles['ID_Etablissement']) ?>" <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1 && $liste_ecoles['ID_Etablissement']==$_SESSION['user_eteelo_app']['ID_Etablissement']){ echo 'selected';} ?>><?php echo(stripslashes($liste_ecoles['Design_Etablissement'])) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <div class="col-lg-12">Option *</div>
                            <select name="liste_option" class="form-control" id="liste_option">
                                <option value="" id="ajouter_option">--</option>
                                <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ while($liste_options=$liste_option->fetch()){ ?>
                                <option value="<?php echo($liste_options['ID_Option']) ?>"><?php echo(stripslashes($liste_options['Design_Option'])) ?></option>
                                <?php }} ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <div class="col-lg-12">Niveau *</div>
                            <select name="liste_niveau" class="form-control" id="liste_niveau">
                                <option value="">--</option>
                                <?php while($liste_niv=$liste_niveau->fetch()){ ?>
                                <option value="<?php echo($liste_niv['ID_Niveau']) ?>"><?php echo(stripslashes($liste_niv['Design_Niveau'])) ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-6">
                            <div class="col-lg-12">Désignation *</div>
                            <div class="col-lg-12"><input type="text" name="Design" id="Design" class="form-control" style="margin-top: 1%;" value="" required></div>
                        </div>
                        <div class="<?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){echo 'col-6';}else{echo 'col-12';} ?>">
                            <div class="col-lg-12">Titulaire</div>
                            <div class="col-lg-12"><input type="text" name="Titulaire" id="Titulaire" class="form-control" style="margin-top: 1%;" value="" required></div>
                        </div>
                    </div>
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
    <script src="vendor/jquery/jquery-ui.min.js"></script>
    <script type="text/javascript" src="notifica/alertify.min.js"></script>
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js" defer></script>
    <script src="./dist/js/demo.min.js" defer></script>
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="vendor/datatables-responsive/dataTables.responsive.js"></script>

    <script>
        listeEnseignant=[]; 
        $(document).ready(function() {
            // $("#ModalAjoutPoint").modal('show');
            // $('#dataTables-example').DataTable({
            //     responsive: true
            // });
        });
  function fermerDialogue(){
        $("#ModalMod").modal('hide');
  }
  $('#Titulaire').autocomplete({source:function(request,response){
        var resultat=$.ui.autocomplete.filter(listeEnseignant,request.term);
        response(resultat.slice(0,15));
        },
        select:function(event,ui){
            $('#ID_Enseignant').val(ui.item.desc);
            $('#enregistrer').focus();
        }
    });
  $('#liste_ecole').change(function(){
        if($('#liste_ecole').val()!=''){
            $.ajax({
                url:'recherche_option.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#liste_ecole').val()},
                success:function(ret){
                    $('#ajouter_option').nextAll().remove();
                    $('#ajouter_option').after(ret);
                    $('#liste_option').focus();
                }
            });
            $.ajax({
              url:"recherche_enseignant.php",
              type:'post',
              dataType:"json",
              data:{Ecole:$('#liste_ecole').val()},
              success:function(donnee){
                  listeEnseignant.length=0;
                  $.map(donnee,function(objet){
                    listeEnseignant.push({
                          value:objet.Nom,
                          desc:objet.ID_Enseignant
                      });
                  });
              }
            });
        }
    })
    $('#liste_option').change(function(){
        if($('#liste_option').val()!=''){
            $('#liste_niveau').focus();
        }
    })
    $('#liste_niveau').change(function(){
        if($('#liste_niveau').val()!=''){
            $('#Design').focus();
        }
    })
  function Function_Modifier(a, b, c, d, e, f, g){
      $("#ModalMod").modal('show');
      $('#ID_Classe').val(a);
      $('#liste_ecole').val(b);
      if($('#liste_ecole').val()!=''){
        $.ajax({
                url:'recherche_option.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#liste_ecole').val()},
                success:function(ret){
                    $('#ajouter_option').nextAll().remove();
                    $('#ajouter_option').after(ret);
                    $('#liste_option').val(c);
                }
            });
            $.ajax({
              url:"recherche_enseignant.php",
              type:'post',
              dataType:"json",
              data:{Ecole:$('#liste_ecole').val()},
              success:function(donnee){
                  listeEnseignant.length=0;
                  $.map(donnee,function(objet){
                    listeEnseignant.push({
                          value:objet.Nom,
                          desc:objet.ID_Enseignant
                      });
                  });
              }
            });
        }
        $('#liste_niveau').val(d);
        $('#ID_Enseignant').val(e);
        if(e!=0){
            $('#Titulaire').val(f);
        }
        $('#Design').val(g);
        $('#Design').focus();
  }
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

    $('#enregistrer').click(function(){
        if($('#Design').val()=='' || $('#liste_ecole').val()=='' || $('#liste_option').val()=='' || $('#liste_niveau').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!');
                $('#Design').focus();
        }else{
                $.ajax({
                        url:'edit_classe.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        data: {Design:$('#Design').val(), Ecole:$('#liste_ecole').val(), Option:$('#liste_option').val(), Niveau:$('#liste_niveau').val(), Titulaire:$('#ID_Enseignant').val(), token:$('#tok').val(), ID_Classe:$('#ID_Classe').val()},
                        success:function(ret){
                            if(ret==1){
                                alertify.success("L'opération a réussi");
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Modification éffectuée'
                                })
                                window.location.replace('table_classe.php?Ecole='+$('#ID_Etab').val()+"&Option="+$('#Option').val()+"&Niveau="+$('#Niveau').val());
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