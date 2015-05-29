<HTML>
<?php
$idr = isset($_POST['compet_rech'])?$_POST['compet_rech']:null;
?>
  <head>
    <title>Competition</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	
	<?php
	mb_internal_encoding("UTF-8");
	include("connect.php");
	$idConnexion=fconnect();
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
  </head>
  <body>

    <table>
      <tr>
        <td>
        Faites un choix :
        </td>
        <td>
          <select name="choice" onchange="catsel(this)">
            <!--1">None</option>!-->
            <option value="4">Rechercher</option>
            <option value="2">Modifier</option>
            <option value="3">Supprimer</option>
            <option value="1">Créer</option>
          </select>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <div id="1" style="display:none">
            <table border="0" cellspacing="3" cellpadding="0">
				<tr><td>formulaire création</td></tr>
			</table>
				<form method = "POST" action="competition_ajout_res.php">
				<p><label for="nom">Nom :</label><br />
				<input type = "text" name = "nom" id="nom" required></p>
				<p><label for="date">Date :</label><br />
				<input type = "date" name = "date" id="date" required></p>
				<!--autre type possible : datetime ou time mais voir pk datetime ne marche pas!-->
				<p><label for="lieu">Lieu :</label><br />
				<input type = "text" name = "lieu" id="lieu"></p>
				<p><label for="site">Site Web :</label><br />
				<input type = "text" name = "site" id="site" required></p> <!--s'il est nul il n'est plus unique.... dommage pour la contrainte-->
				<p><label for="mail">Mail :</label><br />
				<input type = "text" name = "mail" id="mail"></p>
				<!--<p><label for="materiau">Nom Du Materiau :</label><br />
				<input type = "text" name = "materiau" id="materiau"></p> !-->
				<p>
				<label for="type">De quel type de Compétition s'agit-il ?</label><br />
				<select name="type" onchange="catsel(this)" id="type" required>
					<option value="CompetitionKata">Kata</option>
				   <option value="CompetitionKumite">Kumite</option>
				   <option value="CompetitionTameshiWari">Tameshi Wari</option>
				   <option value="CompetitionMixte">Mixte</option>
				</select>
				</p>
				<div id="CompetitionTameshiWari" style="display:none">
					<p>Nom Du Materiau :<br />
					<input type = 'text' name = 'materiau'></p>
				</div>
				<div id="CompetitionMixte" style="display:none">
					<p>Nom Du Materiau :<br />
					<input type = 'text' name = 'materiau' ></p>
				</div>
				<input type = "submit">
				</form>
			
          </div>
          <div id="2" style="display:none">
            <table border="0" cellspacing="3" cellpadding="0"><tr><td>formulaire modification</td></tr></table>
				<form method = "POST" action="competition_modif.php">
				<?php
				echo '<p> <label for="type">Veuillez choisir la competition que vous voulez modifier : </label><br />
				<select name="type" id="type"></p>';
				$querystring = "SELECT nom, date
								FROM projet_karate.competition";
				//créer la requête qui permet de récupérer les compétitions déjà créées
				$query = pg_query($idConnexion, $querystring);
				$i=0;
				while($result = pg_fetch_array($query))
				{
					$i++;
					//$nb = $result['nom']; // ici on stocke la projection sur nom du résultat de la ième ligne 
					echo"<option value='$result[nom]'>$result[nom] - $result[date]</option>";
				}				
				
				echo'</select>
				</p>'
				?>
				<input type = "submit">
				</form>
		  </div>
          <div id="3" style="display:none">
            <table border="0" cellspacing="3" cellpadding="0"><tr><td>formulaire suppression</td></tr></table>
			<form method = "POST" action="competition_supp_res.php">
				<?php
				echo '<p> <label for="type">Veuillez choisir la competition que vous voulez supprimer : </label><br />
				<select name="compet_supp" id="type"></p>';
				$querystring = "SELECT nom, date 
								FROM projet_karate.competition";
				//créer la requête qui permet de récupérer les compétitions déjà créées
				$query = pg_query($idConnexion, $querystring);
				$i=0;
				while($result = pg_fetch_array($query))
				{
					$i++;
					//$nb = $result['nom']; // ici on stocke la projection sur nom du résultat de la ième ligne 
					echo"<option value='$result[nom]'>$result[nom] - $result[date]</option>";
				}				
				echo'</select>
				</p>'
				?>   
				<input type = "submit">
			</form>				
		  </div>
          <div id="4" style="display:block">
            <table border="0" cellspacing="3" cellpadding="0"><tr><td>formulaire rechercher</td></tr></table>
			<!-- action du formulaire permet en gros de rafraichir la page, envoi les données sur la même page qui va recharger. Du coup j'ai 
				été obligée de mettre la recherche dans le premier champ de la liste déroulante sinon ça rechargeait la page et par défaut
				ça affichait le formulaire de création !-->
				<form action="<?php echo($_SERVER['PHP_SELF']); ?>" method = "POST" id="cle_compet">
				
				<!-- On crée la liste déroulante, avec onchange, dès qu'on détecte un changement on envoie le résultat de notre formulaire !-->
				<select name="compet_rech" id="compet_rech" onchange="document.forms['cle_compet'].submit();">;
				
				<!-- option qui s'affiche par défauut !-->
				<option value="-1">- - - Choisissez une competition - - -</option>
				<?php
				echo '<p> <label for="nomCompet">Veuillez choisir la competition que vous souhaitez consulter : </label><br /></p>';
				$querystring = "SELECT nom, date 
								FROM projet_karate.competition";
				//créer la requête qui permet de récupérer les compétitions déjà créées. On a plus besoin de la date maintenant mais je l'ai laissée au cas où on voudrait repartir en arrière 
				//avec ce qu'on a déjà fait avant
				
				//on soumet la requête à la BDD
				$query = pg_query($idConnexion, $querystring);
				
				//on affiche les noms des competitions que nous a retournés la requête à la BDD
				$i=0;
				while($result = pg_fetch_array($query))
				{
					$i++;
					//$nb = $result['nom']; // ici on stocke la projection sur nom du résultat de la ième ligne 
					//echo"<option value=$result[nom]>$result[nom] - $result[date]</option>";
					?>
					<option value="<?php echo($result['nom']); ?>"<?php echo((isset($idr) && $idr == $result['nom'])?" selected=\"selected\"":null); ?>><?php echo($result['nom']); ?></option> 
					<?php
				}				
				echo'</select></p>';
				
				/* On commence par vérifier si on a envoyé un numéro de competition en sélectionnant un des noms de la liste déroulante (stocké dans $idr) et le cas échéant s'il est différent de -1 (valeur par défaut) */
				if(isset($idr) && $idr != -1) 
				{ 
				?>
				
				<!-- On ferme le 1er formulaire !-->
				</form>	 
				
				<!-- on recrée un formulaire qui ce coup-ci va envoyer le résultat au fichier competition_rech_res.php !-->
				<form method = "POST" action="competition_rech_res.php">
				<?php
				
				//C'est là que se trouve le gros bidouillage, je savais pas comment envoyer le $idr sans recréer un champ... mais il faudrait pas que l'utilisateur le modifie...
				echo"<input type = 'text' name = 'nom' value='$idr'  id='nom'></p>";
				
				/* Création de la requête pour avoir les dates de cette compet */ 
				$sql2 = "SELECT date 
				 FROM projet_karate.competition 
				 WHERE nom = ".$idr.";"; 
				 $query = pg_query($idConnexion, $querystring);
				$i=0;
				?>
				<select name="compet_rech_date" id="compet_rech_date" >;
				<?php
				while($result = pg_fetch_array($query))
				{
					$i++;
					//On affiche les dates disponibles pour les compétitions dont le nom est sélectionné.
					echo"<option value=$result[date]>$result[date]</option>";
				}				
				echo'</select></p>';
				}
				?> 
				<input type = "submit">
			</form>	          
		  </div>
        </td>
      </tr>
    </table>
	<br/>
				<a href= "accueil.html"> Retour à l'accueil</a> 
  </body>
</html>
