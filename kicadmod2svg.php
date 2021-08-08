<?php
require './vendor/autoload.php';

$parser = new \Hk\KicadmodParser\KicadmodParser();
$content = '';
if( isset($_POST['data']) === TRUE )
{
    $content = $parser->parseContent($_POST['data']);
//header('Content-Type: image/svg+xml');
}
echo $content;
