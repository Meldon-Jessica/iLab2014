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
         <form action="register.php" method="POST">
            <label for="pseudo">Pseudo</label>
            <input type="text" name="prenom"/><br />
            <label for="password">Password</label>
            <input type="password" name="password"/><br />
            <label for="mail">Adresse Mail</label>
            <input type="text" name="mail"/><br />

            <input type="submit" value="Envoyer" />
         </form> 
      </div>
   </div>
</body>
</html> 