<?php
session_start();
require('auth.php');
require('functions.php');

if(Auth::islog()){

	$liste = 'Mex';
	$pseudo = $_SESSION['Auth']['pseudo'];

// Ajouter une personne
	if(!empty($_POST) && isset($_POST['addName'])){
		$addName = $_POST['addName'];
		$addName = trim($addName);
		$addName = strip_tags($addName);
		$addName = addslashes($addName);
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
		    $_SESSION['addName'] = $addName;
		} catch(PDOException $e) {
		   echo 'erreur: '.$e->getMessage();
		}
	}




// Ajouter liste
	if(!empty($_POST) && isset($_POST['addListe'])){
		$addListe = $_POST['addListe'];
		$addListe = trim($addListe);
		$addListe = strip_tags($addListe);
		$addListe = addslashes($addListe);
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
// Ajouter Montant
	if(!empty($_POST) && isset($_POST['addMontant']) && isset($_SESSION['addName'])){
		$addMontant = $_POST['addMontant'];
		$addMontant = trim($addMontant);
		$addMontant = strip_tags($addMontant);
		$addMontant = addslashes($addslashes);
		$sql3 = "UPDATE friends SET montant = '".$addMontant."' WHERE prenom = '".$_SESSION['addName']."' AND username = '".$pseudo."'";
		try { 
			$connexion->exec($sql3);
			echo 'Le montant a bien été mis à jour';
		} catch(PDOException $e){
			echo 'erreur: '.$e->getMessage();
		}

	} else if(isset($_POST['addMontant']) && !isset($_SESSION['addName'])){
		echo 'addName ne passe pas.';
	}


// Ajouter Date
	if(!empty($_POST) && isset($_POST['datepicker']) && isset($_SESSION['addName'])){
		$addOldDate = $_POST['datepicker'];
		/*$addOldDate = date_format($addDate, 'Y-m-d');*/
		$addDate = date("Y-m-d", strtotime($addOldDate));
		$sql = "UPDATE friends SET dateFin = '".$addDate."' WHERE prenom = '".$_SESSION['addName']."' AND username = '".$pseudo."'";
		try {
			$connexion->exec($sql);
			echo 'Date bien modifiée';
		} catch(PDOException $e){
			echo 'erreur: '.$e->getMessage();
		}
	}


// Ajouter Note
	if(!empty($_POST) && isset($_POST['addNote']) && isset($_SESSION['addName'])){
		$addNote = $_POST['addNote'];
		$addNote = strip_tags($addNote);
		$addNote = addslashes($addNote);
		$sql = "UPDATE friends SET note = '".$addNote."' WHERE prenom = '".$_SESSION['addName']."' AND username = '".$pseudo."'";
		try {
			$req = $connexion->prepare($sql);
			$req->execute();
			echo 'La note/commentaire a bien été mis à jour';
		} catch(PDOException $e){
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
  	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
   	<meta name="author" content="Alexis Bertin" />
   	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
   	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="apple-mobile-web-app-capable" content="yes">

   	<!-- link href="styles.css" rel="stylesheet" -->
   	<link rel="stylesheet" href="assets/css/jquery-ui.css">
   	<link rel="stylesheet" href="assets/css/styles.css">
   	
   	<script src="assets/js/jquery.js"></script>
   	<script type="text/javascript" src="assets/js/jquery-ui.js"></script>
   	<script type="text/javascript" src="assets/js/modernizr.custom.js"></script>
   	
   	<script src="assets/js/boxlayout.js"></script>
   	<script>
		$(function() {
			Boxlayout.init();
			$( "#datepicker" ).datepicker();
			$('#ui-datepicker-div').appendTo('.calendar');
		});
  	</script>

</head>
<body>
		
	<div class="container">	
		<div id="bl-main" class="bl-main">
			<section id="bl-work-section">
				<div class="bl-box">
					<img src="assets/img/add_btn.png"/>
					<h2><span>Add</span> an account</h2>
				</div>
				
				<span class="bl-icon bl-icon-close"></span>
			</section>
			<div class="bl-panel-items" id="bl-panel-work-items">
				<div data-panel="panel-1" id="panel1">
					<div class="quest_form">
						<h3><span>Q</span>ui ?</h3>
				    	<form method="POST" action="private.php">
				    		<input type="text" name="addName" placeholder="NOM" value="<?php if(isset($_POST['addName'])){ echo $_POST['addName']; } ?>" required />
				    		<input type="submit" value="Next" />
				 			<div class="error"><?php if(isset($error_message_name)){ echo $error_message_name;} ?></div>
				    	</form>
				    	<div class="steps">1/4</div>
				    </div>
				</div>
				<div data-panel="panel-2">
					<div class="quest_form">
						<h3><span>M</span>ontant</h3>
			    		<form method="POST" action="private.php">
			    			<label for="addMontant">Combien ?</label>
			    			<input type="text" name="addMontant" placeholder="MONTANT" value="<?php if(isset($_POST['addMontant'])){ echo $_POST['addMontant']; } ?>" required />
			    			<input type="submit" value="Next" />
			    			<div class="error"><?php if(isset($error_message_montant)){ echo $error_message_montant; } ?></div>
			    		</form>
			    		<div class="steps">2/4</div>
			        </div>
			    </div>
			    <div data-panel="panel-3">
			    	<div class="quest_form">
						<h3><span>D</span>ate d'écheance</h3>
						<form action="private.php" method="POST">
							<div class="calendar"></div>
							<input type="text" id="datepicker" name="datepicker" value="<?php if(isset($_POST['datepicker'])){ echo $_POST['datepicker']; } ?>" />
							<input type="submit" value="INSERT DATE">
						</form>
						<div class="steps">3/4</div>
				    </div>
				</div>
				<div data-panel="panel-4">
					<div class="quest_form">
						<h3>Note</h3>
						<form action="private.php" method="POST">
							<label for="addNote">Note</label>
							<textarea name="addNote"></textarea>
							<input type="submit" value="Ajouter" />
						</form>
						<div class="steps">4/4</div>
				    </div>
				</div>
				<div data-panel="panel-5">
					<div>
						<form method="POST" action="private.php">
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
					    	<input type="submit" value="Envoyer" />
					    </form>
				    </div>
				</div>
				<div data-panel="panel-6">
					<div>
						<ul>
						<?php
							$sql2 = "SELECT prenom, montant, liste, id FROM friends WHERE username = '".$pseudo."'";

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
				    </div>
				</div>
				<div data-panel="panel-2">
					<div>
						<a href="logout.php">Se déconnecter</a>
					</div>
				</div>
				<nav>
					<span class="bl-next-work">&gt; Next Project</span>
					<span class="bl-icon bl-icon-close"></span>
				</nav>
			</div>
		</div>
	</div>
	

	    	
	    	
	
</body>
</html> 