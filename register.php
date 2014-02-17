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
   $pseudo = addslashes($pseudo);
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
         $body = 'Bonjour, veuillez activez votre compte en cliquant ici -> <a href="http://localhost/iLab2014/activate.php?token='.$token.'&email='.$mail.'">Activation du compte</a>';

             // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
              $entete  = 'MIME-Version: 1.0' . "\r\n";
              $entete .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
              // En-têtes additionnels
              $entete .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
              $entete .= 'From: Anniversaire <anniversaire@example.com>' . "\r\n";
              $entete .= 'Cc: anniversaire_archive@example.com' . "\r\n";
              $entete .= 'Bcc: anniversaire_verif@example.com' . "\r\n";
            
            // Envoi du mail
            if (mail($mail, 'Activation: ',$body,$entete)){
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
   

   
} /*else { echo 'nope'; }*/


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
      <link rel="stylesheet" href="assets/css/jquery-ui.css">
      <link rel="stylesheet" href="assets/css/styles.css">
      <link rel="stylesheet" href="assets/fonts/css/font-awesome.css">
   <!-- script type="text/javascript" src="http://code.jquery.com/jquery.js"></script -->
</head>
<body>
   <div class="container">
      <header>
         <h1><a href="index.php" src="logo.png" ><span>Owe</span>me</a></h1>
      </header>

      <div class="content_connexion">
         <h2 class="big_titles">Registration</h2>
         <form class="connexion" action="" method="POST">
            <div class="icon-ph"><i class="icon-envelope"></i></div>
            <input type="text" name="pseudo" placeholder="USER"value="<?php if(isset($_POST['pseudo'])){ echo $_POST['pseudo']; } ?>" required /><br />
            <div class="error"><?php if(isset($error_pseudo)){ echo $error_pseudo; } ?></div>
            <input type="text" name="mail" placeholder="EMAIL"value="<?php if(isset($_POST['mail'])){ echo $_POST['mail']; } ?>" required /><br />
            <div class="error"><?php if(isset($error_mail)){ echo $error_mail; } ?></div>
            <input type="password" name="password" placeholder="PASSWORD" required /><br />
            <div class="error"><?php if(isset($error_password)){ echo $error_password; } ?></div>

            <input type="submit" value="Sign in" />
         </form> 
          <a class="sign" href="index.php">Cancel</a>
      </div>
   </div>
</body>
</html> 