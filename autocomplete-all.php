<?php
require('includes/db-config.php'); 

$term = isset($_GET['term']) ? trim($_GET['term']) : '';
$type = isset($_GET['type']) ? trim($_GET['type']) : 'all';

if ($term) {
    try {
        $results = [];
        
        // Business names with additional data
        $stmt = $pdo->prepare("
            SELECT DISTINCT 
                business_name as text,
                'business' as type,
                id,
                category,
                state
            FROM awards 
            WHERE business_name ILIKE :term 
            LIMIT 5
        ");
        $stmt->execute([':term' => "%$term%"]);
        $results['businesses'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        echo json_encode($results);
    } catch (PDOException $e) {
        error_log("Autocomplete Error: " . $e->getMessage());
        echo json_encode([]); 
    }
} else {
    echo json_encode([]); 
}
?>