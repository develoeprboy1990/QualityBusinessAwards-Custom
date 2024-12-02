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
    die(json_encode([])); // Return an empty JSON array on failure
}

// Get the search term and type
$term = isset($_GET['term']) ? trim($_GET['term']) : '';
$type = isset($_GET['type']) ? trim($_GET['type']) : 'business';

if ($term) {
    try {
        // Different queries based on type
        if ($type === 'city') {
            $stmt = $pdo->prepare("SELECT DISTINCT city FROM awards WHERE city ILIKE :term LIMIT 10");
        } else {
            $stmt = $pdo->prepare("SELECT DISTINCT business_name FROM awards WHERE business_name ILIKE :term LIMIT 10");
        }
        
        $stmt->execute([':term' => "%$term%"]);
        $results = $stmt->fetchAll(PDO::FETCH_COLUMN);

        echo json_encode($results);
    } catch (PDOException $e) {
        error_log("Autocomplete Error: " . $e->getMessage());
        echo json_encode([]); 
    }
} else {
    echo json_encode([]); 
}
?>