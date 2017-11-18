<?php
require_once('config.php');

$host = $CONFIG['host'];
$db = $CONFIG['db'];
$user = $CONFIG['user'];
$pass = $CONFIG['password'];
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
     PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
     PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
     PDO::ATTR_EMULATE_PREPARES   => false,
];
$pdo = new PDO($dsn, $user, $pass, $options);

$stmt = $pdo->query('SELECT title FROM reviews');
echo "<ol>\n";
while ($row = $stmt->fetch())
{
    echo "<li>" . $row['title'] ."</li>\n";
}
echo "</ol>\n";