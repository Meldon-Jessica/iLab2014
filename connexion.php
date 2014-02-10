<?php

$serveur = 'localhost';
$user = 'root';
$password = '';
$db = 'iLab';
$port = '3306';

try {
	$connexion = new PDO('mysql:host='.$serveur.';port='.$port.';dbname='.$db, $user, $password);
}
catch(PDOException $e){
	echo $e->getMessage();
}


?>