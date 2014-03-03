<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

define('BASE_PATH', realpath(dirname(__FILE__)));

define('APPLICATION_PATH', BASE_PATH . '/application');
define('PATH_PUBLIC', BASE_PATH . '/public');
define('LIBS_PATH', BASE_PATH . '/library');
define('LIB_LOG_PATH', LIBS_PATH.'/Log');
define('CONFIG_PATH', APPLICATION_PATH . '/configs');
define('LAYOUT_PATH', APPLICATION_PATH . '/layouts');

define('APP_DOMAIN', 'https://localhost/appfb/apps-store');//Khong co dau /
define('FB_APP_DOMAIN', 'https://apps.facebook.com/apps-store-local');

define('ROOT_DOMAIN', APP_DOMAIN);
define('APP_ID', '200746673462064');

define('PATH_UPLOAD', PATH_PUBLIC . '/images');
define('IMAGE_WIDTH', 200);
define('IMAGE_HEIGHT', 300);
define('MAX_IMAGE', 5);


define('ENVIRONMENT', 'env');
define('APPLICATION_ENV', isset($_SERVER['APP_ENV']) ? $_SERVER['APP_ENV'] : 'development');
define('APPLICATION_CONFIG', 'appConfig');

set_include_path(LIBS_PATH . PATH_SEPARATOR . get_include_path());

/** Zend_Application */
try {
    //Get options
    $options = array(
        'bootstrap' => array(
            'path' => APPLICATION_PATH . '/bootstrap.php',
            'class' => 'Bootstrap'
        ),
        'phpSettings' => array(
            'display_startup_errors' => (APPLICATION_ENV == 'development') ? 1 : 0,
            'display_errors' => (APPLICATION_ENV == 'development') ? 1 : 0
        )
    );
    //Load Application
    require_once 'Zend/Application.php';

    $application = new Zend_Application(
                    APPLICATION_ENV,
                    $options
    );
    //Display
    $application->bootstrap()->run();
} catch (Zend_Exception $exception) {
    echo '<html><body><center>'
    . 'An exception occured while bootstrapping the application.';
    echo APPLICATION_ENV . '<br/>';
    if (APPLICATION_ENV == 'development') {
        echo '<br /><br />' . $exception->getMessage() . '<br />'
        . '<div align="left">Stack Trace:'
        . '<pre>' . $exception->getTraceAsString() . '</pre></div>';
    }
    echo '</center></body></html>';
    exit(1);
}