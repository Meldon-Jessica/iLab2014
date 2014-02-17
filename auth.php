<?php

error_reporting(E_ALL);
require_once 'connexion.php';

class Auth {
	static function islog(){
		global $connexion;
		if(isset($_SESSION['Auth']) && isset($_SESSION['Auth']['pseudo']) && isset($_SESSION['Auth']['password'])){

			$sql = "SELECT username, password FROM users WHERE username = '".$_SESSION['Auth']['pseudo']."' AND password = '".$_SESSION['Auth']['password']."'";
			$req = $connexion->prepare($sql);
			$req->execute();
			$count = $req->rowCount($sql);

			if($count == 1){
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

}

?>