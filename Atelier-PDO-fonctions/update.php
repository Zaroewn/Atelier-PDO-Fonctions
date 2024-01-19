<?php 
    require_once __DIR__.'/functions.php';
    
    $pdo = getPDO('mysql:host=localhost;dbname=blog', 'root', '');
       
    // On vérifie avec une structure conditionnelle IF que nos champs ne soit pas vide.
    if (! empty($_POST)) {
        $errors = [];
        
        // Si il n'y a pas d'erreurs, on lance la modification du post via notre fonction updatePost().
        if (! $errors) {
            updatePost($pdo, $_GET['id'], $_POST['title'], $_POST['body'], $_POST['excerpt']);
        }
    }

    
// Ici on appelle notre fonction getPostWithCategory() après la structure conditionnelle IF, pour pouvoir récupérer les informations de nos posts dans nos zones de formulaire
// afin de pouvoir les modifier
    $post = getPostWithCategory($pdo, (int) $_GET['id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modification d'un post</title>
</head>
<body>

    <h1>Modifier un post</h1>

    <form action="" method="post">

        <label for="title">Nouveau titre du post :</label><br>
        <input type="text" name="title" value="<?= $post['title'] ?>">
        <br><br>
        <label for="body">Nouveau contenu du post :</label><br>
        <textarea name="body" cols="30" rows="10" ><?= $post['body'] ?></textarea>
        <br><br>
        <textarea name="excerpt" cols="" rows="" ><?= $post['excerpt'] ?></textarea>
        <br><br>
        <input type="submit" value="Modifier le post">

    </form>
</body>
</html>
