<?php
// db.php - DB connection used by save_result.php and results.php
$DB_HOST = 'localhost';
$DB_NAME = 'dbfgskx8wwgzck';
$DB_USER = 'uei4bkjtcem6s';
$DB_PASS = 'wmhalmspfjgz';
 
try {
    $pdo = new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8mb4", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (Exception $e) {
    // In production do not echo DB errors. For dev, helpful:
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed', 'message' => $e->getMessage()]);
    exit;
}
 
