<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=chatbox;charset=utf8;', 'root', '');
if (!$_SESSION['pseudo']) {
    header('Location: connexion.php');
}
if (isset($_GET['id']) AND !empty($_GET['id'])) {
    $getid = $_GET['id'];
    $recupUser = $bdd->prepare('SELECT * FROM users WHERE id = ?');
    $recupUser->execute(array($getid));
    if ($recupUser -> rowCount() > 0) {
        if (isset($_POST['envoyer'])) {
            $mess = htmlspecialchars($_POST['mess']);
            $insererMessage = $bdd -> prepare('INSERT INTO messages(mess, id_dest, id_auteur) VALUES(?,?,?)');
            $insererMessage -> execute(array($mess, $getid, $_SESSION['id']));
        }
    } else {
        echo ('Aucun utilisateur trouvé');
    }
} else {
    echo ("Aucun identifiant trouvé");
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message privé</title>
</head>

<body>
    <form method="POST" action="">
        <textarea name="mess"></textarea>
        <br />
        <br />
        <input type="submit" name="envoyer" >

    </form>
    <section id="messages">
        <?php 
            $recupMessages = $bdd->prepare('SELECT * FROM messages WHERE id_auteur= ? AND id_dest = ? OR id_auteur =? AND id_dest = ?');
            $recupMessages->execute(array($_SESSION["id"], $getid, $getid,$_SESSION['id']));
            while($mess = $recupMessages->fetch() ){
                if($mess['id_dest']== $_SESSION['id']){
                ?> 
                <p style="color: red;"><?=$mess['mess'] ;  ?></p>
                <?php
                }elseif($mess['id_dest']== $getid){
                   ?> 
                <p style="color: green;"><?=$mess['mess'] ;  ?></p>
                <?php
                }
            }
        ?>

    </section>
</body>

</html>