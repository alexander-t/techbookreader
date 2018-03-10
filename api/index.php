<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';
require_once __DIR__ . '/../ReviewService.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use \TechbookReader\Service\ReviewService as ReviewService;

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

$container['reviewService'] = function($container) {
    return new ReviewService($container['pdo']);
}; 

$app->get('/review/{id}', function (Request $request, Response $response) {

    $reviewId = $request->getAttribute('id');
    if (!is_numeric($reviewId)) {
        return $response->withStatus(400);
    }

    try {
        $review = $this->reviewService->getReviewById($reviewId);
        return $response->withHeader('Content-type', 'application/json')->withJson($review);
    } catch(Exception $e) {
        return $response->withStatus(404);
    }
});

$app->post('/cms', function (Request $request, Response $response) {
    $data = json_decode($request->getBody(), true);
    if (empty($data['title']) || empty($data['author'])) {
        return $response->withStatus(400);
     }

    $summary = $data['summary'];
    error_log($summary);
    
    $response = $response->withHeader('Content-type', 'application/json');
    $response = $response->withJson(["status" => $data['title']])->withStatus(200);
    return $response;
});

$app->run();