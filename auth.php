<?php

error_reporting(E_ALL);
require_once 'connexion.php';

class Auth {

	static function islog(){
		global $connexion;
		if(isset($_SESSION['Auth']) && isset($_SERVER['Auth']['mail']) && isset($_SERVER['Auth']['password'])){
			$sql = "SELECT mail, password FROM users WHERE mail = '".$_SESSION['Auth']['mail']."' AND password = '".$_SESSION['Auth']['password']."'";
			$req->exec($sql);
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