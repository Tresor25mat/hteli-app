<?php
    session_start();
    if(empty($_SESSION['logged_courrier']) || $_SESSION['logged_courrier']==false){
        header("location: connexion");
    }
    require_once ("connexion.php");
    $ID = $_SESSION['user_courrier']['ID_Utilisateur'];
    $Utilisateur = $pdo->query('SELECT * FROM utilisateur WHERE ID_Utilisateur='.$ID);
    $Utilisateurs = $Utilisateur->fetch();
    if($Utilisateurs['Logo']==""){ 
        $Logo = "images/Wavescom.jpg";
    }else{
        $Logo = "images/logo/".$Utilisateurs['Logo'];
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="SMS">
  <meta name="author" content="Dashboard">
  <meta name="keyword" content="SMS">
  <title>SMS</title>

  <!-- Favicons -->
  <link href="images/logo.png" rel="icon">
  <link href="images/logo.png" rel="apple-touch-icon">

  <!-- Bootstrap core CSS -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!--external css-->
  <link href="lib/font-awesome/css/font-awesome.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="css/zabuto_calendar.css">
  <link rel="stylesheet" type="text/css" href="lib/gritter/css/jquery.gritter.css" />
  <link rel="stylesheet" type="text/css" href="vendor/jquery/jquery-ui.min.css" />
  <!-- Custom styles for this template -->
  <!-- <link href="css/style-2.css" rel="stylesheet"> -->
  <link href="css/style-responsive.css" rel="stylesheet">
  <link href="notifica/css/alertify.min.css" rel="stylesheet">
  <script src="lib/chart-master/Chart.js"></script>
  <script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
  <script type="text/javascript" src="notifica/alertify.min.js"></script>
  <script src="js/jquery.slimscroll.min.js"></script>
  <style>
      .ui-autocomplete{
          background-color:#CCC ! important;
      }
      .form-panel{
          background: url(<?php echo $Logo; ?>)no-repeat;
          background-size: 250px;
          background-position: center;
      }
  </style>

</head>

<body>

   <div class=" profile">

    <div class="profile-bottom col-lg-12">

  <section id="container">
<!--     <section id="main-content">
      <section class="wrapper"> -->
        <!-- FORM VALIDATION -->
        <div class="row mt">
          <div class="col-lg-12">
            <!-- <h2 class="page-header" style="padding-left: 5px; color: black">Envoie Multiple des SMS</h2> -->
              <form class="cmxform form-horizontal style-form" id="SMSForm" method="post" action="" enctype="multipart/form-data">
            <div class="form-panel">
              <div class=" form">

                  <div class="row" style=" opacity: 0.9">
                    <div class="col-md-6">
                      <div class="form-group ">
                        <label for="prenom" class="control-label col-lg-2">Emetteur *</label>
                        <div class="col-lg-10">
                          <input id="token" type="hidden" name="token" value="<?php echo($_SESSION['user_courrier']['token']); ?>">
                          <input class="form-control " id="expediteur" type="text" name="expediteur" autofocus="autofocus" maxlength="11" value="<?php echo(stripslashes($_SESSION['user_courrier']['Emetteur'])); ?>">
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group ">
                        <label for="prenom" class="control-label col-lg-2">Téléphone *</label>
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-xs-9">
                                    <input class="form-control " id="destinataire" type="text" name="destinataire" placeholder="EX: 24381xxxxxxx,24384xxxxxxx,24399xxxxxxx">
                                </div>
                                <div class="col-xs-3" style="margin-left: -22px;">
                                    <input type="button" class="btn btn-primary" style="width: 100px;" value="Ajouter" id="btn_ajouter">
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="margin-top: -10px; ">
                    <div class="col-md-6">
                      <div class="form-group ">
                        <label for="prenom" class="control-label col-lg-2">Importer depuis Excel </label>
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-xs-9">
                                    <input class="form-control" disabled="disabled" id="txt_classeur">
                                </div>
                                <div class="col-xs-3" style="margin-left: -22px;">
                                    <input type="hidden" name="ID_Conversation" id="ID_Conversation">
                                    <input type="button" class="btn btn-primary" style="width: 100px; height: 34px" value="Parcourir..." id="btn_parcourir">
                                    <input class="form-control " id="btn_file" type="file" name="btn_file" style="display: none;" accept=".xls, .xlsx, .xlsm, .csv">
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
<!--                                         <div class="form-group col-lg-6 col-md-6  col-sm-6 col-xs-6" style="height: 140px; margin-top: -30px;">

                                        </div> -->
                    <div class="col-md-6">
                      <div class="form-group ">
                        <label for="prenom" class="control-label col-lg-2">Choisir la feuille de calcul </label>
                        <div class="col-lg-10">
                            <div class="row">
                                <div class="col-xs-9">
                                  <select name="feuille_calcul" id="feuille_calcul" class="form-control " disabled="disabled">
                                      <option value="" id="add_feuille">Sélectionner la feuille</option>
                                  </select>
                                </div>
                                <div class="col-xs-3" style="margin-left: -22px;">
                                    <input type="button" class="btn btn-primary" style="width: 100px; height: 34px" value="Importer" id="btn_importer" disabled="disabled">
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="row" style="margin-top: -10px;opacity: 0.9">
                    <div class="col-md-6">
                      <div class="form-group ">
                          <iframe src="table_numero.php?conversation=''" style="width: 94%; height: 250px; border: 1px solid #DDDDDD; margin-top: 27px; margin-left: 15px" id="iframe_numero"></iframe>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class="form-group ">
                        <label for="prenom" class="control-label col-lg-2">Texte *</label>
                        <div class="col-lg-10">
                            <textarea id="message" name="message" class="form-control" style="height: 250px"></textarea>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                                        <div class="col-md-12" id="mtext" style="display: none;">
                                          <div class="col-md-8">
                                            </div>
                                                <div class="col-md-4" style=" color: red; padding-left: 20px; padding-bottom: 10px; text-align: justify;" id="ptext">

                        </div>

                  </div>
                                        <div class="col-md-12">
                                          <div class="col-md-8">

                            <input type="checkbox" name="" style="margin-right: 5px; margin-bottom: 10px" name="mcheck" id="mcheck"><label for="prenom" class="control-label">Planifier l'envoie</label>
                                            </div>
                                                <div class="col-md-4">
                      <div class="form-group ">
                        <!-- <label for="prenom" class="control-label col-lg-2">Téléphone *</label> -->
                        <!-- <div class="col-lg-10"> -->
                          <input type="datetime-local" class="form-control" id="temp_envoi" name="temp_envoi" style="margin-left: 20px; width: 94%" disabled="disabled">
                        </div>

                        </div>

                  </div>

                                        <div class="col-md-12">
                      <div class="form-group ">
                        <label for="prenom" class="control-label col-md-8"></label>
                        <div class="col-md-4">
                                                        <div class="input-group">
                                                            <div class="input-group-addon" style="font-size: 14px; font-weight: bold; border-right: none; text-align: left;border-radius: 0">nombre des caractères :</div>
                                                            <input type="text" class="form-control" id="nbr_caractere" name="nbr_caractere" value="0" disabled="disabled" style="text-align: left; font-size: 14px; font-weight: bold; border-left: none">
                                                        </div>  

                        </div>
                      </div>
                  </div>
                                        <div class="col-md-12">
                      <div class="form-group ">
                        <label for="prenom" class="control-label col-md-8"></label>
                        <div class="col-md-4">
                                                        <div class="input-group">
                                                            <div class="input-group-addon" style="font-size: 14px; font-weight: bold; border-right: none; text-align: left;border-radius: 0">nombre des SMS :</div>
                                                            <input type="text" class="form-control" id="nbr_sms" name="nbr_sms" value="1" disabled="disabled" style="text-align: left; font-size: 14px; font-weight: bold; border-left: none">
                                                        </div>  

                        </div>
                      </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-12">
                    <div class="col-lg-offset-2 col-lg-10 pull-right">
                      <button class="btn btn-primary" type="submit" id="btn_transfert" style="display: none;"></button>
                      <button class="btn btn-primary" type="button" id="btn_envoyer">Envoyer</button>
                      <button class="btn btn-danger" type="button" id="btn_annuler">Annuler</button>
                    </div>
                  </div>
                  </div>

              </div>
            </div>

            </form>
            <!-- /form-panel -->
          </div>
          <!-- /col-lg-12 -->
        </div>
  </section>
          </div>
          <!-- /col-lg-12 -->
        </div>
  <!-- js placed at the end of the document so the pages load faster -->
  <script src="lib/jquery/jquery.min.js"></script>
  <script src="lib/bootstrap/js/bootstrap.min.js"></script>
  <script class="include" type="text/javascript" src="lib/jquery.dcjqaccordion.2.7.js"></script>
  <!-- <script src="lib/jquery.scrollTo.min.js"></script> -->
  <script src="vendor/jquery/jquery-ui.min.js"></script>
  <script src="js/jquery.nicescroll.js"></script>
  <!--common script for all pages-->
  <script src="js/scripts.js"></script>
  <!--script for this page-->
  <script src="lib/form-validation-script.js"></script>

</body>

</html>
<script type="text/javascript">

    var waitingDialog = waitingDialog || (function ($) {
    'use strict';

    // Creating modal dialog's DOM
    var $dialog = $(
        '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
        '<div class="modal-dialog modal-m">' +
        '<div class="modal-content">' +
            '<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
            '<div class="modal-body">' +
                '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
            '</div>' +
        '</div></div></div>');

    return {
        /**
         * Opens our dialog
         * @param message Custom message
         * @param options Custom options:
         *                options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
         *                options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
         */
        show: function (message, options) {
            // Assigning defaults
            if (typeof options === 'undefined') {
                options = {};
            }
            if (typeof message === 'undefined') {
                message = 'Loading';
            }
            var settings = $.extend({
                dialogSize: 'm',
                progressType: '',
                onHide: null // This callback runs after the dialog was hidden
            }, options);

            // Configuring dialog
            $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
            $dialog.find('.progress-bar').attr('class', 'progress-bar');
            if (settings.progressType) {
                $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
            }
            $dialog.find('h3').text(message);
            // Adding callbacks
            if (typeof settings.onHide === 'function') {
                $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
                    settings.onHide.call($dialog);
                });
            }
            // Opening dialog
            $dialog.modal();
        },
        /**
         * Closes dialog
         */
        hide: function () {
            $dialog.modal('hide');
        }
    };

    })(jQuery);
   function select_conversation(){
        $.ajax({
            url:'select_conversation.php',
            type:'post',
            dataType:'text', 

            success:function(ret){
                $('#ID_Conversation').val(ret);
            }
        });
    }

