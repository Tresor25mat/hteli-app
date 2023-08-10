<?php
    session_start();
    require_once('connexion.php');
    $rs=$pdo->query("SELECT * FROM utilisateur WHERE `ID_Utilisateur`=".$_SESSION['user_slj_wings']['ID_Utilisateur']);
    $res=$rs->fetch();
?>
<footer class="row navbar-default container" ng-controller="EventsCtrl">
	<center>
	<p class="text-muted">Copyright &copy; <?php echo date('Y'); ?> <?php if($res['Entreprise']==''){ echo('SJL AERONAUTICA CONGO');}else{ echo(stripslashes($res['Entreprise']));} ?>. Tous droits reservés. | Design By <a href="https://www.facebook.com/tresor.mvuete" target="_blank" analytics-on analytics-category="Links" title="Tresor Mat Mvuete">M@T</a></p></center>
<!-- 	<p class="pull-right hidden-xs">
		<a href="http://yet-another-rest-client.com/" target="_blank" analytics-on analytics-category="Links">Home</a> |
		<a href="{{config.CHROME_STORE_REVIEWS}}" target="_blank" analytics-on analytics-category="Links">Feedback</a> |
		<a href="{{config.CHROME_STORE_SUPPORT}}" target="_blank" analytics-on analytics-category="Links">Issues</a> |
		<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=paulhitz%40gmail%2ecom&lc=IE&item_name=Yet%20Another%20REST%20Client&currency_code=USD&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted" target="_blank" analytics-on analytics-category="Links">Donate</a> |
		<a href="http://opensource.org/licenses/MIT" target="_blank" analytics-on analytics-category="Links">License</a> |
		<a href="#top" target="_self">Back To Top</a>
	</p> -->
</footer>
