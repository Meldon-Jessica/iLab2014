<?php
error_reporting(E_ALL);
session_start();
require_once 'connexion.php';


if(!empty($_POST)){

   $pseudo = $_POST['pseudo'];
   $pseudo = strip_tags($pseudo);
   $password = $_POST['password'];
   $password = sha1($password);

   $sql = "SELECT username, password FROM users WHERE username = '".$pseudo."' AND password = '".$password."'";
   try {
      $req = $connexion->prepare($sql);
      $req->execute();
      $count = $req->rowCount($sql);
      
      if($count == 1){
         // Vérifier si l'user est activé
         $sql2 = "SELECT username, password, activer FROM users WHERE username = '".$pseudo."' AND password = '".$password."' AND activer = 1";
         $req2 = $connexion->prepare($sql2);
         $req2->execute();
         $active = $req2->rowCount($connexion);
         
         if($active == 1){
            $_SESSION['Auth'] = array(
               'pseudo' => $pseudo,
               'password' => $password
            );
            header('Location:private.php');
         } else {
            $error_active = 'Votre compte n\'est pas actif, vérifiez vos mails pour activer votre compte'; 
         }
      } else {
         $error_active = 'Utilisateur inconnu';
      }


   } catch(PDOException $e) {
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
         <h1>Connexion</h1>
      </header>

      <div class="content">
         <form action="" method="POST">
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" value="<?php if(isset($_POST['pseudo'])){ echo $_POST['pseudo']; } ?>" required /><br />
            <div class="error"><?php if(isset($error_pseudo)){ echo $error_pseudo; } ?></div>
            <label for="password">Password</label>
            <input type="password" name="password" required /><br />
            <div class="error"><?php if(isset($error_password)){ echo $error_password; } ?></div>

            <input type="submit" value="Connexion" />
            <div class="error"><?php if(isset($error_active)){ echo $error_active; } ?></div>            
         </form>


         <br />
         <a href="register.php">Inscription</a>
      </div>
   </div>
</body>
</html> 