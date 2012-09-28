<?php
use Zend\Mvc\Application;
chdir(__DIR__);
require 'vendor/autoload.php';
return Application::init(array(
    'modules'   => array(
        'DoctrineModule',
        'DoctrineORMModule',
        'Heartsentwined\Vcard',
    ),
    'module_listener_options' => array(
        'config_glob_paths' => array(
            __DIR__ . '/test/config/{,*.}test.php'
        ),
        'module_paths' => array(
            'Heartsentwined\Vcard' => __DIR__,
            'vendor',
        ),
    ),
));
