<?php
// save_result.php - accepts JSON POST with keys: name, email, raw_score, max_score, iq_score, feedback
header('Content-Type: application/json');
 
// Read JSON body
$body = file_get_contents('php://input');
if(!$body){
    echo json_encode(['success'=>false, 'message'=>'No data received']);
    exit;
}
$data = json_decode($body, true);
if(!$data){
    echo json_encode(['success'=>false, 'message'=>'Invalid JSON']);
    exit;
}
 
// Basic sanitization and defaults
$name = isset($data['name']) ? trim($data['name']) : '';
$email = isset($data['email']) ? trim($data['email']) : '';
$raw = isset($data['raw_score']) ? (int)$data['raw_score'] : null;
$max = isset($data['max_score']) ? (int)$data['max_score'] : null;
$iq = isset($data['iq_score']) ? (int)$data['iq_score'] : null;
$feedback = isset($data['feedback']) ? trim($data['feedback']) : '';
 
if($raw === null || $max === null || $iq === null){
    echo json_encode(['success'=>false, 'message'=>'Missing numeric scores']);
    exit;
}
 
// include DB connection
require_once 'db.php';
 
try {
    $stmt = $pdo->prepare("INSERT INTO iq_test_results (name, email, raw_score, max_score, iq_score, feedback) VALUES (:name, :email, :raw, :max, :iq, :fb)");
    $stmt->execute([
        ':name' => $name,
        ':email' => $email,
        ':raw' => $raw,
        ':max' => $max,
        ':iq' => $iq,
        ':fb' => $feedback
    ]);
    $id = $pdo->lastInsertId();
    echo json_encode(['success'=>true, 'id'=>$id]);
} catch (Exception $e){
    // fail gracefully
    http_response_code(500);
    echo json_encode(['success'=>false, 'message'=>'DB error: '.$e->getMessage()]);
}
