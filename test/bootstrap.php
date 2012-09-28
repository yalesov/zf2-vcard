<?php
chdir(__DIR__.'/..');
$loader = require 'vendor/autoload.php';
$loader->add('Heartsentwined\Vcard\Test', __DIR__);
