<?php
session_start();
require('auth.php');

$pseudo = $_SESSION['Auth']['pseudo'];

	$addListe = $_POST['addListe'];

	$addListe = trim($addListe);
	$addListe = strip_tags($addListe);
	$addListe = addslashes($addListe);

	// Vérifie si la liste existe déjà
	$sql = "SELECT nomDeListe FROM listes WHERE nomDeListe = '".$addListe."' AND createdBy = '".$pseudo."'";
	try {
	    $req = $connexion->prepare($sql);
	    $req->execute();
	    $countPseudo = $req->rowCount($sql);
	    if(!empty($addListe)){
		    if($countPseudo > 0){
		    	echo 'Vous utilisez déjà ce nom de liste.';
		    } else{
		    	$sql2 = "INSERT INTO listes (nomDeListe, createdBy, created) VALUES ('".$addListe."','".$pseudo."','".date("Y-m-d G:i:s")."')";
		    	try {
		    		$req = $connexion->prepare($sql2);
		    		$req->execute();
		    		echo 'ok';
		    	} catch(PDOException $e) {
		    		echo 'erreur: '.$e->getMessage();
		    	}
		    }
		} else {
			echo 'Vous devez remplir le champ';
		}
	} catch(PDOException $e) {
	   echo 'erreur: '.$e->getMessage();
	}

?>
