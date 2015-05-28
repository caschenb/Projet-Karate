<HTML>

<?php
mb_internal_encoding("UTF-8");
//include("connect.php");
include("competition.php");
include("ajout.php");
$idConnexion=fconnect();
$nom = $_POST['nom']; 
$date = $_POST['date'];
$lieu = $_POST['lieu'];
$site = $_POST['site'];  
$mail = $_POST['mail'];
$materiau = $_POST['materiau'];
$type = $_POST['type'];


	if(fajout($idConnexion,$nom,$date,$lieu,$site, $mail, $materiau, $type)) echo "Ajout réussi !";
	else echo "Echec de l'ajout";



pg_close($idConnexion); //on ferme la connexion à notre base de donnée
?>

<a href= "accueil.html"> Retour à l'accueil</a> 
</form>
</BODY>
</HTML>
