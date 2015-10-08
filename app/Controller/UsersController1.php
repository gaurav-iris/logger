<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 */
class UsersController extends AppController {

/**
 * Scaffold
 *
 * @var mixed
 */
	public $scaffold;
        
        public $components = array(
//            'DebugKit.Toolbar',
            'Session',
            'Auth' => array(
                'loginRedirect' => array('controller' => 'users', 'action' => 'index'),
                'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
                'authError' => 'You must be logged in to view this page.',
                'loginError' => 'Invalid Username or Password entered, please try again.'

        ));
        
        public function beforeFilter() {
           CakePlugin::load('Upload'); 
            $this->Auth->allow(array('login','add','signup','logout'));
//            $this->Auth->allow('add');
//            $this->Auth->allow('signup');
            parent::beforeFilter();
        }
        
        public function getdata(){
//            $this->loadModel('User');
//            $this->User->id = 1;
//            $user = $this->User->find('all');
            $user = $this->User->find();
            print_r($user); exit;
        }
        
        public function login(){
            
            if($this->Session->check('Auth.User')){
                $this->redirect(array('action' => 'index'));     
            }

          
            if ($this->request->is('post')) {
                if ($this->Auth->login()) {
                    $this->Session->setFlash(__('Welcome, '. $this->Auth->user('first_name')));
                    $this->redirect($this->Auth->redirectUrl());
                } else {
                    $this->Session->setFlash(__('Invalid username or password'));
                }
            } 
        }
        
        public function logout(){
            $this->Session->setFlash(__('Thanks for using our services, '. $this->Auth->user('first_name')));
            $this->Auth->logout();
            $this->redirect($this->Auth->redirectUrl());
        }
        
        public function signup(){
            if($this->Session->check('Auth.User')){
                $this->redirect(array('action' => 'index'));     
            }
            if ($this->request->is('post')) {
                $this->User->create();
                if ($this->User->save($this->request->data)) {
                        $this->Session->setFlash(__('The User has been saved.'));
                        $data = $this->User->read();
                        $this->Auth->login($data); 
                        return $this->redirect(array('action' => 'index'));
                } else {
                      $this->Session->setFlash(__('Some of the fields require your attention.'));
                }
            } 
        }

}
