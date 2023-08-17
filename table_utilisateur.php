<?php
    session_start();
    $_SESSION['last_activity'] = time();
    if(empty($_SESSION['logged_eteelo_app']) || $_SESSION['logged_eteelo_app']==false){
        header("location: connection");
    }
    require_once('connexion.php');
    if($_SESSION['user_eteelo_app']['ID_Statut']==1){
      $req_user=$pdo->query("SELECT * FROM utilisateur WHERE ID_Utilisateur!=1");
    }else if($_SESSION['user_eteelo_app']['ID_Statut']==3){
      $req_user=$pdo->query("SELECT * FROM utilisateur WHERE ID_Utilisateur!=1 AND ID_Statut!=1 AND ID_Statut!=2 AND ID_Etablissement=".$_SESSION['user_eteelo_app']['ID_Etablissement']);
    }else{
      $req_user=$pdo->query("SELECT * FROM utilisateur WHERE ID_Utilisateur!=1 AND ID_Etablissement=".$_SESSION['user_eteelo_app']['ID_Etablissement']);
    }
    $userTotal=$req_user->rowCount();
    $userparpage=10;
    $pagesTotales=ceil($userTotal/$userparpage);
    if (isset($_GET['page']) AND !empty($_GET['page']) AND $_GET['page'] > 0 AND $_GET['page']<=$pagesTotales) {
        $_GET['page'] = intval($_GET['page']);
        $pageCourante=$_GET['page'];
    } else{
        $pageCourante=1;
    }
    $depart=($pageCourante-1)*$userparpage;
    if($_SESSION['user_eteelo_app']['ID_Statut']==1){
      $utilisateur=$pdo->query("SELECT * FROM utilisateur WHERE ID_Utilisateur!=1 LIMIT ".$depart.",".$userparpage);
    }else if($_SESSION['user_eteelo_app']['ID_Statut']==3){
      $utilisateur=$pdo->query("SELECT * FROM utilisateur WHERE ID_Utilisateur!=1 AND ID_Statut!=1 AND ID_Statut!=2 AND ID_Etablissement=".$_SESSION['user_eteelo_app']['ID_Etablissement']." LIMIT ".$depart.",".$userparpage);
    }else{
      $utilisateur=$pdo->query("SELECT * FROM utilisateur WHERE ID_Utilisateur!=1 AND ID_Etablissement=".$_SESSION['user_eteelo_app']['ID_Etablissement']." LIMIT ".$depart.",".$userparpage);
    }
    $app_info=$pdo->query("SELECT * FROM app_infos");
    $app_infos=$app_info->fetch();
