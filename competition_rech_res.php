<HTML>
<head>
    <title>Consultation compétition </title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
</head>
<?php
mb_internal_encoding("UTF-8");
include("connect.php");
include ("ajout.php");
$idConnexion=fconnect();

$nom = $_GET['type']; 

$querystring = "SELECT * FROM projet_karate.competition WHERE  projet_karate.competition.nom='$nom'";
		$query = pg_query($idConnexion, $querystring);
		$result=pg_fetch_array($query);
?>
	<h1>Information sur la compétition
	<?php
		echo" $result[nom] </h1> 

	<br>

		Date : $result[date] <br>
		Lieu : $result[lieu]<br>
		Site web : $result[siteweb]<br>
		Mail : $result[mail]<br>
		Matériau : $result[nommateriau]<br>
		Type : $result[type] <br><br>";
	?>
<a href= "competition_inscr.php"> S'inscrire à cette compétition </a> <br>

<h2>Liste des participants</h2>
<!--Requete pour avoir la liste des participants
<?php
$querystring = "SELECT P.nom, P.prenom 
				FROM projet_karate.pratiquant P,projet_karate.competition C, projet_karate.match M 
				WHERE  M.nomcompetition='$nom' AND M.datecompetition=$result[date] AND "; //manque lien pratiquant à competition ou à match


?>
-->
<br>

<h2>Liste des matchs</h2>

<table border="1">
		<tr>
		<td width="100pt"><b>Numéro</b></td>
		<td width="100pt"><b>Score1</b></td>
		<td width="100pt"><b>Score2</b></td>
		<td width="100pt"><b>Type</b></td>
		<td width="100pt"><b>Kata</b></td>
		</tr>
<?php
	$date=
	$querystring = "SELECT M.numeromatch AS num, M.score1 AS s1,M.score2 AS s2,M.type AS type,M.kata AS kata
					FROM projet_karate.match M 
					WHERE  M.nomcompetition='$nom';"; 
	$query = pg_query($idConnexion, $querystring);
	$result=pg_fetch_array($query);
	$i=0;
	while($result = pg_fetch_array($query))
		{
			echo "<tr>";
			echo "<td> $Result[num] </td>";
			echo "<td> $Result[s1] </td>";
			echo "<td> $Result[s2] </td>";
			echo "<td> $Result[type] </td>";
			echo "<td> $Result[kata] </td>";
			echo "</tr>";
		}
?> 
</table>
<a href= "match.php"> Mettre à jour les matchs </a> <br>

<h2>Classement</h2>



<?php
pg_close($idConnexion); //on ferme la connexion à notre base de donnée
?>

<a href= "accueil.php"> Retour à l'accueil</a> 
</form>
</BODY>
</HTML>

