<?php declare(strict_types = 1);

function getPDO(string $dsn, string $user, string $mdp) : PDO {
    return new PDO($dsn, $user, $mdp);
}




function getPostsWithCategories(PDO $pdo, int $page, int $perPage) : array {

    // On détermine le nombre total d'articles
    $query = $pdo -> query('SELECT COUNT(*) AS nb_articles FROM posts');

    $query -> execute();
    
    // On récupère le nombre d'articles
    $result = $query -> fetch();
    
    $nbArticles = (int) $result['nb_articles'];

    // On calcule quel sera le premier article à afficher sur la page choisie
     $premier = ($page * $perPage) - $perPage;
 
     $query = $pdo -> prepare('SELECT p.id, p.title, p.excerpt, p.created_at, p.updated_at, c.name AS category_name
            FROM posts p
            LEFT JOIN categories c ON p.category_id = c.id
            ORDER BY p.created_at ASC LIMIT :premier, :perPage');
 
     $query -> bindValue(':premier', $premier, PDO::PARAM_INT);
     $query -> bindValue(':perPage', $perPage, PDO::PARAM_INT);
 
     $query -> execute();
 
    return $query -> fetchAll(PDO::FETCH_ASSOC);
 
}





function getPostWithCategory (PDO $pdo, int $id) : array|false {

    $query = $pdo -> prepare('SELECT p.id, p.title, p.body, p.excerpt, p.created_at, c.name AS category_name
        FROM posts p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE p.id = :id');

    $query -> bindValue(':id', $_GET['id'], PDO::PARAM_INT);

    $query -> execute();

    return $query -> fetch(PDO::FETCH_ASSOC);
}





function getPostsByCategory(PDO $pdo, int $category_id, int $page, int $perPage) : array {

    // On détermine le nombre total d'articles
    $query = $pdo -> query('SELECT COUNT(*) AS nb_articles FROM posts');

    $query->execute();

    // On récupère le nombre d'articles
    $result = $query -> fetch();

    // On stocke le résultat du nombre total d'articles du la variable $nbArticles
    $nbArticles = (int) $result['nb_articles'];

    // On calcule quel sera le premier article à afficher sur la page choisie
    $premier = ($page * $perPage) - $perPage;

    $query = $pdo -> prepare('SELECT p.title, p.excerpt, p.created_at, p.category_id, c.name AS category_name
        FROM posts p
        LEFT JOIN categories c ON p.category_id = c.id
        WHERE c.id = :id
        ORDER BY p.created_at DESC LIMIT :premier, :perPage');

    $query -> bindValue('id', $category_id, PDO::PARAM_INT);
    $query -> bindValue(':premier', $premier, PDO::PARAM_INT);
    $query -> bindValue(':perPage', $perPage, PDO::PARAM_INT);

    $query -> execute();

    return $query -> fetchAll(PDO::FETCH_ASSOC);
}




function createPost(PDO $pdo, string $title, string $body, string $excerpt) {

    // On vérifie avec une structure conditionnelle IF que nos champs ne soit pas vide, (pour éviter de rentrer une ligne vide dans notre BDD)
    if(! empty($_POST['title'] && $_POST['body'] && $_POST['excerpt'])) {

        $query = $pdo -> prepare('INSERT INTO posts (title, body, excerpt) VALUES (:title, :body, :excerpt)');

        $query -> bindValue(':title', $title, PDO::PARAM_STR);
        $query -> bindValue(':body', $body, PDO::PARAM_STR);
        $query -> bindValue(':excerpt', substr($excerpt, 0, 150), PDO::PARAM_STR);

        return $query -> execute();
    }

}




function updatePost(PDO $pdo, int $post_id, string $title, string $body, string $excerpt) {

        $query = $pdo -> prepare('UPDATE posts SET title = :title, body = :body, excerpt = :excerpt WHERE id = :id');

        $query -> bindValue(':title' , $title, PDO::PARAM_STR);
        $query -> bindValue(':body' , $body, PDO::PARAM_STR);
        $query -> bindValue(':excerpt' , substr($excerpt, 0, 150), PDO::PARAM_STR);
        $query -> bindValue(':id' , $_GET['id'], PDO::PARAM_INT);

        return $query -> execute();

}




function deletePost(PDO $pdo, int $id) {

    $query = $pdo -> prepare('DELETE FROM posts WHERE id = :id');
    $query -> bindValue('id', $_POST['id'], PDO::PARAM_INT);

    return $query -> execute();

}




function addComment(PDO $pdo, int $post_id, string $content) {

    // On vérifie avec une structure conditionnelle IF que notre champ ne soit pas vide, (pour éviter de rentrer une ligne vide dans notre BDD)
    if(! empty($_POST['content'])) {

        $query = $pdo -> prepare('INSERT INTO comments (content, post_id) VALUES (:content, :post_id)');

        $query -> bindValue(':content', $content, PDO::PARAM_STR);
        $query -> bindValue(':post_id', $post_id, PDO::PARAM_INT);
        

        return $query -> execute();
    }

}
