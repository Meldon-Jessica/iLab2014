<?php
session_start();
require('auth.php');

$pseudo = $_SESSION['Auth']['pseudo'];

	$addName = $_POST['addName'];

	$addName = trim($addName);
	$addName = strip_tags($addName);
	$addName = addslashes($addName);

	$addListe = $_POST['addListe'];

	// Vérifie si le nom existe déjà
	$sql = "SELECT prenom FROM friends WHERE prenom = '".$addName."' AND username = '".$pseudo."' AND liste = '".$addListe."'";
	try {
	    $req = $connexion->prepare($sql);
	    $req->execute();
	    $countPseudo = $req->rowCount($sql);
	    if($countPseudo > 0){
	    	echo 'Vous utilisez déjà ce prénom dans cette liste.';
	    } else {
	    	echo 'ok';
	    }
	} catch(PDOException $e) {
	   echo 'erreur: '.$e->getMessage();
	}





?>
