<?php

/* Autoloader doesn't exist yet */
include('/usr/local/reach_guard/mvc/app/library/reach_guard/Phalcon/Config/Config.php');
include('/usr/local/reach_guard/mvc/app/library/reach_guard/Phalcon/Autoload/Loader.php');

return new reach_guard\Phalcon\Config\Config(array(
    'application' => array(
        'controllersDir' => __DIR__ . '/../../app/controllers/',
        'modelsDir'      => __DIR__ . '/../../app/models/',
        'viewsDir'       => __DIR__ . '/../../app/views/',
        'pluginsDir'     => __DIR__ . '/../../app/plugins/',
        'libraryDir'     => __DIR__ . '/../../app/library/',
        'cacheDir'       => __DIR__ . '/../../app/cache/',
        'baseUri'        => '/reach_guard_gui/',
    ),
    'globals' => array(
        'config_path'    => '/conf/',
        'temp_path'      => '/tmp/',
        'debug'          => false,
        'simulate_mode'  => false
    )
));
