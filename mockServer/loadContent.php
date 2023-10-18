<?php

// Use $_GET['path'] to get the path from the query parameter
$path = $_GET['url'] ?? '';

// Remove the protocol, the host, and potentially the port, leading hash or slash from the path
$path = preg_replace(['/^https?:\/\/[^\/]+(:\d+)?/','/^[\/#]*/'], '', $path);

$baseDir = realpath('./html_files/');

// Convert path to realpath to avoid directory traversal attacks
$path = realpath($baseDir . '/'. $path);


// Check if the file exists in the html_files directory and is within the base directory
if (!$path || strpos($path, $baseDir) !== 0 || !file_exists($path)) {
    http_response_code(404);
    echo <<<HTML
<h1>404 Not Found</h1>
<p>The requested file "{$path}" was not found on this server.</p>
<hr>
<p>Request Method: {$_SERVER['REQUEST_METHOD']}</p>
<p>Request URI: {$_SERVER['REQUEST_URI']}</p>
<p>Request Query String: {$_SERVER['QUERY_STRING']}</p>
<p>Request Script: {$_SERVER['SCRIPT_NAME']}</p>
<p>Request Script: {$_SERVER['SCRIPT_FILENAME']}</p>
<p>Request Script: {$_SERVER['PHP_SELF']}</p>
<p>Request Script: {$_SERVER['DOCUMENT_ROOT']}</p>
<p>Request Script: {$_SERVER['PATH_TRANSLATED']}</p>
<p>Request Script: {$_SERVER['PATH_INFO']}</p>
<p>Request Script: {$_SERVER['ORIG_PATH_INFO']}</p>
HTML;
    exit;
}

// Serve the file with a text/html content type header
header('Content-Type: text/html');

// Generate red borders to indicate that this is a test server
echo <<<HTML
<div style="position: fixed; top: 0; left: 0; right: 0; background: #f00; color: #fff; padding: 10px; text-align: center;">
HTML;



readfile($path);