?>
<!DOCTYPE html>
<html lang="fr-FR">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Utilisateurs | <?php echo $app_infos['Design_App']; ?></title>
    <!-- CSS files -->
    <!-- DataTables CSS -->
    <link href="notifica/css/alertify.min.css" rel="stylesheet">
    <link href="./dist/css/tabler.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-flags.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-payments.min.css" rel="stylesheet"/>
    <link href="./dist/css/tabler-vendors.min.css" rel="stylesheet"/>
    <link href="./dist/css/demo.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <link href="images/icon.png" rel="icon">
    <link href="images/icon.png" rel="apple-touch-icon">
    <!-- <link href="vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css"> -->
  <style>
      .mylink:hover{
          font-weight: bold;
          text-decoration: none;
      }
      .card-btn:hover{
          color: black;
      }
      .btn-primary:hover{
            background: #1B5BA7;
            border: 1px #1B5BA7;
      }
      .btn-secondary:hover{
            background: #636976;
            border: 1px #636976;
      }
      .btn-info:hover{
            background: #4399E1;
            border: 1px #4399E1;
      }
      .btn-danger:hover{
            background: #D64939;
            border: 1px #D64939;
      }
        .alertify .ajs-dialog {
            top: 20%;
            transform: translateY(-50%);
            margin: auto;
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
                <h2 class="page-title">
                  Utilisateurs
                </h2>
                <div class="text-muted mt-1">

                                    <?php if($userTotal!=0){ 
                                            if($userparpage<$userTotal){
                                                if($depart+$userparpage<$userTotal){

                                        ?>
                                            Affiche de <?php echo $depart+1; ?> à <?php echo $depart+$userparpage; ?> sur <?php echo $userTotal; ?> enregistrements
                                            <?php }else{ ?>
                                                Affiche de <?php echo $depart+1; ?> à <?php echo $userTotal; ?> sur <?php echo $userTotal; ?> enregistrements
                                    <?php }}else{ ?>
                                        Affiche de <?php echo $depart+1; ?> à <?php echo $userTotal; ?> sur <?php echo $userTotal; ?> enregistrements
                                    <?php }}else{ ?>
                                        Affiche de 0 à 0 sur 0 enregistrements
                                    <?php } ?>

                </div>
              </div>
              <!-- Page title actions -->
              <div class="col-12 col-md-auto ms-auto d-print-none">
                <div class="d-flex">
<!--                   <input type="search" class="form-control d-inline-block w-9 me-3" placeholder="Search user…"/> -->
                  <a href="ajouter_utilisateur.php" class="btn btn-primary d-sm-inline-block" title="Ajouter">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="font-weight: bold;"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                    Ajouter
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="page-body">
          <div class="container-xl">
            <div class="row row-deck row-cards">
            <?php while($utilisateurs=$utilisateur->fetch()){
                $profil=$pdo->query("SELECT * FROM profil WHERE ID_Profil=".$utilisateurs['ID_Profil']." ORDER BY ID_Profil");
                $profils=$profil->fetch();
                $ecole=$pdo->query("SELECT * FROM etablissement WHERE ID_Etablissement=".$utilisateurs['ID_Etablissement']);
                $ecoles=$ecole->fetch();
            ?>

              <div class="col-md-6 col-lg-3">
                <div class="card">
                  <div class="card-body p-4 text-center">
                    <a href="#" onclick="Function_Afficher(<?php echo($utilisateurs['ID_Utilisateur']) ?>, '<?php if($utilisateurs['Photo']==''){if($utilisateurs['ID_Profil']==1){echo('images/photo_femme.jpg');}else{echo('images/photo.jpg');}}else{ echo('images/profil/'.$utilisateurs['Photo']);} ?>', '<?php echo $utilisateurs['Prenom'].' '.$utilisateurs['Nom']; ?>', '<?php echo stripslashes($pays['Design_Pays']); ?>', '<?php echo stripslashes($villes['Design_Ville']); ?>', '<?php echo $list; ?>', '<?php echo stripslashes($methods['Design_Mode_Contact']); ?>', '<?php echo date('H:i', strtotime($utilisateurs['Heure_Contact'])); ?>', '<?php echo stripslashes($utilisateurs['Email']); ?>', '<?php echo stripslashes($pays['Code_Pays'].$utilisateurs['Tel']); ?>', <?php echo($utilisateurs['Active']) ?>)" title="Show detail" style="width: 30px; border-radius: 0;">
                    <span class="avatar avatar-xl mb-3 avatar-rounded" style="background-image: url(<?php if($utilisateurs['Photo']==''){if($utilisateurs['ID_Profil']==1){echo('images/photo_femme.jpg');}else{echo('images/photo.jpg');}}else{ echo('images/profil/'.$utilisateurs['Photo']);} ?>); border: 1px solid #DEE2E6;"><?php if($utilisateurs['Etat']==1){echo("<img src='images/connecte.gif' style='width: 12px; height: 12px; margin-top: 85px; margin-left: 78px'>");} ?></span>
                    </a>
                    <h3 class="m-0 mb-1"><?php echo $utilisateurs['Prenom'].' '.$utilisateurs['Nom']; ?><!-- <a href="#">Paweł Kuna</a> --></h3>
                    <!-- <h5 class="m-0 mb-1"><?php echo $utilisateurs['Email']; ?><a href="#">Paweł Kuna</a></h5> -->
                    <h5 class="m-0 mb-1"><?php echo $utilisateurs['Login']; ?><!-- <a href="#">Paweł Kuna</a> --></h5>
                    <?php if($utilisateurs['Tel']!=''){ ?>
                    <h5 class="m-0 mb-1"><?php echo '243'.$utilisateurs['Tel']; ?><!-- <a href="#">Paweł Kuna</a> --></h5>
                    <?php } ?>
                    <div class="text-muted"><?php echo $utilisateurs['Statut']; ?></div>
                    <div class="mt-3">
                      <span class="badge bg-purple-lt"><?php echo stripslashes($ecoles['Design_Etablissement']); ?></span>
                    </div>
                  </div>
                  <div class="d-flex">
<?php if($utilisateurs['ID_Utilisateur']!=1 && $utilisateurs['ID_Utilisateur']!=$_SESSION['user_eteelo_app']['ID_Utilisateur']){ ?><a href="modifier_utilisateur.php?ID=<?php echo($utilisateurs['ID_Utilisateur']) ?>&token=<?php echo($_SESSION['user_eteelo_app']['token']) ?>" title="Modifier" style="width: 30px; border-radius: 0;" class="btn btn-primary card-btn"><i class="fa fa-edit fa-fw" style="color: white"></i></a><?php if ($utilisateurs['Active']==1){ echo '<a class="btn btn-secondary card-btn" href="desactiver_utilisateur.php?ID='.$utilisateurs['ID_Utilisateur'].'&token='.$_SESSION['user_eteelo_app']['token'].'" title="Désactiver" style="width:30px; border-radius: 0;"><i class="fa fa-ban fa-fw" style="margin-left: -7px; color: white"></i></a>';}else{ echo '<a class="btn btn-info card-btn" style="width:30px; border-radius: 0;" href="activer_utilisateur.php?ID='.$utilisateurs['ID_Utilisateur'].'&token='.$_SESSION['user_eteelo_app']['token'].'" title="Activer"><i class="fa fa-check fa-fw" style="color: white"></i></a>';} ?><?php if($utilisateurs['Etat']!=1 && ($_SESSION['user_eteelo_app']['ID_Statut']==1 || $_SESSION['user_eteelo_app']['ID_Statut']==2)){ ?><a style="width: 30px; border-radius: 0;" class="btn btn-danger card-btn" href="javascript: alertify.confirm('Voulez-vous vraiment supprimer cet utilisateur?\n Toutes les informations concernant cet utilisateur seront supprimées!').set('onok',function(closeEvent){window.location.replace('suppr_utilisateur.php?ID=<?php echo($utilisateurs['ID_Utilisateur']) ?>&token=<?php echo($_SESSION['user_eteelo_app']['token']) ?>&IMG=<?php echo($utilisateurs['Photo']) ?>');alertify.success('Spprimé');}).set('oncancel',function(closeEvent){alertify.error('Annulé');}).set({title:'<?php echo $app_infos['Design_App']; ?>'},{labels:{ok:'Oui', cancel:'Non'}});" title="Supprimer"><i class="fa fa-trash" style="color: white"></i></a><?php }} ?>





<!--                     <a href="#" class="card-btn">Download SVG icon from http://tabler-icons.io/i/mail
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="5" width="18" height="14" rx="2" /><polyline points="3 7 12 13 21 7" /></svg>
                      Email</a>
                    <a href="#" class="card-btn">Download SVG icon from http://tabler-icons.io/i/phone
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /></svg>
                      Call</a> -->
                  </div>
                </div>
              </div>
            <?php } ?>
            <div class="d-flex mt-4">
              <ul class="pagination ms-auto">
                                <?php 
                                if($pageCourante>1){
                                    $page=$pageCourante-1;
                                    echo '<li class="page-item"><a class="page-link" href="table_utilisateur.php?page='.$page.'"><svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="15 6 9 12 15 18" /></svg>Previous</a></li>';
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
                                        echo '<li class="page-item"><a class="page-link" href="#">1</a></li><li class="page-item"><a class="page-link" href="table_utilisateur.php?page='.$pageNexte.'">'.$pageNexte.'</a></li><li class="page-item"><a class="page-link" href="table_utilisateur.php?page='.$pageTrois.'">'.$pageTrois.'</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    }else if($pageCourante==2){
                                        echo '<li class="page-item"><a class="page-link" href="table_utilisateur.php?page='.$pagePrecedente.'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li><li class="page-item"><a class="page-link" href="table_utilisateur.php?page='.$pageNexte.'">'.$pageNexte.'</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>';
                                    }else if($pageCourante==$pagesAvantTotales){
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_utilisateur.php?page='.$pagePrecedente.'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li><li class="page-item"><a class="page-link" href="table_utilisateur.php?page='.$pageNexte.'">'.$pageNexte.'</a></li>';
                                    }else if($pageCourante==$pagesTotales){
                                            echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_utilisateur.php?page='.$pageAvantPrecedente.'">'.$pageAvantPrecedente.'</a></li><li class="page-item"><a class="page-link" href="table_utilisateur.php?page='.$pagePrecedente.'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li>';
                                    }else{
                                        echo '<li class="page-item"><a class="page-link" href="#">...</a></li><li class="page-item"><a class="page-link" href="table_utilisateur.php?page='.$pagePrecedente.'">'.$pagePrecedente.'</a></li><li class="page-item active"><a class="page-link" href="#">'.$pageCourante.'</a></li><li class="page-item"><a class="page-link" href="table_utilisateur.php?page='.$pageNexte.'">'.$pageNexte.'</a></li><li class="page-item"><a class="page-link" href="#">...</a></li>'; 
                                    }
                                }else{
                                    for ($i=1; $i <= $pagesTotales ; $i++) { 
                                        if ($i==$pageCourante) {
                                            echo '<li class="page-item active"><a class="page-link" href="#">'.$i.'</a></li>';
                                        }else{
                                            echo '<li class="page-item"><a class="page-link" href="table_utilisateur.php?page='.$i.'">'.$i.'</a></li>';
                                        }
                                    } 
                                }
                                if($pagesTotales>$pageCourante){
                                    $page=$pageCourante+1;
                                    echo '<li class="page-item"><a class="page-link" href="table_utilisateur.php?page='.$page.'">Next<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg></a></li>';
                                }else{
                                    echo '<li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" aria-disabled="true">Next<svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="9 6 15 12 9 18" /></svg></a></li>';
                                }

                            ?>
              </ul>
            </div>

            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="modal modal-blur fade" id="modal-afficher" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">User detail</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <center>
                <span class="avatar avatar-xl mb-3 avatar-rounded" style="background-image: url(''); border: 1px solid #DEE2E6;" id="myphoto"></span>

              </center>
              <label class="form-label">Name</label>
              <input type="text" class="form-control" name="example-text-input" placeholder="Name" id="myname" disabled="disabled" style="margin-bottom: 10px">
              <label class="form-label">Country</label>
              <input type="text" class="form-control" name="example-text-input" placeholder="Country" id="mycountry" disabled="disabled" style="margin-bottom: 10px">
              <label class="form-label">City</label>
              <input type="text" class="form-control" name="example-text-input" placeholder="City" id="mycity" disabled="disabled" style="margin-bottom: 10px">
              <label class="form-label">Language</label>
              <input type="text" class="form-control" name="example-text-input" placeholder="Language" id="mylanguage" disabled="disabled" style="margin-bottom: 10px">
