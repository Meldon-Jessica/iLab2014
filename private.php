<?php
session_start();
require('auth.php');
if(Auth::islog()){

	$liste = 'Mex';
	$pseudo = $_SESSION['Auth']['pseudo'];
	if(!empty($_POST) && isset($_POST['addName'])){
		$addName = $_POST['addName'];
		$addName = trim($addName);
		$addName = strip_tags($addName);
		$sql = "SELECT prenom FROM friends WHERE prenom = '".$addName."' AND username = '".$pseudo."' AND liste = '".$liste."'";
		try {
		    $req = $connexion->prepare($sql);
		    $req->execute();
		    $countPseudo = $req->rowCount($sql);
		    if($countPseudo > 0){
		    	$error_message_name = 'Vous utilisez déjà ce nom dans cette liste';
		    } else {
		    	$sql2 = "INSERT INTO friends (prenom, created, liste, username) VALUES ('".$addName."','".date("Y-m-d G:i:s")."','".$liste."','".$pseudo."')";
		    	try {
		    		$connexion->exec($sql2);
		    		echo 'Nouveau nom bien ajouté dans la base.';
		    	} catch(PDOException $e) {
		    		echo 'erreur: '.$e->getMessage();
		    	}
		    }
		} catch(PDOException $e) {
		   echo 'erreur: '.$e->getMessage();
		}
	}

	if(!empty($_POST) && isset($_POST['addListe'])){
		$addListe = $_POST['addListe'];
		$addListe = trim($addListe);
		$addListe = strip_tags($addListe);
		$sql = "SELECT nomDeListe FROM listes WHERE nomDeListe = '".$addListe."' AND createdBy = '".$pseudo."'";
		try {
		    $req = $connexion->prepare($sql);
		    $req->execute();
		    $countListes = $req->rowCount($sql);
		    if($countListes > 0){
		    	$error_message_liste = 'Vous utilisez déjà ce nom de liste';
		    } else {
		    	$sql2 = "INSERT INTO listes (nomDeListe, createdBy, created) VALUES ('".$addListe."','".$pseudo."','".date("Y-m-d G:i:s")."')";
		    	try {
		    		$connexion->exec($sql2);
		    		echo 'Nouvelle liste bien ajoutée dans la base.';
		    	} catch(PDOException $e) {
		    		echo 'erreur: '.$e->getMessage();
		    	}
		    }
		} catch(PDOException $e) {
		   echo 'erreur: '.$e->getMessage();
		}
	}


	function deleteName($ligne){
		global $connexion;
		$sql = "DELETE FROM friends WHERE id='".$ligne."'";
		try {
			$connexion->exec($sql);
			echo 'supprimé';	
		} catch(PDOException $e) {
			echo 'erreur: '.$e->getMessage();
		}
	}

	if(isset($_GET['tab']) && $_GET['del'] == true){
		deleteName($_GET['tab']);
	}





} else {
	header('Location:index.php');
}

?>
<!DOCTYPE html>
<html lang="fr" class="no-js">
<head>
   <title>PHP | Membres</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="author" content="Alexis Bertin" />
   <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
   <!-- link href="styles.css" rel="stylesheet" -->
   <!-- script type="text/javascript" src="http://code.jquery.com/jquery.js"></script -->
</head>
<body>
	<div class="container">
	    <header>
	        <h1>Espace Privé</h1>
	    </header>

	    <div class="content">
	    	<select>
	    	<?php
	    		$sql = "SELECT nomDeListe FROM listes WHERE createdBy = '".$pseudo."'";
	    		$req = $connexion->prepare($sql);
	    		$req->execute();
	    		$tableau = $req->fetchAll();
	    		$count = $req->rowCount();

	    		for($i = 1; $i <= $count; $i++){
	    			echo '<option value="'.$tableau[$i-1]['nomDeListe'].'">'.$tableau[$i-1]['nomDeListe'].'</option>';
	    		}
	    	?>
	    	</select>
	    	<form method="POST" action="private.php">
	    		<label for="addListe">Ajouter une liste</label>
	    		<input type="text" name="addListe" placeholder="nom de la liste" value="<?php if(isset($_POST['addListe'])){ echo $_POST['addListe']; } ?>" required />
	    		<input type="submit" value="Ajouter" />
	    		<div class="error"><?php if(isset($error_message_liste)){ echo $error_message_liste;} ?></div>
 	    	</form>
	       	<form method="POST" action="private.php">
	       		<label for="addName">Ajouter une personne</label>
	    		<input type="text" name="addName" placeholder="nom de la personne" value="<?php if(isset($_POST['addName'])){ echo $_POST['addName']; } ?>" required />
	    		<input type="submit" value="Ajouter" />
	 			<div class="error"><?php if(isset($error_message_name)){ echo $error_message_name;} ?></div>
	    	</form>
	    	<?php echo $pseudo; ?>
	    	<ul>
	    	<?php
	    		$sql2 = "SELECT prenom, somme, liste, id FROM friends WHERE username = '".$pseudo."'";

	    		$req2 = $connexion->prepare($sql2);
	    		$req2->execute();
	    		$tableau = $req2->fetchAll();
	    		$count = $req2->rowCount();

	    		for ($i = 1; $i <= $count; $i++) {
	    		    echo '<li>';
	    		    for($x = 0; $x <= 2; $x++){
	    		    	echo '<span class="case">'.$tableau[$i-1][$x].'</span>';
	    		    }
	    		    echo '<a class="del" style="margin-left: 10px;" href="?tab='.$tableau[$i-1]['id'].'&del=true">X</a>';
	    		    echo '</li>';
	    		}

	    	?>
	    	</ul>
	        <br />
	        <a href="logout.php">Se déconnecter</a>
	    </div>
	</div>
</body>
</html> 