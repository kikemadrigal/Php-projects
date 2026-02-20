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
    <a href="index.php">Vista uno</a><br><br><br>
<?php


require 'vendor/autoload.php';

//https://stackoverflow.com/questions/78324314/googleanalytics-betaanalyticsdataclient-getting-invalid-argument-a-daterange-is
$service_account_key_file_path = __DIR__ . "/credentials.json";

use Google\Analytics\Data\V1beta\BetaAnalyticsDataClient;

try {

    // Authenticate using a keyfile path
    $client = new BetaAnalyticsDataClient([
        'credentials' => $service_account_key_file_path
    ]);

    // CHANGE THIS
    $ga4_property = '464043499';

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
        'property' => 'properties/' . $ga4_property,
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

} catch (\Google\ApiCore\ValidationException $e) {
    printf($e);
}

?>

</body>
</html>