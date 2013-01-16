<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    /**
     * Bootstrap application.ini config
     */
    protected function _initConfig() {
        $config = new Zend_Config($this->getOptions());

        Zend_Registry::set('config', $config);

        return $config;
    }

    /**
     * Bootstrap Smarty View
     * @return \Ext_View_Smarty
     */
    protected function _initView() {
        // initialize smarty view
        $view = new Ext_View_Smarty($this->getOption('smarty'));
        // setup viewRenderer with suffix and view
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setViewSuffix('tpl');
        $viewRenderer->setView($view);

        // store the view object to Zend_Registry
        Zend_Registry::set('smarty', $view);

        // ensure we have layout bootstrap
        $this->bootstrap('layout');
        // set the tpl suffix to layout also
        $layout = Zend_Layout::getMvcInstance();
        $layout->setViewSuffix('tpl');

        return $view;
    }

    /**
     * Sets default locale language
     */
    protected function _initLocale() {
        Zend_Locale::setDefault('zh_HK');
    }

    protected function _initRoutes() {
        // handle the user request
        $controller = Zend_Controller_Front::getInstance();

        // router object
        $router = $controller->getRouter();

        /******************* Start Dating *********************/

        // dating browse
        $router->addRoute('dating_browse', new Zend_Controller_Router_Route(
                        'dating/browse/view/:view/page/:page',
                        array(
                            'controller' => 'dating',
                            'action' => 'browse'
                        )
                )
        );

        // dating online
        $router->addRoute('dating_online', new Zend_Controller_Router_Route(
                        'dating/online/view/:view/page/:page',
                        array(
                            'controller' => 'dating',
                            'action' => 'online'
                        )
                )
        );

        // dating user
        $router->addRoute('dating_user', new Zend_Controller_Router_Route(
                        'dating/user/:nickname',
                        array(
                            'controller' => 'dating',
                            'action' => 'user'
                        )
                )
        );
        /******************* End  Dating *********************/
        /******************* Start Album *********************/

        // album of user
        $router->addRoute('album_album', new Zend_Controller_Router_Route(
                        ':nickname/albums/:id/photos',
                        array(
                            'controller' => 'album',
                            'action' => 'photos'
                        )
                )
        );

        // albums of user
        $router->addRoute('album_albums', new Zend_Controller_Router_Route(
                        ':nickname/albums',
                        array(
                            'controller' => 'album',
                            'action' => 'albums'
                        )
                )
        );

        // create album
        $router->addRoute('album_create', new Zend_Controller_Router_Route(
                        ':nickname/albums/create',
                        array(
                            'controller' => 'album',
                            'action' => 'create'
                        )
                )
        );

        // edit album
        $router->addRoute('album_edit', new Zend_Controller_Router_Route(
                        ':nickname/albums/edit/:id',
                        array(
                            'controller' => 'album',
                            'action' => 'edit'
                        )
                )
        );

        // delete album
        $router->addRoute('album_delete', new Zend_Controller_Router_Route(
                        ':nickname/albums/delete/:id',
                        array(
                            'controller' => 'album',
                            'action' => 'delete'
                        )
                )
        );

        /******************* End   Album *********************/

        /******************* Start Deals *********************/

        // user products
        $router->addRoute('deals_user_products', new Zend_Controller_Router_Route(
                        ':nickname/products',
                        array(
                            'controller' => 'deals',
                            'action' => 'products'
                        )
                )
        );

        // user product
        $router->addRoute('deals_user_product', new Zend_Controller_Router_Route(
                        ':nickname/products/:id',
                        array(
                            'controller' => 'deals',
                            'action' => 'product'
                        )
                )
        );

        // user create product
        $router->addRoute('deals_user_product_create', new Zend_Controller_Router_Route(
                        ':nickname/products/create',
                        array(
                            'controller' => 'deals',
                            'action' => 'create'
                        )
                )
        );

        // user edit product
        $router->addRoute('deals_user_product_edit', new Zend_Controller_Router_Route(
                        ':nickname/products/edit/:id',
                        array(
                            'controller' => 'deals',
                            'action' => 'edit'
                        )
                )
        );

        // user delete product
        $router->addRoute('deals_user_product_delete', new Zend_Controller_Router_Route(
                        ':nickname/products/delete/:id',
                        array(
                            'controller' => 'deals',
                            'action' => 'delete'
                        )
                )
        );

        // user payments
        $router->addRoute('deals_user_payments', new Zend_Controller_Router_Route(
                        ':nickname/payments',
                        array(
                            'controller' => 'deals',
                            'action' => 'payments'
                        )
                )
        );

        // user payment
        $router->addRoute('deals_user_payment', new Zend_Controller_Router_Route(
                        ':nickname/payment/:id',
                        array(
                            'controller' => 'deals',
                            'action' => 'payment'
                        )
                )
        );



        /******************* End   Deals *********************/
    }

    /**
     * Bootstrap Translatetion
     *
     * @return \Zend_Translate
     */
    protected function _initTranslate() {

        // initialize Zend_Translate
        $translate = new Zend_Translate(array(
                    'adapter' => 'array',
                    'content' => APPLICATION_PATH . '/languages/en_US.php',
                    'locale' => 'en_US',
                ));

        // setup language files
        // traditional chinese
        $translate->addTranslation(array(
            'content' => APPLICATION_PATH . '/languages/zh_HK.php',
            'locale' => 'zh_HK',
        ));

        // taiwan chinese
        $translate->addTranslation(array(
            'content' => APPLICATION_PATH . '/languages/zh_TW.php',
            'locale' => 'zh_TW',
        ));

        // simplified chinese
        $translate->addTranslation(array(
            'content' => APPLICATION_PATH . '/languages/zh_CN.php',
            'locale' => 'zh_CN',
        ));

        // add to zend_registry
        Zend_Registry::set('translate', $translate);

        return $translate;
    }

}

