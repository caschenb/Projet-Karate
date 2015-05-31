<HTML>
<head>
    <title>Mise à jour effectuée </title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body>
	<?php
		mb_internal_encoding("UTF-8");
		include("connect.php");
		$idConnexion=fconnect();
		$nom=$_POST["nomC"];
		$date=$_POST["dateC"];

		if (!empty($_POST["ins"])){
			$querystring = "SELECT C.nom AS nom, C.adresse AS adresse
										FROM projet_karate.club C
										ORDER BY C.nom;"; 
		$query = pg_query($idConnexion, $querystring);
		$i=0;
		$j=3;
		while($res=pg_fetch_array($query)){
			if($_POST["ins"]==$j){
			 $id=$_POST["membre$i"];
			}
			$i=$i+1;
			$j=$j+1;
		}
			$querystring="INSERT INTO projet_karate.participant VALUES ('$nom','$date','$id');";
			$query=pg_query($idConnexion,$querystring);
			$querystring="SELECT P.prenom, P.nom
						  FROM projet_karate.pratiquant P
						  WHERE P.identifiant='$id';";
			$query=pg_query($idConnexion,$querystring);
			$res=pg_fetch_array($query);
			echo("$id $res[nom] $res[prenom] a bien été ajouté à la compétition $nom se déroulant le $date");
		}
		else{

		$querystring = "SELECT C.nom AS nom, C.adresse AS adresse
										FROM projet_karate.club C
										ORDER BY C.nom;"; 
		$query = pg_query($idConnexion, $querystring);
		$i=0;

		while($res=pg_fetch_array($query)){
			if(!strcmp($_POST["desc"],$res['adresse'])){
			 $id=$_POST["membre$i"];
			}
			$i=$i+1;
		}

			$querystring="DELETE FROM projet_karate.participant WHERE projet_karate.participant.idpratiquant=$id;";
			$query=pg_query($idConnexion,$querystring);
			$querystring="SELECT P.prenom, P.nom
						  FROM projet_karate.pratiquant P
						  WHERE P.identifiant='$id';";
			$query=pg_query($idConnexion,$querystring);
			$res=pg_fetch_array($query);
			echo("$id $res[nom] $res[prenom] a bien été enlevé de la compétition $nom se déroulant le $date");
		}
	?>

</body>
</HTML>
