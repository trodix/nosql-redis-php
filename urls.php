<?php

/**
 * @author Sébastien Vallet <sebastien.vallet89@gmail.com>
 */

require __DIR__ . '/vendor/autoload.php';

$client = new Predis\Client();

$urls = $client->hgetall('urls');
$httpCallsCount = 0;

$url_list = [];

foreach ($urls as $key => $value) {

    $counter = $client->get($key . '_count');
    ++$httpCallsCount;

    array_push($url_list, ['url' => $value, 'counter' => $counter]);
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
    <p>http calls: <span><?php echo $httpCallsCount ?></span></p>
    <table>
        <thead>
            <tr>
                <th>URL</th>
                <th>Counter</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($url_list as $value) : ?>
                <tr>
                    <td><?php echo $value['url'] ?></td>
                    <td><?php echo $value['counter'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>