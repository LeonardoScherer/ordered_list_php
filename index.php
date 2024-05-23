<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputJSON = file_get_contents('php://input');
    
    $data = json_decode($inputJSON, true);

    if (json_last_error() === JSON_ERROR_NONE && isset($data['data']) && is_array($data['data'])) {
        sort($data['data']);
    
        $response = [
            'data' => $data['data']
        ];
        
        header('Content-Type: application/json');
        
        echo json_encode($response);
    } else {
        header('Content-Type: application/json', true, 400);
        echo json_encode(['error' => 'Dados inválidos']);
    }
} else {
    header('Content-Type: application/json', true, 405);
    echo json_encode(['error' => 'Método não permitido']);
}
