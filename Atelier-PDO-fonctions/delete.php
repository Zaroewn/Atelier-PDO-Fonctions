<?Php declare(strict_types = 1);

require_once __DIR__.'/functions.php';

$pdo = getPDO('mysql:host=localhost;dbname=blog', 'root', '');

// On vérifie avec une structure conditionnelle IF que nos champs ne soit pas vide.
if (! empty($_POST)) {
    $errors = [];

    // Si il n'y a pas d'erreurs, on lance la suppression du post via notre fonction deletePost().
    if (! $errors) {
        deletePost($pdo, (int) $_POST['id']);
    }
}

// Ici on appelle notre fonction getPostsWithCategories() après la structure conditionnelle IF, pour pouvoir récupérer le nom de nos posts dans notre menu déroulant
// pour pouvoir choisir quels posts nous voulons supprimer
$posts = getPostsWithCategories($pdo, 1, 50);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suppression d'un post</title>
</head>
<body>

    <h1>Supprimer un post</h1>

    <form action="delete.php" method="post">

        <label for="id">Post à supprimer :</label><br>
        <select name="id" id="id">
            <?php foreach($posts as $post) : ?>
            <option value="<?= $post['id'] ?>"><?= $post['title'] ?></option>
            <?php endforeach ?>
        </select>
        <input type="submit" value="Supprimer le post">

    </form>
</body>
</html>

