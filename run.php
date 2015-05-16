<?php

require __DIR__  . '/vendor/autoload.php';

use ImageGenerator\CatApi;
use ImageGenerator\MemeGeneratorApi;

$catApi = new CatApi();

echo 'A random cat image: ' . $catApi->getRandomImage() . "\n";
