<?php
declare(strict_types=1);

use Phalcon\Di\FactoryDefault;
use Phalcon\Flash\Direct as FlashDirect;
use Phalcon\Flash\Session as FlashSession;

error_reporting(E_ALL);

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

try {
    /**
     * The FactoryDefault Dependency Injector automatically registers
     * the services that provide a full stack framework.
     */
    $di = new FactoryDefault();

    $di->set('flash', 
        function() {
            $flash = new FlashDirect(
                [
                    'error' => 'alert alert-danger',
                    'success' => 'alert alert-success',
                    'notice' => 'alert alert-info',
                    'warning' => 'alert alert-warning',
                ]
            );
            
            return $flash;
        }
    );

    $di->set('flash', 
    function() {
        $flash = new FlashSession(
            [
                'error' => 'alert alert-danger',
                'success' => 'alert alert-success',
                'notice' => 'alert alert-info',
                'warning' => 'alert alert-warning',
            ]
        );
        
        return $flash;
    }
);

    /**
     * Read services
     */
    include APP_PATH . '/config/services.php';

    /**
     * Handle routes
     */
    include APP_PATH . '/config/router.php';

    /**
     * Get config service for use in inline setup below
     */
    $config = $di->getConfig();

    /**
     * Include Autoloader
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Handle the request
     */
    $application = new \Phalcon\Mvc\Application($di);

    echo $application->handle($_GET['_url'] ?? '/')->getContent();
    // echo str_replace(["\n","\r","\t"], '', $application->handle()->getContent());
} catch (\Exception $e) {
    echo $e->getMessage() . '<br>';
    echo '<pre>' . $e->getTraceAsString() . '</pre>';
}