<!--               <label class="form-label">Contact method</label>
              <input type="text" class="form-control" name="example-text-input" placeholder="Contact method" id="mymethode" disabled="disabled" style="margin-bottom: 10px">
              <label class="form-label">Time</label>
              <input type="text" class="form-control" name="example-text-input" placeholder="Time" id="mytime" disabled="disabled" style="margin-bottom: 10px"> -->
              <label class="form-label">Phone</label>
              <input type="text" class="form-control" name="example-text-input" placeholder="Phone" id="myphone" disabled="disabled" style="margin-bottom: 10px">
              <label class="form-label">Email</label>
              <input type="text" class="form-control" name="example-text-input" placeholder="Email" id="myemail" disabled="disabled" style="margin-bottom: 10px">
            </div>
          </div>
          <div class="modal-footer" style="border-top: 1px solid #E6E7E9; padding-top: 10px">
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
              Cancel
            </a>
            <a href="#" class="btn btn-primary ms-auto" id="monlien">
              <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
              Create new ticket
            </a>
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
            $('#dataTables-example').DataTable({
                responsive: true
            });
        });
        function Function_Afficher(a, b, c, d, e, f, g, h, i, j, k){
            $("#modal-afficher").modal('show');
            $("#myphoto").css('background-image', 'url("' + b + '")');
            $("#myname").val(c);
            $("#mycountry").val(d);
            $("#mycity").val(e);
            $("#mylanguage").val(f);
            // $("#mymethode").val(g);
            // $("#mytime").val(h);
            $("#myemail").val(i);
            $("#myphone").val(j);
            if(k==1){
                $("#monlien").attr('href', 'ajouter_ticket_admin.php?ID_Peace_Maker='+a);
                $("#monlien").attr('disabled', false);
            }else{
                $("#monlien").attr('href', '#');
                $("#monlien").attr('disabled', true);
            }
        }
        $("#monlien").click(function(){
            if($('#monlien').attr('href')=='#'){
               alertify.alert('<?php echo $app_infos['Design_App']; ?>','This user is disabled!');
            }
        })
    </script>
</body>