$(document).ready(function(){
    select_conversation();
})
        var classeur="";
        $('#btn_parcourir').click(function(){
            $('#feuille_calcul').val('');
            $('#feuille_calcul').prop("disabled",true);
            $('#btn_importer').prop("disabled",true);
            $('#btn_file').click();
        })

        $('#btn_file').change(function(){
            $('#txt_classeur').val($('#btn_file').val());
            $('#btn_transfert').click();
        })
        $('#feuille_calcul').change(function(){
            $('#btn_importer').focus();
        })
        $('#mcheck').click(function(){
            $('#temp_envoi').val('');
            if($(this).is(':checked')){
                $('#temp_envoi').prop('disabled', false);
                $('#temp_envoi').focus();
            }else{
                $('#temp_envoi').prop('disabled', true);
            }
        })
        $('#btn_envoyer').click(function(){
            if($('#expediteur').val()=='' || $('#message').val()==''){
                  alertify.alert('SMS',"Veuillez remplir tous les champs obligatoires svp!",function(){
                    $('#expediteur').focus();
                  })
            }else{
              $.ajax({
                      url:'SMS_MULTI.php',
                      type:'post',
                      beforeSend:function(){
                          waitingDialog.show('Veuillez patienter svp!');
                      },
                      dataType:'html', 
                      data:{message:$('#message').val(), conversation:$('#ID_Conversation').val(), expediteur:$('#expediteur').val()},
                      success:function(ret){
                           waitingDialog.hide();
                           // const str_retour = ret;
                           // const str_valeur_ret = str_retour.split(',');
                           if(ret==1){
                               alertify.alert('SMS', 'Messages envoyés avec succès');
                               alertify.success('Messages envoyés avec succès');
                               $('#btn_annuler').click();
                               $('#expediteur').focus();
                           }else{
                              alertify.alert('SMS', ret)
                           }

                      }
                  });
            }
        })
        $('#btn_importer').click(function(){
            if($('#feuille_calcul').val()==''){
                alertify.alert('SMS',"Veuillez sélectionner une feuille svp!",function(){
                  $('#feuille_calcul').focus();
                  })
            }else{
                  const str_classeur = $('#feuille_calcul').val();
                  const classeur = str_classeur.split(',');
                            $.ajax({
                              url:'select_feuille.php',
                              type:'post',
                              beforeSend:function(){
                                  waitingDialog.show('Veuillez patienter svp!');
                              },
                              dataType:'html', 
                              data:{classeur:classeur[0], conversation:$('#ID_Conversation').val(), feuille:classeur[1]},

                              success:function(ret){
                                  waitingDialog.hide();
                                  const str_feuille = ret;
                                  const valeur_ret = str_feuille.split(',');
                                  if(valeur_ret[0]==1){
                                      alertify.alert('SMS',"Vous avez ajouté "+valeur_ret[1]+" numéros. Le nombre des doublons est: "+valeur_ret[2],function(){
                                        $('#message').focus();
                                        $('#txt_classeur').val('');
                                        $('#btn_file').val('');
                                        $('#feuille_calcul').val('');
                                        })
                                      $('#iframe_numero').attr('src', "table_numero.php?conversation="+$('#ID_Conversation').val());
                                      $('#txt_classeur').val('');
                                      $('#btn_file').val('');
                                  }else if(ret==2){
                                      alertify.alert('SMS',"La feuille sélectionnée ne dispose d'aucune donnée!",function(){
                                        $('#feuille_calcul').focus();
                                      })
                                  }
                              }
                          });
            }
        })
        $('#btn_ajouter').click(function(){
            if($('#destinataire').val()==''){
                alertify.alert('SMS',"Veuillez saisir un numéro svp!",function(){
                  $('#destinataire').focus();
                  })
            }else{
                  $.ajax({
                    url:'enreg_numero.php',
                    type:'post',
                    beforeSend:function(){
                        waitingDialog.show('Veuillez patienter svp!');
                    },
                    dataType:'html', 
                    data:{numero:$('#destinataire').val(), conversation:$('#ID_Conversation').val()},

                    success:function(ret){
                        waitingDialog.hide();
                        const str = ret;
                        const valeur = str.split(',');
                        if(valeur[0]==1){
                            alertify.alert('SMS',"Vous avez ajouté "+valeur[1]+" numéros. Le nombre des doublons est: "+valeur[2],function(){
                              $('#message').focus();
                              })
                            $('#iframe_numero').attr('src', "table_numero.php?conversation="+$('#ID_Conversation').val());
                            $('#destinataire').val('');
                        }
                    }
                });
            }
        })

        $('#SMSForm').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
                    $.ajax({
                        url:'select_classeur.php',
                        type:'post',
                        beforeSend:function(){
                            waitingDialog.show('Veuillez patienter svp!');
                        },
                        dataType:'html', 
                        data: formData,
                        processData: false,
                        cache: false,
                        contentType: false,

                        success:function(ret){
                            // alertify.alert(ret);
                            waitingDialog.hide();
                            const str = ret;
                            const valeur = str.split(',');
                            if(valeur[0]==1){
                                alertify.alert('SMS',"Vous avez ajouté "+valeur[1]+" numéros. Le nombre des doublons est: "+valeur[2],function(){
                                  $('#message').focus();
                                  })
                                $('#iframe_numero').attr('src', "table_numero.php?conversation="+$('#ID_Conversation').val());
                                $('#txt_classeur').val('');
                                $('#btn_file').val('');
                            }else if(ret==2){
                                alertify.alert('SMS',"Le fichier sélectionné ne dispose d'aucune donnée!",function(){
                                    $('#btn_parcourir').focus();
                                })
                            }else if(ret==3){
                                alertify.alert('SMS',"L'extension du fichier sélectionné ne correspond pas à un fichier Excel/CSV!",function(){
                                    $('#btn_parcourir').focus();
                                })
                            }else if(ret==4){
                                alertify.alert('SMS',"Veuillez sélectionner un fichier Excel/CSV svp!",function(){
                                    $('#btn_parcourir').focus();
                                })
                            }else{
                                $('#add_feuille').nextAll().remove();
                                $('#add_feuille').after(ret);
                                $('#feuille_calcul').prop("disabled",false);
                                $('#btn_importer').prop("disabled",false);
                                $('#feuille_calcul').focus();
                            }

                        }
                    });


            // formData.append('content', CKEDITOR.instances['descript'].getData());
          })

    var encodage="";
    var nbrSMS=0;
    $('#message').keyup(function(){
        $.ajax({
          url:'count_caratere.php',
          type:'post',
          dataType:'html', 
          data:{message:$('#message').val()},

          success:function(ret){
              $('#nbr_caractere').val(ret);
          }
      });
        $.ajax({
          url:'check_encodage.php',
          type:'post',
          dataType:'html', 
          data:{message:$('#message').val()},

          success:function(ret){
            encodage=ret;
            if(ret=='UTF-8'){
                $('#ptext').text('Caractères Unicode déctectés, vous allez passer de 160 caractères à 70 par SMS.');
                $('#mtext').slideDown('slow');
            }else if(ret!='UTF-8' && nbrSMS!=0){
                $('#mtext').slideUp('slow');
            }
          }
      });
        $.ajax({
          url:'count_sms.php',
          type:'post',
          dataType:'text', 
          data:{message:$('#message').val()},

          success:function(ret){
            nbrSMS=ret;
            if(ret==0){
                $('#ptext').text('Vous avez dépassé le nombre maximun des caractères (1224 pour le texte simple et 560 pour Unicode) qui vaut 8 SMS.');
                $('#mtext').slideDown('slow');
                $('#nbr_sms').val('max');
            }else if(ret!=0 && encodage!='UTF-8'){
                $('#mtext').slideUp('slow');
                $('#nbr_sms').val(ret);
            }else if(ret!=0 && encodage=='UTF-8'){
                // $('#mtext').slideUp('slow');
                $('#nbr_sms').val(ret);
            }
          }
      });
    })
    $('#message').change(function(){
        $.ajax({
          url:'count_caratere.php',
          type:'post',
          dataType:'html', 
          data:{message:$('#message').val()},

          success:function(ret){
              $('#nbr_caractere').val(ret);
          }
      });
        $.ajax({
          url:'check_encodage.php',
          type:'post',
          dataType:'html', 
          data:{message:$('#message').val()},

          success:function(ret){
            encodage=ret;
            if(ret=='UTF-8'){
                $('#ptext').text('Caractères Unicode déctectés, vous allez passer de 160 caractères à 70 par SMS.');
                $('#mtext').slideDown('slow');
            }else if(ret!='UTF-8' && nbrSMS!=0){
                $('#mtext').slideUp('slow');
            }
          }
      });
        $.ajax({
          url:'count_sms.php',
          type:'post',
          dataType:'text', 
          data:{message:$('#message').val()},

          success:function(ret){
            nbrSMS=ret;
            if(ret==0){
                $('#ptext').text('Vous avez dépassé le nombre maximun des caractères (1224 pour le texte simple et 560 pour Unicode) qui vaut 8 SMS.');
                $('#mtext').slideDown('slow');
                $('#nbr_sms').val('max');
            }else if(ret!=0 && encodage!='UTF-8'){
                $('#mtext').slideUp('slow');
                $('#nbr_sms').val(ret);
            }else if(ret!=0 && encodage=='UTF-8'){
                // $('#mtext').slideUp('slow');
                $('#nbr_sms').val(ret);
            }
          }
      });
    })   
    $('#btn_annuler').click(function(){
        $('#expediteur').val('<?php echo(stripslashes($_SESSION['user_courrier']['Emetteur'])); ?>');
        select_conversation();
        $('#destinataire').val('');
        $('#message').val('');
        $('#nbr_caractere').val(0);
        $('#iframe_numero').attr('src', "table_numero.php?conversation=''");
        $('#nbr_sms').val(1);
        $('#mtext').slideUp('slow');
        $('#ID_Conversation').val('');
        $('#expediteur').focus();
    })
</script>