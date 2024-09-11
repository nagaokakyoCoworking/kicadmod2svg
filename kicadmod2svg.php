<?php
require './vendor/autoload.php';

$parser = new \Hk\KicadmodParser\KicadmodParser();
$content = '';
if( isset($_POST['data']) === TRUE )
{
    $rawData = $_POST['data'];
    if( strpos($rawData,'https://') === 0 )
    {
        if( parse_url($rawData)!== FALSE )
        {
            $rawData = file_get_contents($rawData);
        }
    }
    $content = $parser->parseContent($rawData);
//header('Content-Type: image/svg+xml');
}
echo $content;
