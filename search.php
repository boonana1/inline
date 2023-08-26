<?php
require_once "db.php";
$data = json_decode(file_get_contents("php://input"), 256);
$result = array();

$commentsQuery = "SELECT * from comments WHERE body LIKE :string ";
$comments = $pdo->prepare($commentsQuery);
$comments->execute([
    ":string" => "%" . $data["string"] . "%"
]);
$commentsResponse = $comments->fetchAll();

$postsQuery = "SELECT p.* from posts p LEFT JOIN comments c ON c.body LIKE :string WHERE p.id = c.postId GROUP BY p.id";
$posts = $pdo->prepare($postsQuery);
$posts->execute([
    ":string" => "%" . $data["string"] . "%"
]);
$postsResponse = $posts->fetchAll();
foreach ($postsResponse as $key => $post) {
    $result[$key] = array("id" => $post["id"], "title" => $post["title"], "body" => $post["body"]);
    foreach ($commentsResponse as $comment) {
        if ($post["id"] == $comment["postId"]) {
            $result[$key]["comments"][] = array("postId" => $comment["postId"], "id" => $comment["id"], "name" => $comment["name"], "body" => $comment["body"], "email" => $comment["email"]);
        }
    }
}

if (empty($result)) {
    http_response_code(404);
    echo json_encode(array("message" => "Таких записей нет"));
    die();
}


http_response_code(200);
echo json_encode($result);
