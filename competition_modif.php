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
	
	<form method = "GET" action="competition_modif_res.php">
	<p> Remplissez les champs que vous souhaitez modifier </p>
				<p><label for="nom">Nom :</label><br />
				<?php 
				echo"
				<input type='hidden' name='anciennom'  value=$nom > 
				<input type = 'text' name = 'nom' value=$result[nom]  ></p>
				<p>Date :<br />
				<input type = 'text' name = 'date' value=$result[date]></p>
				<p>Lieu :<br />
				<input type = 'text' name = 'lieu' value=$result[lieu] ></p>
				<p>Site Web :<br />
				<input type = 'text' name = 'site' value=$result[siteweb] ></p>
				<p>Mail :<br />
				<input type = 'text' name = 'mail' value=$result[mail] ></p>
				<p> Ancien type de Competition: $result[type] </p> 
				<p>Nom de la Competition<br />";
				?>
				<select name="type" onchange="catsel(this)">
					<option value="CompetitionKata">Kata</option>
				    <option value="CompetitionKumite">Kumite</option>
				    <option value="CompetitionTameshiWari">Tameshi Wari</option>
				    <option value="CompetitionMixte">Mixte</option>
				</select> <br/>
				<div id="CompetitionTameshiWari" style="display:none">
					<p>Nom Du Materiau :<br />
					<input type = 'text' name = 'materiau' <?php echo" value=$result[nommateriau] "; ?>></p>
				</div>
				<div id="CompetitionMixte" style="display:none">
					<p>Nom Du Materiau :<br />
					<input type = 'text' name = 'materiau' <?php echo" value=$result[nommateriau] "; ?>></p>
				</div>
				<div id="CompetitionKata" style="display:none">      <!-- si le type de competition choisie est kata ou kumite le type de materiau est mis a NUL !-->
					<input type='hidden' name='materiau'  value='' > 	
				</div>
				<div id="CompetitionKumite" style="display:none">
					<input type='hidden' name='materiau'  value='' > 	
				</div>
				<input type = "submit">
				</form>
		

<?php
pg_close($idConnexion); //on ferme la connexion à notre base de donnée
?>

<a href= "accueil.php"> Retour à l'accueil</a> 
</form>
</BODY>
</HTML>
