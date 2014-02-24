<?php

require_once 'Zend/Loader/Autoloader.php';

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    /**
     * Front Controller
     */
    private static $front = null;

    /**
     * Application configuration
     */
    private static $configuration = null;

    /**
     * Tracknig configuration
     */
    private static $tracking_configuration = null;

    /**
     * Admin log configuration
     */
    private static $admin_log_configuration = null;

    /**
     * Registration of my name space
     */
    protected function initNamespace() {
        Zend_Loader_Autoloader::getInstance()->setFallbackAutoloader(true);
    }

    /**
     * Init application configuration
     */
    protected function initAppConfiguration() {
        if (null === self::$configuration) {
            $configs = new Zend_Config_Ini(APPLICATION_PATH . '/configs/application.' . APPLICATION_ENV . '.ini', APPLICATION_ENV);
            self::$configuration = $configs;
        }

        Zend_Registry::set(APPLICATION_CONFIG, self::$configuration);
    }

    /**
     * Routers setup
     */
    protected function initRouters() {
        self::$front->addControllerDirectory(APPLICATION_PATH . '/modules/default/controllers', 'default');
        $default = new Zend_Controller_Router_Route(':controller/:action/*', array('controller' => 'index', 'action' => 'index', 'module' => 'default'));

        self::$front->addControllerDirectory(APPLICATION_PATH . '/modules/admin/controllers', 'admin');
        $admin = new Zend_Controller_Router_Route('admin/:controller/:action/*', array('controller' => 'index', 'action' => 'index', 'module' => 'admin'));

		self::$front->addControllerDirectory(APPLICATION_PATH . '/modules/ishali/controllers', 'ishali');
        $ishali = new Zend_Controller_Router_Route('ishali/:controller/:action/*', array('controller' => 'index', 'action' => 'index', 'module' => 'ishali'));

        //Init route
        $registry = new Zend_Controller_Router_Route('/registry/:action/*', array('controller' => 'registry', 'action' => 'index', 'module' => 'default'));
        $manage = new Zend_Controller_Router_Route('/manage/:action/*', array('controller' => 'manage', 'action' => 'index', 'module' => 'default'));
        $article = new Zend_Controller_Router_Route('/article/:action/*', array('controller' => 'article', 'action' => 'index', 'module' => 'default'));

        //Add router
        $routers = self::$front->getRouter();
        $routers->addRoute('default', $default);
        $routers->addRoute('admin', $admin);
		$routers->addRoute('ishali', $ishali);
        $routers->addRoute('registry', $registry);
        $routers->addRoute('manage', $manage);
        $routers->addRoute('article', $article);
    }

    /**
     * Helper controller setup
     */
    protected function initControllerHelper() {
        
    }

    /**
     * Zend_Front_Controller created on each request
     */
    protected function initFrontController() {
        //Init frontController
        self::$front = Zend_Controller_Front::getInstance();

        //Set the current environment
        self::$front->setParam(ENVIRONMENT, APPLICATION_ENV);

        //Enable error controller plugin
        if (APPLICATION_ENV == 'development') {
            self::$front->throwExceptions(true);
        } else {
            self::$front->throwExceptions(false);
        }
        //Set new router
        $this->initRouters();

        //Controller helpers
        //$this->initControllerHelper();
    }

    /**
     * Plugin Front Init
     */
    protected function initFrontPlugin() {
        
    }

    /**
     * Run the application
     *
     * Checks to see that we have a default controller directory. If not, an
     * exception is thrown.
     *
     * If so, it registers the bootstrap with the 'bootstrap' parameter of
     * the front controller, and dispatches the front controller.
     *
     * @return void
     * @throws Zend_Exception
     */
    public function run() {
        //Init namspace
        $this->initNamespace();

        //Init Application Configuration
        $this->initAppConfiguration();

        //Init Front Controller
        $this->initFrontController();

        //Check default module
        if (null === self::$front->getControllerDirectory(self::$front->getDefaultModule())) {
            throw new Zend_Exception('No default controller directory registered with front controller');
        }

        //Set controller plugin
        $this->initFrontPlugin();

        //Dispatch controller
        self::$front->setParam('bootstrap', $this);
        self::$front->dispatch();
        exit(0);
    }

}