<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$CONFIG['displayErrorDetails'] = false;
$CONFIG['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $CONFIG]);
$container = $app->getContainer();
$container['pdo'] = function($container) {
    $settings = $container["settings"];
    $host = $settings['host'];
    $db = $settings['db'];
    $charset = 'utf8mb4';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    return new PDO($dsn, $settings['user'], $settings['password'], $options);
};

$app->get('/review/{id}', function (Request $request, Response $response) {

    $reviewId = $request->getAttribute('id');
    if (!is_numeric($reviewId)) {
        return $response->withStatus(400);
    }
    
    $stmt = $this->pdo->prepare('SELECT id, title, author, publication_year FROM reviews WHERE id = :id');
    $stmt->execute(['id' => $reviewId]);

    $response = $response->withHeader('Content-type', 'application/json');
    if ($row = $stmt->fetch()) {
        $response = $response->withJson($row);
    } else {
        $response = $response->withStatus(404);
    }
    return $response;
});

$app->run();