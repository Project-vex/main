<?php
// Function to generate XML sitemap
function generateSitemap($dir) {
    $xml = '';

    // Get HTML files
    $htmlFiles = glob($dir . '/*.html');
    foreach ($htmlFiles as $htmlFile) {
        $xml .= '<url>' . PHP_EOL;
        $xml .= '<loc>' . 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/' . basename($htmlFile) . '</loc>' . PHP_EOL;
        $xml .= '</url>' . PHP_EOL;
    }

    // Get directories
    $directories = glob($dir . '/*', GLOB_ONLYDIR);
    foreach ($directories as $directory) {
        $xml .= '<url>' . PHP_EOL;
        $xml .= '<loc>' . 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/' . basename($directory) . '/</loc>' . PHP_EOL;
        $xml .= '</url>' . PHP_EOL;

        // Recursively generate sitemap for subdirectories
        $xml .= generateSitemap($directory);
    }

    return $xml;
}

// Generate the sitemap
$directory = __DIR__; // Change this to the root directory of your website
$xmlSitemap = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
$xmlSitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . PHP_EOL;
$xmlSitemap .= generateSitemap($directory);
$xmlSitemap .= '</urlset>' . PHP_EOL;

// Set the header content type for XML
header('Content-Type: application/xml');

// Output the sitemap
echo $xmlSitemap;
