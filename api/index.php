<?php

namespace TechbookReader;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config.php';

use PDO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use TechbookReader\Service\ReviewService as ReviewService;

$CONFIG['displayErrorDetails'] = false;
$CONFIG['addContentLengthHeader'] = false;

$app = new \Slim\App(["settings" => $CONFIG]);
$corsOptions = array(
    "origin" => "https://www.techbookreader.com",
    "exposeHeaders" => array("Content-Type", "X-Requested-With", "X-authentication", "X-client"),
    "allowMethods" => array('GET', 'POST', 'PUT', 'DELETE', 'OPTIONS')
);
$app->add(new \CorsSlim\CorsSlim($corsOptions));

$container = $app->getContainer();

$container['pdo'] = function ($container) {
    $settings = $container["settings"];
    $host = $settings['host'];
    $db = $settings['db'];
    $charset = 'utf8mb4';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];
    try {
        return new PDO($dsn, $settings['user'], $settings['password'], $options);
    } catch (\PDOException $e) {
        return NULL;
    }
};

$container['reviewService'] = function ($container) {
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
            ['item' => 'Product Ownership & Requirements', 'category' =>'product_ownership'],
            ['item' => 'Architecture', 'category' =>'architecture'],
            ['item' => 'Continuous Delivery', 'category' =>'continuous_delivery'],
            ['item' => 'Software Engineering', 'category' =>'sw_engineering'],
            ['item' => 'TDD and Testing', 'category' =>'testing'],
            ['item' => 'Working with Code', 'category' =>'code'],
            ['separator' => true],
            ['item' => 'Databases', 'category' =>'databases'],
            ['item' => 'Tools', 'category' =>'tools'],
            ['item' => 'The Cloud', 'category' =>'cloud'],
            ['item' => 'Web Development', 'category' =>'web'],
            ['item' => 'Microsoft', 'category' =>'microsoft'],
            ['separator' => true],
            ['item' => 'Security', 'category' =>'security'],
            ['item' => 'Performance', 'category' =>'performance'],
            ['separator' => true],
            ['item' => 'Java and J2EE', 'category' =>'java'],
            ['item' => 'Ruby', 'category' =>'ruby'],
            ['item' => '.NET', 'category' =>'dotnet'],
            ['separator' => true],
            ['item' => 'Exam Preparation', 'category' =>'exam_prep'],
            ['item' => 'Game Development', 'category' =>'game_development']
        ]],
        ['menu' => 'Soft Skills Books', 'items' => [
            ['item' => 'Leadership', 'category' =>'leadership']
        ]]
    ];
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
    } catch (Exception $e) {
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