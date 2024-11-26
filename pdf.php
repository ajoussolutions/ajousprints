<?php

try {
    $token = $_GET['token'] ?? null;
    if (!$token) {
        throw new Exception('Token is required');
    }

    // Build render URL (using absolute path)
    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
    $host = $_SERVER['HTTP_HOST'];
    $renderUrl = $protocol . $host . dirname($_SERVER['PHP_SELF']) . '/render.php?token=' . $token;

    // Get PDF
    $pdf = getPdf($renderUrl);

    // Clear any previous output
    if (ob_get_level()) ob_end_clean();
    
    // Set proper headers
    header('Content-Type: application/pdf');
    header('Content-Length: ' . strlen($pdf));
    header('Content-Disposition: inline; filename="document.pdf"');
    // Prevent caching
    header('Cache-Control: no-cache, no-store, must-revalidate');
    header('Pragma: no-cache');
    header('Expires: 0');
    
    // Output PDF
    echo $pdf;
    exit();
    
} catch (Exception $e) {
    header('Content-Type: text/plain');
    echo 'Error: ' . $e->getMessage();
    exit(1);
}
?>

