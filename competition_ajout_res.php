<HTML>

<?php
mb_internal_encoding("UTF-8");
//include("connect.php");
include("competition.php");
include("ajout.php");
$idConnexion=fconnect();
$nom = $_GET['nom']; 
$date = $_GET['date'];
$lieu = $_GET['lieu'];
$site = $_GET['site'];  
$mail = $_GET['mail'];
$materiau = $_GET['materiau'];
$type = $_GET['type'];


	if(fajout($idConnexion,$nom,$date,$lieu,$site, $mail, $materiau, $type)) echo "Ajout réussi !";
	else echo "Echec de l'ajout";



pg_close($idConnexion); //on ferme la connexion à notre base de donnée
?>

<a href= "accueil.php"> Retour à l'accueil</a> 
</form>
</BODY>
</HTML>
