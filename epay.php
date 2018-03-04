<?php
    header('Content-Type: application/json');
    $query = '?uid=94&mid=230&apikey=AT986PV4T3RM6NJS&cc=' . $_GET['cc'];
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://api.e-payouts.com/getData.php" . $query);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data_string))
    );
    $result = curl_exec($ch);
    curl_close($ch);
    if ($result) {
        echo $result;
    }
?>