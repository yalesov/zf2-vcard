<?php
error_reporting(-1);
error_reporting(-1);
chdir(__DIR__.'/..');
$loader = require 'vendor/autoload.php';
$loader->add('Yalesov\Vcard\Test', __DIR__);
