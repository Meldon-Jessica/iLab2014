<?php
error_reporting(E_ALL);
require_once 'connexion.php';

$token = $_GET['token'];
$mail = $_GET['mail'];
if(!empty($_GET)){

   $sql = "SELECT mail, token FROM users WHERE mail = '".$mail."' AND token = '".$token."' ";
   try {
      $connexion->exec($sql);
      $count = $connexion->rowCount($sql);
      if($count == 1){
         // on vérifie si l'user en activé
         $sql2 = "SELECT mail, activer FROM users WHERE mail = '".$mail."' AND activer = 1 ";
         $connexion->exec($sql2);
         $dejaActive = $connexion->rowCount($sql2);
         if($dejaActive == 1){
            $error_actif = 'Votre compte a déjà été activé';
         } else {
            $sql3 = "UPDATE users SET activer = 1 WHERE email = '".$mail."'";
            $connexion->exec($sql3);
            $activated = 'Votre compte est désormais activé !';
         }
      } else {
         // Utilisateur inconnus
         $prob_token = 'Mauvais Token';
      }
   }
   catch(PDOException $e) {
      echo 'erreur: '.$e->getMessage();
   }

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
         <h1>Espace Membre</h1>
      </header>

      <div class="content">
         <div class="error"><?php if(isset($error_actif)){ echo $error_actif; } ?></div>
         <div class="error"><?php if(isset($activated)){ echo $activated; } ?></div>
         <div class="error"><?php if(isset($prob_token)){ echo $prob_token; } ?></div>
      </div>
   </div>
</body>
</html> 





