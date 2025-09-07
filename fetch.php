<?php
if (!isset($_GET['number'])) {
    echo "No number provided.";
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

// Show raw response (you can parse it with regex/DOM if needed)
echo $response;
?>
