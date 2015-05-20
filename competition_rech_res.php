<HTML>
<head>
    <title>Consultation compétition </title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <script type="text/javascript">
      function catsel(sel) {
        //if (sel.value=="-1" ) return;
        var opt=sel.getElementsByTagName("option" );
        for (var i=0; i<opt.length; i++) {
          var x=document.getElementById(opt[i].value);
          if (x) x.style.display="none";
        }
        var cat = document.getElementById(sel.value);
        if (cat) cat.style.display="block";
      }
    </script>

</head>
<?php
mb_internal_encoding("UTF-8");
include("connect.php");
include ("ajout.php");
$idConnexion=fconnect();

$nom = $_GET['type']; 
$nom = "Thecompet"; //à enlever lorsque competition finie

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
				WHERE  M.nomcompetition='$nom' AND M.datecompetition=$result[date] AND "; //manque lien pratiquant à competition ou à match.


?>
-->
<br>

<?php
	echo "<br>";
	$nom = $_GET['type'];
	$nom = "Competition1"; //à enlever aussi
	$req_date= "SELECT C.Date AS date
				FROM Projet_Karate.Competition C
				WHERE C.Nom= '$nom';"; //On récupère la date du match
	$query=pg_query($idConnexion,$req_date);
	$res=pg_fetch_array($query);
	$date= strtotime("$res[date]");
	$date_today = strtotime(date('Y-m-d H:i:s')); //On récupère la date d'aujourd'hui et on la convertie en nombre pour faciliter la comparaison
	if($date<$date_today){ //On compare les 2 dates et on affiche les classements seulement si la date est passée.
		echo "<h2>Liste des matchs</h2>";

echo"<table border='1'>";
		echo"<tr>";
		echo"<td width='100pt'><b>Numéro</b></td>";
		echo"<td width='100pt'><b>Score1</b></td>";
		echo"<td width='100pt'><b>Score2</b></td>";
		echo"<td width='100pt'><b>Type</b></td>";
		echo"<td width='100pt'><b>Kata</b></td>";
		echo"</tr>";

	$querystring = "SELECT M.numeromatch AS num, M.score1 AS s1,M.score2 AS s2,M.type AS type,M.kata AS kata
					FROM projet_karate.match M 
					WHERE  M.nomcompetition='$nom';"; 
	$query = pg_query($idConnexion, $querystring);
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

echo"</table>";


		echo "<h2>Classement</h2>";

	}
	else{
?>
		<table>
      <tr>
        <td>
        Choisissez :
        </td>
        <td>
          <select name="choice" onchange="catsel(this)">
          <!--<option value="-1">None</option>!-->
            <option value="1">Inscription</option>
            <option value="2">Description</option>
          </select>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <div id="1" style="display:block">
				<form method = "GET" action="competition_insert_res.php">
				<p><label for="club">Choisissez le club </label><br />
				<select name="club" onchange="catsel(this)" id="club" required>

				<?php
					$querystring = "SELECT C.nom AS nom, C.adresse AS adresse
					FROM projet_karate.club C
					ORDER BY C.nom;"; 
					$query = pg_query($idConnexion, $querystring);
					while($result = pg_fetch_array($query))
					{
						echo"<option value='$result[adresse]'>$result[nom] $result[adresse]</option>";
					}

							?>				   
				</select>
				</p>
				<?php
				echo "<div id=$result[adresse] style='display:block'>";
				echo"<p><label for='membre'>Choisissez le karateka </label><br />";
				echo"<select name='membre' id='membre' required>";

				
					$querystring = "SELECT K.identifiant AS identifiant, K.nom AS nom, K.prenom AS prenom
					FROM projet_karate.pratiquant K
					WHERE K.adresseclub='$result[adresse]'
					ORDER BY K.nom, K.prenom;"; 
					$query = pg_query($idConnexion, $querystring);
					$i=0;
					while($result = pg_fetch_array($query))
					{
						echo"<option value='club$i'>$result[nom] $result[adresse]</option>";
						$i=$i+1;
					}

							?>				   
				</select>
				</p>
				<input type = "submit">
				</form>
			
          </div>
	
<?php
}
?>
<a href= "match.php"> Mettre à jour les matchs </a> <br>



<?php
pg_close($idConnexion); //on ferme la connexion à notre base de donnée
?>

<a href= "accueil.php"> Retour à l'accueil</a> 
</form>
</BODY>
</HTML>
