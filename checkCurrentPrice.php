<?php
	session_start();
	require('auth.php');

	$pseudo = $_SESSION['Auth']['pseudo'];

	$sql = "SELECT SUM(montant) as prix_total FROM friends WHERE username = '".$pseudo."'";
	try {
		$req = $connexion->prepare($sql);
		$req->execute();
		$result = $req->fetch(PDO::FETCH_ASSOC);
		/*$req->fetch();*/
		print_r($result['prix_total']);
	} catch(PDOException $e) {
		echo 'erreur: '.$e->getMessage();
	}

?>
