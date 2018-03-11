<?php
namespace TechbookReader;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';
use \PDO;
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
    try {
        return new PDO($dsn, $settings['user'], $settings['password'], $options);
    } catch (\PDOException $e) {
        return NULL;
    }
};

$container['reviewService'] = function($container) {
    return new ReviewService($container['pdo']);
}; 

$app->get('/ping', function (Request $request, Response $response) {
    $pong = ['answer' => 'pong', 'database' => is_null($this->pdo) ? "error" : "ok"];
    return $response->withHeader('Content-type', 'application/json')->withJson($pong);
});

$app->get('/menu', function (Request $request, Response $response) {
    $menu = [
        ['menu' => 'Technical Books', 'items' => [
        ['item' => 'Agile', 'category' => 'agile'],
        ['item' => 'Product Ownership & Requirements'],
        ['item' => 'Architecture'],
        ['item' => 'Continuous Delivery'],
        ['item' => 'Software Engineering'],
        ['item' => 'TDD and Testing'],
        ['item' => 'Working with Code'],
        ['separator' => true],
        ['item' => 'Databases'],
        ['item' => 'Tools'],
        ['item' => 'The Cloud'],
        ['item' => 'Web Development'],
        ['item' => 'Microsoft'],
        ['separator' => true],
        ['item' => 'Security'],
        ['item' => 'Performance'],
        ['separator' => true],
        ['item' => 'Java and J2EE'],
        ['item' => 'Ruby'],
        ['item' => '.NET'],
        ['separator' => true],
        ['item' => 'Exam Preparation'],
        ['item' => 'Game Development']
        ]],
        ['menu' => 'Soft Skills Books', 'items' =>
        ['item' => 'Leadership']
        ]];
    return $response->withHeader('Content-type', 'application/json')->withJson($menu);
});    

$app->get('/review', function (Request $request, Response $response) {
    if (empty($request->getParam('category'))) {
        return $response->withStatus(400);
    }
    $reviews = $this->reviewService->getReviewsByCategory($request->getParam('category'));
    return $response->withHeader('Content-type', 'application/json')->withJson($reviews);
});

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