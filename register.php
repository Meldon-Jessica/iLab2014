<?php
error_reporting(E_ALL);


require_once 'connexion.php';


if(!empty($_POST) && isset($_POST['pseudo']) && isset($_POST['mail']) && isset($_POST['password'])){

   function is_valid_email($email){
      return filter_var($email, FILTER_VALIDATE_EMAIL);
      // return true or false
   }

   $pseudo = trim($_POST['pseudo']);
   $pseudo = strip_tags($pseudo);
   $mail = trim($_POST['mail']);
   $mail = strip_tags($mail);
   $token = sha1(uniqid(rand()));
   $password = trim($_POST['password']);
   $password = strip_tags($password);

   /*$sql = "SELECT username, password FROM users WHERE username = '".$pseudo."' AND password = '".$password."'";*/
   $sql = "SELECT username, password FROM users WHERE username = '".$pseudo."'";
   try {
      $req = $connexion->prepare($sql);
      $req->execute();
      $countPseudo = $req->rowCount($sql);
   } catch(PDOException $e) {
      echo 'erreur: '.$e->getMessage();
   }
   $sql = "SELECT username, mail FROM users WHERE mail = '".$mail."'";
   try {
      $req = $connexion->prepare($sql);
      $req->execute();
      $countMail = $req->rowCount($sql);
   } catch(PDOException $e) {
      echo 'erreur: '.$e->getMessage();
   }


   if(strlen($pseudo)>3 && is_valid_email($mail) == true && !empty($password) && $countPseudo == 0 && $countMail == 0){
   
      $password = sha1($password);

      $sql = "INSERT INTO users (username, mail, password, created, token) VALUES ('".$pseudo."', '".$mail."', '".$password."','".date("Y-m-d G:i:s")."', '".$token."')";
      try {
         $connexion->exec($sql);
         $body = '
            Bonjour, veuillez activez votre compte en cliquant ici ->
            <a href="http://localhost/iLab2014/activate.php?token='.$token.'&email='.$to.'">Activation du compte</a>';
            $entete = "MIME-Version: 1.0\r\n";
            $entete .= "Content-type: text/html; charset=UTF-8\r\n";
            $entete .= 'From: appli@appli.com' . "\r\n" .
            'Reply-To: contact@appli.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
            
            // Envoi du mail
            if (mail($to,$sujet,$body,$entete)){
               $reponse = 'Votre inscription a bien été enregistrée, un mail d\'activation vous a été envoyé. Merci !';
            } else {
               $reponse = 'Échec de l\'envoi de l\'email';
            };
            echo $reponse;

      }
      catch(PDOException $e) {
         echo 'erreur: '.$e->getMessage();
      }
      
   } else {
      if(!empty($_POST) && strlen($_POST['pseudo'])<4){
         $error_pseudo = 'Votre pseudo doit comporter au minimum 3 charactères !';
      } else if(!empty($_POST) && is_valid_email($mail) == false){
         $error_mail = 'Votre adresse e-mail n\'est pas valide !';
      } else if(!empty($_POST) && empty($password)){
         $error_password = 'Votre mot de pass n\'est pas valide';
      } else if(!empty($_POST) && $countPseudo != 0 && $countMail != 0){
         $error_pseudo = 'Ce peudo est déjà utilisé.';
         $error_mail = 'Cette adresse e-mail est déjà utilisée';
      } else if(!empty($_POST) && $countPseudo != 0 || $countMail != 0){
         if($countPseudo != 0){
            $error_pseudo = 'Ce peudo est déjà utilisé.';
         } else if($countMail != 0){
            $error_mail = 'Cette adresse e-mail est déjà utilisée';
         }
      }
   }
   

   
} else { echo 'nope'; }


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
         <form action="" method="POST">
            <label for="pseudo">Pseudo</label>
            <input type="text" name="pseudo" value="<?php if(isset($_POST['pseudo'])){ echo $_POST['pseudo']; } ?>" required /><br />
            <div class="error"><?php if(isset($error_pseudo)){ echo $error_pseudo; } ?></div>
            <label for="password">Password</label>
            <input type="password" name="password" required /><br />
            <div class="error"><?php if(isset($error_password)){ echo $error_password; } ?></div>
            <label for="mail">Adresse Mail</label>
            <input type="text" name="mail" value="<?php if(isset($_POST['mail'])){ echo $_POST['mail']; } ?>" required /><br />
            <div class="error"><?php if(isset($error_mail)){ echo $error_mail; } ?></div>

            <input type="submit" value="Envoyer" />
         </form> 
      </div>
   </div>
</body>
</html> 