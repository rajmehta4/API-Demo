<?php
if (!empty($_GET['location'])) {

    /* Building the Google Maps API call */

    $maps_url = 'https://' .
        'maps.googleapis.com/' .
        'maps/api/geocode/json' .
        '?address=' . urlencode($_GET['location']);

    /* Making the API call */

    $curl = curl_init();

    curl_setopt_array($curl, array(

        CURLOPT_URL => $maps_url,
        CURLOPT_RETURNTRANSFER => 1

    ));

    $maps_json = curl_exec($curl);
    curl_close($curl);

    $maps_array = json_decode($maps_json, true);

    $lat = $maps_array['results'][0]['geometry']['location']['lat'];
    $lng = $maps_array['results'][0]['geometry']['location']['lng'];

    /* Building the Instagram API call */

    $insta_url = 'https://' .
        'api.instagram.com/v1/media/search' .
        '?lat=' . $lat .
        '&lng=' . $lng .
        '&access_token=3124626336.e029fea.c9609ea33a374a8186b84405f4457c28';

    /* Making the API call */

    $curl = curl_init();

    curl_setopt_array($curl, array(

        CURLOPT_URL => $insta_url,
        CURLOPT_RETURNTRANSFER => 1

    ));

    $insta_json = curl_exec($curl);
    curl_close($curl);

    $insta_array = json_decode($insta_json, true);
}
?>

<!DOCTYPE html>

<html>

    <head>
        <meta charset = "utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>API Demo</title>
    </head>

    <body>
            <form action="" method="get">
                <input type="text" name="location"/>
                <button type="submit">Submit</button>
            </form>

            <br/>

            <div id="results">
                <?php

                if (!empty($insta_array)) {

                    foreach ($insta_array['data'] as $item) {
                        echo '<img id="' . $item['id'] . '" src="' . $item['images']['low_resolution']['url'] . '" alt=""/><br/>';
                    }
                }
                
                ?>
            </div>
    </body>
</html>