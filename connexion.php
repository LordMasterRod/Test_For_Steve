<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=chatbox;charset=utf8;', 'root','');
if(isset($_POST['valider'])){
    if(!empty($_POST['pseudo'])){
        $recupUser = $bdd -> prepare('SELECT * FROM  users WHERE pseudo = ?');
        $recupUser->execute(array($_POST['pseudo']));
        if($recupUser->rowCount()>0){
            $_SESSION['pseudo']=$_POST['pseudo'];
            $_SESSION['id'] = $recupUser ->fetch()['id'];
            header('Location: index.php');
        }
        else{
            echo "Aucun utilsateur trouvé";
        }

    }
    else{
      echo ("Veuillez entrer votre pseudo"); 
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>For Steve</title>
       <link rel="stylesheet" href="index.css">
</head>
<body>
    <form action="" method="POST" >
        <input type="text" name="pseudo">
        <input type="submit" name="valider">
    </form>

   <!-- <div class="appli">
    <form action="" method="POST">
   <p> <label class="lblnom">Nom</label><input type="text" style="margin-left: auto;"></p>
   <p> <label class="lbldest">Dest</label><input type="text" style="margin-left: auto ;"></p>
   <p> <label class="lbltext">Text</label><input type="textarea" style="margin-left: auto;"></p>
   <p> <input type="submit" style="margin-left: auto;" value="Envoyer"></p>
   </form> -->
   </div>  
</body>
</html>