<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.Config
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/View/Pages/home.ctp)...
 */
Router::connect('/auth/login', array('controller' => 'users', 'action' => 'login'));
Router::connect('/auth/logout', array('controller' => 'users', 'action' => 'logout'));
Router::connect('/signup', array('controller' => 'users', 'action' => 'signup'));
Router::connect('/services/api/v1/*', array('controller' => 'api', 'action' => 'v1'));

Router::connect('/tools/upload', array('controller' => 'tools', 'action' => 'upload'));

Router::connect('/signup/verify/:code', array('controller' => 'users', 'action' => 'verify'),array('pass'=>array('code')));
Router::connect('/invitation/verify/:code', array('controller' => 'invites', 'action' => 'verify'),array('pass'=>array('code')));
Router::connect('/sc/:slug/*',
    array('controller' => 'tools', 'action' => 'getimage'),
    array('pass' => array('slug'))
);
Router::connect('/sc/:slug/:h/*',
    array('controller' => 'tools', 'action' => 'getimage'),
    array('pass' => array('slug','h'))
);
Router::connect('/sc/:slug/:h/:w/*',
    array('controller' => 'tools', 'action' => 'getimage'),
    array('pass' => array('slug','h','w'))
);
        
if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
// handle ajax request	
}else{
    Router::connect('/*', array('controller' => 'japp'));
}

//      Ajax handlers   //
        Router::connect('/timesheet/', array('controller' => 'timesheets', 'action' => 'index'));
//      Ajax handlers   //


        
        
        
      
/**
 * ...and connect the rest of 'Pages' controller's URLs.
 */
//	Router::connect('/*', array('controller' => 'pages', 'action' => 'display'));

/**
 * Load all plugin routes. See the CakePlugin documentation on
 * how to customize the loading of plugin routes.
 */
        Router::connect('/dashboard', array('controller' => 'dashboard', 'action' => 'index'));
        
        Router::connect('/profile', array('controller' => 'users', 'action' => 'profile'));
        
        
        Router::connect('/activities', array('controller' => 'activities', 'action' => 'index'));
        Router::connect('/timesheets', array('controller' => 'timesheets', 'action' => 'index'));
        Router::connect('/organizations', array('controller' => 'organizations', 'action' => 'index'));
        Router::connect('/organizations/create', array('controller' => 'organizations', 'action' => 'create'));
        
//        Router::connect('/organizations/:slug/edit/*',
//            array('controller' => 'organizations', 'action' => 'edit'),
//            array('pass' => array('slug'))
//        );
//        
//        Router::connect('/organizations/:slug/*',
//            array('controller' => 'organizations', 'action' => 'view'),
//            array('pass' => array('slug'))
//        );
        
        Router::connect('/', array('controller' => 'pages', 'action' => 'display','home'));
//        Router::connect('/*', array('controller' => 'pages', 'action' => 'display'));
        
	CakePlugin::routes();

/**
 * Load the CakePHP default routes. Only remove this if you do not want to use
 * the built-in default routes.
 */
	require CAKE . 'Config' . DS . 'routes.php';
