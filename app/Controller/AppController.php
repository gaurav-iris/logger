<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller','Controller');
App::uses('CakeTime', 'Utility');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 * * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller{
    
    var $components = array(
          'Auth' => array(
                'loginAction'   => array('controller' => 'auth', 'action' => 'login'),
                'loginRedirect' => array('controller' => 'dashboard', 'action' => 'index'),
                'logoutRedirect' => array('controller' => 'auth', 'action' => 'login'),
                'authError' => 'You must be logged in to view this page.',
                'loginError' => 'Invalid Username or Password entered, please try again.',
                'userModel' => 'User',
          ),
          'Session'
        );
    
    
    public $image_resize_default = array(
        'width'             => 150,    //Width of the new Image, Default is Original Width
        'height'            => 150,    //Height of the new Image, Default is Original Height
        'aspect'            => true,    //Keep aspect ratio
        'crop'              => false,   //Crop the Image
        'cropvars'          => array(), //How to crop the image, array($startx, $starty, $endx, $endy);
        'autocrop'          => true,   //Auto crop the image, calculate the crop according to the size and crop from the middle
        'htmlAttributes'    => array(), //Html attributes for the image tag
        'quality'           => 100,      //Quality of the image
        'urlOnly'           => false    //Return only the URL or return the Image tag
    );

    
    public function beforeFilter(){
        parent::beforeFilter();
        $this->loadModel('Menu');
        $this->loadModel('Setting');
        $is_user = $this->Auth->loggedIn();
        if($is_user){
            $u = $this->Auth->user();
            if(isset($u['Timezone']['value'])){ 
                Configure::write('Config.timezone', $u['Timezone']['value']);
                date_default_timezone_set($u['Timezone']['value']);
            }
        }
        $this->Auth->authenticate = array(
              'Form' => array(
                        'scope' => array('User.status' => '1')
              )
        );
        $menuType = ($is_user)?'user':'front';
        $this->set('menu',$this->Menu->generateHtml($menuType));
        $this->set('loggedIn', $is_user);
        $this->set('resizeDefault',$this->image_resize_default);
        $this->Setting->load();  
    }
    
    public function _site($url){
        return Configure::read('config.home') . $url;
    }
    
    public function toUserTime($time,$format='Y-m-d h:i:s'){
       
          $time = date($format,CakeTime::convert(strtotime($time), Configure::read('Config.timezone')));
          
	  return $time;
    }
}
