<?Php declare(strict_types = 1);

require_once __DIR__.'/functions.php';

$pdo = getPDO('mysql:host=localhost;dbname=blog', 'root', '');

if (! empty($_POST)) {
    $errors = false;

    if (! $errors) {
        deletePost($pdo, (int) $_POST['id']);
        $errors = true;
        echo $errors;
    }
}

$posts = getPostsWithCategories($pdo, 1, 50);

// echo '<pre>';
// var_dump($posts);
// echo '</pre>'; 

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

