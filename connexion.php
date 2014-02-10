<?php

$serveur = 'localhost';
$user = 'root';
$password = 'root';
$db = 'iLab';
$port = '3306';

try {
	$connexion = new PDO('mysql:host='.$serveur.';port='.$port.';dbname='.$db, $user, $password);
	$connexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}
catch(PDOException $e){
	echo "erreur: ".$e->getMessage();
}

?>