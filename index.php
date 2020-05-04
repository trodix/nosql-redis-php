<?php

/**
 * @author Sébastien Vallet <sebastien.vallet89@gmail.com>
 */

require __DIR__ . '/vendor/autoload.php';

$client = new Predis\Client();

if (isset($_POST['url'])) {
    $url = $_POST['url'];

    if (filter_var($url, FILTER_VALIDATE_URL) !== false) {
        $token = uniqid('', true);

        $client->hset('urls', $token, $url);
        $client->set($token.'_count', 0);
        
        $path_url = "http://".$_SERVER['HTTP_HOST']."/?t=".$token;
        echo "<p>L'url est:  <a href='$path_url' target='_blank'>$path_url</a></p>";
    } else {
      echo 'Invalid URL, get the fuck out !';
    }
}

// http://localhost:8000/?t=mon_url
if (isset($_GET['t'])) {
    $url_param = $_GET['t'];
    
    $url = $client->hget('urls', $url_param);
    $count = $client->get($url_param.'_count');

    $client->set($url_param.'_count', ++$count);
    header('location: '.$url);
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="post">
        <input type="text" name="url" id="">
        <input type="submit" value="Send">
    </form>
</body>
</html>

