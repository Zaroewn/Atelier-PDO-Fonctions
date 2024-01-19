<?php require_once __DIR__.'/functions.php';
    
    $pdo = getPDO('mysql:host=localhost;dbname=blog', 'root', '');

    // On vérifie avec une structure conditionnelle IF que nos champs ne soit pas vide, (pour éviter de rentrer une ligne vide dans notre BDD)
    if (! empty($_POST)) {
        $errors = [];
    
        // Si il n'y a pas d'erreurs, on lance la création du post via notre fonction createPost().
        if (! $errors) {
            createPost($pdo, $_POST['title'], $_POST['body'], $_POST['excerpt']);
        }
    
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création d'un nouveau post</title>
</head>
<body>

    <h1>Créer un nouveau post</h1>

    <form action="create.php" method="post">

        <label for="title">Titre du post :</label><br>
        <input type="text" name="title" placeholder="Titre du post">
        <br><br>
        <label for="body">Contenu du post :</label><br>
        <textarea name="body" cols="30" rows="10" placeholder="Écrivez votre post ici"></textarea>
        <br><br>
        <label for="body">Contenu de l'extrait du post :</label><br>
        <textarea name="excerpt" cols="" rows="" placeholder="Écrivez l'extrait du post ici" maxlength="150"></textarea>
        <br><br>
        <input type="submit" value="Créer le post">

    </form>
</body>
</html>
