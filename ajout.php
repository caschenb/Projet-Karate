<?php
function fajout($idConnexion,$nom,$date,$lieu,$site, $mail, $materiau, $type)
{
		$querystring = "INSERT INTO projet_karate.competition (nom, date, lieu, siteweb, mail, nommateriau, type) VALUES ('$nom', '$date', '$lieu', '$site', '$mail', '$materiau', '$type')" ;
		$query = pg_query($idConnexion, $querystring);
	//	$result=pg_fetch_array($query);
	if (!is_null($result=pg_fetch_array($query))) return 1;
return 0;
	
		
}

function fmodif($idConnexion,$nom,$date,$lieu,$site, $mail, $materiau, $type, $anciennom)
{
		$querystring = "UPDATE projet_karate.competition SET nom='$nom', date='$date', lieu='$lieu', siteweb='$site', mail='$mail', nommateriau='$materiau', type='$type'
						WHERE nom='$anciennom'" ;
		$query = pg_query($idConnexion, $querystring);
	//	$result=pg_fetch_array($query);
	if (!is_null($result=pg_fetch_array($query))) return 1;
return 0;		
}
?>




