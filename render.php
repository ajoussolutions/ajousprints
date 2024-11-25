<?php
header('Content-Type: text/html; charset=utf-8');

try {
    $token = $_GET['token'] ?? null;
    if (!$token) {
        throw new Exception('Token is required');
    }

    $filePath = __DIR__ . '/temp/' . $token . '.html';
    if (!file_exists($filePath)) {
        throw new Exception("File not found for token: $token");
    }

    $html = file_get_contents($filePath);
    if ($html === false) {
        throw new Exception("Could not read file for token: $token");
    }

    echo $html;
} catch (Exception $e) {
    http_response_code(404);
    echo "Error: " . $e->getMessage();
}
?>
