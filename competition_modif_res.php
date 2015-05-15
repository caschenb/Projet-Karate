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
$anciennom=$_GET['anciennom'];
echo"$anciennom";
	if(fmodif($idConnexion,$nom,$date,$lieu,$site, $mail, $materiau, $type, $anciennom)) echo "Modification réussie !";
	else echo "Echec de la modification";



pg_close($idConnexion); //on ferme la connexion à notre base de donnée
?>

<a href= "accueil.php"> Retour à l'accueil</a> 
</form>
</BODY>
</HTML>
