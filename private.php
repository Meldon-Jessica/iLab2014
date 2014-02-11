<?php
session_start();
require('auth.php');
if(Auth::islog()){

	$soiree = 'Mex';
	$pseudo = $_SESSION['Auth']['pseudo'];
	if(!empty($_POST) && isset($_POST['addName'])){
		$addName = $_POST['addName'];
		$addName = trim($addName);
		$addName = strip_tags($addName);
		$sql = "SELECT prenom FROM friends WHERE prenom = '".$addName."' AND username = '".$pseudo."' AND soiree = '".$soiree."'";
		try {
		    $req = $connexion->prepare($sql);
		    $req->execute();
		    $countPseudo = $req->rowCount($sql);
		    if($countPseudo > 0){
		    	$error_message = 'Vous utilisez déjà ce nom dans cette liste';
		    } else {
		    	$sql2 = "INSERT INTO friends (prenom, created, soiree, username) VALUES ('".$addName."','".date("Y-m-d G:i:s")."','".$soiree."','".$pseudo."')";
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
	       	<form method="POST" action="">
	       		<label for="addName">Ajouter une personne</label>
	    		<input type="text" name="addName" placeholder="nom" value="<?php if(isset($_POST['addName'])){ echo $_POST['addName']; } ?>" />
	    		<input type="submit" value="Ajouter" />
	 			<div class="error"><?php echo $error_message; ?></div>
	    	</form>
	    	<?php echo $pseudo; ?>
	    	<ul>
	    	<?php
	    		$sql2 = "SELECT prenom, somme, soiree FROM friends WHERE username = '".$pseudo."'";

	    		$req2 = $connexion->prepare($sql2);
	    		$req2->execute();
	    		$tableau = $req2->fetchAll();
	    		$count = $req2->rowCount();
	    		echo $count;

	    		for ($i = 1; $i <= $count; $i++) {
	    		    echo '<li>';
	    		    print_r($tableau[$i-1]);
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