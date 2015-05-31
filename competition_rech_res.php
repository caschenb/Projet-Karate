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
<body>
	<?php
		mb_internal_encoding("UTF-8");
		include("connect.php");
		date_default_timezone_set('Europe/Paris');
		$idConnexion=fconnect();
		$nom = $_POST["compet_rech"];  
		$querystring = "SELECT DISTINCT C.nom AS nom
						FROM projet_karate.competition C
						ORDER BY C.nom;"; 
		$query = pg_query($idConnexion, $querystring);
		$i=0;
		while($res=pg_fetch_array($query)){
			if(!strcmp($res['nom'],$nom)){
			 $date = $_POST["date$i"];
			}
			$i=$i+1;
		}
		echo("coucou voici la compétition $nom du $date");
		$req_materiau= "SELECT C.nommateriau AS materiau
					FROM Projet_Karate.Competition C
					WHERE C.Nom= '$nom';"; //On récupère le materiau du match
		$query=pg_query($idConnexion,$req_materiau);
		$res=pg_fetch_array($query);
		$materiau= $res['materiau'];

		$querystring = "SELECT * FROM projet_karate.competition WHERE  projet_karate.competition.nom='$nom' AND projet_karate.competition.date='$date'";
		$query = pg_query($idConnexion, $querystring);
		$result=pg_fetch_array($query);
	?>
	<h1>Information sur la compétition : 
	<?php
		echo" $result[nom] </h1> 

		Date : $result[date] <br>
		Lieu : $result[lieu]<br>
		Site web : $result[siteweb]<br>
		Mail : $result[mail]<br>
		Type : $result[type] <br>";
		if($materiau!=NULL){
		echo"Matériau : $result[nommateriau]<br><br>";}
	?>

	<h2>Liste des participants</h2>
	<table border="1">
		<tr>
			<td width="100pt"><b>Identifiant</b></td>
			<td width="100pt"><b>Nom</b></td>
			<td width="100pt"><b>Prénom</b></td>
			<td width="100pt"><b>Poids</b></td>
			<td width="100pt"><b>Club</b></td>
		</tr>
	
	<?php
	//Requete pour avoir la liste des participants
	$querystring = "SELECT Pra.identifiant AS id,Pra.nom AS nom, Pra.prenom AS prenom, Pra.poids AS poids, Pra.nomclub AS nomclub
					FROM projet_karate.participant P, projet_karate.pratiquant Pra
					WHERE  P.nomcompet='$nom' AND P.date='$date' AND P.idpratiquant=Pra.identifiant;"; 
	$vQuery = pg_query($idConnexion,$querystring);
  while ($vResult = pg_fetch_array($vQuery)){
	echo "<tr>";
	echo "<td> $vResult[id] </td>";
	echo "<td> $vResult[nom] </td>";
	echo "<td> $vResult[prenom] </td>";
	echo "<td> $vResult[poids] </td>";
	echo "<td> $vResult[nomclub] </td>";
	echo "</tr>";
}
?> 
</table>
	
	<br>

	<?php
		echo "<br>";
		$nom = $_POST['compet_rech'];
		$querystring = "SELECT DISTINCT C.nom AS nom
						FROM projet_karate.competition C
						ORDER BY C.nom;"; 
		$query = pg_query($idConnexion, $querystring);
		$i=0;
		while($res=pg_fetch_array($query)){
			if(!strcmp($res['nom'],$nom)){
			 $date1 = $_POST["date$i"];
			}
			$i=$i+1;
		}
		$date= strtotime("$date1");
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
				echo"<td width='100pt'><b>Participant 1</b></td>";
				echo"<td width='100pt'><b>Participant 2</b></td>";
			echo"</tr>";

		$querystring = "SELECT M.numeromatch AS num, M.score1 AS s1,M.score2 AS s2,M.type AS type,M.kata AS kata, M.participant1 AS id1, M.participant2 AS id2,P1.nom AS nom1, P2.nom AS nom2, P1.prenom AS prenom1,P2.prenom AS prenom2
						FROM projet_karate.match M, projet_karate.pratiquant P1, projet_karate.pratiquant P2
						WHERE  M.nomcompetition='$nom' AND M.datecompetition='$date1' AND M.participant1=P1.identifiant AND M.participant2=P2.identifiant
						ORDER BY M.numeromatch;"; 
		$query = pg_query($idConnexion, $querystring);
		$i=0;
		while($result = pg_fetch_array($query))
			{
				echo "<tr>";
					echo "<td> $result[num] </td>";
					echo "<td> $result[s1] </td>";
					echo "<td> $result[s2] </td>";
					echo "<td> $result[type] </td>";
					echo "<td> $result[kata] </td>";
					echo "<td> $result[prenom1] $result[nom1] ($result[id1])</td>";
					echo "<td> $result[prenom2] $result[nom2] ($result[id2])</td>";
				echo "</tr>";
			}

		echo"</table>

		<a href= 'match.php'> Mettre à jour les matchs </a> <br>";

		echo "<h2>Classement</h2>";
		}

		else{
	?>
	<br>
	<h2>Gestion des Inscriptions</h2>
	<table>
      <tr>
        <td>
        	Choisissez :
        </td>
        <td>
          <select name="choice" onchange="catsel(this)">
            <option value="1">Inscription</option>
            <option value="2">Desinscription</option>
          </select>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <div id="1" style="display:display">
				<form method = "POST" action="competition_insert_res.php">
					<p>
						<label for="club">Choisissez le club </label><br />
						<select name="ins" onchange="catsel(this)" id="club">

							<?php
								$z=3;
								$querystring = "SELECT C.nom AS nom, C.adresse AS adresse
												FROM projet_karate.club C
												ORDER BY C.nom;"; 
								$query = pg_query($idConnexion, $querystring);
								echo"<option value='0'> -----Choisissez un club--------</option>";
								while($result = pg_fetch_array($query))
								{
									echo"<option value='$z'>$result[nom] $result[adresse]</option>";
									$z=$z+1;
								}

										?>				   
						</select>
					</p>
					<?php
						$querystring = "SELECT C.nom AS nom, C.adresse AS adresse
										FROM projet_karate.club C
										ORDER BY C.nom;"; 
						$query = pg_query($idConnexion, $querystring);
						$j=0;
						$z=3;
						while($result = pg_fetch_array($query)){

							echo "<div id='$z' style='display:none'>";
							echo"<p><label for='membre'>Choisissez le karateka </label><br />";
							echo"<select name='membre' id='membre'>";
							$j=$j+1;
							$z=$z+1;

				
							$pratiquant = "SELECT K.identifiant AS identifiant, K.nom AS nom, K.prenom AS prenom
											FROM projet_karate.pratiquant K
											WHERE K.adresseclub='$result[adresse]' AND K.nomclub='$result[nom]' AND K.identifiant NOT IN
												(
												   SELECT K.identifiant
												   FROM projet_karate.participant P, projet_karate.pratiquant K
												   WHERE  P.nomcompet='$nom' AND P.date='$date1' AND P.idpratiquant=K.identifiant AND K.adresseclub='$result[adresse]' AND K.nomclub='$result[nom]'
													)
											ORDER BY K.nom, K.prenom;"; 
							$requete = pg_query($idConnexion, $pratiquant);
							while($res = pg_fetch_array($requete))
							{
								echo"<option value='$res[identifiant]'>$res[identifiant] $res[nom] $res[prenom]</option>";
							}
							echo"</select>";
							echo"</p>";
							echo"</div>";

						}
						echo("<INPUT TYPE='hidden' NAME='nomC' VALUE='$nom'>");
								echo("<INPUT TYPE='hidden' NAME='dateC' VALUE='$date1'>");	
					?>			
					<input type = "submit" value="envoyer">	   
				</form>
			</div>

			<div id="2" style="display:none">
				<form method = "POST" action="competition_insert_res.php">
					<p>
						<label for="club">Choisissez le club </label><br />
						<select name="desc" onchange="catsel(this)" id="club">

							<?php
								$querystring = "SELECT C.nom AS nom, C.adresse AS adresse
												FROM projet_karate.club C
												ORDER BY C.nom;"; 
								$query = pg_query($idConnexion, $querystring);
								echo"<option value='0'> -----Choisissez un club--------</option>";
								while($result = pg_fetch_array($query))
								{
									echo"<option value='$result[adresse]'>$result[nom] $result[adresse]</option>";
								}

										?>				   
						</select>
					</p>
					<?php
						$querystring = "SELECT C.nom AS nom, C.adresse AS adresse
										FROM projet_karate.club C
										ORDER BY C.nom;"; 
						$query = pg_query($idConnexion, $querystring);
						$j=0;
						while($result = pg_fetch_array($query)){

							echo "<div id='$result[adresse]' style='display:none'>";
							echo"<p><label for='membre'>Choisissez le karateka </label><br />";
							echo"<select name='membre' id='membre'>";
							$j=$j+1;

				
							$pratiquant = "SELECT Pra.identifiant AS id,Pra.nom AS nom, Pra.prenom AS prenom
										   FROM projet_karate.participant P, projet_karate.pratiquant Pra
										   WHERE  P.nomcompet='$nom' AND P.date='$date1' AND P.idpratiquant=Pra.identifiant AND Pra.adresseclub='$result[adresse]' AND Pra.nomclub='$result[nom]'
										   ORDER BY Pra.nom, Pra.prenom;"; 
							$requete = pg_query($idConnexion, $pratiquant);
							while($res = pg_fetch_array($requete))
							{
								echo"<option value='$res[id]'>$res[id] $res[nom] $res[prenom]</option>";
							}
							echo"</select>";
							echo"</p>";
							echo"</div>";

						}	
						echo("<INPUT TYPE='hidden' NAME='nomC' VALUE='$nom'>");
								echo("<INPUT TYPE='hidden' NAME='dateC' VALUE='$date1'>");
					?>		
					<input type = "submit">		   
				</form>
			</div>
					
				
		
		</td>
		</tr>		
        </table>

	
<?php
}
?>



<?php
pg_close($idConnexion); //on ferme la connexion à notre base de donnée
?>

<a href= "competition.php"> Retour à l'accueil</a> 
</BODY>
</HTML>
