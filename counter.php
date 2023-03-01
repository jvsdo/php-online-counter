<?php
// Set the storage file name
$filename = 'visitors.json';

// Get the visitor's IP address
$ip = $_SERVER['REMOTE_ADDR'];

// Initialize the visitor list
$visitors = [];

// Check if the storage file exists
if (file_exists($filename)) {
    // Read the storage file and deserialize the visitor list
    $contents = file_get_contents($filename);
    if (is_string($contents)) {
        $visitors = json_decode($contents, true);
    }
}

// Remove visitors who have already left the site
$timestamp = time();
$visitors = array_filter($visitors, function($visitor) use ($timestamp) {
    return ($timestamp - $visitor['timestamp']) < 60;
});

// Check if the visitor is already in the list
$found = false;
foreach ($visitors as &$visitor) {
    if ($visitor['ip'] === $ip) {
        $visitor['timestamp'] = $timestamp;
        $found = true;
        break;
    }
}
unset($visitor);

// Add the visitor to the list if not already in it
if (!$found) {
    $visitor = [
        'ip' => $ip,
        'timestamp' => $timestamp
    ];
    $visitors[] = $visitor;
}

// Write the updated visitor list to the storage file
file_put_contents($filename, json_encode($visitors));

// Get the number of unique visitors
$count = count($visitors);

// Print the number of online visitors
echo "Visitantes online: $count";
?>
