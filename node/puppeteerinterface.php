<?php

function getPdf($url) {
    if (empty($url)) {
        throw new Exception("URL parameter is required");
    }

    // Convert relative URL to absolute
    if (strpos($url, 'http') !== 0) {
        // Get the protocol
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https://' : 'http://';
        
        // Get the host
        $host = $_SERVER['HTTP_HOST'];
        
        // Create absolute URL
        $url = $protocol . $host . $url;
    }

    $command = "node " . __DIR__ . "/puppeteer.js " . escapeshellarg($url);
    
    // Capture stderr as well
    $descriptorspec = array(
        1 => array('pipe', 'w'), // stdout
        2 => array('pipe', 'w')  // stderr
    );
    
    $process = proc_open($command, $descriptorspec, $pipes);
    
    if (is_resource($process)) {
        $output = stream_get_contents($pipes[1]);
        $error = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $return_var = proc_close($process);

        if ($return_var !== 0) {
            throw new Exception("PDF generation failed. Error: " . $error);
        }

        if (empty($output)) {
            throw new Exception("No PDF data received from puppeteer");
        }

        // Convert ASCII codes to bytes
        $bytes = array_map('chr', explode(',', $output));
        return implode('', $bytes);
    }
    
    throw new Exception("Failed to execute command");
}
