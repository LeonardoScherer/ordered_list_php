<?php

session_start();

if($_SERVER['REQUEST_METHOD'] === 'POST') {

    if(file_get_contents('php://input')) {
        sortListJson();
    }

    if(isset($_FILES["arquivo"])) {
        sortList();
    }

} else if($_SERVER['REQUEST_METHOD'] === 'GET') {

    echo '
        <!DOCTYPE html>
        <html lang="pt-BR">
        <head>
            <meta charset="UTF-8">
            <title>Enviar Arquivo</title>
        </head>
        <body style="background-color: rgba(19, 123, 99, 1)">
            <p style="display: flex; justify-content: center; align-items: center; margin-top: 20px">
                Para o correto funcionamento adicione um arquivo .txt com palavras separadas por virgula. Ex.:  maçã, uva, banana, pêra, abacaxi...
            </p>';
        
            if (isset($_SESSION['error'])) {
                echo '<p style="color:red; text-align: center;">' . $_SESSION['error'] . '</p>';
                unset($_SESSION['error']);
            }
        
            echo '
                <form action="index.php" method="post" enctype="multipart/form-data" style="display: flex; justify-content: center; align-items: center;">
                    <input type="file" name="arquivo" required>
                    <button type="submit">Enviar</button>
                </form>
        </body>
        </html>
        ';

} else {
    header('Content-Type: application/json', true, 405);
    echo json_encode(['error' => 'Método não permitido']);
}

function sortList() {
    $temp_file = $_FILES["arquivo"]["tmp_name"];
    $file = $_FILES["arquivo"]["name"];

    if ($_FILES["arquivo"]["type"] === "text/plain") {
        $content = file_get_contents($temp_file);

        $data = explode(',', $content);

        $data = array_map('trim', $data);
            
        sort($data);
        
        $ordered_temp_file = tempnam(sys_get_temp_dir(), 'data_ordenadas_');
        file_put_contents($ordered_temp_file, implode("\n", $data));
        
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($file) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($ordered_temp_file));
        
        readfile($ordered_temp_file);
        
        unlink($ordered_temp_file);
        
        exit;
    } else {
        $_SESSION['error'] = 'Erro: Arquivo inválido.';
        header('Location: index.php');
    }
}

function sortListJson() {
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
}