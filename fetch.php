<?php
if (!isset($_GET['number'])) {
    echo "<b>Error:</b> No number provided.";
    exit;
}

$number = urlencode($_GET['number']);
$url = "https://excise.gos.pk/vehicle/vehicle_search";

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, "reg_no=$number");
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/x-www-form-urlencoded"
]);

$response = curl_exec($ch);
curl_close($ch);

// If no response
if (!$response) {
    echo "<b>Error:</b> Unable to connect to Excise server.";
    exit;
}

// Extract only the vehicle info table
if (preg_match('/<table[^>]*>(.*?)<\/table>/is', $response, $matches)) {
    $table = $matches[0];

    // Clean table styles and keep plain text
    $table = preg_replace('/style="[^"]*"/i', '', $table);
    $table = preg_replace('/class="[^"]*"/i', '', $table);
    $table = str_replace("td>", "td style='border:1px solid #00ff00; padding:5px;'>", $table);
    $table = str_replace("th>", "th style='border:1px solid #00ff00; padding:5px;'>", $table);

    echo "<h2 style='color:#00ff00;'>Vehicle Information</h2>";
    echo $table;
} else {
    echo "<b>No record found</b> for number: <span style='color:#0f0;'>$number</span>";
}
?>
