<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connexion");
    }
    require_once('connexion.php');
    $ecole=$pdo->query("SELECT * FROM etablissement ORDER BY Design_Etablissement");
    $liste_ecole=$pdo->query("SELECT * FROM etablissement ORDER BY Design_Etablissement");
    if($_SESSION['user_eteelo_app']['ID_Statut']!=1){
        $compte_debit=$pdo->query("SELECT * FROM compte INNER JOIN categorie_compte ON compte.ID_Categorie=categorie_compte.ID_Categorie WHERE compte.ID_Nature=8 AND compte.ID_Etablissement=".$_SESSION['user_eteelo_app']['ID_Etablissement']);
        $compte_credit=$pdo->query("SELECT * FROM compte INNER JOIN categorie_compte ON compte.ID_Categorie=categorie_compte.ID_Categorie WHERE compte.ID_Etablissement=".$_SESSION['user_eteelo_app']['ID_Etablissement']." AND (compte.ID_Nature=2 OR compte.ID_Nature=3)");
    }
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
    <title>Catégories frais | <?php echo $app_infos['Design_App']; ?></title>
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
      #btn_afficher:hover{
         border: 2px solid #D9DBDE;
      }
      #btn_afficher:focus{
         border: 2px solid #D9DBDE;
      }
  </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed" style="overflow-x: hidden;">
    <div class="page">
      <div class="page-wrapper">
        <div class="container-xl">
          <!-- Page title -->
          <div class="page-header d-print-none">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  
                </div>
                <h2 class="page-title">
                    Catégories frais
                </h2>
              </div>
              <!-- Page title actions -->
              <div class="col-12">
                <div class="row" style="border-bottom: 1px solid #EEEEEE; padding-bottom: 20px">
                    <div class="col-md-3" style="<?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){echo 'display: none';} ?>">
                      <div class="form-group ">
                        <label for="classe" class="control-label col-lg-12" style="text-align: left;">Ecole </label>
                        <div class="col-lg-12">
                          <div class="row">
                            <div class="col-sm-12">
                                <select name="ecole" class="form-control" id="ecole" <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ echo 'disabled';} ?>>
                                    <option value="">--</option>
                                    <?php while($ecoles=$ecole->fetch()){ ?>
                                    <option value="<?php echo($ecoles['ID_Etablissement']) ?>" <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1 && $ecoles['ID_Etablissement']==$_SESSION['user_eteelo_app']['ID_Etablissement']){ echo 'selected';} ?>><?php echo(stripslashes($ecoles['Design_Etablissement'])) ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-3" style="margin-top: 20px; margin-bottom: 20px;  <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){echo 'display: none';} ?>">
                      <button class="btn btn-default" type="button" id="btn_afficher" style="height: 32px; border-radius: 0; margin-top: 2px"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="col-12 col-md-auto ms-auto d-print-none" style="margin-top: 18px">
                        <div class="btn-list">
                        <a href="#" id="btn_ajouter" class="btn btn-primary d-sm-inline-block" title="Ajouter une catégorie">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="font-weight: bold;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                            Ajouter une catégorie
                        </a>
                        </div>
                    </div>
                  </div>


              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
            <iframe src="" style="width: 100%; height: 1500px; border: none;" id="iframe"></iframe>
        </div>
      </div>
    </div>
    <div id="ModalAjout" class="modal fade" data-backdrop="static" style="margin-top: 100px">
        <div class="modal-dialog modal-sm" style="border: 1px solid #E6E7E9">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Nouvelle catégorie</h4>
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
                    <div class="col-lg-12">Désignation *</div>
                    <div class="col-lg-12"><input type="text" name="Design" id="Design" class="form-control" style="margin-top: 1%;" value="" required></div>
                    <div class="col-lg-12">Compte debit *</div>
                    <select name="compte_debit" class="form-control" id="compte_debit">
                        <option value="" id="ajouter_compte_debit">--</option>
                        <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ while($compte_debits=$compte_debit->fetch()){ ?>
                        <option value="<?php echo($compte_debits['ID_Compte']) ?>"><?php echo(stripslashes($compte_debits['Cod_Categorie'].$compte_debits['Cod_Compte'].' '.$compte_debits['Design_Compte'])) ?></option>
                        <?php }} ?>
                    </select>
                    <div class="col-lg-12">Compte credit *</div>
                    <select name="compte_credit" class="form-control" id="compte_credit">
                        <option value="" id="ajouter_compte_credit">--</option>
                        <?php if($_SESSION['user_eteelo_app']['ID_Statut']!=1){ while($compte_credits=$compte_credit->fetch()){ ?>
                        <option value="<?php echo($compte_credits['ID_Compte']) ?>"><?php echo(stripslashes($compte_credits['Cod_Categorie'].$compte_credits['Cod_Compte'].' '.$compte_credits['Design_Compte'])) ?></option>
                        <?php }} ?>
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
        $('#iframe').attr('src', "table_cat_frais.php?Ecole="+$('#ecole').val());
    });
    $('#ecole').change(function(){
        if($('#ecole').val()!=''){
            $('#btn_afficher').focus();
        }
    })
    $('#liste_ecole').change(function(){
        if($('#liste_ecole').val()!=''){
            $.ajax({
                url:'recherche_compte_debit.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#liste_ecole').val()},
                success:function(ret){
                    $('#ajouter_compte_debit').nextAll().remove();
                    $('#ajouter_compte_debit').after(ret);
                }
            });
            $.ajax({
                url:'recherche_compte_credit.php',
                type:'post',
                dataType:'html', 
                data:{Ecole:$('#liste_ecole').val()},
                success:function(ret){
                    $('#ajouter_compte_credit').nextAll().remove();
                    $('#ajouter_compte_credit').after(ret);
                }
            });
            $('#Design').focus();
        }
    })
    $('#compte_debit').change(function(){
        if($('#compte_debit').val()!=''){
            $('#compte_credit').focus();
        }
    })
    $('#compte_credit').change(function(){
        if($('#compte_credit').val()!=''){
            $('#enregistrer').focus();
        }
    })
    $('#btn_afficher').click(function(){
        $('#iframe').attr('src', "table_cat_frais.php?Ecole="+$('#ecole').val());
    })
    function fermerDialogue(){
        $("#ModalAjout").modal('hide');
    }
  $(function() {
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 5000
    });

    $('#btn_ajouter').click(function(e){
      e.preventDefault();
      $("#ModalAjout").modal('show');
      $('#compte_debit').val('');
      $('#compte_credit').val('');
      $('#Design').val('');
      $('#Design').focus();
    })
    $('#enregistrer').click(function(){
        if($('#Design').val()=='' || $('#liste_ecole').val()=='' || $('#compte_debit').val()=='' || $('#compte_credit').val()==''){
                alertify.alert('<?php echo $app_infos['Design_App']; ?>','Veuillez remplir tous les champs obligatoires svp!');
                $('#Design').focus();
        }else{
                $.ajax({
                        url:'enreg_cat_frais.php',
                        type:'post',
                        beforeSend:function(){
                        },
                        dataType:'text',
                        data: {Design:$('#Design').val(), Compte_Debit:$('#compte_debit').val(), Compte_Credit:$('#compte_credit').val(), Ecole:$('#liste_ecole').val(), token:$('#tok').val()},
                        success:function(ret){
                            if(ret==1){
                                alertify.success("L'opération a réussi");
                                Toast.fire({
                                    icon: 'success',
                                    title: 'Enregistrement éffectué'
                                })
                                $('#iframe').attr('src', "table_cat_frais.php?Ecole="+$('#ecole').val());
                                fermerDialogue();
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