<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Metrics</title>
</head>
<body>

    <h1>Metrics</h1>
    <a href="https://footballdata.tipolisto.es/">Volver a footballdata</a><br>
    <a href="dos.php">Vista dos</a><br><br><br>
<?php
require 'vendor/autoload.php';


//https://github.com/googleapis/google-cloud-php
//composer require google/analytics-data
//composer require google/cloud-storage
use Google\Cloud\Storage\StorageClient;
use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;

putenv('GOOGLE_APPLICATION_CREDENTIALS=credentials.json');

$cloud = new StorageClient();
$client = new BetaAnalyticsDataClient();

    // Set the date range for the last 90 days.
$start_date = date('Y-m-d', strtotime('-90 days'));
$end_date = date('Y-m-d');
$date_range = new \Google\Analytics\Data\V1beta\DateRange(['start_date' => $start_date, 'end_date' => $end_date]);
$date_ranges = [$date_range];

 // Set the dimensions and metrics for the request.
 $dimensions = [new \Google\Analytics\Data\V1beta\Dimension(['name' => 'pagePath'])];
 $metrics = [
     new \Google\Analytics\Data\V1beta\Metric(['name' => 'activeUsers']),
 ];

$response = $client->runReport([
    'property' => 'properties/464043499',
    'dateRanges' => $date_ranges,
    'dimensions' => $dimensions,
    'metrics' => $metrics,
]);

foreach ($response->getRows() as $row) {
    foreach ($row->getDimensionValues() as $dimensionValue) {
        print 'Dimension Value: ' . $dimensionValue->getValue() . PHP_EOL."<br>";
    }
    foreach ($row->getMetricValues() as $metricValue) {
        print 'Metric Value: ' . $metricValue->getValue() . PHP_EOL."<br>";
    }
}


/*

use Google\Cloud\Storage\StorageClient;

// Authenticate using a keyfile path
$cloud = new StorageClient([
    'keyFilePath' => 'path/to/keyfile.json'
]);

// Authenticate using keyfile data
$cloud = new StorageClient([
    'keyFile' => json_decode(file_get_contents('/path/to/keyfile.json'), true)
]);

*/

?>
    
</body>
</html>