<?php

require_once "db.php";

$posts = json_decode(file_get_contents("https://jsonplaceholder.typicode.com/posts"), true);
$comments = json_decode(file_get_contents("https://jsonplaceholder.typicode.com/comments"), true);
$postsCount = 0;
$commentsCount = 0;

foreach ($posts as $post) {

    $sql = "INSERT INTO posts (id, title, body) VALUES (:id, :title, :body)";

    $responseS = getPost($pdo, $post['id']);

    if (count($responseS) === 0) {
        $postsCount += 1;
        $statement = $pdo->prepare($sql);
        $response = $statement->execute([
            ":title" => $post["title"],
            ":body" => $post["body"],
            ":id" => $post["id"]
        ]);

        $postComments = array_filter($comments, function ($var) use ($post) {
            return ($var['postId'] == $post["id"]);
        });

        foreach ($postComments as $comment) {
            $sqlc = "INSERT INTO comments (postId, id, name, email, body) VALUES (:postId, :id, :name, :email, :body)";

            $responseCS = getComment($pdo, $comment["id"]);

            if (count($responseCS) === 0) {
                $commentsCount += 1;
                $statementC = $pdo->prepare($sqlc);
                $response = $statementC->execute([
                    ":name" => $comment["name"],
                    ":email" => $comment["email"],
                    ":body" => $comment["body"],
                    ":id" => $comment["id"],
                    ":postId" => $comment["postId"]
                ]);
            }
        }
    }
    if ($post["id"] == count($posts))
        echo "Загружено " . $postsCount . " записей и " . $commentsCount . " комментариев";
}

function getPost($pdo, $id)
{
    $sqls = "SELECT id from posts WHERE id = :id";

    $statementS = $pdo->prepare($sqls);

    $statementS->execute([
        ":id" => $id
    ]);

    return $statementS->fetchAll();
}
function getComment($pdo, $id)
{
    $sqlcs = "SELECT id from comments WHERE id = :id";

    $statementCS = $pdo->prepare($sqlcs);

    $statementCS->execute([
        ":id" => $id
    ]);
    return $statementCS->fetchAll();
}
