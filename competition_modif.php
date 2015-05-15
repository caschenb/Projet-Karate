<HTML>

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
	<form method = "GET" action="competition_modif_res.php">
	<p> Remplissez les champs que vous souhaitez modifier </p>
				<p><label for="nom">Nom :</label><br />
				<?php 
				echo"
				<input type = 'text' name = 'nom' value=$result[nom]  id='nom'></p>
				<p><label for='date'>Date :</label><br />
				<input type = 'text' name = 'date' value=$result[date] id='date'></p>
				<p><label for='lieu'>Lieu :</label><br />
				<input type = 'text' name = 'lieu' value=$result[lieu] id='lieu'></p>
				<p><label for='site'>Site Web :</label><br />
				<input type = 'text' name = 'site' value=$result[siteweb] id='site'></p>
				<p><label for='mail'>Mail :</label><br />
				<input type = 'text' name = 'mail' value=$result[mail] ></p>
				<p><label for='materiau'>Nom Du Materiau :</label><br />
				<input type = 'text' name = 'materiau' value=$result[nommateriau] ></p>
				<p><label for='type'>Nom de la Competition</label><br />
				<input type='text' name='type' value=$result[type] id='type'> </p> 
				<input type='hidden' name='anciennom' value=$nom> "; ?>
				<input type = "submit">
				</form>




<?php
pg_close($idConnexion); //on ferme la connexion à notre base de donnée
?>

<a href= "accueil.php"> Retour à l'accueil</a> 
</form>
</BODY>
</HTML>
