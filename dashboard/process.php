<?php
require '../vendor/autoload.php';

use Goutte\Client;

$client = new Client();

$url = $_POST['portfolio_url'] ?? '';

if (!$url) {
    die('Portfolio URL is required.');
}

try {
    $crawler = $client->request('GET', $url);

    // Example: scrape all project titles inside <h2 class="project-title">
    $projects = $crawler->filter('.project-title')->each(function ($node) {
        return trim($node->text());
    });

    // Prepare data to send to your AI or resume generator
    $data = [
        'projects' => $projects,
        // Add more scraped info here as needed (roles, durations, etc.)
    ];

    // Send $data to your AI or save it, etc.
    header('Content-Type: application/json');
    echo json_encode($data);

} catch (Exception $e) {
    echo "Error scraping URL: " . $e->getMessage();
}