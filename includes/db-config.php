<?php
// Database connection
$db_config = [
    'host' => '35.209.175.114',
    'port' => '5432',
    'dbname' => 'dbrsb9vqhcdnqn',
    'user' => 'uq5sl17zwkz9u',
    'password' => '&&m13fi$~%4,'
];

try {
    $dsn = "pgsql:host={$db_config['host']};port={$db_config['port']};dbname={$db_config['dbname']}";
    $pdo = new PDO($dsn, $db_config['user'], $db_config['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>