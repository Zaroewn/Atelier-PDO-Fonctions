<?php declare(strict_types = 1);

require_once __DIR__.'/functions.php';

$pdo = getPDO('mysql:host=localhost;dbname=blog', 'root', '');

$posts = getPostsWithCategories($pdo, (int) 1, (int) 20);


// Fonction anonyme

$postsSansCategories = array_filter($posts, function($posts) {
    return empty($posts['category_name']);
});


// Fonction fléchées
$postsSansCategories = array_filter($posts, fn($posts) => empty($posts['category_name']));

echo '<pre>';
var_dump($postsSansCategories);
echo '</pre>';

?>