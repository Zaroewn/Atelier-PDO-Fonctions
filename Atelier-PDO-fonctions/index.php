<?php declare(strict_types = 1);

require_once __DIR__.'/functions.php';

// Connection à la base de données
$pdo = getPDO('mysql:host=localhost;dbname=blog', 'root', '');

// Récupération de tout les posts présents sur la base de données
$posts = getPostsWithCategories($pdo, (int) 1, (int) 20);


// Fonction anonyme (8ème point)

$postsSansCategories = array_filter($posts, function($posts) {
    return empty($posts['category_name']);
});


// Fonction fléchées (8ème point)
$postsSansCategories = array_filter($posts, fn($posts) => empty($posts['category_name']));

echo '<pre>';
var_dump($postsSansCategories);
echo '</pre>';

?>
