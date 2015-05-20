<html>

<?php
mb_internal_encoding("UTF-8");
include("connect.php");
include ("ajout.php");
$idConnexion=fconnect();

$nom = $_GET['compet_supp']; 


$querystring = "DELETE FROM projet_karate.competition WHERE  projet_karate.competition.nom='$nom'";
		$query = pg_query($idConnexion, $querystring);
		$result=pg_fetch_array($query);
		if (!is_null($result)) echo "suppression réussie de la competition $nom";
		
		
		
		pg_close($idConnexion);
?>


</html>
